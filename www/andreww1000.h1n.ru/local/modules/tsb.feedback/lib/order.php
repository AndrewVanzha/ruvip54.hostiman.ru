<?php
/**
 * @var $APPLICATION
 */

namespace Tsb\Feedback;

use Bitrix\Main\ORM\Data\AddResult;
use Bitrix\Main\Type\DateTime;
use Exception;
use Tsb\Feedback\Entity\OrdersTable;
use Tsb\Feedback\Entity\UsersTable;

class Order
{
    const ERROR_CAPTCHA = 'Введен некорректно код с картинки';
    const ERROR_CODE = 'Введен некорректно код из смс';

    /**
     * Создание заявки и валидация
     * @param $data
     * @return string
     * @throws Exception
     */
    public static function create_order($data)
    {
        if (empty($data['fname'])) {
            throw new Exception(json_encode(['fname' => 'Не указано имя']));
        }
        if (preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$data['fname'])) {
            throw new Exception(json_encode(['fname' => 'Неправильное имя']));
        }
        if (empty($data['sname'])) {
            throw new Exception(json_encode(['sname' => 'Не указана фамилия']));
        }
        if (preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$data['sname'])) {
            throw new Exception(json_encode(['fname' => 'Неправильная фамилия']));
        }
        if (empty($data['mname'])) {
            throw new Exception(json_encode(['mname' => 'Не указано отчество']));
        }
        if (preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$data['mname'])) {
            throw new Exception(json_encode(['fname' => 'Неправильное отчество']));
        }
        if (empty($data['phone'])) {
            throw new Exception(json_encode(['phone' => 'Не указан номер телефона']));
        }
        if (empty($data['email'])) {
            throw new Exception(json_encode(['email' => 'Не указан email']));
        }
        if (preg_match("/[^(\w)|(\@)|(\.)]/",$data['email'])) {
            throw new Exception(json_encode(['email' => 'Неправильный email']));
        }
        if (empty($data['subject'])) {
            throw new Exception(json_encode(['subject' => 'Не указана тема обращения']));
        }
        $subject = htmlspecialchars(nl2br($data['subject']), ENT_NOQUOTES);
        if (empty($data['text'])) {
            throw new Exception(json_encode(['text' => 'Не задан текст обращения']));
        }
        if(stristr($data['text'], 'href') !== false || stristr($data['text'], 'http') !== false) {
            throw new Exception(json_encode(['text' => 'Размещение ссылок на иные интернет-ресурсы в тексте сообщения запрещено.<br>Просьба скорректировать обращение.<br>С уважением, Трансстройбанк']));
        }
        $text = htmlspecialchars(nl2br($data['text']), ENT_NOQUOTES);
        if (empty($data['policy'])) {
            throw new Exception(json_encode(['policy' => 'Не согласились с правилами']));
        }
        if (!General::validate('email', $data['email'])) {
            throw new Exception(json_encode(['email' => 'Некорректный email-адрес']));
        }

        $params = [
            'fname' => $data['fname'],
            'sname' => $data['sname'],
            'mname' => $data['mname'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            //'subject' => $data['subject'],
            'subject' => $subject,
            //'text' => $data['text'],
            'text' => $text,
            'dopname' => $data['dopname']
        ];

        return self::add_order($params);
    }

    /**
     * Добавление заявки в бд
     * @param $params
     * @return string
     * @throws Exception
     */
    private static function add_order($params)
    {
        //$first = ['date' => new DateTime(), 'fname' => $params['fname'], 'text' => $params['text']];  //  ???
        $first = ['date' => new DateTime()];
        $order = OrdersTable::add($first);

        if (empty($order)) {
            throw new Exception(json_encode(['order' => 'При оформлении заявки возникла ошибка, повторите позже']));
        }

        $order_id = $order->getId();
        $number = "Y-{$order_id}";

        OrdersTable::update($order_id, ['number' => $number]);
        if (!OrdersTable::update($order_id, ['number' => $number])) {
            throw new Exception(json_encode(['order' => 'При оформлении заявки возникла ошибка, повторите позже']));
        }
        //OrdersTable::update($order_id, ['fname' => $params['fname']]); //  ???
        //OrdersTable::update($order_id, ['text' => $params['text']]);  //  ???

        $params['number'] = $number;

        General::send_email($params);

        $base_path = $_SERVER["DOCUMENT_ROOT"];
        file_put_contents($base_path . '/dopX/obratny/tsb_params_' . $number . '.txt', $params);
        file_put_contents($base_path . '/dopX/obratny/tsb_text_' . $number . '.txt', $params['text']);
        Logger::write('rbs', $params['fname']);
        Logger::write('rbs', $params['sname']);
        Logger::write('rbs', $params['mname']);
        Logger::write('rbs', $params['phone']);
        Logger::write('rbs', $params['email']);
        Logger::write('rbs', $params['subject']);
        Logger::write('rbs', $params['text']);
        if(empty($params['dopname'])) {
            Logger::write('rbs', 'dopname');
        } else {
            Logger::write('rbs', $params['dopname']);
        }

        return $number;
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
}