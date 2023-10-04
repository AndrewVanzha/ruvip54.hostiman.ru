<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { ?>
    <? die(); ?>
<? } ?>

<div class="v21-section">
<?//debugg($arResult); ?>
    <div class="v21-container">
        <div class="v21-grid">
            <div class="v21-grid__item v21-grid__item--1x2@lg">
                <div class="v21-exchange-info">
                    <h2 class="v21-h2"><?= GetMessage("EXCHANGE_RATES") ?></h2>
                    <div class="v21-exchange-info__date">
                        <svg width="18" height="18" class="v21-exchange-info__date-icon">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#info"></use>
                        </svg>
                        <? if (isset($arResult['MODIFY_DATE_FILE'])) {
                            $dateCurModify = $arResult['MODIFY_DATE_FILE'];
                        } else {
                            $dateCurModify = $_SESSION['MODIFY_CUR_DATE_FILE'];
                        } ?>
                        <span><?= GetMessage("DATA_FOR") ?> <?= FormatDate("H:i j F Y", $dateCurModify) ?></span>
                    </div>
                    <div class="v21-exchange-info__note">
                        <?= GetMessage("RESERVE_TEXT") ?><br>
                        <a href="/chastnym-klientam/rezervirovanie-kursa/" class="v21-link">
                            <span class="v21-link__text"><?= GetMessage("RESERVE_LINK") ?></span>
                        </a>
                    </div>
                    <p class="v21-exchange-info__brief">
                        <? if (!strpos($_SERVER['PHP_SELF'], 'konvertor-valyut')) {
                            $citySesKV = ($_SESSION['city']) ? $_SESSION['city'] : 399;
                            if ($citySesKV == 399) { ?>
                                <?= GetMessage("CURS_MSK_MESSAGE_WARN") ?>
                            <? } else { ?>
                                <?= GetMessage("CURS_ALL_CITY_MESSAGE_WARN") ?>
                            <? } ?>
                        <? } ?>
                    </p>
                    <? if (!strpos($_SERVER['PHP_SELF'], 'konvertor-valyut')) { ?>
                        <a href="/chastnym-klientam/konvertor-valyut/" class="v21-exchange-info__button v21-button v21-button--border">
                            <?= GetMessage("CURRENCY_CONVERTER") ?>
                        </a>
                    <? } ?>
                </div>
            </div><!-- /.v21-grid__item -->
            <?//debugg($arResult['CUR']);?>

            <div class="v21-grid__item v21-grid__item--1x2@lg">
                <table class="v21-exchange-table">
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
                                                <? if ($countTD === 4) {
                                                    $classColorText = " v21-exchange-table__value--buy";
                                                } elseif ($countTD === 3) {
                                                    $classColorText = " v21-exchange-table__value--sell";
                                                } elseif ($countTD === 2) {
                                                    $classColorText = "";
                                                } ?>
                                                <div class="v21-exchange-table__value<?= $classColorText ?>">
                                                    <span><?= number_format((float)$arElement[0], 2, '.', '') ?></span>
                                                    <svg width="10" height="10" class="v21-exchange-table__icon">
                                                        <? if ($arElement[1] == '>') { ?>
                                                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#upValue"></use>
                                                        <? } else { ?>
                                                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#downValue"></use>
                                                        <? } ?>
                                                    </svg>
                                                </div>
                                            <? } ?>
                                        </td>
                                    <? } else { ?>
                                        <? $symb = explode(' ', $cur); ?>
                                        <td>
                                            <div class="v21-exchange-table__type" style="width: 3.2em; text-align: left;">
                                                <?= $symb[0] ?>
                                                <?= ($symb[0] == 'AED')? '<sup style="font-size: 50%;">1</sup>' : ''; ?>
                                                <?= ($symb[0] == 'AMD')? '<sup style="font-size: 50%;">2</sup>' : ''; ?>
                                                <?= ($symb[0] == 'CZK')? '<sup style="font-size: 50%;">3</sup>' : ''; ?>
                                                <?= ($symb[0] == 'EGP')? '<sup style="font-size: 50%;">4</sup>' : ''; ?>
                                                <?= ($symb[0] == 'HKD')? '<sup style="font-size: 50%;">5</sup>' : ''; ?>
                                                <?= ($symb[0] == 'HUF')? '<sup style="font-size: 50%;">6</sup>' : ''; ?>
                                                <?= ($symb[0] == 'ILS')? '<sup style="font-size: 50%;">7</sup>' : ''; ?>
                                                <?= ($symb[0] == 'INR')? '<sup style="font-size: 50%;">8</sup>' : ''; ?>
                                                <?= ($symb[0] == 'JPY')? '<sup style="font-size: 50%;">9</sup>' : ''; ?>
                                                <?= ($symb[0] == 'KGS')? '<sup style="font-size: 50%;">10</sup>' : ''; ?>
                                                <?= ($symb[0] == 'KRW')? '<sup style="font-size: 50%;">11</sup>' : ''; ?>
                                                <?= ($symb[0] == 'KZT')? '<sup style="font-size: 50%;">12</sup>' : ''; ?>
                                                <?= ($symb[0] == 'MDL')? '<sup style="font-size: 50%;">13</sup>' : ''; ?>
                                                <?= ($symb[0] == 'MXN')? '<sup style="font-size: 50%;">14</sup>' : ''; ?>
                                                <?= ($symb[0] == 'QAR')? '<sup style="font-size: 50%;">15</sup>' : ''; ?>
                                                <?= ($symb[0] == 'RSD')? '<sup style="font-size: 50%;">16</sup>' : ''; ?>
                                                <?= ($symb[0] == 'SAR')? '<sup style="font-size: 50%;">17</sup>' : ''; ?>
                                                <?= ($symb[0] == 'THB')? '<sup style="font-size: 50%;">18</sup>' : ''; ?>
                                                <?= ($symb[0] == 'TJS')? '<sup style="font-size: 50%;">19</sup>' : ''; ?>
                                                <?= ($symb[0] == 'TRY')? '<sup style="font-size: 50%;">20</sup>' : ''; ?>
                                                <?= ($symb[0] == 'UZS')? '<sup style="font-size: 50%;">21</sup>' : ''; ?>
                                                <?= ($symb[0] == 'ZAR')? '<sup style="font-size: 50%;">22</sup>' : ''; ?>
                                            </div>
                                        </td>
                                    <? } ?>
                                <? } ?>
                            </tr>
                        <? } ?>
                    <? } ?>
                </table><!-- /.v21-exchange-table -->
                <div class="v21-exchange-note">
                    <p class="v21-exchange-note__item"><?= GetMessage("CURS_NOT_OFFER") ?></p>
                    <p class="v21-exchange-note__item">
                        <? if ($arResult['CUR']['AED'][1] !== '/') { ?>
                            1 - <?= GetMessage("CURS_COUNT_AED") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['AMD'][1] !== '/') { ?>
                            2 - <?= GetMessage("CURS_COUNT_AMD") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['CZK'][1] !== '/') { ?>
                            3 - <?= GetMessage("CURS_COUNT_CZK") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['EGP'][1] !== '/') { ?>
                            4 - <?= GetMessage("CURS_COUNT_EGP") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['HKD'][1] !== '/') { ?>
                            5 - <?= GetMessage("CURS_COUNT_HKD") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['HUF'][1] !== '/') { ?>
                            6 - <?= GetMessage("CURS_COUNT_HUF") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['ILS'][1] !== '/') { ?>
                            7 - <?= GetMessage("CURS_COUNT_ILS") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['INR'][1] !== '/') { ?>
                            8 - <?= GetMessage("CURS_COUNT_INR") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['JPY'][1] !== '/') { ?>
                            9 - <?= GetMessage("CURS_COUNT_JPY") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['KGS'][1] !== '/') { ?>
                            10 - <?= GetMessage("CURS_COUNT_KGS") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['KRW'][1] !== '/') { ?>
                            11 - <?= GetMessage("CURS_COUNT_KRW") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['KZT'][1] !== '/') { ?>
                            12 - <?= GetMessage("CURS_COUNT_KZT") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['MDL'][1] !== '/') { ?>
                            13 - <?= GetMessage("CURS_COUNT_MDL") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['MXN'][1] !== '/') { ?>
                            14 - <?= GetMessage("CURS_COUNT_MXN") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['QAR'][1] !== '/') { ?>
                            15 - <?= GetMessage("CURS_COUNT_QAR") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['RSD'][1] !== '/') { ?>
                            16 - <?= GetMessage("CURS_COUNT_RSD") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['SAR'][1] !== '/') { ?>
                            17 - <?= GetMessage("CURS_COUNT_SAR") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['THB'][1] !== '/') { ?>
                            18 - <?= GetMessage("CURS_COUNT_THB") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['TJS'][1] !== '/') { ?>
                            19 - <?= GetMessage("CURS_COUNT_TJS") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['TRY'][1] !== '/') { ?>
                            20 - <?= GetMessage("CURS_COUNT_TRY") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['UZS'][1] !== '/') { ?>
                            21 - <?= GetMessage("CURS_COUNT_UZS") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                        <? if ($arResult['CUR']['ZAR'][1] !== '/') { ?>
                            22 - <?= GetMessage("CURS_COUNT_ZAR") ?><br>
                            <? //редактировать в lang/ru/template.php и lang/en/template.php 
                            ?>
                        <? } ?>
                    </p>
                </div><!-- /.v21-exchange-note -->
            </div><!-- /.v21-grid__item -->

            <div style="display: none"><?= GetMessage("DATA_FOR") ?> <span id="note-date"><? echo FormatDate("H:i j F Y", $dateCurModify), "."; ?></span></div>

        </div><!-- /.v21-grid -->
    </div><!-- /.v21-section -->
</div><!-- /.v21-section -->