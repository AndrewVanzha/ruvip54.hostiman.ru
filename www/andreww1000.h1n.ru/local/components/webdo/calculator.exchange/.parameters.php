<?php
use \Bitrix\Main\Loader;
if (!Loader::includeModule("iblock")){ return; }

$arSection = array();
$iblocks = array();

$iblocksPre = CIBlock::GetList(
    array(
        "SORT" => "ASC"
    ),
    array(
        "ACTIVE"=>"Y"
    )
);
while ($iblock = $iblocksPre->Fetch()) {
    $iblocks[$iblock['ID']] = $iblock['NAME'];
}
$arComponentParameters = array(
    "PARAMETERS" => array(
        "OFFICE_IBLOCK_ID" => array(
            "PARENT"  => "DATA_SOURCE",
            "NAME"    => "Инфоблок с офисами",
            "TYPE"    => "LIST",
            "VALUES"  => $iblocks,
            "REFRESH" => "Y",
        ),
        "CACHE_TIME"   => array("DEFAULT"=>36000000),
    ),
);