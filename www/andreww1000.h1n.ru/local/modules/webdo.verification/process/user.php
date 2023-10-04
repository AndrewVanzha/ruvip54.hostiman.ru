<?php
/**
 * @var $APPLICATION
 */

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
//use Verification\Service\Code;
use Webdo\Verification\Code;
//use Verification\Service\Event;
use Webdo\Verification\Event;
//use Verification\Service\Logger;
use Webdo\Verification\Logger;
//use Verification\Service\Order;
use Webdo\Verification\Order;

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

define("STOP_STATISTICS", true);
define('NO_AGENT_CHECK', true);
define("DisableEventsCheck", true);
require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
print_r('<br>'.'www/andreww1000.h1n.ru/local/modules/webdo.verification/process/user.php'.'<br>');

try {
    if (Loader::IncludeModule("webdo.verification")) {
        $request = Application::getInstance()->getContext()->getRequest();
        $post = $request->getPostList();

        if (count($post) > 0) {
            // проверка капчи
            if ($post["captcha_code"] && $post["captcha_id"] && $post["order_id"]) {
                if ($APPLICATION->CaptchaCheckCode($post["captcha_code"], $post["captcha_id"])) {
                    Order::update_order($post["order_id"], ['status_captcha' => 1]);
                    Event::add_event(['name' => 'captcha_success', 'order_id' => $post["order_id"]]);
                    LocalRedirect("/verification.service/?h={$post["order_hash"]}");
                } else {
                    LocalRedirect("/verification.service/?h={$post["order_hash"]}&error=" . urlencode(Order::ERROR_CAPTCHA));
                }
            }
            //проверка кода из смс
            if ($post['action'] && $post['action'] === 'check_code' && $post['code']) {
                $code = Code::get_code(['order_id' => $post["order_id"], 'status' => 0, 'type' => 'phone']);
                //if ($code && $code['code'] == $post['code'] || $post['code'] == '0000') {
                if ($code && $code['code'] == $post['code']) {
                    Code::update_code($code['id'], ['status' => 1]);
                    Order::update_order($post["order_id"], ['status_phone' => 1]);
                    Event::add_event(['name' => 'success_sms_code', 'order_id' => $post["order_id"]]);
                    LocalRedirect("/verification.service/?h={$post["order_hash"]}");
                } else {
                    $attempts = (int)$code['attempts'];
                    Code::update_code($code['id'], ['attempts' => ++$attempts]);
                    Event::add_event(['name' => 'error_sms_code', 'order_id' => $post["order_id"]]);

                    if ($attempts === (int)Option::get('verification.service', 'other_count_key')) {
                        Order::cancel_order($code['order_id'], 4);
                    }

                    LocalRedirect("/verification.service/?h={$post["order_hash"]}&error=" . urlencode(Order::ERROR_CODE));
                }
            }
        }
    }
} catch (Exception $e) {
    Logger::write('error', $e->getMessage());
}

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php";
