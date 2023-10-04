<?php
//namespace Verification\Service\Entity;
namespace Webdo\Verification\Entity;

use Bitrix\Main\Entity;

class EventTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'verification_event';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('id', array('primary' => true, 'autocomplete' => true)),
            new Entity\IntegerField('order_id'),
            new Entity\DatetimeField('date'),
            new Entity\StringField('name'),
            new Entity\StringField('message')
        );
    }
}
