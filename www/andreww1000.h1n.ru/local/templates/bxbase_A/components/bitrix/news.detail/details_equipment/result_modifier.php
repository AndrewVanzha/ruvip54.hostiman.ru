<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global array $arParams */
use Bitrix\Main\Type\Collection;

//debugg($arResult);

//$arFilter = $GLOBALS[$arParams["FILTER_NAME"]];
//debugg($arFilter);
//debugg($arParams["FILTER_NAME"]);
//debugg($arParams);
//debugg($arResult);

//debugg($arResult["PROPERTIES"]);
//debugg($arResult["PROPERTIES"]["PROP_SE"]);

// вытаскиваю свойство из свойства по ссылке на раздел
debugg('свойство по ссылке на раздел - result_modifier.php (CIBlockSection::GetList) ');
$arSectionFilter = Array(
    "IBLOCK_ID" => $arResult["PROPERTIES"]["PROP_SE"]["LINK_IBLOCK_ID"],
    "ID" => $arResult["PROPERTIES"]["PROP_SE"]["VALUE"],
    "ACTIVE" => "Y"
);
$arSectionSelect = Array("*", "UF_*");
//$arSectionSelect = Array("ID", "NAME", "DESCRIPTION", "SECTION_PAGE_URL", "XML_ID", "LEFT_MARGIN", "RIGHT_MARGIN", "DEPTH_LEVEL", "UF_*");
$rsSect = CIBlockSection::GetList(
    Array(),
    $arSectionFilter,
    false,
    $arSectionSelect
);
while ($arSect = $rsSect->GetNext()) {
    //$arSection["CHILDREN"][] = $arSect;
    $arSecChild = $arSect;
}
//debugg($arSecChild);

// вытаскиваю свойство из свойства по ссылке на элемент
debugg('свойство по ссылке на элемент - result_modifier.php (CIBlockElement::GetList) ');
//debugg($arResult["PROPERTIES"]["PROP_EL"]);
//echo $arResult["PROPERTIES"]["PROP_EL"]["VALUE"];
$arElementFilter = Array(
    "IBLOCK_ID" => $arResult["PROPERTIES"]["PROP_EL"]["LINK_IBLOCK_ID"],
    "ID" => $arResult["PROPERTIES"]["PROP_EL"]["VALUE"],
    "ACTIVE" => "Y"
);
//$arElementSelect = Array("*", "PROPERTY_*");
$arElementSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "XML_ID", "CODE", "PROPERTY_*");
$resEl = CIBlockElement::GetList(Array(), $arElementFilter, false, false, $arElementSelect);
while($arEl = $resEl->GetNextElement()) {
    $arElems = $arEl->GetFields();
    $arProps = $arEl->GetProperties();
}
//debugg($arElems);
//debugg($arProps);
