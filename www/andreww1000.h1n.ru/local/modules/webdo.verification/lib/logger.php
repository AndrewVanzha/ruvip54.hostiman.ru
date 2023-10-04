<?php
//namespace Verification\Service;
namespace Webdo\Verification;

class Logger
{
    /**
     * Запись логов в файл
     *
     * @param $type
     * @param $message
     */
    public static function write($type, $message)
    {
        if (in_array($type, ['warning', 'error', 'rbs']) && !empty($message)) {
            file_put_contents(
                $_SERVER["DOCUMENT_ROOT"] .
                '/local/modules/webdo.verification/log/' .
                date('YW') . '_' . $type . '.log',
                '[' . date('d.m.Y H:i:s') . '] ' .
                $message . PHP_EOL,
                FILE_APPEND
            );
        }
    }
}