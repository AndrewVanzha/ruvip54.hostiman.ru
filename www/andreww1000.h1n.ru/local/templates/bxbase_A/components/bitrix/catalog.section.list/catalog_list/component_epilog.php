<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//if($USER->IsAdmin()) {

    debugg('catalog.section.list / epilog (не влияет): ');
    //debugg($arResult);

    $arElem = Array();
    foreach ($arResult['SECTIONS'] as $arSect) {
        $arElem[] = $arSect["ID"];
    }
    //debugg($arElem);
    $GLOBALS['arSectionsID'] = $arElem;
    $GLOBALS['subSections'] = false;

    //debugg($GLOBALS['arSectionsID']);
    //debugg($arResult["SECTIONS"]);
    /*if($arResult["SECTION"]["RIGHT_MARGIN"]-$arResult["SECTION"]["LEFT_MARGIN"] == 1) {
        echo $arResult["SECTION"]["RIGHT_MARGIN"].'-'.$arResult["SECTION"]["LEFT_MARGIN"];
    }*/
    if($arResult["SECTIONS"]) {
        //echo ' SECTIONS ';
        $GLOBALS['subSections'] = true;
    }
    //echo $GLOBALS['subSections'];

global $arSubItems;
$arSubItems = [];
$itItems = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['IBLOCK_ID' => 1, 'SECTION_ID' => $arResult['SECTION']['ID'], 'ACTIVE' => 'Y'],
    false,
    false,
    ['NAME','DETAIL_PAGE_URL']
);
while($arSub = $itItems->GetNext()) {
    $arSubItems[] = [
        $arSub['NAME'],
        $arSub['ID'],
        $arSub['DETAIL_PAGE_URL'],
        $arSub['IBLOCK_SECTION_ID'],
    ];
}
debugg('CIBlockElement::GetList ->');
debugg($arSubItems);

//}
?>