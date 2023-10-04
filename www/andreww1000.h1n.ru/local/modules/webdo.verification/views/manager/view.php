<?php
/**
 * @var $order
 * @var $events
 * @var $module_id
 * @var $error
 */

//use Verification\Service\Order;
use Webdo\Verification\Order;

?>
<h2 class="vs-orders__title">Заявка №<?= $order['id'] ?></h2>
<div class="vs-order">
    <div class="vs-order__back">
        <a href="/<?= $module_id ?>/">&larr; вернуться назад</a>
    </div>
    <div class="vs-order__wrapper">
        <div class="vs-order__block">
            <div class="vs-order__title">Данные заявки</div>
            <div class="vs-order__table">
                <div class="vs-order__tr">
                    <div class="vs-order__th">Номер заявки</div>
                    <div class="vs-order__td"><?= $order['id'] ?></div>
                </div>
                <??>
                <div class="vs-order__tr">
                    <div class="vs-order__th">Номер клиента в АБС</div>
                    <div class="vs-order__td"><?= $order['abs_id'] ?></div>
                </div>
                <??>
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
                    <div class="vs-order__td"><?= Order::check_deleted(Order::get_print_phone($order['phone_number'])) ?></div>
                </div>
                <? if ($order['type'] === 'email'): ?>
                    <div class="vs-order__tr">
                        <div class="vs-order__th">Email</div>
                        <div class="vs-order__td"><?= Order::check_deleted($order['email']) ?></div>
                    </div>
                <? endif; ?>
            </div>
            <div class="vs-order__title">Статус заявки</div>
            <div class="vs-order__table">
                <div class="vs-order__tr">
                    <div class="vs-order__th">Текущий статус</div>
                    <div class="vs-order__td"><?= Order::get_order_status_label($order['status']) ?></div>
                </div>
                <? if ($order['status'] == 0): ?>
                    <div class="vs-order__tr">
                        <div class="vs-order__th">Код подтверждения</div>
                        <div class="vs-order__td">
                            <? if ($order['type'] === 'phone'): ?>
                                <form action="/local/modules/webdo.verification/process/manager.php" method="post"
                                      class="vs-order__flex">
                                    <input type="hidden" name="action" value="check_code">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <input class="vs-input vs-order__input" type="text" name="code" size="14" value="" placeholder="введите код" required>
                                    <button class="vs-button vs-order__button">Подтвердить</button>
                                </form>
                            <? endif; ?>
                            <form action="/local/modules/webdo.verification/process/manager.php" method="post">
                                <input type="hidden" name="action" value="renew_code">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <button class="vs-button vs-order__button--link">Не получил код, отправить ещё раз</button>
                            </form>
                        </div>
                    </div>
                <? endif; ?>
            </div>
            <? if (!empty($error)): ?>
                <div class="vs-order__error"><?= $error ?></div>
            <? endif; ?>
            <? if ($order['status'] == 0): ?>
                <form action="/local/modules/webdo.verification/process/manager.php" method="post">
                    <input type="hidden" name="action" value="cancel_order">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <button class="vs-button vs-order__button vs-order__button_cancel">Отменить заявку</button>
                </form>
            <? endif; ?>
        </div>
        <div class="vs-order__block">
            <div class="vs-order__title">История событий</div>
            <div class="vs-order__table">
                <div class="vs-order__thead">
                    <div class="vs-order__th">Время</div>
                    <div class="vs-order__th">Наименование события</div>
                </div>
                <? foreach ($events as $event): ?>
                    <div class="vs-order__tr">
                        <div class="vs-order__td"><?= $event['date'] ?></div>
                        <div class="vs-order__td"><?= $event['message'] ?></div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    </div>
</div>
