<?php
/**
 * @var $module_id
 * @var $hash
 * @var $APPLICATION
 * @var $get
 * @var $post
 */

//use Verification\Service\Code;
use Webdo\Verification\Code;
//use Verification\Service\Entity\UsersTable;
use Webdo\Verification\Entity\UsersTable;
//use Verification\Service\Event;
use Webdo\Verification\Event;
//use Verification\Service\Logger;
use Webdo\Verification\Logger;
//use Verification\Service\Order;
use Webdo\Verification\Order;

try {
    $code = Code::get_code(['code' => $hash]);
    $order = Order::get_order(['id' => $code['order_id']]);
    $status = +$order['status'];
    ?>
    <h2 class="vs-orders__title">Заявка №<?= $order['id'] ?></h2>
    <div class="vs-order vs-order--user">
        <?
        if ($status === 0) {
            $code_sms = Code::get_code([
                'order_id' => $order['id']
            ]);
            $user = UsersTable::get_user(['id' => $order['user_id']]);
            $order['abs_id'] = $user['abs_id'];
            $captcha = htmlspecialchars($APPLICATION->CaptchaGetCode());

            if (+$order['status_email'] === 0) {
                Order::update_order($order['id'], ['status_email' => 1]);
                Code::update_code($code['id'], ['status' => 1]);
                Event::add_event(['name' => 'email_open', 'order_id' => $order['id']]);
            }
            if (+$order['status_email'] && +$order['status_captcha'] && +$order['status_phone']) {
                Order::update_order($order['id'], ['status' => 1]);
                Event::add_event(['name' => 'success_order', 'order_id' => $order['id']]);
                $order['status'] = 1;
            }
            $APPLICATION->IncludeFile("/local/modules/$module_id/views/user/check.php",
                array('order' => $order, 'hash' => $hash, 'captcha' => $captcha, 'error' => $get['error'])
            );
        } elseif ($status === 1) {
            $APPLICATION->IncludeFile("/local/modules/$module_id/views/user/success.php");
        } elseif ($status === 2) {
            $APPLICATION->IncludeFile("/local/modules/$module_id/views/user/expired.php");
        } elseif ($status === 3) {
            $APPLICATION->IncludeFile("/local/modules/$module_id/views/user/cancel.php");
        } elseif ($status === 4) {
            $APPLICATION->IncludeFile("/local/modules/$module_id/views/user/attempts_expired.php");
        }
        ?>
    </div>
    <?php
} catch (Exception $e) {
    Logger::write('error', $e->getMessage());
}