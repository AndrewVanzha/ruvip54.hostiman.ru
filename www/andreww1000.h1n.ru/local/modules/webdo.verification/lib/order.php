<?php
//namespace Verification\Service;
namespace Webdo\Verification;

use Bitrix\Main\ORM\Data\AddResult;
use Bitrix\Main\ORM\Data\UpdateResult;
use Bitrix\Main\ORM\Query\Result;
use Bitrix\Main\Type\DateTime;
use Exception;
//use Verification\Service\Entity\OrdersTable;
use Webdo\Verification\Entity\OrdersTable;
//use Verification\Service\Entity\UsersTable;
use Webdo\Verification\Entity\UsersTable;

class Order
{
    const ERROR_CAPTCHA = 'Введен некорректно код с картинки';
    const ERROR_CODE = 'Введен некорректно код из смс';

    /**
     * Создание заявки и валидация
     * @param $data
     * @return array
     * @throws Exception
     */
    public static function create_order($data)
    {
        if (count($data) === 0) {
            return [];
        }
        if (empty($data['type'])) {
            return ['data' => $data, 'error' => 'Не указан тип заявки'];
        }
        if (empty($data['abs_id'])) {
            return ['data' => $data, 'error' => 'Не указан код клиента из АБС'];
        }
        if (empty($data['phone'])) {
            return ['data' => $data, 'error' => 'Не указан номер телефона'];
        }
        if (empty($data['email']) && $data['type'] === 'email') {
            return ['data' => $data, 'error' => 'Не указан email-адрес'];
        }
        if (!General::validate('email', $data['email']) && $data['type'] === 'email') {
            return ['data' => $data, 'error' => 'Некорректный email-адрес'];
        }
        if (!General::validate('number', $data['abs_id'])) {
            return ['data' => $data, 'error' => 'Некорректный номер клиента в АБС'];
        }

        $params = [
            'type' => $data['type'],
            'abs_id' => $data['abs_id'],
            'date' => new DateTime(),
            'phone_number' => General::correct_phone($data['phone']),
        ];

        if ($data['type'] === 'email') {
            $params['email'] = $data['email'];
        }

        $repeat_order = Order::get_order(
            $params['type'] === 'phone'
                ? ['type' => 'phone', 'phone_number' => $params['phone_number']]
                : ['type' => 'email', 'email' => $params['email']]
        );

        if (!empty($repeat_order)) {
            return [
                'data' => $data,
                'error' => sprintf(
                    "Заявка с данным %s уже <a href='/verification.service/?page=order&id=%s'>существует</a>",
                    $data['type'] === 'email' ? 'email' : 'телефоном',
                    $repeat_order['id']
                )
            ];
        }

        try {
            return [
                'success' => true,
                'data' => $data,
                'response' => self::add_order($params)
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'data' => $data
            ];
        }
    }

    /**
     * Получение заявки по параметрам
     * @param $params
     * @return array|false
     * @throws Exception
     */
    public static function get_order($params)
    {
        return OrdersTable::getRow(array(
            "filter" => $params,
        ));
    }

    /**
     * Добавление заявки в бд
     * @param $params
     * @return AddResult
     * @throws Exception
     */
    private static function add_order($params)
    {
        $user = UsersTable::get_user(['abs_id' => $params['abs_id']]); // Получение пользователя

        if (!$user) {
            $user_id = self::add_user($params['abs_id'])->getId(); // Добавление пользователя
        } else {
            $user_id = $user['id'];
        }

        unset($params['abs_id']);

        $response = OrdersTable::add(
            array_merge(['user_id' => $user_id], $params)
        );

        if ($response) {
            Event::add_event([
                'name' => $params['type'] . '_verification_create',
                'order_id' => $response->getId()
            ]);

            Code::add_code([
                'order_id' => $response->getId(),
                'type' => $params['type'],
                'from' => $params['type'] === 'email'
                    ? $params['email']
                    : $params['phone_number']
            ]);

            if ($params['type'] === 'email') {
                Code::add_code([
                    'order_id' => $response->getId(),
                    'type' => 'phone',
                    'from' => $params['phone_number']
                ]);
            }
        }

        return $response;
    }

    /**
     * Обновление заявки
     * @param $id
     * @param $data
     * @return UpdateResult
     * @throws Exception
     */
    public static function update_order($id, $data)
    {
        return OrdersTable::Update($id, $data);
    }

