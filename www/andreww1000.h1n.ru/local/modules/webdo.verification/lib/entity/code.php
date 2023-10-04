<?php
//namespace Verification\Service\Entity;
namespace Webdo\Verification\Entity;

use Bitrix\Main\Entity;

class CodeTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'verification_code';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('id', array('primary' => true, 'autocomplete' => true)),
            new Entity\IntegerField('order_id'),
            new Entity\DatetimeField('date'),
            new Entity\DatetimeField('date_expired'),
            new Entity\StringField('type'),
            new Entity\StringField('code'),
            new Entity\IntegerField('attempts'),
            new Entity\IntegerField('status')
        );
    }
}
