<?php
/**
 * @var $orders
 * @var $get
 * @var $count
 * @var $pages
 */

//use Verification\Service\Order;
use Webdo\Verification\Order;

$get_params = [];
foreach ($get as $k => $v) {
    $get_params[$k] = $v;
}

$current_page = $get['current_page'] ? $get['current_page'] : 1;
$prev_page = $current_page - 1;
$next_page = $current_page + 1;
$prev_link = $prev_page ? array_merge($get_params, ['current_page' => $prev_page]) : null;
$next_link = $next_page <= $pages ? array_merge($get_params, ['current_page' => $next_page]) : null;

?>
<h2 class="vs-orders__title">Список заявок</h2>
<div class="vs-orders">
    <form action="" method="get">
        <input type="hidden" name="action" value="filter">
        <div class="vs-order__filter">
            <div class="vs-filter__block">
                <div class="vs-filter__label">Дата заявки:</div>
                <div class="vs-filter__param">
                    <input type="text" name="period" id="daterange" value="<?= $get['period'] ?>" size="22">
                </div>
            </div>
            <div class="vs-filter__block">
                <div class="vs-filter__label">Код клиента:</div>
                <div class="vs-filter__param">
                    <input type="text" name="abs_id" value="<?= $get['abs_id'] ?>" size="10" autocomplete="off">
                </div>
            </div>
            <div class="vs-filter__block">
                <div class="vs-filter__label">Тип заявки:</div>
                <div class="vs-filter__param">
                    <select name="type">
                        <option value="">Все типы</option>
                        <? foreach (['email', 'phone'] as $type): ?>
                            <option value="<?= $type ?>" <?= $type === $get['type'] ? ' selected' : '' ?>>
                                <?= Order::get_order_type_label($type) ?>
                            </option>
                        <? endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="vs-filter__block">
                <div class="vs-filter__label">Номер телефона:</div>
                <div class="vs-filter__param">
                    <input type="tel" name="phone_number" value="<?= $get['phone_number'] ?>" autocomplete="off">
                </div>
            </div>
            <div class="vs-filter__block">
                <div class="vs-filter__label">Email-адрес:</div>
                <div class="vs-filter__param">
                    <input type="email" name="email" value="<?= $get['email'] ?>" autocomplete="off">
                </div>
            </div>
            <div class="vs-filter__block">
                <div class="vs-filter__label">Статус:</div>
                <div class="vs-filter__param">
                    <select name="status">
                        <option value="">все статусы</option>
                        <? foreach ([0, 1, 2, 3, 4] as $status): ?>
                            <option value="<?= $status ?>" <?= isset($get['status']) && $get['status'] !== "" && $status === +$get['status'] ? ' selected' : '' ?>>
                                <?= Order::get_order_status_label($status) ?>
                            </option>
                        <? endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="vs-filter__block">
                <div class="vs-filter__param">
                    <button class="vs-button vs-filter__button">Поиск</button>
                </div>
            </div>
        </div>
    </form>
    <div class="vs-order__table">
        <div class="vs-order__thead">
            <div class="vs-order__th">№</div>
            <div class="vs-order__th">Дата</div>
            <div class="vs-order__th">Код клиента</div>
            <div class="vs-order__th">Тип заявки</div>
            <div class="vs-order__th">Номер телефона</div>
            <div class="vs-order__th">Email-адрес</div>
            <div class="vs-order__th">Статус</div>
        </div>
        <?php foreach ($orders as $order) : ?>
            <div class="vs-order__tr">
                <div class="vs-order__td"><?= $order['id'] ?></div>
                <div class="vs-order__td"><?= $order['date'] ?></div>
                <div class="vs-order__td"><?= $order['abs_id'] ?></div>
                <div class="vs-order__td"><?= Order::get_order_type_label($order['type']) ?></div>
                <div class="vs-order__td"><?= Order::check_deleted(Order::get_print_phone($order['phone_number'])) ?></div>
                <div class="vs-order__td"><?= $order['type'] === 'email' ? Order::check_deleted($order['email']) : '' ?></div>
                <div class="vs-order__td"><?= Order::get_order_status_label($order['status']) ?></div>
                <div class="vs-order__td">
                    <a class="vs-order__link" href="?page=order&id=<?= $order['id'] ?>">Подробнее</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<? if ($pages > 1): ?>
    <div class="vs-pagination">
        <span>Страницы: </span>
        <?php if ($prev_page >= 1): ?>
            <a class="vs-pagination__arrow" href="?<?= http_build_query($prev_link) ?>">предыдущая</a>
        <?php else: ?>
            <span class="vs-pagination__arrow vs-pagination__arrow--disabled">предыдущая</span>
        <?php endif; ?>
        <span class="vs-pagination__current"><?= $current_page ?> из <?= $pages ?></span>
        <?php if ($next_page <= $pages): ?>
            <a class="vs-pagination__arrow" href="?<?= http_build_query($next_link) ?>">следующая</a>
        <?php else: ?>
            <span class="vs-pagination__arrow vs-pagination__arrow--disabled">следующая</span>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if (count($orders) > 0): ?>
    <div class="vs-export">
        <a class="vs-button vs-export__button"
           href="/local/modules/webdo.verification/process/generate_xlsx.php?<?= http_build_query($get_params) ?>"
           target="_blank" download="true">Экспортировать результаты в .xlsx-файл</a>
    </div>
<?php endif; ?>
