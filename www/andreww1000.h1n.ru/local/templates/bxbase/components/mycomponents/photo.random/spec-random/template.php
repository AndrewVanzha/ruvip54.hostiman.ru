<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$frame = $this->createFrame()->begin('');
?>
<div class="photo-random">
    <h2>Копия шаблона в работе (выбор по Акции)</h2>
	<?if(is_array($arResult["PICTURE"])):?>
		<a href="<?=$arResult["DETAIL_PAGE_URL"]?>">
            <img
				src="<?=$arResult["PICTURE"]["src"]?>"
				width="<?=$arResult["PICTURE"]["width"]?>"
				height="<?=$arResult["PICTURE"]["height"]?>"
				alt="<?=$arResult["PICTURE"]["ALT"]?>"
				title="<?=$arResult["PICTURE"]["TITLE"]?>"
				/>
        </a>
	<?endif?>
	<a href="<?=$arResult["DETAIL_PAGE_URL"]?>"><?=$arResult["NAME"]?></a>
</div>
<?
$frame->end();
?>