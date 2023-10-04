<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<div class="currency-section">
<?//debugg($arResult); ?>
    <div class="currency-container">
        <div class="currency-grid">
            <div class="currency-grid__item currency-grid__item--1x2@lg">
                <div class="currency-exchange-info">
                    <h2 class="currency-h2"><?= GetMessage("EXCHANGE_RATES") ?></h2>
                    <div class="currency-exchange-info__date">
                        <svg width="18" height="18" class="currency-exchange-info__date-icon">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21/v21_v21-icons.svg#info"></use>
                        </svg>
                        <? if (isset($arResult['MODIFY_DATE_FILE'])) {
                            $dateCurModify = $arResult['MODIFY_DATE_FILE'];
                        } else {
                            $dateCurModify = $_SESSION['MODIFY_CUR_DATE_FILE'];
                        } ?>
                        <span><?= GetMessage("DATA_FOR") ?> <?= FormatDate("H:i j F Y", $dateCurModify) ?></span>
                    </div>
                    <div class="currency-exchange-info__note">
                        <?= GetMessage("RESERVE_TEXT") ?><br>
                        <a href="/kompleks/rezervirovanie-kursa/" class="currency-link">
                            <span class="currency-link__text"><?= GetMessage("RESERVE_LINK") ?></span>
                        </a>
                    </div>
                    <p class="currency-exchange-info__brief">
                        <? if (!strpos($_SERVER['PHP_SELF'], 'konvertor-valyut')) {
                            $citySesKV = ($_SESSION['city']) ? $_SESSION['city'] : 410;  // !!Москва
                            if ($citySesKV == 410) { ?>
                                <?= GetMessage("CURS_MSK_MESSAGE_WARN") ?>
                            <? } else { ?>
                                <?= GetMessage("CURS_ALL_CITY_MESSAGE_WARN") ?>
                            <? } ?>
                        <? } ?>
                    </p>
                    <? if (!strpos($_SERVER['PHP_SELF'], 'konvertor-valyut')) { ?>
                        <a href="/kompleks/konvertor-valyut/" class="currency-exchange-info__button currency-button currency-button--border">
                            <?= GetMessage("CURRENCY_CONVERTER") ?>
                        </a>
                    <? } ?>
                    <div class="currency-exchange-info__renew">
                        <button class="currency-exchange-info__renew_btn">Обновить курсы валют</button>
                    </div>
                    <div class="currency-exchange-info__set">
                        <button class="currency-exchange-info__set_btn">Установить курсы валют</button>
                    </div>

                </div>
            </div>


            <section class="currency-grid__item currency-grid__item--1x2@lg">
                <div class="v21-exchange-table--header">
                    <div class="v21-exchange-table--header_currency"><?= GetMessage("CURRENCY") ?></div>
                    <div class="v21-exchange-table--header_code"><?= GetMessage("CURRENCY_CODE") ?></div>
                    <div class="v21-exchange-table--header_purchase"><?= GetMessage("PURCHASE") ?></div>
                    <div class="v21-exchange-table--header_sale"><?= GetMessage("SALE") ?></div>
                    <div class="v21-exchange-table--header_cbrf"><?= GetMessage("CBRF") ?></div>
                </div>

                <? foreach ($arResult['MAIN_TABLE'] as $arCur) :?>
                    <div class="v21-grid-table v21-grid-row">
                        <? for ($jj=0; $jj<5; $jj++) : ;?>
                            <? $countTD = 0; ?>
                            <? $classColorText = "";?>
                            <? if ($jj === 0) : ?>
                                <div class="v21-grid-cell v21-grid-cell--currency<?= $classColorText ?>">
                                    <span><?= $arCur['name'] ?></span>
                                </div>
                            <? endif; ?>
                            <? if ($jj === 1) : ?>
                                <div class="v21-grid-cell v21-grid-cell--code<?= $classColorText ?>">
                                    <span><?= $arCur['symbol'] ?></span>
                                    <? if(!empty($arCur['mark'])) : ?>
                                        <span class="<?=($arCur['note'])? 'v21-exchange-table__text-note js-show-notetext' : ''; ?>"> <?= $arCur['note'] ?></span>
                                        <div class="v21-exchange-table__text-subline">
                                            <span><?= $arCur['name'] ?></span>
                                            <span class="v21-exchange-table__text-subline--close js-subline--close">
                                                            <img src="/images/close_crux.png" alt="закрывающий крестик">
                                                </span>
                                            <? if($arCur['mark'] == 'cb') { ?>
                                                <span><?= GetMessage("CURS_LIST"); ?></span>
                                            <? } ?>
                                            <? if($arCur['mark'] == 'multi') { ?>
                                                <span><?= GetMessage("CURS_COUNT").' '.$arCur['multi'].' '.$arCur['genetive']; ?></span>
                                            <? } ?>
                                            <? if($arCur['mark'] == 'both') { ?>
                                                <span><?= GetMessage("CURS_LIST") . ', ' . GetMessage("CURS_COUNT") . ' ' . $arCur['multi'].' '.$arCur['genetive']; ?></span>
                                            <? } ?>
                                        </div>
                                    <? endif; ?>
                                </div>
                            <? endif; ?>
                            <? if ($jj === 2) : ?>
                                <? $classColorText = " v21-exchange-table__value--buy"; ?>
                                <div class="v21-grid-cell v21-grid-cell--buy">
                                    <div class="v21-grid-cell--buy_name">Покупка</div>
                                    <div class="v21-grid-cell--buy_value<?= $classColorText ?>">
                                        <span><?= number_format((float)$arCur['buy'], 2, '.', '') ?></span>
                                        <? if ($arCur['buy_move'] == '>') { ?>
                                            <svg width="10" height="10" class="v21-exchange-table__icon">
                                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#upValue"></use>
                                            </svg>
                                        <? } ?>
                                        <? if ($arCur['buy_move'] == '<') { ?>
                                            <svg width="10" height="10" class="v21-exchange-table__icon">
                                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#downValue"></use>
                                            </svg>
                                        <? } ?>
                                        <? if ($arCur['buy_move'] == '=') { ?>
                                            <span class="v21-exchange-table__icon v21-equal-sign">=</span>
                                        <? } ?>
                                    </div>
                                </div>
                            <? endif; ?>
                            <? if ($jj === 3) : ?>
                                <? $classColorText = " v21-exchange-table__value--sell"; ?>
                                <div class="v21-grid-cell v21-grid-cell--sell">
                                    <div class="v21-grid-cell--sell_name">Продажа</div>
                                    <div class="v21-grid-cell--sell_value<?= $classColorText ?>">
                                        <span><?= number_format((float)$arCur['sell'], 2, '.', '') ?></span>
                                        <? if ($arCur['sell_move'] == '>') { ?>
                                            <svg width="10" height="10" class="v21-exchange-table__icon">
                                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#upValue"></use>
                                            </svg>
                                        <? } ?>
                                        <? if ($arCur['sell_move'] == '<') { ?>
                                            <svg width="10" height="10" class="v21-exchange-table__icon">
                                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#downValue"></use>
                                            </svg>
                                        <? } ?>
                                        <? if ($arCur['sell_move'] == '=') { ?>
                                            <span class="v21-exchange-table__icon v21-equal-sign">=</span>
                                        <? } ?>
                                    </div>
                                </div>
                            <? endif; ?>
                            <? if ($jj === 4) : ?>
                                <? $classColorText = ""; ?>
                                <div class="v21-grid-cell v21-grid-cell--cbrf">
                                    <div class="v21-grid-cell--cbrf_name">ЦБ РФ</div>
                                    <div class="v21-grid-cell--cbrf_value<?= $classColorText ?>">
                                        <? if($arCur['cb']) : ?>
                                            <span><?= number_format((float)$arCur['cb'], 2, '.', '') ?></span>
                                            <? if ($arCur['cb_move'] == '>') { ?>
                                                <svg width="10" height="10" class="v21-exchange-table__icon">
                                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#upValue"></use>
                                                </svg>
                                            <? } ?>
                                            <? if ($arCur['cb_move'] == '<') { ?>
                                                <svg width="10" height="10" class="v21-exchange-table__icon">
                                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#downValue"></use>
                                                </svg>
                                            <? } ?>
                                            <? if ($arCur['cb_move'] == '=') { ?>
                                                <span class="v21-exchange-table__icon v21-equal-sign">=</span>
                                            <? } ?>
                                        <? else: ?>
                                            <span> </span>
                                        <? endif; ?>
                                    </div>
                                </div>
                            <? endif; ?>
                            <?// endif; ?>
                            <? $countTD++; ?>
                        <? endfor; ?>
                    </div>
                <? endforeach; ?>
            </section>



            <div class="currency-grid__item currency-grid__item--1x2@lg">
                <table class="currency-exchange-table">
                    <tr>
                        <th><?= GetMessage("CURRENCY") ?></th>
                        <th><?= GetMessage("PURCHASE") ?></th>
                        <th><?= GetMessage("SALE") ?></th>
                        <th><?= GetMessage("CBRF") ?></th>
                    </tr>
                    <? foreach ($arResult['CUR'] as $arCur) { ?>
                        <? if ($arCur[1] !== '/') { ?>
                            <tr class="body-table">
                                <? $countTD = 0; ?>
                                <? foreach ($arCur as $key => $cur) { ?>
                                    <? $countTD++; ?>
                                    <? if ($key > 0) {
                                        $arElement = explode("/", $cur); ?>
                                        <td>
                                            <? if ($arElement[0] > 0) { ?>
                                                <? if ($countTD === 2) {
                                                    $classColorText = " currency-exchange-table__value--buy";
                                                } elseif ($countTD === 3) {
                                                    $classColorText = " currency-exchange-table__value--sell";
                                                } elseif ($countTD === 4) {
                                                    $classColorText = "";
                                                } ?>
                                                <div class="currency-exchange-table__value<?= $classColorText ?>">
                                                    <span><?= number_format((float)$arElement[0], 2, '.', '') ?></span>
                                                    <svg width="10" height="10" class="currency-exchange-table__icon">
                                                        <? if ($arElement[1] == '>') { ?>
                                                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21/v21_v21-icons.svg#upValue"></use>
                                                        <? } else { ?>
                                                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21/v21_v21-icons.svg#downValue"></use>
                                                        <? } ?>
                                                    </svg>
                                                </div>
                                            <? } ?>
                                        </td>
                                    <? } else { ?>
                                        <? $symb = explode(' ', $cur); ?>
                                        <td>
                                            <div class="currency-exchange-table__type" style="width: 2.7em;">
                                                <?= $symb[0] ?>
                                                <?= ($symb[0] == 'CZK')? '<sup style="font-size: 50%;">1</sup>' : ''; ?>
                                                <?= ($symb[0] == 'HUF')? '<sup style="font-size: 50%;">2</sup>' : ''; ?>
                                                <?= ($symb[0] == 'INR')? '<sup style="font-size: 50%;">3</sup>' : ''; ?>
                                                <?= ($symb[0] == 'JPY')? '<sup style="font-size: 50%;">4</sup>' : ''; ?>
                                                <?= ($symb[0] == 'KGS')? '<sup style="font-size: 50%;">5</sup>' : ''; ?>
                                                <?= ($symb[0] == 'KZT')? '<sup style="font-size: 50%;">6</sup>' : ''; ?>
                                                <?= ($symb[0] == 'TRY')? '<sup style="font-size: 50%;">7</sup>' : ''; ?>
                                                <?= ($symb[0] == 'ZAR')? '<sup style="font-size: 50%;">8</sup>' : ''; ?>
                                            </div>
                                        </td>
                                    <? } ?>
                                <? } ?>
                            </tr>
                        <? } ?>
                    <? } ?>
                </table><!-- /.currency-exchange-table -->
                <div class="currency-exchange-note">
                    <p class="currency-exchange-note__item"><?= GetMessage("CURS_NOT_OFFER") ?></p>
                    <p class="currency-exchange-note__item">
                        <? if ($arResult['CUR']['CZK'][1] !== '/') { ?>
                            1 - <?= GetMessage("CURS_COUNT_CZK") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['HUF'][1] !== '/') { ?>
                            2 - <?= GetMessage("CURS_COUNT_HUF") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['INR'][1] !== '/') { ?>
                            3 - <?= GetMessage("CURS_COUNT_INR") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['JPY'][1] !== '/') { ?>
                            4 - <?= GetMessage("CURS_COUNT_JPY") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['KGS'][1] !== '/') { ?>
                            5 - <?= GetMessage("CURS_COUNT_KGS") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['KZT'][1] !== '/') { ?>
                            6 - <?= GetMessage("CURS_COUNT_KZT") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['TRY'][1] !== '/') { ?>
                            7 - <?= GetMessage("CURS_COUNT_TRY") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['ZAR'][1] !== '/') { ?>
                            8 - <?= GetMessage("CURS_COUNT_ZAR") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php
                            ?>
                        <? } ?>
                    </p>
                </div><!-- /.currency-exchange-note -->
            </div><!-- /.currency-grid__item -->

            <div style="display: none"><?= GetMessage("DATA_FOR") ?> <span id="note-date"><? echo FormatDate("H:i j F Y", $dateCurModify), "."; ?></span></div>

        </section>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function () {

        document.querySelector(".currency-exchange-info__renew_btn").addEventListener('click', function (event) { // клик
            //let slidePic = event.target.closest(".slide_pic");

            //let url = '/ajax/ask_courses.php';
            let url = '/ajax/handle_courses.php';  // Обновить курсы валют
            url += '?courses=renew';
            let xhr = new XMLHttpRequest();
            //console.log(url);
            xhr.open('GET', url, true);
            xhr.addEventListener("readystatechange", () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    //renderModalPicture(xhr.responseText); // прорисовка модального окна
                }
            });
            xhr.send();
            xhr.onerror = function() {
                console.log('error');
            };

        });

        document.querySelector(".currency-exchange-info__set_btn").addEventListener('click', function (event) { // клик
            //let slidePic = event.target.closest(".slide_pic");

            //let url = '/ajax/set_courses.php';
            let url = '/ajax/handle_courses.php';  // Установить курсы валют
            url += '?courses=set';
            let xhr = new XMLHttpRequest();
            //console.log(url);
            xhr.open('GET', url, true);
            xhr.addEventListener("readystatechange", () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    //renderModalPicture(xhr.responseText); // прорисовка модального окна
                }
            });
            xhr.send();
            xhr.onerror = function() {
                console.log('error');
            };

        });

    });

</script>
