<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вид");
?><div class="container">
	<h1>Вид </h1>
	<h2>Инфоблок Реклама + news + Включаемые области</h2>
    <h5>смешанное menu со своим инфоблоком</h5>
    <?$APPLICATION->IncludeComponent(
        "bitrix:menu",
        "subtop_menu",
        Array(
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "subtop",
            "DELAY" => "N",
            "MAX_LEVEL" => "2",
            "MENU_CACHE_GET_VARS" => array(0=>"",),
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "ROOT_MENU_TYPE" => "subtop",
            "USE_EXT" => "Y"
        )
    );?>
</div>
<?//debugg($_REQUEST);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"product_advert", 
	array(
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "product_advert",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "SHOW_COUNTER",
			3 => "IBLOCK_ID",
			4 => "CREATED_USER_NAME",
			5 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "PROP_A",
			2 => "PROP_EL",
			3 => "PROP_SPRAV",
			4 => "UF_ARGUMENTS_TEXT",
			5 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "5",     // реклама
		"IBLOCK_TYPE" => "company_content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "IBLOCK_ID",
			4 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "PROP_A",
			2 => "PROP_EL",
			3 => "PROP_SPRAV",
			4 => "UF_ARGUMENTS_TEXT",
			5 => "",
		),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "9",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "modern",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/vid/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "#SECTION_CODE#/",
			//"section" => "#SECTION_CODE_PATH#/",
			"detail" => "#SECTION_CODE#/#ELEMENT_CODE#/",
			//"detail" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		)
	),
	false
);?>
    <div class="container">
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "include_page",
            Array(
                "AREA_FILE_RECURSIVE" => "Y",
                "AREA_FILE_SHOW" => "page",
                "AREA_FILE_SUFFIX" => "inc",
                //"EDIT_TEMPLATE" => "",
                //"PATH" => ""
            )
        );?>
    </div>
    <div class="container">
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "include_section",
            array(
                "AREA_FILE_RECURSIVE" => "Y",
                "AREA_FILE_SHOW" => "sect",
                "AREA_FILE_SUFFIX" => "inc",
                "EDIT_TEMPLATE" => "",
                //"EDIT_TEMPLATE" => "standard.php",
                "COMPONENT_TEMPLATE" => "include_section"
            ),
            false
        );?>
    </div>
    <div class="container">
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "include_file",
            array(
                "AREA_FILE_SHOW" => "file",
                //"AREA_FILE_SUFFIX" => "inc",
                //"EDIT_TEMPLATE" => "",
                "PATH" => SITE_TEMPLATE_PATH."/include/some_new.php",
                "COMPONENT_TEMPLATE" => "include_file"
            ),
            false
        );?>
    </div>
    <p>https://www.youtube.com/watch?v=Ex638TB3ULM</p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>