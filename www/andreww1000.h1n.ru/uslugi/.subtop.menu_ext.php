<?
global $APPLICATION;
debugg('menu.sections');
$aMenuLinksExt = array();
//debugg($aMenuLinks);

if(CModule::IncludeModule('iblock')) {
    $arFilter = array(
        "TYPE" => "company_products",
        //"SITE_ID" => SITE_ID,
    );

    $dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), $arFilter);
    $dbIBlock = new CIBlockResult($dbIBlock);

    if ($arIBlock = $dbIBlock->GetNext()) { // вызов компоненты работает
        if(defined("BX_COMP_MANAGED_CACHE")) $GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_".$arIBlock["ID"]);

        if($arIBlock["ACTIVE"] == "Y") {
            debugg("arIBlock[IBLOCK_TYPE_ID]=");
            debugg($arIBlock['IBLOCK_TYPE_ID']);
            $s_len = strlen('#SITE_DIR#/') + strlen($arIBlock['LIST_PAGE_URL']) - 1;
            debugg('s_len=');
            debugg($s_len);
            $aMenuLinksExt = $APPLICATION->IncludeComponent(
                "bitrix:menu.sections", 
                "", 
                array(
                    "IS_SEF" => "Y",
                    "SEF_BASE_URL" => $arIBlock['LIST_PAGE_URL'],
                    "SECTION_PAGE_URL" => substr($arIBlock['SECTION_PAGE_URL'], $s_len),
                    "DETAIL_PAGE_URL" => substr($arIBlock['DETAIL_PAGE_URL'], $s_len),
                    "IBLOCK_TYPE" => $arIBlock['IBLOCK_TYPE_ID'],
                    "IBLOCK_ID" => $arIBlock['ID'],
                    "DEPTH_LEVEL" => "3",
                    //"CACHE_TYPE" => "N",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                ),
                false, Array('HIDE_ICONS' => 'Y')
            );
        }
    }

    if(defined("BX_COMP_MANAGED_CACHE")) $GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_new");
}
//debugg($aMenuLinksExt);
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt); // при клике на меню тут работает


$section = $APPLICATION->IncludeComponent(
	"bitrix:menu.sections",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DEPTH_LEVEL" => "3",
		"DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "company_products",
        //"ID" => $_REQUEST["ID"],
        //"ID" => "18",
		"IS_SEF" => "Y",
		"SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
		//"SECTION_URL" => "/uslugi/#SECTION_CODE#/",
		"SEF_BASE_URL" => "/infoblok/"
	)
);
//debugg($section);
//debugg($aMenuLinks);

//$aMenuLinks = array_merge($aMenuLinks, $section);
?>