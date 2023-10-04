<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?php
//file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/chastnym-klientam/konvertor-valyut/test_ajax_get.txt', $_GET);
//$last_session = $_SESSION['city'];

if(isset($_GET['office'])) {
    $office = htmlspecialchars($_GET['office']);
    \GarbageStorage::set('OfficeId', $office);
    //file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/chastnym-klientam/konvertor-valyut/test_office.txt', $office);
}
?>
<?
$result = $APPLICATION->IncludeComponent(
    //"webtu:synch.currency",
    "webdo:currency_synch",
    "new_table",
    array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CBR_IBLOCK_ID" => "116", // Курсы валют ЦБ - не используется
        "OFFICE_IBLOCK_ID" => "16" // Курсы валют банка
    )
);

echo 'synch.currency.result';
echo json_encode($result);