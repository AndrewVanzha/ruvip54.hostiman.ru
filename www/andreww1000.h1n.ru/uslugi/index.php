<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Услуги");
?>
<?$APPLICATION->ShowViewContent("block_id"); // ob?>

<div class="container">
    <h1>Услуги </h1>
    <h2>Инфоблок Оборудование</h2>
    <h5>menu с переходом на infoblokk </h5>
        <?$APPLICATION->IncludeComponent("bitrix:menu", "subtop_menu", Array(
            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
            "CHILD_MENU_TYPE" => "subtop",	// Тип меню для остальных уровней
            "DELAY" => "N",	// Откладывать выполнение шаблона меню
            "MAX_LEVEL" => "3",	// Уровень вложенности меню
            "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
                0 => "",
            ),
            "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
            "MENU_CACHE_TYPE" => "N",	// Тип кеширования
            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
            "ROOT_MENU_TYPE" => "subtop",	// Тип меню для первого уровня
            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
        ),
        false
    );?>

    <?$page = $APPLICATION->GetCurPage(false);
    debugg('$page=');
    debugg($page);
    //$GLOBALS['arFilter'] = array();
    ?>
</div>
<?ob_start();?>
    <p style="color: red">here is ob block</p>
    <?$outt = ob_get_contents();
ob_end_clean(); ?>
<?$APPLICATION->AddViewContent("block_id", $outt); // объявили метку и указали что в ней выводить  ?>

    <?$APPLICATION->IncludeComponent(
        "bitrix:news",
        "product_uslugi",
        array(
            "ADD_ELEMENT_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            //"FILTER_NAME" => "arFilter",
            "FILTER_NAME" => "",
            "INCLUDE_SUBSECTIONS" => "N",
            "BROWSER_TITLE" => "-",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
            "DETAIL_DISPLAY_TOP_PAGER" => "N",
            "DETAIL_FIELD_CODE" => array(
                0 => "ID",
                1 => "NAME",
                2 => "SHOW_COUNTER",
                3 => "IBLOCK_ID",
                4 => "",
            ),
            "DETAIL_PAGER_SHOW_ALL" => "Y",
            "DETAIL_PAGER_TEMPLATE" => "",
            "DETAIL_PAGER_TITLE" => "Страница",
            "DETAIL_PROPERTY_CODE" => array(
                0 => "PROP_A",
                1 => "PROP_EL",
                2 => "PROP_SPRAV",
                3 => "",
            ),
            "DETAIL_SET_CANONICAL_URL" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "1",
            "IBLOCK_TYPE" => "company_products",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "LIST_FIELD_CODE" => array(
                0 => "ID",
                1 => "NAME",
                2 => "PREVIEW_TEXT",
                3 => "",
            ),
            "LIST_PROPERTY_CODE" => array(
                0 => "PROP_A",
                1 => "PROP_EL",
                2 => "PROP_SPRAV",
                3 => "",
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
            "SEF_MODE" => "Y",
            "SET_LAST_MODIFIED" => "N",
            "SET_STATUS_404" => "Y",
            "SET_TITLE" => "N",
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
            "USE_RSS" => "N",
            "USE_SEARCH" => "N",
            "USE_SHARE" => "N",
            "COMPONENT_TEMPLATE" => "product_uslugi",
            "SEF_FOLDER" => "/uslugi/",
            "FILTER_FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "FILTER_PROPERTY_CODE" => array(
                0 => "",
                1 => "",
            ),
            "USE_REVIEW" => "N",
            "SEF_URL_TEMPLATES" => array(
                "news" => "",
                "section" => "#SECTION_CODE_PATH#/",
                "detail" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
            )
        ),
        false
    );?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>