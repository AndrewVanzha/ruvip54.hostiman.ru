<?
/**
 * @var $APPLICATION
 */

use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Резервирование курса наличной валюты");
$APPLICATION->SetPageProperty("description", "Резервирование курса наличной валюты");
$APPLICATION->SetTitle("Резервирование курса наличной валютый");
Asset::getInstance()->addCss("/assets/css/style-broker-deposit.css?v=1.0.6");
Asset::getInstance()->addCss("/dopX/rezervirovanie-kursa/style.css");
Asset::getInstance()->addJs("/assets/js/script-broker-deposit.js?v=1.0.6");

function workData($timestamp){
	if(date('w', $timestamp) < 1 || date('w', $timestamp) > 5) return false;
    if(date('G', $timestamp) < 9 || (date('G', $timestamp) >= 19 && date('i', $timestamp) !== '00')) return false;
    return true;
}

function checkCourse()
{
    $file = $_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/currency.json';

    if (!file_exists($file)) {
        return false;
    }

    $file_content = json_decode(file_get_contents($file), true);

    if (!$serviceCourse = $file_content['tsb']['data']['10013']['currency']) {
        return false;
    }

    return isset($serviceCourse['USD']) && isset($serviceCourse['EUR']);
}

?>
<? if (!empty($_SESSION['city']) && $_SESSION['city'] != 414): // Москва ?>
    <div class="page-lf">
        <div class="container">
            <section class="reservation-rate">
                <div class="reservation-rate__header">
                    <h2 class="reservation-rate__title page-title">
                        Резервирование курса <br>
                        наличной валюты </h2>
                </div>
                <div class="reservation-rate__city">
                    <p>
                        К сожалению, в выбранном городе сервис не доступен.
                    </p>
                    <p>
                        Для получения информации по обмену валюты, перейдите на страницу «Операции с валютой»
                    </p>
                </div>
                <div class="reservation-rate__button">
                    <!--a href="/chastnym-klientam/konvertor-valyut/">Операции с валютой</a-->
                    <a href="/dopX/currency/">Операции с валютой</a>
                </div>
            </section>
        </div>
    </div>
<? elseif (!workData(time())): ?>
    <div class="page-lf">
        <div class="container">
            <section class="reservation-rate">
                <div class="reservation-rate__header">
                    <h2 class="reservation-rate__title page-title">
                        Резервирование курса <br>
                        наличной валюты </h2>
                </div>
                <div class="reservation-rate__city">
                    <p>Уважаемые клиенты!</p>
                    <p>Услуги Сервиса резервирования курса наличной валюты предоставляются с понедельника по пятницу с
                        9:00 до 19:00 по московскому времени.</p>
                </div>
            </section>
        </div>
    </div>
<? elseif (!checkCourse()): ?>
    <div class="page-lf">
        <div class="container">
            <section class="reservation-rate">
                <div class="reservation-rate__header">
                    <h2 class="reservation-rate__title page-title">
                        Резервирование курса <br>
                        наличной валюты </h2>
                </div>
                <div class="reservation-rate__city">
                    <p>Уважаемые клиенты!</p>
                    <p>В данный момент Сервис резервирования курса наличной валюты недоступен.</p>
                </div>
            </section>
        </div>
    </div>
<? else: ?>
    <div class="page-lf">
        <div class="container">
            <section class="reservation-rate">
                <div class="reservation-rate__header">
                    <h2 class="reservation-rate__title page-title">
                        Резервирование курса <br>
                        наличной валюты </h2>
                </div>
                <div class="reservation-rate__banner row">
                    <div class="reservation-rate__image col-md-7">
                        <!--img alt="Резервирование курса валюты"
                             src="/chastnym-klientam/rezervirovanie-kursa/images/reservation_rate.png"-->
                        <img alt="Резервирование курса валюты"
                             src="/dopX/rezervirovanie-kursa/images/reservation_rate.png">
                    </div>
                    <div class="reservation-rate__advantages rr-advantages col-md-4 offset-md-1">
                        <div class="rr-advantages__item">
                            <!--div class="rr-advantages__icon">
                                <img src="/chastnym-klientam/rezervirovanie-kursa/images/Pause.svg" alt=""-->
                            <div class="rr-advantages__icon">
                                <img src="/dopX/rezervirovanie-kursa/images/Pause.svg" alt="">
                            </div>
                            <div class="rr-advantages__name">
                                Фиксация выгодного курса на 2 дня
                            </div>
                        </div>
                        <div class="rr-advantages__item">
                            <div class="rr-advantages__icon">
                                <!--img src="/chastnym-klientam/rezervirovanie-kursa/images/commission.svg" alt=""-->
                                <img src="/dopX/rezervirovanie-kursa/images/commission.svg" alt="">
                            </div>
                            <div class="rr-advantages__name">
                                Низкая ставка обеспечительного платежа
                            </div>
                        </div>
                        <div class="rr-advantages__item">
                            <div class="rr-advantages__icon">
                                <!--img src="/chastnym-klientam/rezervirovanie-kursa/images/no-commission.svg" alt=""-->
                                <img src="/dopX/rezervirovanie-kursa/images/no-commission.svg" alt="">
                            </div>
                            <div class="rr-advantages__name">
                                Без дополнительных комиссий
                            </div>
                        </div>
                    </div>
                </div>

                <? $APPLICATION->IncludeComponent(
                    //"loginoff:reservation.rate.form",
                    "webdo:reservation.rate.form",
                    "",
                    array()
                ); ?>

                <? $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "reservation-rate-faq",
                    array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "N",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "188",
                        "IBLOCK_TYPE" => "private_clients",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "20",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("", ""),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "ID",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N"
                    )
                ); ?>
            </section>
        </div>
    </div>
<? endif; ?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>