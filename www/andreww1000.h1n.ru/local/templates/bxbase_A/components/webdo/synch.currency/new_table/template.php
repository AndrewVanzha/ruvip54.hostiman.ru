<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { ?>
    <? die(); ?>
<? } ?>

<div class="v21-section v21-exchange-block js-v21-exchange-block">
<?// debugg($arResult); ?>
<?// debugg($arResult['MAIN_TABLE']); ?>
    <div class="v21-new-table-container">
        <div class="v21-grid v21-new-table-grid">
            <?/*?>
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
            <?*/?>

            <?//debugg($arResult['CUR']);?>

            <!--div class="v21-grid__item v21-grid__item--1x2@lg v-21-exchange-box"-->
            <div class="v21-exchange-box">
                <??>
                <div class="v21-exchange-info__box">
                    <div class="v21-exchange-info__date">
                        <? if (isset($arResult['MODIFY_DATE_FILE'])) { // отображается в new_konvertor_valyut/template.php
                            $dateCurModify = $arResult['MODIFY_DATE_FILE'];
                        } else {
                            $dateCurModify = $_SESSION['MODIFY_CUR_DATE_FILE'];
                        } ?>
                        <span><?= GetMessage("DATA_FOR") ?> <?= FormatDate("H:i, j F Y", $dateCurModify) ?></span>
                    </div>
                </div>
                <??>

                <??>
                <section class="v21-exchange-grid-table js-currency-table">
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
                                                        <?/*?><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#upValue"></use><?*/?>
                                                        <use xlink:href="/images/v21_v21-icons.svg#upValue"></use>
                                                    </svg>
                                                <? } ?>
                                                <? if ($arCur['buy_move'] == '<') { ?>
                                                    <svg width="10" height="10" class="v21-exchange-table__icon">
                                                        <?/*?><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/img/v21_v21-icons.svg#downValue"></use><?*/?>
                                                        <use xlink:href="/images/v21_v21-icons.svg#downValue"></use>
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
                                                        <use xlink:href="/images/v21_v21-icons.svg#upValue"></use>
                                                    </svg>
                                                <? } ?>
                                                <? if ($arCur['sell_move'] == '<') { ?>
                                                    <svg width="10" height="10" class="v21-exchange-table__icon">
                                                        <use xlink:href="/images/v21_v21-icons.svg#downValue"></use>
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
                                                            <use xlink:href="/images/v21_v21-icons.svg#upValue"></use>
                                                        </svg>
                                                    <? } ?>
                                                    <? if ($arCur['cb_move'] == '<') { ?>
                                                        <svg width="10" height="10" class="v21-exchange-table__icon">
                                                            <use xlink:href="/images/v21_v21-icons.svg#downValue"></use>
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
                </section><!-- /.v21-exchange-table -->

                <?/*?>
                <table class="v21-exchange-table js-currency-table">
                    <tr>
                        <th><?= GetMessage("CURRENCY") ?></th>
                        <th><?= GetMessage("CURRENCY") ?></th>
                        <th><?= GetMessage("PURCHASE") ?></th>
                        <th><?= GetMessage("SALE") ?></th>
                        <th><?= GetMessage("CBRF") ?></th>
                    </tr>
                    <? foreach ($arResult['MAIN_TABLE'] as $arCur) :?>
                            <tr class="body-table">
                                <? for ($jj=0; $jj<5; $jj++) : ;?>
                                    <? $countTD = 0; ?>
                                    <td>
                                        <? $classColorText = "";?>
                                        <? if ($jj === 0) : ?>
                                            <div class="v21-exchange-table__text v21-exchange-currency-table__text<?= $classColorText ?>">
                                                <span><?= $arCur['name'] ?></span>
                                            </div>
                                        <? endif; ?>
                                        <? if ($jj === 1) : ?>
                                            <div class="v21-exchange-table__text<?= $classColorText ?>">
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
                                            <div class="v21-exchange-table__value<?= $classColorText ?>">
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
                                        <? endif; ?>
                                        <? if ($jj === 3) : ?>
                                            <? $classColorText = " v21-exchange-table__value--sell"; ?>
                                            <div class="v21-exchange-table__value<?= $classColorText ?>">
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
                                        <? endif; ?>
                                        <? if ($jj === 4) : ?>
                                            <? $classColorText = ""; ?>
                                            <div class="v21-exchange-table__value<?= $classColorText ?>">
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
                                        <? endif; ?>
                                        <?// endif; ?>
                                    </td>
                                    <? $countTD++; ?>
                                <? endfor; ?>
                            </tr>
                    <? endforeach; ?>
                </table><!-- /.v21-exchange-table -->
                <?*/?>

                <? //debugg($arResult); ?>

                <hr>
                <?/*?>
                <div class="v21-exchange-note">
                    <??>
                    <!--p class="v21-exchange-note__item v21-exchange-note__item-center"><?= GetMessage("CURS_NOT_OFFER") ?></p-->
                    <??>
                    <div class="v21-exchange-note__item v21-exchange-note__list-wrap js-v21-exchange-note__list-check">
                        <p>Сноски</p>
                        <svg width="9" height="9" class="v21-button__icon">
                            <use xlink:href="/local/templates/v21_template_home/img/v21_v21-icons.svg#arrowDownSmall"></use>
                        </svg>
                    </div>

                    <div class="v21-exchange-note__list-box">
                        <div class="v21-exchange-note__list-box--close js-v21-exchange-note__list-box--close">
                            <svg width="12" height="12">
                                <use xlink:href="/local/templates/v21_template_home/img/v21_v21-icons.svg#close"></use>
                            </svg>
                        </div>
                        <??>
                        <!--span class="v21-exchange-note__list-box--close js-v21-exchange-note__list-box--close">
                                 <img src="/images/close_crux.png" alt="закрывающий крестик">
                        </span-->
                        <??>
                        <div class="v21-exchange-note__item js-exchange-note__items">
                            <? foreach ($arResult['MAIN_TABLE'] as $arCur) : ?>
                                <p>
                                    <?= $arCur['note'] ?>
                                    <? if($arCur['mark'] == 'cb') { ?>
                                        <span><?= GetMessage("CURS_LIST"); ?></span>
                                    <? } ?>
                                    <? if($arCur['mark'] == 'multi') { ?>
                                        <span><?= GetMessage("CURS_COUNT").' '.$arCur['multi'].' '.$arCur['genetive']; ?></span>
                                    <? } ?>
                                    <? if($arCur['mark'] == 'both') { ?>
                                        <span><?= GetMessage("CURS_LIST") . ', ' . GetMessage("CURS_COUNT") . ' ' . $arCur['multi'].' '.$arCur['genetive']; ?></span>
                                    <? } ?>
                                </p>
                            <? endforeach; ?>

                        </div>
                    </div>
                    <hr class="v21-exchange-note__hr">
                </div><!-- /.v21-exchange-note -->
                <?*/?>
            </div><!-- /.v21-grid__item -->

            <div style="display: none"><?= GetMessage("DATA_FOR") ?> <span id="note-date"><? echo FormatDate("H:i j F Y", $dateCurModify), "."; ?></span></div>

        </div><!-- /.v21-grid -->
    </div><!-- /.v21-section -->
</div><!-- /.v21-section -->

<?php
if(isset($_GET['office'])) {
    $office = htmlspecialchars($_GET['office']);
    //file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/chastnym-klientam/konvertor-valyut/test_table_get.txt', $_GET);
    \GarbageStorage::set('OfficeId', $office);
}
?>

<script>
    let office = '';
    office = '<?php echo $office; ?>';
</script>
