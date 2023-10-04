<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); // https://va-soft.ru/blog/bitrix-dynamic-menu/?>
<?//debugg($arResult); // https://www.youtube.com/watch?v=ugg20XU1Mqg&t=189s?>
<?if (!empty($arResult)):?>
<?debugg('menu.template subtop_menu_long');?>
<ul class="sub-menu">

<?foreach($arResult as $item):
	/*if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
		continue;*/?>
    <li>
        <a href="<?= $item['LINK']; ?>" <?= $item["SELECTED"]? 'style="color:#0a900b"' : ''; ?>>
            <?= $item['TEXT']; ?>
            <?if(!empty($item['subitems'])): ?>
                <span class="indicator"><i class="fa fa-angle-down"></i></span>
            <?endif;?>
        </a>

        <?if(!empty($item["subitems"])):?>
            <ul class="internal-menu">
                <?foreach ($item['subitems'] as $subitem):?>
                    <li><a href="<?= $subitem["LINK"]; ?>" class="selected"><?= $subitem["TEXT"]; ?></a></li>
                <?endforeach;?>
            </ul>
        <?endif?>
    </li>

<?endforeach?>

</ul>
<?endif?>