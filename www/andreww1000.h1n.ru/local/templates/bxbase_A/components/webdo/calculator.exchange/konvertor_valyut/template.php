<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { ?>
    <? die(); ?>
<? } ?>
<? $officeId = htmlspecialchars($_GET['office']); ?>
<?
$phpSelf = $_SERVER['PHP_SELF'];
if (substr($phpSelf, -9) == "index.php") {
    $phpSelf = substr($phpSelf, 0, -9);
}
if (isset($_GET["city"]) && ($_GET["city"] != $_SESSION["city"])) {
    header('Location: http://' . $_SERVER['SERVER_NAME'] . $phpSelf);
    exit();
}
$OfficeCode = \GarbageStorage::get('OfficeCode');
$cityID = $_SESSION["city"];
?>
<?
//debugg($_SESSION["city"]);
//debugg($arResult);
//debugg(gd_info());
//debugg($_SERVER['DOCUMENT_ROOT'].'/upload/p_dog1.webp');
?>
<?php/*?>
<img src="<?='/upload/'?>p_dog1.webp" class="" alt="Картинка WebP" data-noaft="1" style="width: 815px; height: 611.25px; margin: 0px; display: block;">
<img src="http://veg.by/files/habr/webp_vs_jpeg/p_dog1.webp" class="" alt="Картинка WebP" data-noaft="1" style="width: 815px; height: 611.25px; margin: 0px; display: block;">
<?php*/?>

