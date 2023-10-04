<?php
/**
 * @var $APPLICATION
 * @var $module_id
 * @var $get
 * @var $post
 */

use Bitrix\Main\Localization\Loc;
//use Verification\Service\Entity\UsersTable;
use Webdo\Verification\Entity\UsersTable;
//use Verification\Service\Event;
use Webdo\Verification\Event;
//use Verification\Service\General;
use Webdo\Verification\General;
//use Verification\Service\Logger;
use Webdo\Verification\Logger;
//use Verification\Service\Order;
use Webdo\Verification\Order;
?>
    <div class="vs-tabs">
        <a href="/verification.service/" class="vs-tab <?= empty($get['page']) ? 'vs-tab_active' : '' ?>">
            <?= Loc::getMessage("list_order") ?>
        </a>
        <a href="/verification.service/?page=create_order"
           class="vs-tab <?= !empty($get['page']) && $get['page'] === 'create_order' ? 'vs-tab_active' : '' ?>"
        ><?= Loc::getMessage("add_order") ?>
        </a>
        <?/*?><a href="/v/?logout=yes" class="vs-tab" style="margin-left: auto;">Выйти из сервиса</a><?*/?>
        <?/*?><a href="/verification.service/?logout=yes&<?=bitrix_sessid_get('sessid')?>" class="vs-tab" style="margin-left: auto;">Выйти из сервиса</a><?*/?>
        <a href="/v/?logout=yes&<?=bitrix_sessid_get('sessid')?>" class="vs-tab" style="margin-left: auto;">Выйти из сервиса</a>
    </div>
<?php
try {
    if (empty($get['page'])) {
        $current_page = $get['current_page'] ? $get['current_page'] : 1;

        if ($get['action'] && $get['action'] === 'filter') {
            $params = [];
            $get['type'] ? $params['type'] = $get['type'] : null;
            $get['phone_number'] ? $params['phone_number'] = General::correct_phone($get['phone_number']) : null;
            $get['email'] ? $params['email'] = $get['email'] : null;
            isset($get['status']) && $get['status'] !== "" ? $params['status'] = $get['status'] : null;
            $get['abs_id'] ? $params['abs_id'] = $get['abs_id'] : null;
            $get['period'] ? $params['period'] = $get['period'] : null;
            $params = Order::get_correct_filter_params($params);
        } else {
            $params = [];
            $start_date = new \Bitrix\Main\Type\DateTime(date("d/m/Y", time() - 30 * 24 * 3600), "d/m/Y");
            $end_date = new \Bitrix\Main\Type\DateTime(date("d/m/Y"), "d/m/Y");
            $params['>=date'] = $start_date;
            $params['<=date'] = $end_date->add('1 day');
        }

        $array_orders = Order::get_all_orders($current_page, $params);
        $orders = array_map(
            function ($value) {
                $value['abs_id'] = (int)UsersTable::get_user(['id' => $value['user_id']])['abs_id'];
                return $value;
            }, $array_orders['data']->fetchAll()
        );

        $APPLICATION->IncludeFile(
            "/local/modules/$module_id/views/manager/list.php",
            ['orders' => $orders, 'get' => $get, 'count' => $array_orders['count'], 'pages' => $array_orders['pages']]
        );
    }
    elseif ($get['page'] === 'order') {
        $events = Event::get_events(['order_id' => $get['id']]);
        $order = Order::get_order(['id' => $get['id']]);
        $user = UsersTable::get_user(['id' => $order['user_id']]);
        $order['abs_id'] = $user['abs_id'];

        $APPLICATION->IncludeFile(
            "/local/modules/$module_id/views/manager/view.php",
            ['order' => $order, 'events' => $events, 'module_id' => $module_id, 'error' => $get['error']]
        );
    }
    elseif ($get['page'] === 'create_order') {
        $APPLICATION->IncludeFile(
            "/local/modules/$module_id/views/manager/create.php",
            array('result' => $get['result'] ? json_decode(urldecode($get['result']), true) : false)
        );
    }
} catch (\Exception $ex) {
    Logger::write('error', $ex->getMessage());
}
