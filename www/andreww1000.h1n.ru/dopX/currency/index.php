<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Комплекс");
?>
<div class="container">
    <?/*?> перемещено
	<h1>Комплексное меню</h1>
	<h2>Инфоблоки Оборудование и Реклама</h2>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"subtop_menu_long",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "subtop",
		"DELAY" => "N",
		"MAX_LEVEL" => "3",
		"MENU_CACHE_GET_VARS" => array(0=>"",),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "subtop",
		"USE_EXT" => "Y"
	)
    );*/?>

    <div class="v21">
        <div class="v21-citySelector">
            <a href="#citySelector" data-fancybox class="v21-header__link v21-header__link--contacts v21-link">
                <svg width="14" height="14" class="v21-header__link-icon">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_icons.svg#compass"></use>
                </svg>
                <span class="v21-link__text v21-link__text--inv">
                            <?
                            if (CSite::InDir('/en/')) {
                                echo \GarbageStorage::get('english_name');
                            } else {
                                echo \GarbageStorage::get('name');
                            }
                            if(isset($_GET['office'])) {
                                $office = htmlspecialchars($_GET['office']);
                                \GarbageStorage::set('OfficeId', $office);
                            }
                            ?>
                </span>
                <svg width="7" height="4" class="v21-header__link-icon">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_icons.svg#chevron"></use>
                </svg>
            </a>
        </div>
    </div>
</div>
<div class="container v21-section v21-section-courses">
	<h2 class="kompleks-currency v21-section__heading-title v21-h2">Операции с валютой в <? if (CSite::InDir('/en/')) {
            echo \GarbageStorage::get('english_name');
        } else {
            echo \GarbageStorage::get('nameWhere');
        }
        ?>
    </h2>
    <p class="kompleks-currency__subtitle v21-p v21-section__subtitle">Здесь вы можете найти выгодный курс покупки-продажи наличной валюты более 30 стран мира и выбрать ближайший пункт обмена.</p>
    <?$APPLICATION->IncludeComponent(
        "webdo:calculator.exchange",
        "konvertor_valyut",
        Array(
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "OFFICE_IBLOCK_ID" => "16" // Курс валют банка по офисам
        )
    );?>
</div>
<hr>
<div class="container v21-section v21-section-courses">
    <?/*$APPLICATION->IncludeComponent(
        "webdo:currency_synch",
        "def",
        Array(
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A"
        )
    );*/?>
</div>

<p>Форма в футере</p>
<?
//Отображаем форму в футере
\GarbageStorage::set('feedback', true);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>