<?// debugg($arResult['CUR']) ;?>
<div class="v21-section v21-section--konvertor">

    <div class="v21-section--konvertor__preheader v21-exchange-info__date">Данные на&nbsp;<span id="exchange-date"></span>, <?= \GarbageStorage::get('name'); ?></div>
    <div class="v21-section--konvertor__wrap-main">

        <div class="v21-exchange-box"">
            <div class="v21-section-calc-up">
                <div class="v21-exchange-calc__img-top v21-exchange-calc__img-top--up">
                    <img src="images/currency_konvertor-ring.png">
                </div>
            </div>
            <div class="v21-exchange-calc__main">
            <div class="v21-exchange-calc__content">
                <div class="v21-exchange-calc__img-top v21-exchange-calc__img-top--down">
                    <img src="images/currency_konvertor-ring.png">
                </div>
                <div class="v21-exchange-calc is-active" id="v21_exCalc">
                    <div class="v21-exchange-calc__header-box">
                        <h3 class="v21-exchange-calc__title v21-h3">Конвертер валют</h3>
                        <div class="v21-exchange-calc__type">
                            <div class="v21-switch">
                                <input type="radio" name="v21_exCalcType" id="v21_exCalcBuy" value="sell" checked class="v21-switch__input">
                                <label for="v21_exCalcBuy" class="v21-exchange-calc__type-label v21-switch__label">Продать</label>
                                <input type="radio" name="v21_exCalcType" id="v21_exCalcSell" value="buy" class="v21-switch__input">
                                <label for="v21_exCalcSell" class="v21-exchange-calc__type-label v21-switch__label">Купить</label>
                                <div class="v21-switch__handle"></div>
                            </div>
                        </div><!-- /.v21-exchange-calc__type -->
                    </div>

                    <div class="v21-exchange-calc__course">
                        <div class="v21-exchange-calc__course-text">По курсу <span class="js-v21-exchange-calc-course"><?= $curVar ?></span></div>
                    </div><!-- /.v21-exchange-calc__course -->

                    <?/*?>
                    <div class="v21-exchange-calc__brief">
                        <? if ($arResult['NAME_OFFICE'] != 'iSimple') {
                            $officeName = $arResult['NAME_OFFICE'];
                        } else {
                            $officeName = 'ТСБ-онлайн';
                        } ?>
                        Данные для офиса «<?= $officeName; ?>»<br>
                        по&nbsp;состоянию на&nbsp;<span id="exchange-date"></span>
                    </div>
                    <?*/?>

                    <div class="v21-exchange-calc__fields">
                        <div class="v21-exchange-calc__side">
                            <div class="v21-input-combo">
                                <input type="text" value="1000" name="v21_exCalcLeftInput" class="v21-input-combo__field v21-input-group__field v21-field">
                                <div class="v21-input-combo__select">


                                    <?/*?>
                                    <div class="v21-input-combo__select">
                                        <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true" aria-expanded="false">
                                            <div class="choices__inner">
                                                <select name="v21_exCalcLeftSelect" class="v21-select choices__input" hidden="" tabindex="-1" data-choice="active">
                                                    <option value="USD">USD</option>
                                                </select>
                                                <div class="choices__list choices__list--single">
                                                    <div class="choices__item choices__item--selectable" data-item="" data-id="2" data-value="USD" data-custom-properties="null" aria-selected="true">
                                                        USD
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="choices__list choices__list--dropdown" aria-expanded="false">
                                                <div class="choices__list" role="listbox">
                                                    <div id="choices--v21_exCalcLeftSelect-hv-item-choice-1" class="choices__item choices__item--choice choices__item--selectable is-highlighted" role="option" data-choice="" data-id="1" data-value="RUB" data-select-text="" data-choice-selectable="" aria-selected="true">
                                                        RUB
                                                    </div>
                                                    <div id="choices--v21_exCalcLeftSelect-hv-item-choice-2" class="choices__item choices__item--choice is-selected choices__item--selectable" role="option" data-choice="" data-id="2" data-value="USD" data-select-text="" data-choice-selectable="">
                                                        USD
                                                    </div>
                                                    <div id="choices--v21_exCalcLeftSelect-hv-item-choice-3" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="3" data-value="EUR" data-select-text="" data-choice-selectable="">
                                                        EUR                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-4" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="4" data-value="GBP" data-select-text="" data-choice-selectable="">
                                                        GBP                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-5" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="5" data-value="CHF" data-select-text="" data-choice-selectable="">
                                                        CHF                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-6" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="6" data-value="JPY" data-select-text="" data-choice-selectable="">
                                                        JPY                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-7" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="7" data-value="CNY" data-select-text="" data-choice-selectable="">
                                                        CNY                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-8" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="8" data-value="AUD" data-select-text="" data-choice-selectable="">
                                                        AUD                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-9" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="9" data-value="AZN" data-select-text="" data-choice-selectable="">
                                                        AZN                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-10" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="10" data-value="AMD" data-select-text="" data-choice-selectable="">
                                                        AMD                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-11" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="11" data-value="BYN" data-select-text="" data-choice-selectable="">
                                                        BYN                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-12" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="12" data-value="BGN" data-select-text="" data-choice-selectable="">
                                                        BGN                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-13" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="13" data-value="HUF" data-select-text="" data-choice-selectable="">
                                                        HUF                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-14" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="14" data-value="HKD" data-select-text="" data-choice-selectable="">
                                                        HKD                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-15" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="15" data-value="DKK" data-select-text="" data-choice-selectable="">
                                                        DKK                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-16" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="16" data-value="INR" data-select-text="" data-choice-selectable="">
                                                        INR                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-17" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="17" data-value="KZT" data-select-text="" data-choice-selectable="">
                                                        KZT                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-18" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="18" data-value="CAD" data-select-text="" data-choice-selectable="">
                                                        CAD                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-19" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="19" data-value="KGS" data-select-text="" data-choice-selectable="">
                                                        KGS                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-20" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="20" data-value="MDL" data-select-text="" data-choice-selectable="">
                                                        MDL                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-21" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="21" data-value="SGD" data-select-text="" data-choice-selectable="">
                                                        SGD                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-22" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="22" data-value="TJS" data-select-text="" data-choice-selectable="">
                                                        TJS                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-23" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="23" data-value="TRY" data-select-text="" data-choice-selectable="">
                                                        TRY                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-24" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="24" data-value="CZK" data-select-text="" data-choice-selectable="">
                                                        CZK                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-25" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="25" data-value="ZAR" data-select-text="" data-choice-selectable="">
                                                        ZAR                                            </div><div id="choices--v21_exCalcLeftSelect-hv-item-choice-26" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="26" data-value="KRW" data-select-text="" data-choice-selectable="">
                                                        KRW
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="choices__list--single_html">Доллар США</div>
                                        </div>
                                    </div>
                                    <?*/?>



                                    <select name="v21_exCalcLeftSelect" class="v21-select">
                                        <option value="RUB">RUB</option>
                                        <?
                                        $i = 0;
                                        foreach ($arResult['CUR'] as $currency) { ?>
                                            <? if ($currency['BUY'] > 0) { ?>
                                                <? if ($i++ == 0) $curVar = $currency['SELL']; ?>
                                                <option value="<?= $currency['NAME'] ?>">
                                                    <?= $currency['NAME']; ?>
                                                </option>
                                            <? } ?>
                                        <? } ?>
                                    </select>
                                </div>
                            </div><!-- /.v21-input-combo -->
                            <div class="v21-exchange-calc__slider">
                                <div class="js-v21-exchange-calc-left-slider"></div>
                                <div class="v21-exchange-calc__marks">
                                    <div class="js-v21-exchange-calc-left-min"></div>
                                    <div class="js-v21-exchange-calc-left-max"></div>
                                </div>
                            </div><!-- /.v21-exchange-calc__slider -->
                        </div><!-- /.v21-exchange-calc__side -->

                        <div class="v21-exchange-calc__swap-img js-v21-exchange-calc-swap">
                            <img src="images/change_places.png" alt="поменять местами">
                        </div>
                        <?/*?><div class="v21-exchange-calc__swap v21-button js-v21-exchange-calc-swap">
                            <svg width="32" height="32">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#swap"></use>
                            </svg>
                        </div><?*/?>

                        <div class="v21-exchange-calc__side">
                            <div class="v21-input-combo">
                                <input type="text" name="v21_exCalcRightInput" class="v21-input-combo__field v21-input-group__field v21-field">
                                <div class="v21-input-combo__select">
                                    <select name="v21_exCalcRightSelect" class="v21-select">
                                        <option value="RUB" selected>RUB</option>
                                        <?
                                        $i = 0;
                                        foreach ($arResult['CUR'] as $currency) { ?>
                                            <? if ($currency['BUY'] > 0) { ?>
                                                <? if ($i++ == 0) $curVar = $currency['SELL']; ?>
                                                <option value="<?= $currency['NAME'] ?>">
                                                    <?= $currency['NAME'] ?>
                                                </option>
                                            <? } ?>
                                        <? } ?>
                                    </select>
                                </div>
                            </div><!-- /.v21-input-combo -->
                            <div class="v21-exchange-calc__slider">
                                <div class="js-v21-exchange-calc-right-slider"></div>
                                <div class="v21-exchange-calc__marks">
                                    <div class="js-v21-exchange-calc-right-min"></div>
                                    <div class="js-v21-exchange-calc-right-max"></div>
                                </div>
                            </div><!-- /.v21-exchange-calc__slider -->
                        </div><!-- /.v21-exchange-calc__side -->
                    </div><!-- /.v21-exchange-calc__fields -->
                </div>

                <script>
                    $(document).ready(function () {
                        let new_curr_0 = 'USD';
                        let new_curr_1 = 'RUB';
                        let arCurr = $.parseJSON('<?php echo json_encode($arResult['CUR']); ?>');

                        function ask_curr_symbol() {
                            let currency_symbol = $('.v21-input-combo__select .v21-select.choices__input option');
                            return currency_symbol;
                        }

                        //console.log(arCurr); js-v21-exchange-calc-swap
                        let curr_sy = $('.v21-input-combo__select .choices__list--single');
                        $(curr_sy[0]).parent().parent().append('<div class="choices__list--single_html">' + arCurr[new_curr_0]['LONGNAME'] + '</div>');

                        $('.v21-input-combo__select .choices__list--single').on('click', function () {
                            let $this = $(this);
                            let curr_0 = ask_curr_symbol()[0].value;
                            let curr_1 = ask_curr_symbol()[1].value;

                            let curr_intrvl = setInterval(() => {
                                let curr_sy_0 = ask_curr_symbol()[0].value;
                                let curr_sy_1 = ask_curr_symbol()[1].value;
                                if(curr_0 != curr_sy_0) {
                                    new_curr_0 = curr_sy_0;
                                    clearInterval(curr_intrvl);
                                    $this.parent().next().next().remove();
                                    if(arCurr[new_curr_0]) {
                                        $this.parent().parent().append('<div class="choices__list--single_html">' + arCurr[new_curr_0]['LONGNAME'] + '</div>');
                                    }
                                }
                                if(curr_1 != curr_sy_1) {
                                    new_curr_1 = curr_sy_1;
                                    clearInterval(curr_intrvl);
                                    $this.parent().next().next().remove();
                                    if(arCurr[new_curr_1]) {
                                        $this.parent().parent().append('<div class="choices__list--single_html">' + arCurr[new_curr_1]['LONGNAME'] + '</div>');
                                    }
                                }
                            }, 200);
                        });
                    });
                </script>

                <form action="" method="get" class="v21_exchange-converter">
                    <input type="hidden" name="city" value="<?= $_SESSION["city"] ?>">
                    <?/*?><input type="hidden" name="office_code" value="<?= $OfficeCode ?>"><?*/?>

                    <div class="v21-section v21-section--border">
                        <?// debugg($arResult['OFFICE']) ;?>
                        <div class="v21-intro-card v21-intro-card--list">
                            <h3 class="v21-intro-header v21-intro-card__box v21-intro-card__width v21-intro-card__width--xs">
                                <div class="v21-intro-card--image">
                                    <img src="images/bank_symbol.png" alt="символ банка">
                                </div><!-- /.intro-card__image -->
                                <p class="v21-intro-header--text">В каком офисе Трансстройбанка купить данную валюту?</p>
                            </h3>
                            <div class="v21-intro-card__content v21-intro-card__box">
                                <div class="v21-intro-card__location js-v21-tabs">
                                    <?/*?><div>Выберите удобный для вас офис банка для обмена валюты</div><?*/?>
                                    <div class="v21-intro-card__location_select--wrap">
                                        <? $nOffice = 4; $iOffice = 0; ?>
                                        <? foreach ($arResult['OFFICE'] as $key=>$arOffice) : ?>
                                            <div class="v21-intro-card__location_select--block <?= ($iOffice > 3)? 'is-hidden' : ''; ?>">
                                                <div class="v21-intro-card__location_select--textbox">
                                                    <? if ($arOffice['NAME'] != 'iSimple') :
                                                        $officeName = $arOffice['NAME']; ?>
                                                        <p class="js-v21-intro-card" data-office="<?=$arOffice['ID']?>" data-city="<?=$cityID?>" data-num="<?=$key?>"><?= $officeName?></p>
                                                        <p class="v21-p--address"><?= $arOffice['PROPERTY_ATT_ADDRESS_CITY_VALUE']; ?>, <?= $arOffice['PROPERTY_ATT_ADDRESS_VALUE']; ?></p>
                                                        <p class="v21-p--hours_string"><?= $arOffice['PROPERTY_ATT_OFFICE_HOURS_VALUE']; ?></p>
                                                        <p>
                                                            <span class="v21-p--hours_add"><?= $arOffice['PROPERTY_ATT_OFFICE_HOURS_VALUE'] . ' | '; ?></span>
                                                            <a href="tel:<?= $arOffice['PROPERTY_ATT_PHONE_LINK_VALUE']; ?>"><?= $arOffice['PROPERTY_ATT_PHONE_VALUE']; ?></a>
                                                        </p>
                                                    <? /*else:
                                                        $officeName = 'ТСБ-онлайн'; ?>
                                                        <p class="js-v21-intro-card" data-office="<?=$arOffice['ID']?>" data-city="<?=$cityID?>" data-num="<?=$key?>"><?= $officeName?></p>
                                                        <?*/?>
                                                    <? endif; ?>
                                                </div>

                                                <? if ($arOffice['NAME'] != 'iSimple') : ?>
                                                <div class="v21-intro-card__location_select--geobox">
                                                    <div class="v21-intro-card__location_select--geobox-symbol js-select-yandex-geobox"
                                                         data-office="<?=$arOffice['ID']?>"
                                                         data-city="<?=$cityID?>"
                                                         data-position="<?=$arOffice['PROPERTY_ATT_YANDEX_POS_VALUE']?>"
                                                    >
                                                        <?/*?>
                                                        <img src="images/yzndex_maps.png" alt="яндекс карта">
                                                        <?*/?>
                                                        <a href="<?=$arOffice["PROPERTY_ATT_YANDEX_LOCATION_VALUE"]?>" target="_blank">
                                                            <img src="/images/yzndex_box.png" alt="яндекс карта">
                                                        </a>
                                                        <??>
                                                    </div>
                                                    <?/*?>
                                                    <div class="v21-intro-card__location_select--geobox-symbol js-select-google-geobox"
                                                         data-office="<?=$arOffice['ID']?>"
                                                         data-city="<?=$cityID?>"
                                                         data-position="<?=$arOffice['PROPERTY_ATT_YANDEX_POS_VALUE']?>"
                                                    >
                                                        <img src="images/Google_Maps.png" alt="гугль карта">
                                                    </div>
                                                    <?*/?>
                                                    <div class="v21-intro-card__location_select--geobox-symbol js-select-gis-geobox"
                                                         data-office="<?=$arOffice['ID']?>"
                                                         data-city="<?=$cityID?>"
                                                         data-position="<?=$arOffice['PROPERTY_ATT_YANDEX_POS_VALUE']?>"
                                                         data-num="<?=$key?>"
                                                    >
                                                        <a href="<?=$arOffice["PROPERTY_ATT_2GIS_LOCATION_VALUE"]?>" target="_blank">
                                                            <img src="/images/2gis_box.png" alt="2gis карта">
                                                        </a>
                                                    </div>
                                                </div>
                                                <? endif; ?>

                                                <div class="v21-intro-map__popup">
                                                    <div class="v21-intro-map__popup--close js-v21-intro-map__popup--close">X</div>
                                                    <?/*?><div class="v21-intro-map__popup_yandex">yandex map</div><?*/?>
                                                    <div class="v21-intro-map__popup_yandex">yandex
                                                        <? /*$arPos = explode(",", $arOffice['PROPERTY_ATT_YANDEX_POS_VALUE']);
                                                        $APPLICATION->IncludeComponent(
                                                            "bitrix:map.yandex.view",
                                                            "",
                                                            Array(
                                                                "INIT_MAP_TYPE" => "MAP",
                                                                "MAP_DATA" => serialize(array(
                                                                    'yandex_lat' => $arPos[0],
                                                                    'yandex_lon' => $arPos[1],
                                                                    'yandex_scale' => 13,
                                                                    'PLACEMARKS' => array (
                                                                        array(
                                                                            'TEXT' => $arPos[0] . ", " . $arPos[1],
                                                                            'LON' => $arPos[1],
                                                                            'LAT' => $arPos[0],
                                                                        ),
                                                                    ),
                                                                )),
                                                                "MAP_WIDTH" => "100%",
                                                                "MAP_HEIGHT" => "300",
                                                                "CONTROLS" => array("ZOOM", "MINIMAP", "TYPECONTROL", "SCALELINE"),
                                                                "OPTIONS" => array("DESABLE_SCROLL_ZOOM", "ENABLE_DBLCLICK_ZOOM", "ENABLE_DRAGGING"),
                                                                "MAP_ID" => ""
                                                            ),
                                                            false
                                                        ); */?>
                                                    </div>
                                                    <div class="v21-intro-map__popup_google">google
                                                    </div>
                                                    <div class="v21-intro-map__popup_gis">
                                                        <div id="map_gis_<?=$key?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <? if ($arOffice['NAME'] != 'iSimple') : ?>
                                                <hr class="v21-intro-card__location_select--hr <?= ($iOffice > 3)? 'is-hidden' : ''; ?>">
                                            <? endif; ?>
                                            <? $iOffice += 1;?>
                                        <? endforeach; ?>
                                        <input type="hidden" name="office">
                                        <? if(count($arResult['OFFICE']) >= 4) : ?>
                                            <div class="v21-intro-card__appendix v21-intro-card__appendix-check">
                                                <p class="">Показать ещё</p>
                                                <svg width="9" height="9" class="v21-button__icon">
                                                    <use xlink:href="/images/v21_v21-icons.svg#arrowDownSmall"></use>
                                                </svg>
                                            </div>
                                        <? endif; ?>
                                    </div>

                                </div><!-- /.v21-exchange-location -->
                            </div><!-- /.v21-intro-card__content -->
                        </div><!-- /.v21-intro-card -->
                    </div><!-- /.v21-section -->
                </form>

            </div><!-- /.v21-exchange-calc__content -->

                <div class="v21-exchange-calc__img-bottom v21-exchange-calc__img-bottom--up">
                    <img src="images/currency_ball.png">
                </div>
            </div>
            <div class="v21-section--calc-down">
                <div class="v21-exchange-calc__img-bottom v21-exchange-calc__img-bottom--down">
                    <img src="images/currency_ball.png">
                </div>
            </div>
        </div><!-- /.v21-exchange-calc -->

        <? $res = $APPLICATION->IncludeComponent(
            "webdo:currency_synch",
            //"webdo:synch.currency",
            //"deff",
            //"def",
            "new_table",
            array(
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CBR_IBLOCK_ID" => "116", // Курсы валют ЦБ - не используется
                "OFFICE_IBLOCK_ID" => "16" // Курсы валют банка
            )
            //false
        );?>
    </div>

    <div class="v21-exchange-calc__note">
        <?php if (empty($_SESSION["city"]) || $_SESSION["city"] == 414) : // Москва в инфоблоке 17 ?>
        <div class="v21-exchange-rezerv__block">
            <div class="v21-exchange-rezerv__block-img">
                <img src="images/table_clock.png" alt="настольные часы">
            </div>
            <div class="v21-exchange-rezerv__block-textbox">
                <h2 class="v21-h2 v21-exchange-rezerv__block-text--header">Зафиксируйте курс валюты</h2>
                <div class="v21-exchange-rezerv__block-text v21-exchange-rezerv__text1">Для предотвращения потерь из-за резкого падения курса наш сервис позволяет на 2 дня заморозить цену для купли/продажи EUR и USD без дополнительных комиссиий.</div>
                <ul>
                    <li class="v21-exchange-rezerv__block-text v21-exchange-rezerv__text2">Сервис работает в будние дни с 09.00 до 19.00</li>
                </ul>
                <a href="/dopX/rezervirovanie-kursa/" class="v21-exchange-calc__button v21-button">Зарезервировать курс&nbsp;валют</a>
            </div>
        </div>
        <?php endif; ?>

        <?/* нет в макете?><div>
            Просим дополнительно ознакомиться с
            <a href="https://www.transstroybank.ru/chastnym-klientam/drugie-uslugi/raschetno-kassovoe-obsluzhivanie" class="v21-link">
                    <span class="v21-link__text">
                        "Тарифами на проведение валютно-обменных операций"
                    </span>
            </a>
        </div><?*/?>

    </div><!-- /.v21-exchange-calc__note -->
