<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

/*foreach ($arResult['CUR'] as $key => $arCur){
    if($key == "CNY") {
        $arResult['CUR'][$key][0] = "CNY Ұ <sup>2</sup>";
    }
}*/

function compare_words2($a, $b) {
    return strnatcmp($a["name"], $b["name"]);
}


\Bitrix\Main\Loader::IncludeModule('highloadblock');

$ID = 8; // CurrencyOutCbrf
$hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById($ID)->fetch();
$hlEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData)->getDataClass();

$arCurrencyOutCbrf = [];
$result = $hlEntity::getList([ // перенес в class.php
    'select' => ["*"],
    //"select" => array("ID", "UF_NAME", "UF_XML_ID"), // Поля для выборки
    'filter' => [],
    "order" => array(),
    //"order" => array("UF_SORT" => "ASC"),
]);
while ($res = $result->fetch()) {
    $arCurrencyOutCbrf[] = $res;
}
//$arResult["CURRENCY_OUT_CBRF"] = $arCurrencyOutCbrf;


$ID = 9; // CurrencyMultiplicity
$hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById($ID)->fetch();
$hlEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData)->getDataClass();

$arCurrencyMultiplicity = [];
$result = $hlEntity::getList([
    'select' => ["*"],
    //"select" => array("ID", "UF_NAME", "UF_XML_ID"), // Поля для выборки
    'filter' => [],
    "order" => array(),
    //"order" => array("UF_SORT" => "ASC"),
]);
while ($res = $result->fetch()) {
    $arCurrencyMultiplicity[] = $res;
}
//$arResult["CURRENCY_COEFF"] = $arCurrencyMultiplicity;

//debugg('$arCurrencyMultiplicity');
//debugg($arCurrencyMultiplicity);
//debugg($arCurrencyOutCbrf);
//debugg($arResult['CUR']);

$arShowTable = [];
$arShowLine = [];
$ii = 1;
foreach ($arResult['CUR'] as $key=>$arCur) {
    if ($arCur[1] !== '/') {
        $arShowLine['name'] = $arCur[4];
        $symbol = $arCur[5];
        $arShowLine['symbol'] = $symbol;
        $arElement = explode("/", $arCur[1]);
        $arShowLine['buy'] = $arElement[0];
        $arShowLine['buy_move'] = $arElement[1];
        $arElement = explode("/", $arCur[2]);
        $arShowLine['sell'] = $arElement[0];
        $arShowLine['sell_move'] = $arElement[1];
        $arElement = explode("/", $arCur[3]);
        $arShowLine['cb'] = $arElement[0];
        $arShowLine['cb_move'] = $arElement[1];
        $arShowLine['note'] = '';
        $arShowLine['mark'] = '';
        if(!empty($arCur[7])) $arShowLine['multi'] = $arCur[7];
        else $arShowLine['multi'] = '';

        /*foreach ($arCurrencyOutCbrf as $item) {                  // сначала сортировка
            if($symbol == $item['UF_CURRENCY_OUT_CB']) {
                $arShowLine['note'] = "<sup>" . $ii . "</sup>";
                $ii += 1;
                $arShowLine['mark'] = 'cb';
            }
        }

        foreach ($arCurrencyMultiplicity as $item) {
            if($symbol == $item['UF_CURR_WITH_MULT']) {
                if($arShowLine['mark'] === 'cb') {
                    $arShowLine['mark'] = 'both';
                } else {
                    $arShowLine['mark'] = 'multi';
                    $arShowLine['note'] = "<sup>" . $ii . "</sup>";
                    $ii += 1;
                }
                $arShowLine['multi'] = $item['UF_MULT_COEFF'];
            }
        }*/
    }
    $arShowTable[$key] = $arShowLine;
}
usort($arShowTable, "compare_words2");
/*
$ii = 1;
foreach ($arShowTable as $key=>$arCur) {                                    // это все сделано в компоненте
    $symbol = $arCur['symbol'];
    foreach ($arCurrencyOutCbrf as $item) {
        if($symbol == $item['UF_CURRENCY_OUT_CB']) {
            $arShowTable[$key]['note'] = "<sup>" . $ii . "</sup>";
            $ii += 1;
            $arShowTable[$key]['mark'] = 'cb';
        }
    }

    foreach ($arCurrencyMultiplicity as $item) {
        if($symbol == $item['UF_CURR_WITH_MULT']) {
            if($arShowTable[$key]['mark'] === 'cb') {
                $arShowTable[$key]['mark'] = 'both';
            } else {
                $arShowTable[$key]['mark'] = 'multi';
                $arShowTable[$key]['note'] = "<sup>" . $ii . "</sup>";
                $ii += 1;
            }
            $arShowTable[$key]['multi'] = $item['UF_MULT_COEFF'];
            if (isset($item['UF_CURR_TEXT_MULT'])) {
                $arShowTable[$key]['genetive'] = $item['UF_CURR_TEXT_MULT'];
            } else {
                $arShowTable[$key]['genetive'] = ' единиц валюты';
            }
        }
    }
}
*/

unset($arShowLine);
unset($arShowTable);
