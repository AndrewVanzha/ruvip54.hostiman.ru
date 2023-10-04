<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arViewModeList = array('LIST', 'LINE', 'TEXT', 'TILE');

$arDefaultParams = array(
	'VIEW_MODE' => 'LIST',
	'SHOW_PARENT_NAME' => 'Y',
	'HIDE_SECTION_NAME' => 'N'
);

$arParams = array_merge($arDefaultParams, $arParams);

if (!in_array($arParams['VIEW_MODE'], $arViewModeList))
	$arParams['VIEW_MODE'] = 'LIST';
if ('N' != $arParams['SHOW_PARENT_NAME'])
	$arParams['SHOW_PARENT_NAME'] = 'Y';
if ('Y' != $arParams['HIDE_SECTION_NAME'])
	$arParams['HIDE_SECTION_NAME'] = 'N';

$arResult['VIEW_MODE_LIST'] = $arViewModeList;

global $sectionsFilter;
//debugg($arResult);
//debugg($sectionsFilter);

if (0 < $arResult['SECTIONS_COUNT'])
{
	if ('LIST' != $arParams['VIEW_MODE'])
	{
		$boolClear = false;
		$arNewSections = array();
		foreach ($arResult['SECTIONS'] as &$arOneSection)
		{
			if (1 < $arOneSection['RELATIVE_DEPTH_LEVEL'])
			{
				$boolClear = true;
				continue;
			}
			$arNewSections[] = $arOneSection;
		}
		unset($arOneSection);
		if ($boolClear)
		{
			$arResult['SECTIONS'] = $arNewSections;
			$arResult['SECTIONS_COUNT'] = count($arNewSections);
		}
		unset($arNewSections);
	}
}

if (0 < $arResult['SECTIONS_COUNT'])
{
	$boolPicture = false;
	$boolDescr = false;
	$arSelect = array('ID');
	$arMap = array();
	if ('LINE' == $arParams['VIEW_MODE'] || 'TILE' == $arParams['VIEW_MODE'])
	{
		reset($arResult['SECTIONS']);
		$arCurrent = current($arResult['SECTIONS']);
		if (!isset($arCurrent['PICTURE']))
		{
			$boolPicture = true;
			$arSelect[] = 'PICTURE';
		}
		if ('LINE' == $arParams['VIEW_MODE'] && !array_key_exists('DESCRIPTION', $arCurrent))
		{
			$boolDescr = true;
			$arSelect[] = 'DESCRIPTION';
			$arSelect[] = 'DESCRIPTION_TYPE';
		}
	}
	if ($boolPicture || $boolDescr)
	{
		foreach ($arResult['SECTIONS'] as $key => $arSection)
		{
			$arMap[$arSection['ID']] = $key;
		}
		$rsSections = CIBlockSection::GetList(array(), array('ID' => array_keys($arMap)), false, $arSelect);
		while ($arSection = $rsSections->GetNext())
		{
			if (!isset($arMap[$arSection['ID']]))
				continue;
			$key = $arMap[$arSection['ID']];
			if ($boolPicture)
			{
				$arSection['PICTURE'] = intval($arSection['PICTURE']);
				$arSection['PICTURE'] = (0 < $arSection['PICTURE'] ? CFile::GetFileArray($arSection['PICTURE']) : false);
				$arResult['SECTIONS'][$key]['PICTURE'] = $arSection['PICTURE'];
				$arResult['SECTIONS'][$key]['~PICTURE'] = $arSection['~PICTURE'];
			}
			if ($boolDescr)
			{
				$arResult['SECTIONS'][$key]['DESCRIPTION'] = $arSection['DESCRIPTION'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION'] = $arSection['~DESCRIPTION'];
				$arResult['SECTIONS'][$key]['DESCRIPTION_TYPE'] = $arSection['DESCRIPTION_TYPE'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION_TYPE'] = $arSection['~DESCRIPTION_TYPE'];
			}
		}
	}
}

$this->GetComponent()->arResultCacheKeys[] = "SECTIONS";

//debugg($arParams);
//debugg($arResult);
debugg('$arResult["SECTIONS_COUNT"]=');
debugg($arResult["SECTIONS_COUNT"]);

debugg('$arResult["SECTION"]=');
debugg($arResult["SECTION"]);
debugg('$arResult["SECTIONS"]=');
debugg($arResult["SECTIONS"]);

debugg('$arParams["IBLOCK_ID"]=');
debugg($arParams["IBLOCK_ID"]);
debugg('$arParams["SECTION_ID"]=');
debugg($arParams["SECTION_ID"]);

// разбираюсь со структурой в разделе Оборудование - секции-родители и секции-подчиненные
//$arSectionFilter = Array('IBLOCK_ID' => $arParams["IBLOCK_ID"], '>LEFT_MARGIN' => $arParams["IBLOCK_ID"], 'RIGHT_MARGIN' => ($arParams["IBLOCK_ID"]+1));
$arSection = Array();
$arSectionFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $arParams["SECTION_ID"], "ACTIVE" => "Y", "GLOBAL_ACTIVE"=>"Y", "SECTION_ACTIVE" => "Y");
$arSectionSelect = Array("*", "UF_*");
$rsParentSection = CIBlockSection::GetList(
	Array("SORT"=>"ASC"),
	$arSectionFilter,
	false,
	$arSectionSelect
	//false
);
while ($arParentSection = $rsParentSection->GetNext()) {
	$arSection["PARENT"] = $arParentSection;
	$arSectionFilter = Array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
	$rsSect = CIBlockSection::GetList(
		Array('left_margin' => 'asc'), 
		$arSectionFilter,
		false,
		$arSectionSelect
		//false
	);
	while ($arSect = $rsSect->GetNext()) {
		//debugg($arSect);
		$arSection["CHILDREN"][] = $arSect;
	}
}
//debugg($arSection);
$arResult["SECTION"]["CONTENT"] = $arSection;
unset($arSection);
