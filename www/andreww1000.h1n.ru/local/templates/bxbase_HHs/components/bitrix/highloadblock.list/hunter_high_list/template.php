<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	echo $arResult['ERROR'];
	return false;
}

//$GLOBALS['APPLICATION']->SetTitle('Highloadblock List');

?>

<div class="reports-list-wrap">
	<?//debugg($arResult);?>
	<?foreach($arResult["rows"] as $item): ?>
		<?$url = str_replace(
			array('#ID#', '#BLOCK_ID#'),
			array($item["ID"], intval($arParams['BLOCK_ID'])),
			$arParams['DETAIL_URL']
		);?>
	<div class="coll col-lg-3 col-xs-2 info__box">
		<h3 class="info__box_header bg-blue">
			<a href="<?=$url?>"><?=$item["UF_PERSONAL_NAME"]?></a>
		</h3>
		<p class="info__box_email">
			<a href="mailto:<?=$item["UF_PERSONAL_EMAIL"]?>"><?=$item["UF_PERSONAL_EMAIL"]?></a>
		</p>
		<p class="info__box_tel"><?=$item["UF_PERSONAL_TEL"]?></p>
		<p class="info__box_comment"><?=$item["UF_PERSONAL_COMMENT"]?></p>
	</div>
	<?endforeach; ?>
</div>

<?php
/*if ($arParams['ROWS_PER_PAGE'] > 0):
	$APPLICATION->IncludeComponent(
		'bitrix:main.pagenavigation',
		'',
		array(
			'NAV_OBJECT' => $arResult['nav_object'],
			'SEF_MODE' => 'N',
		),
		false
	);
endif;*/

// https://yandex.ru/video/preview/?text=%D0%B1%D0%B8%D1%82%D1%80%D0%B8%D0%BA%D1%81%20%D0%B7%D0%B0%D0%BF%D0%B8%D1%81%D1%8C%20%D0%B2%20highload%20%D0%B1%D0%BB%D0%BE%D0%BA%20%D1%87%D0%B5%D1%80%D0%B5%D0%B7%20api&path=wizard&parent-reqid=1627970547329843-17805953415471059110-sas3-0737-9f4-sas-l7-balancer-8080-BAL-4638&wiz_type=vital&filmId=7217791734947689521
?>
