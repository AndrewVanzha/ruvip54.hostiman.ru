<?php
//namespace Verification\Service\Entity;
namespace Webdo\Verification\Entity;

use Bitrix\Main\Entity;

class OrdersTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'verification_orders';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('id', array('primary' => true, 'autocomplete' => true)),
            new Entity\IntegerField('user_id'),
            new Entity\DatetimeField('date'),
            new Entity\StringField('email'),
            new Entity\StringField('type'),
            new Entity\IntegerField('phone_number'),
            new Entity\IntegerField('status_email'),
            new Entity\IntegerField('status_captcha'),
            new Entity\IntegerField('status_phone'),
            new Entity\IntegerField('status')
        );
    }
}
