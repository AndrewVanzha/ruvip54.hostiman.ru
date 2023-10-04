<?php
/**
 * @var $APPLICATION
 */

use Bitrix\Main\Application;
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

try {
    if (Loader::IncludeModule("webdo.verification")) {
        $request = Application::getInstance()->getContext()->getRequest();
        $post = $request->getPostList();
        print_r('<br>$post=');
        print_r($post);

        if (count($post) > 0) {
            switch ($post['action']) {
                case 'create_order':
                    $result = Order::create_order([
                        'type' => $post['type'],
                        'abs_id' => $post['abs_id'],
                        'phone' => $post['phone'],
                        'email' => $post['email']
                    ]);

                    if ($result['success']) {
                        LocalRedirect('/verification.service/?page=order&id=' . $result['response']->getId());
                    }

                    $result = urlencode(json_encode($result));
                    LocalRedirect("/verification.service/?page=create_order&result={$result}");
                    break;

            }
        }
    }

} catch (Exception $ex) {
    Logger::write('error', $ex->getMessage());
}

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php";

