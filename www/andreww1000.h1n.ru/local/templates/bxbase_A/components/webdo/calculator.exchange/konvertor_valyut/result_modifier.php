<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$i = 0;

$arResult["monetaryRate"] = [];
$arResult["monetaryRate"]["RUB"] = [
    "min" => 100,
    "max" => 10000,
];
//debugg("arResult['CUR']");
//debugg($arResult['CUR']);

foreach ($arResult['CUR'] as $currency) {
    if($currency['BUY'] == null && $currency['SELL'] == null) continue;
    if ($currency['BUY'] > 0) {
        if ($currency["NAME"] === "TRY") {
            $currency['BUY'] = floatval($currency['BUY']) / 10;
            $currency['SELL'] = floatval($currency['SELL']) / 10;
        }

        if ($currency["NAME"] === "JPY") {
            $currency['BUY'] = floatval($currency['BUY']) / 100;
            $currency['SELL'] = floatval($currency['SELL']) / 100;
        }

        $arResult["monetaryRate"][$currency['NAME']] = [
            "min" => 10,
            "max" => 10000,
            "sell" => [
                "RUB" => [
                    "value" => $currency['BUY'],
                    "caption" => $currency['BUY'] . " RUB"
                ]
            ],
            "buy" => [
                "RUB" => [
                    "value" => $currency['SELL'],
                    "caption" => $currency['SELL'] . " RUB"
                ]
            ]
        ];
        foreach ($arResult['CUR'] as $curs) {
            if ($curs["NAME"] === $currency["NAME"]) {
                continue;
            }
            if($curs['BUY'] == null && $curs['SELL'] == null) continue;

            if ($curs["NAME"] === "TRY") {
                $curs['BUY'] = floatval($curs['BUY']) / 10;
                $curs['SELL'] = floatval($curs['SELL']) / 10;
            }

            if ($curs["NAME"] === "JPY") {
                $curs['BUY'] = floatval($curs['BUY']) / 100;
                $curs['SELL'] = floatval($curs['SELL']) / 100;
            }

            $sell = round(floatval($currency['BUY']) / floatval($curs['BUY']), 4);
            $buy =  round(floatval($currency['SELL']) / floatval($curs['SELL']), 4);

            if ($sell == INF && $buy == INF) {
                continue;
            }
            if ($sell == NAN || $buy == NAN) {
                continue;
            }

            $arResult["monetaryRate"][$currency['NAME']]['sell'][$curs['NAME']] = [
                "value" => $sell,
                "caption" => $sell . " " . $curs['NAME']
            ];
            $arResult["monetaryRate"][$currency['NAME']]['buy'][$curs['NAME']] = [
                "value" => $buy,
                "caption" => $buy . " " . $curs['NAME']
            ];
        }

        $sell = round(1 / floatval($currency['BUY']), 4);
        $buy =  round(1 / floatval($currency['SELL']), 4);
        if ($sell == NAN || $buy == NAN) {
            continue;
        }
        $arResult["monetaryRate"]["RUB"]["sell"][$currency['NAME']] = [
            "value" => $sell,
            "caption" => $sell . " " . $currency['NAME']
        ];
        $arResult["monetaryRate"]["RUB"]["buy"][$currency['NAME']] = [
            "value" => $buy,
            "caption" => $buy . " " . $currency['NAME']
        ];
    }
}
//debugg("arResult['monetaryRate']");
//debugg($arResult['monetaryRate']);

$arResult["monetaryRate"] = json_encode($arResult["monetaryRate"]);
