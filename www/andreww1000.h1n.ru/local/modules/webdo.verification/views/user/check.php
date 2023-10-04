<?php
/**
 * @var $order
 * @var $hash
 * @var $captcha
 * @var $error
 */

//use Verification\Service\Order;
use Webdo\Verification\Order;

?>
<div class="vs-order__wrapper">
    <div class="vs-order__block">
        <div class="vs-order__title">Данные заявки</div>
        <div class="vs-order__table">
            <div class="vs-order__tr">
                <div class="vs-order__th">Номер заявки</div>
                <div class="vs-order__td"><?= $order['id'] ?></div>
            </div>
            <?/*?>
            <div class="vs-order__tr">
                <div class="vs-order__th">Номер клиента в АБС</div>
                <div class="vs-order__td"><?= $order['abs_id'] ?></div>
            </div>
            <?*/?>
            <div class="vs-order__tr">
                <div class="vs-order__th">Время заявки</div>
                <div class="vs-order__td"><?= $order['date'] ?></div>
            </div>
            <div class="vs-order__tr">
                <div class="vs-order__th">Тип заявки</div>
                <div class="vs-order__td"><?= Order::get_order_type_label($order['type']) ?></div>
            </div>
            <div class="vs-order__tr">
                <div class="vs-order__th">Номер телефона</div>
                <div class="vs-order__td"><?= Order::get_print_phone($order['phone_number']) ?></div>
            </div>
            <? if ($order['type'] === 'email'): ?>
                <div class="vs-order__tr">
                    <div class="vs-order__th">Email</div>
                    <div class="vs-order__td"><?= $order['email'] ?></div>
                </div>
            <? endif; ?>
        </div>
    </div>
    <div class="vs-order__block">
        <div class="vs-order__title">Статус заявки</div>
        <div class="vs-order__table">
            <div class="vs-order__tr">
                <div class="vs-order__th">Текущий статус</div>
                <div class="vs-order__td"><?= Order::get_order_status_label($order['status']) ?></div>
            </div>
            <? if ($order['status_captcha'] != 1): ?>
                <div class="vs-order__tr">
                    <div class="vs-order__th">Код с картинки</div>
                    <div class="vs-order__td">
                        <form action="/local/modules/webdo.verification/process/user.php" method="post">
                            <div class="vs-order__captcha">
                                <div>
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>"/>
                                    <input type="hidden" name="order_hash" value="<?= $hash ?>"/>
                                    <input type="hidden" id="captchaSid" name="captcha_id" value="<?= $captcha ?>"/>
                                    <img id="captchaImg" src="/bitrix/tools/captcha.php?captcha_sid=<?= $captcha ?>"
                                         alt="">
                                </div>
                                <div>
                                    <button class="vs-button vs-order__reload" id="reload">
                                        <img src="/local/templates/.default/img/reload.png" alt="reload">
                                    </button>
                                </div>
                                <div>
                                    <input
                                        class="vs-input vs-order__input"
                                        type="text"
                                        name="captcha_code"
                                        size="14"
                                        placeholder="введите код" autocomplete="off"
                                        required
                                    >
                                </div>
                                <div><button class="vs-button vs-order__button">Подтвердить</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            <? endif; ?>
            <? if ($order['status_phone'] != 1): ?>
                <div class="vs-order__tr">
                    <div class="vs-order__th">Код из СМС</div>
                    <div class="vs-order__td">
                        <form action="/local/modules/webdo.verification/process/user.php" method="post"
                              class="vs-order__flex">
                            <input type="hidden" name="action" value="check_code">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>"/>
                            <input type="hidden" name="order_hash" value="<?= $hash ?>"/>
                            <input class="vs-input vs-order__input" type="text" name="code" size="14" value="" placeholder="введите код" required>
                            <button class="vs-button vs-order__button">Подтвердить</button>
                        </form>
                    </div>
                </div>
            <? endif; ?>
            <? if (!empty($error)): ?>
                <div class="vs-order__error"><?= urldecode($error) ?></div>
            <? endif; ?>
        </div>
    </div>
</div>
