<?php
//namespace Verification\Service;
namespace Webdo\Verification;

use Bitrix\Main\ORM\Data\AddResult;
use Bitrix\Main\ORM\Query\Result;
use Bitrix\Main\Type\DateTime;
use Exception;
//use Verification\Service\Entity\EventTable;
use Webdo\Verification\Entity\EventTable;

class Event
{
    const email_verification_create = "Создана заявка на верификацию email";
    const phone_verification_create = "Создана заявка на верификацию номера телефона";
    const send_sms_code = "Отправлен смс-код для верификации";
    const success_sms_code = "Смс-код подтвержден";
    const error_sms_code = "Введен некоррктный код смс-подтверждения";
    const send_email_code = "Отправлена ссылка для верификации на email-адрес";
    const success_order = "Заявка выполнена";
    const expired_order = "Истекло время действия заявки, заявка закрыта";
    const cancel_order = "Заявка отменена";
    const attempts_expired_order = "Истекли попытки на ввод кода, заявка закрыта";
    const email_open = "Произведен переход по ссылке из email";
    const captcha_success = "Капча успешно пройдена";

    /**
     * Получение списка событий по параметрам
     * @param $params
     * @return Result
     * @throws Exception
     */
    public static function get_events($params)
    {
        return EventTable::getList(array(
            "filter" => $params,
            "order" => ['date' => 'asc']
        ));
    }

    /**
     * @param $params
     * @return AddResult
     * @throws Exception
     */
    public static function add_event($params)
    {
        $params += [
            'date' => new DateTime(),
            //'message' => constant('Verification\Service\Event::'.$params['name'])
            'message' => constant('Webdo\Verification\Event::'.$params['name'])
        ];

        return EventTable::add($params);
    }
}