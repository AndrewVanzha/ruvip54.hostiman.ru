<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<?
if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD']=='GET')) {

    $mess_office = trim(htmlspecialchars($_GET["OFFICE"])); // office
    $mess_lon = trim(htmlspecialchars($_GET["LON"])); // lon
    $mess_lat = trim(htmlspecialchars($_GET["LAT"])); // lat

    //$result = [$mess_office, $mess_lon, $mess_lat];

    $result = $APPLICATION->IncludeComponent(
 		"bitrix:map.yandex.view",
 		"",
 		Array(
 			"INIT_MAP_TYPE" => "MAP",
 			"MAP_DATA" => serialize(array(
 			'yandex_lat' => $mess_lat,
 			'yandex_lon' => $mess_lon,
 			'yandex_scale' => 13,
 			'PLACEMARKS' => array (
 				array(
 					'TEXT' => $mess_lat.", ".$mess_lon,
 					'LON' => $mess_lon,
 					'LAT' => $mess_lat,
 					),
 				),
 			)),
 			"MAP_WIDTH" => "100%",
 			"MAP_HEIGHT" => "300",
 			"CONTROLS" => array("ZOOM", "MINIMAP", "TYPECONTROL", "SCALELINE"),
 			"OPTIONS" => array("DESABLE_SCROLL_ZOOM", "ENABLE_DBLCLICK_ZOOM", "ENABLE_DRAGGING"),
 			"MAP_ID" => ""
 	),
 	false
 	);

    echo $result;
    //echo json_encode($result);
}
