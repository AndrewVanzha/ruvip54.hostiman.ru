<?
// https://www.youtube.com/watch?v=-QB0IjyPvWs
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    Array(
        //"ID" => $_REQUEST["ELEMENT_ID"],
        "ID" => "1",
        "IBLOCK_TYPE" => "company_content",
        "IBLOCK_ID" => "3",
        //"SECTION_URL" => "/moda/list.php?SECTION_ID=#ID#",
        //"SECTION_URL" => "/moda/index.php?SECTION_ID=#ID#",
        "SECTION_URL" => "/moda/#SECTION_CODE_PATH#/",
        "DEPTH_LEVEL" => "2", // => "2"
        "CACHE_TIME" => "3600",
        "IS_SEF" => "N", // => "Y" ?
        "SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
        "DETAIL_PAGE_URL" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
        //"SEF_BASE_URL" => "/moda/", // ?
    )
);
//debugg($aMenuLinksExt);
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>
