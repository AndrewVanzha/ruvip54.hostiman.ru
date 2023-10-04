<?php

namespace Reservation\Rate\Entity;

use Bitrix\Main\Entity;
use Exception;

class OrdersTable extends Entity\DataManager
{
    const STATUS_ACTIVE = 0;

    public static function getTableName()
    {
        return 'reservation_rate_orders';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array('primary' => true, 'autocomplete' => true)),
            new Entity\StringField('NUM_PAY'),
            new Entity\FloatField('SUMMCALL'),
            new Entity\FloatField('KURS'),
            new Entity\FloatField('SUMMTOCLIENT'),
            new Entity\FloatField('SUMSECPAY'),
            new Entity\DatetimeField('TIMEIN'),
            new Entity\DatetimeField('TIMELIMIT'),
            new Entity\StringField('FNAME'),
            new Entity\StringField('SNAME'),
            new Entity\StringField('MNAME'),
            new Entity\StringField('TEL'),
            new Entity\StringField('EMAIL'),
            new Entity\IntegerField('STATUS'),
            new Entity\IntegerField('REQUEST_TYPE'),
            new Entity\StringField('CURVAL'),
            new Entity\IntegerField('IDCASH')
        );
    }

    /**
     * Обновление статуса
     * @param $id
     * @param $status
     * @return bool
     * @throws Exception
     */
    public static function updateOrder($id, $status)
    {
        if (intval($id) > 0) {
            OrdersTable::Update($id, array(
                'STATUS' => $status,
                'FNAME' => '',
                'SNAME' => '',
                'MNAME' => '',
                'TEL' => '',
                'EMAIL' => '',
            ));
        }
        return true;
    }
}
