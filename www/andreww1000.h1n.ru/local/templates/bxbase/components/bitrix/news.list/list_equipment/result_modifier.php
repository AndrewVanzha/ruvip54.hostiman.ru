<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global array $arParams */
use Bitrix\Main\Type\Collection;

//$arFilter = $GLOBALS[$arParams["FILTER_NAME"]];
//debugg($arFilter);
//debugg($arParams["FILTER_NAME"]);
//debugg($arParams);
//debugg($arResult);

//echo $arResult["IBLOCK_ID"].' ';
//echo $arResult["ID"].'  ';
//echo $arParams["ID"].'  ';
//echo $arParams["PARENT_SECTION"]. ' ';

// разбираюсь со структурой в разделе Оборудование - секции-родители и секции-подчиненные
debugg( 'структура в разделе Оборудование - секции-родители и секции-подчиненные - result_modifier.php');
//debugg($arResult);

$arSection = Array();
$arSecChild = Array();
$arSectionFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $arParams["PARENT_SECTION"], "ACTIVE" => "Y", "GLOBAL_ACTIVE"=>"Y", "SECTION_ACTIVE" => "Y");
//$arSectionSelect = Array("*", "UF_*");
$arSectionSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID", "IBLOCK_ID", "SECTION_PAGE_URL", "XML_ID", "LEFT_MARGIN", "RIGHT_MARGIN", "DEPTH_LEVEL", "UF_*");
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
    //$arSectionSelect = Array("*", "UF_*");
	$rsSect = CIBlockSection::GetList(
		Array('left_margin' => 'asc'), 
		$arSectionFilter,
		false,
		$arSectionSelect
		//false
	);
	while ($arSect = $rsSect->GetNext()) {
		//debugg($arSect);
        //$arSection["CHILDREN"][] = $arSect;
        $arSecChild[] = $arSect;
	}
}
//debugg($arSecChild);

foreach ($arSecChild as $key=>$item) {
    if($item["DEPTH_LEVEL"] == 2) {
        $arSection["CHILDREN"][$item["ID"]]["PARENT"] = $item;
    }
    if($item["DEPTH_LEVEL"] == 3) {
        $arSection["CHILDREN"][$item["IBLOCK_SECTION_ID"]]["CHILDREN"][$item["ID"]] = $item;
    }
}
//debugg($arSection);

$arResult["SECTION"]["TREE"] = $arSection;
//debugg($arResult["SECTION"]);

unset($arSection);
unset($arSecChild);

// ----------------------------------------------------------

debugg('вывожу весь highload block');
$ID = 2; // ИД reference

\Bitrix\Main\Loader::IncludeModule('highloadblock');
$hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById($ID)->fetch();
$hlEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData)->getDataClass();

$result = $hlEntity::getList([
    'select' => ["*"],
    //"select" => array("ID", "UF_NAME", "UF_XML_ID"), // Поля для выборки
    'filter' => [],
    "order" => array(),
    //"order" => array("UF_SORT" => "ASC"),
]);
while ($res = $result->fetch()) {
    // Выводите что вам надо
    //debugg($res);
}

// ----------------------------------------------------------

debugg('вывожу highload block (Reference) из элемента Оборудование');
//debugg($arResult["ITEMS"]);
$hlRes = [];
$arHighloadProperty = $arResult["ITEMS"][0]["PROPERTIES"]["PROP_SPRAV"];
$sTableName = $arHighloadProperty['USER_TYPE_SETTINGS']['TABLE_NAME'];
// '=TABLE_NAME' => $sTableName,

foreach ($arResult["ITEMS"] as $key=>$hl_item) {
    debugg($hl_item["PROPERTIES"]["PROP_SPRAV"]["USER_TYPE_SETTINGS"]);
    debugg($hl_item["DISPLAY_PROPERTIES"]["PROP_SPRAV"]["VALUE"]);

    $result = $hlEntity::getList([
        'select' => ["*"],
        //"select" => array("ID", "UF_NAME", "UF_XML_ID"), // Поля для выборки
        'filter' => ['UF_XML_ID' => $hl_item["DISPLAY_PROPERTIES"]["PROP_SPRAV"]["VALUE"] ],
        "order" => array(),
        //"order" => array("UF_SORT" => "ASC"),
    ]);
    while ($res = $result->fetch()) {
        $hlRes[$hl_item["ID"]][] =$res;
    }
}
debugg($hlRes);
unset($hlRes);

// ----------------------------------------------------------

debugg('вывожу    свойство  PROP_EL (ссылка на элемент)     из элемента Оборудование');
debugg($arResult["ITEMS"][0]["DISPLAY_PROPERTIES"]["PROP_EL"]);
