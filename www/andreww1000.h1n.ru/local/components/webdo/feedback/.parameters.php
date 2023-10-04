<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

if(!CModule::IncludeModule("iblock")) {
    return;
}

$iblocksPre = CIblock::GetList(array(), array(), false);
$iblocks = array();

while ($iblock = $iblocksPre->Fetch()) {
    $iblocks[$iblock['ID']] = $iblock['NAME'];
}

$propertiesPre = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"]));
$properties = array();

while ($property = $propertiesPre->Fetch()) {
    $properties[$property['CODE']] = $property['NAME'];
}

$eventsPre = CEventType::GetList(array(), array("LID" => "ru"));
$events = array(
    "NONE" => "Не отправлять"
);

while ($event = $eventsPre->Fetch()) {
    $events[$event['EVENT_NAME']] = $event['NAME'];
}

$sitesPre = CSite::GetList($by = "sort", $order = "desc", array());
$sites = array();

while ($site = $sitesPre->Fetch()) {
    $sites[$site['ID']] = $site['NAME'];
}

$arComponentParameters = array(
    "PARAMETERS" => array(
        "AJAX_MODE" => array(),
        "IBLOCK_ID" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => "Инфоблок",
            "TYPE" => "LIST",
            "VALUES" => $iblocks,
            "REFRESH" => "Y",
        ),
        "PROPERTIES" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => "Свойства",
            "TYPE" => "LIST",
            "VALUES" => $properties,
            "REFRESH" => "Y",
            "MULTIPLE" => "Y",
        ),
        "ADMIN_EVENT" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => "Письмо администрации",
            "TYPE" => "LIST",
            "VALUES" => $events,
            "REFRESH" => "Y",
        ),
        "USER_EVENT" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => "Письмо пользователю",
            "TYPE" => "LIST",
            "VALUES" => $events,
            "REFRESH" => "Y",
        ),
        "SITES" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => "Сайты для почтового события",
            "TYPE" => "LIST",
            "VALUES" => $sites,
            "REFRESH" => "Y",
            "MULTIPLE" => "Y",
        ),
        "SHOW_DEBETS_CARDS" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => "Показать дебетовые карты",
            "TYPE" => "LIST",
            "VALUES" => ["Y", "N"],
        ),
    ),
);
