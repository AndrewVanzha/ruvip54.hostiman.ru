<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global array $arParams */
use Bitrix\Main\Type\Collection;

// разбираюсь со структурой в массиве результатов
$arrSubresult = array();
$bg_color_class = "";
$email_class = "";
$comment_class = "";
$ix = 0;

if(count($arResult["arrResults"]) > 0) {
	//debugg($arResult["arrAnswers"]);
    foreach($arResult["arrAnswers"] as $ii=>$arItem) { // 8 10 9
        foreach($arItem as $key=>$item) {
            if($key == 8) {  // name
                $arrSubresult[$ix]["8"] = $arItem[$key][$key]["USER_TEXT"];
            }
            if($key == 10) {  // email
                $arrSubresult[$ix]["9"] = $arItem[$key][$key]["USER_TEXT"];
            }
            if($key == 9) {  // comment
                $arrSubresult[$ix]["10"] = $arItem[$key][$key]["USER_TEXT"];
            }
        }
        $ix += 1;
    }
}
$arResult["arrAnswers"]["arrSubresult"] = $arrSubresult;

unset($arrSubresult);
