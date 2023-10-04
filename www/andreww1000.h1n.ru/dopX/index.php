<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ДопX");
?><div class="container">
    <h2>Доп X</h2>
    <h1>Разное со своими инфоблоками</h1>
<?$APPLICATION->IncludeComponent("bitrix:menu", "subtop_menu", Array(
    "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
    "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
    "DELAY" => "N",	// Откладывать выполнение шаблона меню
    "MAX_LEVEL" => "2",	// Уровень вложенности меню
    "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
        0 => "",
    ),
    "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
    "MENU_CACHE_TYPE" => "N",	// Тип кеширования
    "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
    "ROOT_MENU_TYPE" => "subtop",	// Тип меню для первого уровня
    "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
),
    false
);?>
    <h2>Инфоблоки Оборудование и Реклама</h2>
    <h3>Комплексное меню</h3>
<?$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "subtop_menu_long",
    Array(
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "subtop",
        "DELAY" => "N",
        "MAX_LEVEL" => "3",
        "MENU_CACHE_GET_VARS" => array(0=>"",),
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "ROOT_MENU_TYPE" => "subtop",
        "USE_EXT" => "Y"
    )
);?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>