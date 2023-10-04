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

        $Asset->addCss(SITE_TEMPLATE_PATH . '/libs/bootstrap.min.css');

        $Asset->addJs(SITE_TEMPLATE_PATH . '/libs/jquery-3.4.0.min.js');
        $Asset->addJs(SITE_TEMPLATE_PATH . '/libs/jquery.validate.min.js');
        $Asset->addJs(SITE_TEMPLATE_PATH . '/libs/bootstrap.min.js');
        ?>
        <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>

        <? /*google recaptcha v3*/ ?>
        <script async src='https://www.google.com/recaptcha/api.js?render=<?=PUBLIC_KEY?>'></script>

    </head>
	<body>
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>
	
		<header class="header-container">
			<div class="container">

				<?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    //"bootstrap_v4",
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
                        //"ROOT_MENU_TYPE" => "left",
                        "ROOT_MENU_TYPE" => "top",
                        "USE_EXT" => "N",
                        //"COMPONENT_TEMPLATE" => "bootstrap_v4",
                        "COMPONENT_TEMPLATE" => "main_menu",
                        "MENU_THEME" => "site"
                    ),
                    false
                );?>
			</div>

            <div class="container">
                <div class="header-info">
                    <div class="header-info-box flex_box">
                        <h3>Очень и очень длинная срока</h3>
                        <div>
                            <a href="#">header header</a>
                            <p>header comment</p>
                        </div>
                    </div>
                    <div class="inter-box flex_box">
                        <p>intermediary</p>
                        <span>addition</span>
                    </div>
                    <div class="system_auth_form flex_box">
                        <h2>Авторизация</h2>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:system.auth.form",
                            "auth_header",
                            //"auth_top",
                            //"",

                            Array(
                                //"FORGOT_PASSWORD_URL" => "/auth/forgot.php",	// Страница забытого пароля
                                "FORGOT_PASSWORD_URL" => "/auth/",	// Страница забытого пароля
                                "PROFILE_URL" => "/auth/profile.php",	// Страница профиля
                                "REGISTER_URL" => "/auth/registration.php",	// Страница регистрации
                                "SHOW_ERRORS" => "Y",	// Показывать ошибки
                            ),
                            false
                        );?>
                        <?global $USER; if ($USER->IsAuthorized()){ echo 'Вы авторизованы!='; echo $USER->GetID(); }?>
                    </div>
                </div>
            </div>

        </header>bxbase
		<main class="main-container">
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
