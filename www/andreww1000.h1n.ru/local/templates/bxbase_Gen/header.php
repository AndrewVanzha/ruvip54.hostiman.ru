<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<!DOCTYPE html>
<html>
	<head>
        <?//$APPLICATION->AddHeadScript('/bitrix/js/main/core/core.js')?>
		<?$APPLICATION->ShowHead();?>
		
    <meta charset="UTF-8">
    <meta name="description" content="Набор для руководителя">
    <meta name="keywords" content="набор, руководитель, расписание, отчеты">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Тест для Генератор продаж</title>
    <link rel="stylesheet" href="/style_generator.css">

        <?
        use Bitrix\Main\Page\Asset;
        $Asset = Asset::getInstance();
        ?>

    </head>
	<body>
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>
	
		<header class="header-container">
        </header>
		<main class="main-container">
