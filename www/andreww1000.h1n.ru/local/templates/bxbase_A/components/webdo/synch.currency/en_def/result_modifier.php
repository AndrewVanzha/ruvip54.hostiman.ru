<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();
    foreach ($arResult['CUR'] as $key => $arCur){
        if($key == "CNY") {
            $arResult['CUR'][$key][0] = "CNY Ұ <sup>2</sup>";
        }
    }
