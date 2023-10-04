<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="menu-block">
	<ul class="main-menu">

	<?
	foreach($arResult as $arItem):
		if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
			continue;
	?>
		<?if($arItem["SELECTED"]):?>
			<li><a href="<?=$arItem["LINK"]?>" class="selected"><?=$arItem["TEXT"]?></a></li>
		<?else:?>
			<li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
		<?endif?>
		
	<?endforeach?>

	</ul>
</div>
<?endif?>
<script>
    let var_root = document.querySelector(':root');
    let root_style = getComputedStyle(var_root);
    let fstyle = root_style.getPropertyValue('--font-size');
    //console.log(var_root);
    //console.log(root_style);
    //console.log(fstyle);
</script>
