<?

global $APPLICATION;
debugg('menu.sections');
$aMenuLinksExt = array();

if(CModule::IncludeModule('iblock')) {
    $arFilter = array(
        "TYPE" => "company_content",
        //"SITE_ID" => SITE_ID,
    );

    $dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), $arFilter);
    $dbIBlock = new CIBlockResult($dbIBlock);

    if ($arIBlock = $dbIBlock->GetNext()) { // не работает толком вызов компоненты
        if(defined("BX_COMP_MANAGED_CACHE")) $GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_".$arIBlock["ID"]);

        if($arIBlock["ACTIVE"] == "Y") {
			//debugg('.subtop.menu_ext');
			//debugg($arIBlock);
            $s_len = strlen('#SITE_DIR#/') + strlen($arIBlock['LIST_PAGE_URL']) - 1;
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
                    "DEPTH_LEVEL" => "2",
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
//$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt); // при клике на меню вываливает все элементы

debugg('bitrix:menu.sections 2');
$section = $APPLICATION->IncludeComponent(
	"bitrix:menu.sections",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DEPTH_LEVEL" => "2",
		"DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "company_content",
        //"ID" => $_REQUEST["ID"],
        //"ID" => "18",
		"IS_SEF" => "Y",
		"SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
		//"SECTION_URL" => "/vid/#SECTION_CODE#/",
		"SEF_BASE_URL" => "/vid/"
	)
);
//debugg($section);
//debugg($aMenuLinks);

$aMenuLinks = array_merge($aMenuLinks, $section);

?>