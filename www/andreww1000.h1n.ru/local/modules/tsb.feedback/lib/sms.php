<?php

namespace Tsb\Feedback;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Web\HttpClient;
use CDataXML;
use Exception;

class Sms
{
    const SMS_API_URL = 'https://api.smstraffic.ru/multi.php';

    private $login;
    private $password;

    /**
     * Sms constructor.
     * @throws ArgumentNullException|\Bitrix\Main\ArgumentOutOfRangeException
     */
    public function __construct()
    {
        $this->login = Option::get('tsb_feedback', 'sms_login');
        $this->password = Option::get('tsb_feedback', 'sms_pass');
    }

    /**
     * Отправка СМС
     *
     * @param string $phone
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function send($phone, $data)
    {
        if (empty($this->login) || empty($this->password)) {
            throw new Exception(Loc::getMessage("SMS_ERROR_ACCESS"));
        }

        $message = $this->getMessage($data);

        $params = [
            'login' => $this->login,
            'password' => $this->password,
            'phones' => '7' . $phone,
            'message' => $message,
            'rus' => 5
        ];

        return $this->makeRequest(self::SMS_API_URL, $params);
    }

    /**
     * Формирование сообщения для отправки
     *
     * @param $code
     * @return string
     */
    private function getMessage($code)
    {
        return sprintf(
            Loc::getMessage("SMS_MESSAGE"),
            $code
        );
    }

    /**
     * Выполнение запроса к API смс шлюза
     * @param $url
     * @param $params
     * @return array
     */
    private function makeRequest($url, $params)
    {
        $httpClient = new HttpClient();
        $httpClient->setHeader('Content-Type', 'application/x-www-form-urlencoded');
        $httpClient->post($url, $params);

        if ($httpClient->getStatus() !== 200) {
            return [
                'errorCode' => 500,
                'errorMessage' => Loc::getMessage("SMS_ERROR")
            ];
        }

        return $this->parseXML($httpClient->getResult());
    }

    /**
     *
     * Парсинг ответа от смс-шлюза
     *
     * @param $result
     * @return array
     */
    private function parseXML($result)
    {
        $xml = new CDataXML();
        $xml->LoadString($result);
        $result = $xml->SelectNodes('/reply/result');

        if (strtolower($result->content) === 'error') {
            $code = $xml->SelectNodes('/reply/code');
            $description = $xml->SelectNodes('/reply/description');

            return [
                'errorCode' => $code,
                'errorMessage' => $description
            ];
        }

        return [
            'errorCode' => 0,
            'status' => $result
        ];
    }
}