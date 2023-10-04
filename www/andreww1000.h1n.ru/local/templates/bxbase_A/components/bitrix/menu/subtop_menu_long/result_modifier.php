<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global array $arParams */
use Bitrix\Main\Type\Collection;

$arPrepItems = [];
if(!empty($arResult)) {
    foreach ($arResult as $key=>$item) {
        if($item["DEPTH_LEVEL"] === 1) {
            $arPrepItems[] = $item;
        } else {
            $arPrepItems[end(array_keys($arPrepItems))]["subitems"][] = $item;
        }
    }
}
$arResult = $arPrepItems;

$arSubSections = [];
$itItems = CIBlockSection::GetList(
    ['SORT' => 'ASC'],
    ['IBLOCK_ID' => 2, 'ACTIVE' => 'Y'],
    false,
    array(),
    false
);
while($arSub = $itItems->GetNext()) {
    $arSubSections[] = $arSub;
}
//debugg($arSubSections);

$arSubItems = [];
$itItems = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['IBLOCK_ID' => 2, 'ACTIVE' => 'Y'],
    false,
    false,
    ['NAME','DETAIL_PAGE_URL']
);
while($arSub = $itItems->GetNext()) {
    $arSubItems[] = [
        $arSub['NAME'],
        $arSub['DETAIL_PAGE_URL'],
        [$arSub['DETAIL_PAGE_URL']],
        [
            'FROM_IBLOCK' => 2,
            'IS_PARENT' => false,
            'DEPTH_LEVEL' => 3
        ]
    ];
}
//debugg($arSubItems);