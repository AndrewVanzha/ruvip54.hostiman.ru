<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Детально");
?>
<?//debugg($_REQUEST);?>
<?$APPLICATION->IncludeComponent(
"bitrix:highloadblock.view", 
"hunter_high_detail", 
Array(
		"BLOCK_ID" => $_REQUEST["IBLOCKID"],	// ID highload блока
		"CHECK_PERMISSIONS" => "N",	// Проверять права доступа
		"LIST_URL" => "/honeyhighload",	// Путь к странице списка записей
		"ROW_ID" => $_REQUEST["ROW_ID"],	// Значение ключа записи
		"ROW_KEY" => "ID",	// Ключ записи
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>