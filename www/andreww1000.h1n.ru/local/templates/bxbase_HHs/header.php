<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<!DOCTYPE html>
<html>
	<head>
        <?//$APPLICATION->AddHeadScript('/bitrix/js/main/core/core.js')?>

        <?
        use Bitrix\Main\Page\Asset;
        $Asset = Asset::getInstance();

        $Asset->addCss(SITE_TEMPLATE_PATH . '/libs/bootstrap.min.css');

        $Asset->addJs(SITE_TEMPLATE_PATH . '/libs/jquery-3.4.0.min.js');
        $Asset->addJs(SITE_TEMPLATE_PATH . '/libs/jquery.validate.min.js');
        $Asset->addJs(SITE_TEMPLATE_PATH . '/libs/bootstrap.min.js');
        ?>

		<?$APPLICATION->ShowHead();?>
		<title><?$APPLICATION->ShowTitle();?></title>
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

        <? /*google recaptcha v3*/ /*?>
        <script async src='https://www.google.com/recaptcha/api.js?render=<?=PUBLIC_KEY?>'></script>
        <?*/?>

    </head>
	<body>
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>
	
		<header class="header-container">
            <div class="container">
                <div class="header-info">
                    <a href="https://honey-hunters.ru/ru/main.html"><img src="upload/images/logo-main_HoneyHunters.png" alt="лого компании"></a>
                </div>
            </div>

        </header>
		<main class="main-container">
            <?/*?>
            <div class="container">
            <?$APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "",
                Array(
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0"
                )
            );?>
            </div>
            <?*/?>
