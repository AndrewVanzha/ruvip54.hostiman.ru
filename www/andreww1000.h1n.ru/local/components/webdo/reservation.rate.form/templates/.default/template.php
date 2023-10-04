<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arResult */
/** @var string $templateFolder */
?>
<form action="/bitrix/reservation.rate/init.php" method="POST" id="form">
    <div class="row">
        <div class="rr-timer col-sm-12 col-md-5 col-lg-3">
            <img src="<?= $templateFolder ?>/images/timer.png" alt="">
            <img src="<?= $templateFolder ?>/images/timer_gradient.png" alt="" class="rr-timer__gradient">
            <div class="rr-timer__info">
                <?/*?><div class="rr-timer__time">5:00</div><?*/?>
                <div class="rr-timer__time">0:00</div>
                <div class="rr-timer__description">до обновления курса</div>
            </div>
        </div>
        <div class="rr-options col-sm-12 col-md-7 col-lg-4">
            <div class="rr-options__table">
                <div class="rr-options__tr">
                    <div class="rr-options__th"></div>
                    <div class="rr-options__th">я продаю</div>
                    <div class="rr-options__th">я покупаю</div>
                </div>
                <div class="rr-options__tr">
                    <div class="rr-options__td rr-options__currency">USD</div>
                    <div class="rr-options__td rr-options__sell">
                        <div class="rr-options__checkbox" data-rr_type="sell-usd" data-rr_rate=""></div>
                        <div class="rr-options__checkbox_label"></div>
                    </div>
                    <div class="rr-options__td rr-options__buy">
                        <div class="rr-options__checkbox" data-rr_type="buy-usd" data-rr_rate=""></div>
                        <div class="rr-options__checkbox_label"></div>
                    </div>
                </div>
                <div class="rr-options__tr">
                    <div class="rr-options__td rr-options__currency">EUR</div>
                    <div class="rr-options__td rr-options__sell">
                        <div class="rr-options__checkbox" data-rr_type="sell-eur" data-rr_rate=""></div>
                        <div class="rr-options__checkbox_label"></div>
                    </div>
                    <div class="rr-options__td rr-options__buy">
                        <div class="rr-options__checkbox" data-rr_type="buy-eur" data-rr_rate=""></div>
                        <div class="rr-options__checkbox_label"></div>
                    </div>
                </div>
            </div>
            <div class="rr-options__amount">
                <div class="rr-options__amount-title">
                    <label for="rr-amount-input">Сумма обмена</label>
                    <div class="reservation-rate__help">
                        <img src="<?= $templateFolder ?>/images/info.svg" alt="">
                        <div class="reservation-rate__tooltip">
                            <div class="reservation-rate__tooltip_wrapper">
                                Для обмена необходимо предоставить документы подтверждающие личность и
                                происхождение денежных средств
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rr-options__amount-form">
                    <div class="rr-options__row">
                        <input id="rr-amount-input" name="amount" type="text" class="rr-options__amount-input"
                               value="<?=$arResult['GET_ARR']['amount']?$arResult['GET_ARR']['amount']:5000?>">
                        <input id="rr-amount-range">
                        <div class="rr-options__amount-currency">USD</div>
                    </div>
                    <div class="rr-options__amount-range"></div>
                    <div class="rr-options__amount-interval"></div>
                </div>
            </div>
        </div>
        <div class="rr-summary col-sm-12 col-lg-5">
            <div class="rr-summary__wrapper">
                <div class="rr-summary__title">Сводка</div>
                <div class="rr-summary__table">
                    <div class="rr-summary__tr">
                        <div class="rr-summary__td rr-summary__rate_label">Продажа USD по курсу</div>
                        <div class="rr-summary__td rr-summary__rate"></div>
                    </div>
                    <div class="rr-summary__tr">
                        <div class="rr-summary__td">Сумма обмена</div>
                        <div class="rr-summary__td rr-summary__amount"></div>
                    </div>
                    <div class="rr-summary__tr">
                        <div class="rr-summary__td">Сумма сделки</div>
                        <div class="rr-summary__td rr-summary__full"></div>
                    </div>
                    <div class="rr-summary__tr">
                        <div class="rr-summary__td">
                            Обеcпечительный платёж
                            <div class="reservation-rate__help">
                                <img src="<?= $templateFolder ?>/images/info.svg" alt="">
                                <div class="reservation-rate__tooltip">
                                    <div class="reservation-rate__tooltip_wrapper">
                                        Платеж возвращается на вашу карту в полном объёме после совершения
                                        валютно-обменной операции в Офисе Банка
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rr-summary__td rr-summary__secure"></div>
                    </div>
                    <div class="rr-summary__tr">
                        <div class="rr-summary__td">Курс будет зафиксирован до</div>
                        <div class="rr-summary__td">
                            <span class="rr-summary__date"></span>
                            <br>
                            <span class="rr-summary__time">(23:59:59)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? if($arResult['GET_ARR']['message']): ?>
        <div class="rr-message">
            <div class="alert alert-danger" role="alert"><?=$arResult['GET_ARR']['message']?></div>
        </div>
    <? endif; ?>
    <div class="rr-form">
        <div class="rr-form__wrapper row">
            <div class="rr-form__input col-md-4">
                <label for="rr-form-fio">Ваши данные *</label>
                <input type="text" name="fio" id="rr-form-fio" placeholder="Фамилия Имя Отчество" required
                       value="<?=$arResult['GET_ARR']['fio']?$arResult['GET_ARR']['fio']:''?>">
            </div>
            <div class="rr-form__input col-md-4">
                <label for="rr-form-phone">Мобильный номер *</label>
                <input type="text" name="phone" id="rr-form-phone" data-mask="phone" placeholder="+7 (929) 000-0000"
                       required value="<?=$arResult['GET_ARR']['phone']?$arResult['GET_ARR']['phone']:''?>">
            </div>
            <div class="rr-form__input col-md-4">
                <label for="rr-form-email">Email *</label>
                <input type="text" name="email" id="rr-form-email" placeholder="example@mail.ru" required
                       value="<?=$arResult['GET_ARR']['email']?$arResult['GET_ARR']['email']:''?>">
            </div>
        </div>
        <div class="rr-form__accept">
            <input type="checkbox" id="rr-accept">
            <label for="rr-accept">С условиями <a href="/chastnym-klientam/rezervirovanie-kursa/doc/offer.pdf?v=1" target="_blank">оферты</a> ознакомлен и согласен</label>
        </div>
        <div class="rr-form__address">Обмен наличной иностранной валюты возможен только <br>в кассе Банка по
            адресу: ул. Дубининская 94, Москва. <br>Пн-пт 9:30-17:00 (без перерыва)
        </div>
        <input type="hidden" name="type" id="rr-form-type" value="<?=$arResult['GET_ARR']['type']?$arResult['GET_ARR']['type']:'sell'?>">
        <input type="hidden" name="currency" id="rr-form-currency" value="<?=$arResult['GET_ARR']['currency']?$arResult['GET_ARR']['currency']:'usd'?>">
        <input type="hidden" name="rate" id="rr-form-rate">
        <button class="rr-form__button" disabled>Зарезервировать</button>
    </div>
</form>