    /**
     * Отмена заявки
     * @param $order_id
     * @param int $status
     * @throws Exception
     */
    public static function cancel_order($order_id, $status = 3)
    {
        $event_name = [
            2 => 'expired_order',
            3 => 'cancel_order',
            4 => 'attempts_expired_order',
        ];

        self::update_order($order_id, [
            'email' => '',
            'phone_number' => 0,
            'status_email' => $status,
            'status_captcha' => $status,
            'status_phone' => $status,
            'status' => $status,
        ]);

        Event::add_event([
            'name' => $event_name[$status],
            'order_id' => $order_id
        ]);

        $codes = Code::get_code_all(['order_id' => $order_id, 'status' => 0])->fetchAll();

        foreach ($codes as $code) {
            Code::update_code($code['id'], ['status' => $status]);
        }
    }

    /**
     * Получение всего списка заявок
     * @param int $page
     * @param array $params
     * @return array
     * @throws Exception
     */
    public static function get_all_orders($page = 1, $params = [])
    {
        $limit = 20;
        $offset = $page > 1 ? --$page * $limit : 0;
        $result = self::get_orders($params, $limit, $offset);
        $result['pages'] = (int)ceil($result['count'] / $limit);
        return $result;
    }

    /**
     * Получение списка заявок по параметрам
     * @param $filter
     * @param int $limit
     * @param int $offset
     * @param string[] $order
     * @return array
     * @throws Exception
     */
    public static function get_orders($filter, $limit = 9999, $offset = 0, $order = ['date' => 'desc'])
    {
        $count = OrdersTable::getCount($filter);
        return [
            'count' => (int)$count,
            'data' => OrdersTable::getList(array(
                "filter" => $filter,
                "limit" => $limit,
                "offset" => $offset,
                "order" => $order
            ))
        ];
    }

    /**
     * Добавление пользователя
     * @param $abs_id
     * @return AddResult
     * @throws Exception
     */
    private static function add_user($abs_id)
    {
        return UsersTable::add(array(
            'abs_id' => $abs_id
        ));
    }

    /**
     * Получение наименования типа заявки
     * @param $type
     * @return string
     */
    public static function get_order_type_label($type)
    {
        $text = [
            'email' => 'Email-верификация',
            'phone' => 'СМС-верификация'
        ];

        return $text[$type];
    }

    /**
     * Получение наименования статуса заявки
     * @param $status
     * @return string
     */
    public static function get_order_status_label($status)
    {
        $text = [
            0 => 'в ожидании',
            1 => 'выполнено',
            2 => 'истек срок действия',
            3 => 'отменена',
            4 => 'истекли попытки'
        ];

        return $text[$status];
    }

    /**
     * Проверка на наличае данных
     * @param $value
     * @return mixed|string
     */
    public static function check_deleted($value)
    {
        return $value ? $value : 'удален';
    }

    /**
     * Форматирование номера телефона для вывода
     * @param $number
     * @return string
     */
    public static function get_print_phone($number)
    {
        if (strlen($number) != 10) {
            return !empty($number) ? ($number) : '';
        }
        $sArea = substr($number, 0, 3);
        $sPrefix = substr($number, 3, 3);
        $sNumber = substr($number, 6, 4);

        return "+7 ({$sArea}) {$sPrefix}-{$sNumber}";
    }

    /**
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public static function get_correct_filter_params($params)
    {
        $params = array_filter($params, function ($v, $k) {
            return !empty($v) || ($k == 'status');
        }, ARRAY_FILTER_USE_BOTH);

        if (!empty($params['abs_id'])) {
            $user = UsersTable::get_user(['abs_id' => $params['abs_id']]);
            $params['user_id'] = $user['id'] ? $user['id'] : 0;
        }

        if (!empty($params['period'])) {
            $period = explode(' - ', $params['period']);
            $start_date = new DateTime($period[0], "d/m/Y");
            $end_date = new DateTime($period[1], "d/m/Y");
            $params['>=date'] = $start_date;
            $params['<=date'] = $end_date->add('1 day');
        }

        $params = array_filter($params, function ($k) {
            return in_array($k, ['>=date', '<=date', 'user_id', 'type', 'phone_number', 'email', 'status']);
        }, ARRAY_FILTER_USE_KEY);

        return $params;
    }
}