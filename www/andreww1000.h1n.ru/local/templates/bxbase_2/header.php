<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<!DOCTYPE html>
<html>
	<head>
        <?//$APPLICATION->AddHeadScript('/bitrix/js/main/core/core.js')?>
		<?$APPLICATION->ShowHead();?>
		<title><?$APPLICATION->ShowTitle();?></title>
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

        <?
        use Bitrix\Main\Page\Asset;
        $Asset = Asset::getInstance();

        $Asset->addJs(SITE_TEMPLATE_PATH . '/libs/jquery-3.4.0.min.js');
        $Asset->addJs(SITE_TEMPLATE_PATH . '/libs/jquery.validate.min.js');
        ?>

        <? /*google recaptcha v3*/ ?>
        <script async src='https://www.google.com/recaptcha/api.js?render=<?=PUBLIC_KEY?>'></script>

        <!-- 2ГИС карты -->
        <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
    </head>
	<body>
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>
	
		<header class="header-container">
			<div class="container">

				<?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "main_menu",
					array(
						"ALLOW_MULTI_SELECT" => "N",
						"CHILD_MENU_TYPE" => "submenu",
						"DELAY" => "N",
						"MAX_LEVEL" => "2",
						"MENU_CACHE_GET_VARS" => array(
						),
						"MENU_CACHE_TIME" => "3600",
						"MENU_CACHE_TYPE" => "N",
						"MENU_CACHE_USE_GROUPS" => "Y",
						"ROOT_MENU_TYPE" => "top",
                        //"ROOT_MENU_TYPE" => "left",
						"USE_EXT" => "N",
						"COMPONENT_TEMPLATE" => "main_menu"
					),
					false
				);?>			
			</div>
        </header>bxbase 2
		<main class="main-container">
