<?php

namespace Tsb\Feedback\Entity;

use Bitrix\Main\Entity;

class OrdersTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'tsb_feedback';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('id', array('primary' => true, 'autocomplete' => true)),
            new Entity\StringField('number'),
            new Entity\DatetimeField('date')
        );
    }
}
