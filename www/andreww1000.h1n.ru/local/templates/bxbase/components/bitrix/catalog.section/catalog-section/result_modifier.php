<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$arSections = Array();
$arBundle = Array();

//debugg($arResult);
//debugg($arResult["ITEMS"]);

// https://bxapi.ru/src/?module_id=iblock&name=CIBlockSectionPropertyLink::GetArray

debugg($GLOBALS[$arParams["FILTER_NAME"]]["SECTION_ID"]);
$arPr1 = Array();
$res1 = CIBlockSectionPropertyLink::GetArray(4, $GLOBALS[$arParams["FILTER_NAME"]]["SECTION_ID"]);
debugg($res1);

$ix = 0;
foreach ($res1 as $item) {
    $obs = CIBlockProperty::GetByID($item["PROPERTY_ID"], 4); // список свойств в зависимости от раздела
    while($enum_fields = $obs->GetNext()) {
        $arPr1[$ix]["ID"] = $enum_fields["ID"];
        $arPr1[$ix]["NAME"] = $enum_fields["NAME"];
        $arPr1[$ix]["~NAME"] = $enum_fields["~NAME"];
        $arPr1[$ix]["CODE"] = $enum_fields["CODE"];
    }
    $ix += 1;
}
debugg($arPr1);

//$arResult["BUNDLE"]["DISPLAY_PROPERTIES"] = $arPr1;

unset($arPr1);
unset($arSections);
unset($arBundle);
