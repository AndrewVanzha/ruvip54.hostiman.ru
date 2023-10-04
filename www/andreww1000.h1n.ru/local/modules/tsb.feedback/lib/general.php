<?php

namespace Tsb\Feedback;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Mail\Event;
use CUser;
use Exception;
use Tsb\Feedback\Entity\UsersTable;

class General
{
    private static $module_id = 'tsb.feedback';

    /**
     * Запрос по API
     * @param $url
     * @param $params
     * @return mixed
     */
    public static function request($url, $params)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64)");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result, true);
    }

    /**
     * Отправка СМС клиенту
     * @param $data
     * @return bool
     * @throws Exception
     */
    public static function send_sms_message($data)
    {
        $sms = new Sms();
        $result_sms = $sms->send(
            $data['phone'],
            $data['code']
        );

        return $result_sms['errorCode'] === 0;
    }

    /**
     * Отправка email-уведомления
     * @param $params
     */
    public static function send_email($params)
    {
        self::send_email_event($params, 'TSB_FEEDBACK_ORDER');
        self::send_email_event($params, 'TSB_FEEDBACK_ORDER_USER');
    }

    /**
     * Отправка уведомления по типу события
     *
     * @param $params
     * @param $event
     */
    private static function send_email_event($params, $event)
    {
        $args = array(
            "EVENT_NAME" => $event,
            "LID" => "s1",
            "C_FIELDS" => $params
        );

        Event::send($args);
    }

    /**
     * Валидация данных
     *
     * @param $type
     * @param $value
     * @return bool|false|int
     */
    public static function validate($type, $value)
    {
        switch ($type) {
            case 'number':
                return self::validate_number($value);
            case 'fio':
                return self::validate_fio($value);
            case 'email':
                return self::validate_email($value);
            default:
                return false;
        }
    }

    /**
     * Валидация на число
     * @param $value
     * @return false|int
     */
    private static function validate_number($value)
    {
        return preg_match('/^[0-9]*[.,]?[0-9]+$/', $value);
    }

    /**
     * Валидация на ФИО
     * @param $value
     * @return false|int
     */
    private static function validate_fio($value)
    {
        return preg_match('/^([а-яёa-z ]+)$/iu', $value);
    }

    /**
     * Удаление лишнего из номера телефона
     *
     * @param $phone
     * @return false|string
     */
    public static function correct_phone($phone)
    {
        $only_integer = preg_replace('~\D+~', '', $phone);

        return substr($only_integer, -10);
    }

    /**
     * Валидация email
     *
     * @param $value
     * @return bool
     */
    private static function validate_email($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return $value;
        }

        return false;
    }
}