</div>

<?/*?>
<form action="" method="get" class="v21_exchange-converter">
    <input type="hidden" name="city" value="<?= $_SESSION["city"] ?>">

    <div class="v21-section v21-section--border">
        <?// debugg($arResult['OFFICE']) ;?>
        <div class="v21-intro-card v21-intro-card--exchange">
            <div class="v21-intro-card__image">
                <img src="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-exchange.png" alt="">
            </div><!-- /.intro-card__image -->
            <div class="v21-intro-card__content">
                <h2 class="v21-h5 v21-intro-card__title v21-intro-card__width v21-intro-card__width--xs">
                    Обмен наличной иностранной валюты возможен только в кассах Банка
                </h2>
                <div class="v21-exchange-location js-v21-tabs">
                    <div>Выберите удобный для вас офис банка для обмена валюты</div>
                    <div class="v21-exchange-location__select">
                        <select name="office" class="v21-select js-v21-select" onchange="$('.v21_exchange-converter').submit();">
                            <?
                            foreach ($arResult['OFFICE'] as $arOffice) {
                                if ($arOffice['NAME'] != 'iSimple') {
                                    $officeName = $arOffice['NAME'];
                                } else {
                                    $officeName = 'ТСБ-онлайн';
                                }
                            ?>

                                <option value="<?= $arOffice['ID'] ?>" <? if ($arOffice['ID'] == $officeId) echo 'selected'; ?>>
                                    <?= $officeName ?>
                                </option>

                            <? } ?>
                        </select>
                    </div>

                    <div class="v21-tabs-content">

                        <div data-tab-id="office9" class="v21-exchange-location__info v21-tabs-content__item v21-fade is-active">
                            <? if (!empty($arResult['ADDRESS_OFFICE'])) { ?>
                                <div class="v21-exchange-location__item">
                                    <svg width="14" height="14" class="v21-exchange-location__icon">
                                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#address"></use>
                                    </svg>
                                    <div class="v21-exchange-location__title">Адрес</div>
                                    <div class="v21-exchange-location__address"><?= $arResult['ADDRESS_OFFICE'] ?></div>
                                </div><!-- /.v21-exchange-location__item -->
                            <? } ?>
                            <? if (!empty($arResult['ADDRESS_OFFICE'])) { ?>
                                <div class="v21-exchange-location__item">
                                    <svg width="14" height="14" class="v21-exchange-location__icon">
                                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#phone"></use>
                                    </svg>
                                    <div class="v21-exchange-location__title">Телефон</div>
                                    <div class="v21-exchange-location__phone"><?= $arResult['PHONE_OFFICE'] ?></div>
                                </div><!-- /.v21-exchange-location__item -->
                            <? } ?>
                        </div><!-- /.v21-exchange-location__info -->

                    </div><!-- /.v21-tabs-content -->
                </div><!-- /.v21-exchange-location -->
            </div><!-- /.v21-intro-card__content -->
        </div><!-- /.v21-intro-card -->
    </div><!-- /.v21-section -->
</form>
<?*/?>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        //const intro_card_check = document.querySelectorAll('.js-v21-intro-card .table-link');
        const intro_card_check = document.querySelectorAll('.js-v21-intro-card');
        //console.log(intro_card_check);
        const appendix_check = document.querySelector('.v21-intro-card__appendix-check');

        [].forEach.call(intro_card_check, function (elem_box) { // перебираю все значения intro_card_check
            elem_box.addEventListener('click', function (event) {
                let box = event.target.closest('.js-v21-intro-card');
                let data_request = 'city=' + box.dataset.city + '&office=' + box.dataset.office;
                let input_cell = $('input[name=office]')[0];
                input_cell.setAttribute('value', box.dataset.office);
                $('.v21_exchange-converter').submit();

                /*$.get('/', {data_request}, function(data) {
                    console.log(data); // ответ от сервера
                })
                    .success(function() { console.log('Успешное выполнение'); })
                    .error(function(jqXHR) { console.log('Ошибка выполнения'); })
                    .complete(function() { console.log('Завершение выполнения'); });*/
            });
        });
        if(appendix_check) {
            appendix_check.addEventListener('click', function (event) {
                //console.log(event.target);
                appendix_check.classList.add('is-hidden');
                [].forEach.call(intro_card_check, function (elem_box) {
                    //console.log(elem_box);
                    let select_block = elem_box.closest('.v21-intro-card__location_select--block');
                    //console.log(select_block);
                    if(select_block.classList.contains('is-hidden')) {
                        select_block.classList.remove('is-hidden');
                    }
                    select_block.nextElementSibling.classList.remove('is-hidden');
                });
            });
        }
    });

    var monetaryRate = <?= $arResult["monetaryRate"] ?>;
    //var monetaryRate = null;
</script>