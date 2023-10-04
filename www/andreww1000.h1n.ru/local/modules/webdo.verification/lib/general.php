<?php
//namespace Verification\Service;
namespace Webdo\Verification;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Mail\Event;
use CUser;
use Exception;
//use Verification\Service\Entity\UsersTable;
use Webdo\Verification\Entity\UsersTable;

class General
{
    private static $module_id = 'webdo.verification';

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
     * Отправка email-уведомления
     * @param $params
     */
    public static function send_email($params)
    {
        self::send_email_event($params, 'WD_VERIFICATION_ORDER');
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
     * Отправка СМС клиенту
     * @param $data
     * @return bool
     * @throws Exception
     */
    public static function send_sms_message($data)
    {
        /*$sms = new Sms();
        $result_sms = $sms->send(
            $data['phone'],
            $data['code']
        );*/
        print_r('<br>sms<br>');

        //return $result_sms['errorCode'] === 0;
    }

    /**
     * Проверка доступа к сервису
     * @param $hash
     * @return int
     * @throws Exception
     */
    public static function check_access($hash)
    {
        global $USER;
        $user_id = $USER->GetParam('USER_ID');
        //print_r(' $user_id=');
        //print_r($user_id);

        if ($user_id) {
            $user_groups = CUser::GetUserGroup($user_id);
            $group_validate_id = Option::get(self::$module_id, "group_id");
            //print_r(' $user_groups=');
            //print_r($user_groups);
            //print_r(' $group_validate_id=');
            //print_r($group_validate_id);

            if (in_array($group_validate_id, $user_groups)) {
                return 1;
            }
        }

        return self::valid_code('email', $hash) ? 2 : 0;
    }

    /**
     * Проверка email/смс кода на валидность
     * @param $type
     * @param $code
     * @return bool
     * @throws Exception
     */
    public static function valid_code($type, $code)
    {
        if (!$code) {
            return false;
        }

        if (Code::get_code(['code' => $code, 'type' => $type])) {
            return true;
        }

        return false;
    }

}