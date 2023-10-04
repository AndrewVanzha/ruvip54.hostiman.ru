<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

// https://ut11-web.ru/learning-eshop-on-1c-bitrix/support-class-in-components-bitrix/

use \Bitrix\Main;
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;

class SynchCurrency extends CBitrixComponent
{
    public $MessageError = array();
    public $MessageSend  = array();

    private static $json_path;
    private static $bank_path;
    //private static $bank_path1;
    private static $xml_path;
    private static $html_path;
    private static $test_path;
    private static $day_path;

    public function __construct($component)
    {
        parent::__construct($component);

        self::$json_path = $_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/currency.json'; // json с курсами ЦБР и отделениями банка в городах
        self::$bank_path = $_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/bank.csv'; // csv с курсами в отделениях банка в городах на дату
        //self::$bank_path1 = $_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/bank1.csv';
        self::$html_path = $_SERVER['DOCUMENT_ROOT'] . '/dopX/currency_rates_table.html';
        self::$xml_path = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=';
        self::$test_path = $_SERVER['DOCUMENT_ROOT'] . '/dopX/test.json'; // json с курсами ЦБР и отделений - часть исходного
        self::$day_path = $_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/day.json';
    }

    /**
     * Перезаписываем $this->arParams (удаляем ненужное)
     *
     * @param array $params Параметры компонента
     *
     * @return array Возвращает очищенные параметры компонента
     */
    public function onPrepareComponentParams($params)
    {
        return array(
            "CACHE_TIME" => $params['CACHE_TIME'],
            //"OFFICE_IBLOCK_ID" => $params['OFFICE_IBLOCK_ID'],
            "CBR_IBLOCK_ID" => $params['CBR_IBLOCK_ID'],
        );
    }

    /**
     * Проверяет подключение необходиимых модулей
     */
    protected function checkModules()
    {
        if (!Loader::includeModule('iblock')) {
            throw new Main\LoaderException('Ошибка модуля iblock');
        }
    }

    /**
     * Вывод сообщения об ошибке
     */
    protected function actionMessage()
    {
        $this->arResult["MESSAGE_ERROR"] = $this->MessageError;
        $this->arResult["MESSAGE_SEND"] = $this->MessageSend;
        foreach ($this->arResult['MESSAGE_ERROR'] as $error) {
            echo "<p style='color: red;'>{$error}</p>";
        }
        foreach ($this->arResult['MESSAGE_SEND'] as $send) {
            echo "<p style='color: green;'>{$send}</p>";
        }
    }

    /**
     * Выполнение компонента
     */
    public function executeComponent()
    {
        try {
            $this->arResult["COMPONENT_ID"] = 'SC';
            $this->checkModules();
            //$this->updateCourses();
            $this->getResult();
            $this->actionMessage();

            $this->includeComponentTemplate(); // ?
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }

    /**
     * Вывод курсов валют на сайт
     */
    protected function getResult()
    {
        try {
            $json = $this->checkCurrencyJson();   // проверяем существование json-файла и его валидность
            //debugg('getResult');
            //debugg($json);

            if (!empty($json['tsb']['time'])) {
                $this->arResult['MODIFY_DATE_FILE'] = $json['tsb']['time'];
            }

            try {
                $tsb = $this->getCourseTSB($json);
            } catch (Exception $e) {
                $tsb = array();
                $this->logger('error', $e->getMessage());
            }
            //debugg('getResult tsb');
            //debugg($tsb);
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/getResult_tsb.json', json_encode($tsb));

            try {
                $cbr = $this->getCourseCBR($json);
            } catch (Exception $e) {
                $cbr = array();
                $this->logger('error', $e->getMessage());
            }
            //debugg('getResult cbr');
            //debugg($cbr);

            // проверяем существование day.json
            if (!file_exists(self::$day_path)) {
                $day_json = $json;
                throw new Exception('файл day.json с курсами валют отсутствует, данные берем из текущего json');
            } else {
                $day_json = json_decode(file_get_contents(self::$day_path), true);
                //$day_tsb = $this->getCourseTSB($day_json);
                $day_tsb = $this->getCourseCBR($day_json);
                $day_cbr = $this->getCourseCBR($day_json);
                //debugg('$day_cbr');
                //debugg($day_cbr);
            }

            foreach (self::templateCourses() as $key => $course) {
                //debugg('$course=');
                //debugg($course);
                //debugg('tsb[$key][buy]');
                //debugg($tsb[$key]['buy']);
                if (!empty($tsb[$key]['buy'])) {
                    if (!empty($cbr[$key]) && !empty($cbr[$key]['course']) && !empty($cbr[$key]['status'])) {
                        $cbr_course = $cbr[$key]['course'];
                        $cbr_status = $cbr[$key]['status'];
                    } else {
                        $cbr_course = '';
                        $cbr_status = '';
                    }
                    //debugg('$cbr_course');
                    //debugg($cbr_course);
                    //debugg($cbr_status);

                    /*$this->arResult['CUR'][$key] = array(
                        $course['iso_s'] . ' ' . $course['symbol'],
                        $tsb[$key]['buy'] . '/' . $tsb[$key]['status'],
                        $tsb[$key]['sell'] . '/' . $tsb[$key]['status'],
                        $cbr_course . '/' . $cbr_status
                    );*/

                    if(isset($tsb[$key]['multi'])) $multi_coeff = $tsb[$key]['multi'];
                    else $multi_coeff = '';
                    $this->arResult['CUR'][$key] = array(
                        $course['iso_s'] . ' ' . $course['symbol'],
                        $tsb[$key]['buy'] . '/' . $tsb[$key]['status'],
                        $tsb[$key]['sell'] . '/' . $tsb[$key]['status'],
                        $cbr_course . '/' . $cbr_status,
                        $course['name'],
                        $course['iso_s'],
                        $course['symbol'],
                        $multi_coeff,
                    );
                }
            }
            //debugg($this->arResult['CUR']);
            $this->arResult['MAIN_TABLE'] = $this->makeCurrencyTableArray($this->arResult['CUR'], $day_tsb, $day_cbr);
            //debugg('$this->arResult');
            //debugg($this->arResult);
            return $this->arResult['MAIN_TABLE'];
        } catch (Exception $e) {
            $this->logger('error', $e->getMessage());
            return [];
        }
    }

    /**
     * Делаем таблицу с курсами валют для сайта
     */
    public function makeCurrencyTableArray($arCurrency, $day_tsb, $day_cbr)
    {
        function compare_currency_words($a, $b) {
            return strnatcmp($a["name"], $b["name"]);
        }

        \Bitrix\Main\Loader::IncludeModule('highloadblock');

        $ID = 8; // CurrencyOutCbrf
        $hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById($ID)->fetch();
        $hlEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData)->getDataClass();

        $arCurrencyOutCbrf = [];
        $result = $hlEntity::getList([
            'select' => ["*"],
            //"select" => array("ID", "UF_NAME", "UF_XML_ID"), // Поля для выборки
            'filter' => [],
            "order" => array(),
            //"order" => array("UF_SORT" => "ASC"),
        ]);
        while ($res = $result->fetch()) {
            $arCurrencyOutCbrf[] = $res;
        }


        $ID = 9; // CurrencyMultiplicity
        $hlData = \Bitrix\Highloadblock\HighloadBlockTable::getById($ID)->fetch();
        $hlEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlData)->getDataClass();

        $arCurrencyMultiplicity = [];
        $result = $hlEntity::getList([
            'select' => ["*"],
            'filter' => [],
            "order" => array(),
        ]);
        while ($res = $result->fetch()) {
            $arCurrencyMultiplicity[] = $res;
        }
        //debugg('$arCurrencyMultiplicity');
        //debugg($arCurrencyMultiplicity);

        $arShowTable = [];
        $arShowLine = [];
        $ii = 1;
        foreach ($arCurrency as $key=>$arCur) {
            if ($arCur[1] !== '/') {
                $arShowLine['name'] = $arCur[4];
                $symbol = $arCur[5];
                $arShowLine['symbol'] = $symbol;

                $arElement = explode("/", $arCur[1]);
                $arShowLine['buy'] = $arElement[0];
                $arShowLine['buy_move0'] = $arElement[1];
                if($arShowLine['buy'] > $day_tsb[$symbol]['buy']) $arShowLine['buy_move'] = '>';
                if($arShowLine['buy'] < $day_tsb[$symbol]['buy']) $arShowLine['buy_move'] = '<';
                if($arShowLine['buy'] == $day_tsb[$symbol]['buy']) $arShowLine['buy_move'] = '=';

                $arElement = explode("/", $arCur[2]);
                $arShowLine['sell'] = $arElement[0];
                $arShowLine['sell_move0'] = $arElement[1];
                if($arShowLine['sell'] > $day_tsb[$symbol]['sell']) $arShowLine['sell_move'] = '>';
                if($arShowLine['sell'] < $day_tsb[$symbol]['sell']) $arShowLine['sell_move'] = '<';
                if($arShowLine['sell'] == $day_tsb[$symbol]['sell']) $arShowLine['sell_move'] = '=';

                $arElement = explode("/", $arCur[3]);
                $arShowLine['cb'] = $arElement[0];
                $arShowLine['cb_move0'] = $arElement[1];
                if(!empty($arElement[0])) {
                    if($arShowLine['cb'] > $day_cbr[$symbol]['course']) $arShowLine['cb_move'] = '>';
                    if($arShowLine['cb'] < $day_cbr[$symbol]['course']) $arShowLine['cb_move'] = '<';
                    if($arShowLine['cb'] == $day_cbr[$symbol]['course']) $arShowLine['cb_move'] = '=';
                } else {
                    $arShowLine['cb_move'] = '';
                }

                $arShowLine['note'] = '';
                $arShowLine['mark'] = '';
                if(empty($arCur[7])) {
                    $arShowLine['multi'] = '';
                    $ask_highload_multi_flag = true; // беру multi из соотв. highloadblock
                }
                else {
                    $arShowLine['multi'] = $arCur[7]; // multi из входного cur.csv
                    $ask_highload_multi_flag = false;
                }

                /*foreach ($arCurrencyOutCbrf as $item) {                  // сначала сортировка
                    if($symbol == $item['UF_CURRENCY_OUT_CB']) {
                        $arShowLine['note'] = "<sup>" . $ii . "</sup>";
                        $ii += 1;
                        $arShowLine['mark'] = 'cb';
                    }
                }

                foreach ($arCurrencyMultiplicity as $item) {
                    if($symbol == $item['UF_CURR_WITH_MULT']) {
                        if($arShowLine['mark'] === 'cb') {
                            $arShowLine['mark'] = 'both';
                        } else {
                            $arShowLine['mark'] = 'multi';
                            $arShowLine['note'] = "<sup>" . $ii . "</sup>";
                            $ii += 1;
                        }
                        $arShowLine['multi'] = $item['UF_MULT_COEFF'];
                    }
                }*/
            }
            $arShowTable[$key] = $arShowLine;
        }
        usort($arShowTable, "compare_currency_words");

        $ii = 1;
        foreach ($arShowTable as $key=>$arCur) {
            $symbol = $arCur['symbol'];
            foreach ($arCurrencyOutCbrf as $item) {
                if($symbol == $item['UF_CURRENCY_OUT_CB']) {
                    //$arShowTable[$key]['note'] = "<sup>" . $ii . "</sup>";
                    $arShowTable[$key]['note'] = "<sup>" . "i" . "</sup>";
                    $ii += 1;
                    $arShowTable[$key]['mark'] = 'cb';
                }
            }

            foreach ($arCurrencyMultiplicity as $item) {
                if($symbol == $item['UF_CURR_WITH_MULT']) {
                    if($arShowTable[$key]['mark'] === 'cb') {
                        $arShowTable[$key]['mark'] = 'both';
                    } else {
                        $arShowTable[$key]['mark'] = 'multi';
                        //$arShowTable[$key]['note'] = "<sup>" . $ii . "</sup>";
                        $arShowTable[$key]['note'] = "<sup>" . "i" . "</sup>";
                        $ii += 1;
                    }
                    if($ask_highload_multi_flag) {
                        $arShowTable[$key]['multi'] = $item['UF_MULT_COEFF'];
                    }
                    if (isset($item['UF_CURR_TEXT_MULT'])) {
                        $arShowTable[$key]['genetive'] = $item['UF_CURR_TEXT_MULT'];
                    } else {
                        $arShowTable[$key]['genetive'] = ' единиц валюты';
                    }
                }
            }
        }
        return $arShowTable;
    }


    /**
     * Обновляем курсы валют на сайте
     */
    public function updateCourses()
    {
        try {
            $json = $this->checkCurrencyJson();  // проверяем существование json-файла с курсами ЦБР и отделениями банка и его валидность
            $fpc = file_put_contents(self::$test_path, json_encode($json));
            //debugg('updateCourses');
            //debugg($fpc);
            //debugg($json);

            if (!file_exists(self::$bank_path)) {  // проверяем существование csv-файла с курсами в отделениях банка в городах
                throw new Exception('CSV-файл с курсами валют отсутствует');
            }

            // если время последнего обновления курсов банка < времени обновления файла с актуальными курсами, то обновляем курсы в json
            //debugg($json['tsb']['time']);
            //debugg(filectime(self::$bank_path));
            if ($json['tsb']['time'] < filectime(self::$bank_path)) {
                $tsb_courses = $this->parseCoursesTSB();

                if (!empty($tsb_courses)) {
                    $json = $this->updateCoursesTSB($tsb_courses, $json);
                    $update = true;
                }
            }

            // если курсы валют ЦБ сегодня ещё не обновлялись, то обновляем
            //debugg($json['cbr']['time']);
            //debugg(mktime(0, 0, 0, date('m'), date('d'), date('Y')));
            if ($json['cbr']['time'] < mktime(0, 0, 0, date('m'), date('d'), date('Y'))) {
                $cbr_courses = $this->parseCoursesCBR();
                //debugg('$cbr_courses');debugg($json);//debugg($cbr_courses);
                if (!empty($cbr_courses)) {
                    $json = $this->updateCoursesCBR($cbr_courses, $json);
                    $update = true;

                    $this->addCourseForDynamic($json['cbr']['data']);
                }
            }
            //$this->createHtml($json);  // при отладке

            // если обновились данные по курсам банка или ЦБ, то записываем всё в json-файл
            if (!empty($update)) {
                file_put_contents(self::$json_path, json_encode($json));

                // если запись в json-файл не произошла, заносим в логи ошибку
                if (filectime(self::$json_path) < time() - 120) {
                    $this->logger('error', 'При обновлении json-файла возникла ошибка');
                } else {
                    $this->logger('notice', 'Json-файл успешно обновлен');

                    // обновляем html-файл для банки.ру
                    $this->createHtml($json);
                    $this->add_history_rate($json);
                }
            }

            //$fpc = file_put_contents(self::$test_path, json_encode($json));
            //debugg('$fpc');
            //debugg($fpc);
            //debugg(self::$test_path);
        } catch (Exception $e) {
            $this->logger('error', $e->getMessage());
        }
    }

    /**
     * Проверка json-файла с курсами валют
     *
     * @return array
     */
    private function checkCurrencyJson()
    {
        try {
            //debugg('checkCurrencyJson');
            if (!file_exists(self::$json_path)) {
                throw new Exception('Файл json отстутствует. Будет создан новый файл.');
            }
            $json = json_decode(file_get_contents(self::$json_path), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Невалидный json. Данные будут полностью заменены новыми.');
            }
        } catch (Exception $e) {
            $json = array(
                'tsb' => array(
                    'time' => time() - 365 * 24 * 60 * 60,
                    'data' => []
                ),
                'cbr' => array(
                    'time' => time() - 365 * 24 * 60 * 60,
                    'data' => []
                )
            );
            $this->logger('warning', $e->getMessage());
        }
        return $json;
    }

    /**
     * Парсим CSV-файл с курсами валют банка
     *
     * @return array
     */
    private function parseCoursesTSB()
    {
        try {
            $fd = @fopen(self::$bank_path, "r");

            if (!$fd) {
                throw new Exception('CSV-файл с курсами валют не доступен.');
            }

            $result = [];
            while (($data = fgetcsv($fd, 1000, ";")) !== false) {
                $num = count($data);
                if ($num == 6) {
                    for ($c = 0; $c < $num; $c++) {
                        $result[$data['0']]['code'] = $data['0'];
                        $result[$data['0']]['name'] = $data['1'];
                        $result[$data['0']]['date'] = $data['2'];
                        $result[$data['0']]['currency'][$data['3']]['buy'] = $data['4'];
                        $result[$data['0']]['currency'][$data['3']]['sell'] = $data['5'];
                        $result[$data['0']]['currency'][$data['3']]['status'] = '>';
                    }
                }
            }
            @fclose($fd);

            return $result;
        } catch (Exception $e) {
            $this->logger('error', $e->getMessage());

            return [];
        }
    }

    /**
     * Обновляем курсы валют по банку
     *
     * @param array $courses Массив с актуальными курсами валют банка
     * @param array $json Массив последних обновленных данных по курсам валют
     *
     * @return array Обновленный массив данных по курсам валют
     */
    private function updateCoursesTSB(array $courses, array $json)
    {
        $currency_out = [];

        foreach ($courses as $key => $course) {
            $currency_out[$key] = $course;

            if (empty($json['tsb']['data'][$key])) {
                continue;
            }

            $currency_out[$key] = $this->updateCoursesTSBStatus($course, $json['tsb']['data'][$key]);
        }

        $json['tsb']['time'] = time();
        $json['tsb']['data'] = $currency_out;

        return $json;
    }

    /**
     * Обновляем статусы курса валюты банка
     *
     * @param array $course Актуальный курс валюты
     * @param array $json Массив последних обновленных данных по курсам валют
     *
     * @return array Возвращает массив с обновленными статусами курсов валют банка
     */
    private function updateCoursesTSBStatus(array $course, array $json)
    {
        foreach ($course['currency'] as $key => $currency) {
            if (!empty($json['currency'][$key])) {
                if ($json['currency'][$key]['buy'] === $currency['buy'] && $json['currency'][$key]['sell'] === $currency['sell']) {
                    $course['currency'][$key]['status'] = $json['currency'][$key]['status'];
                } elseif ($json['currency'][$key]['buy'] > $currency['buy']) {
                    $course['currency'][$key]['status'] = '<';
                } else {
                    $course['currency'][$key]['status'] = '>';
                }
            }
        }

        return $course;
    }

    /**
     * Парсим XML-файл с курсами валют ЦБ РФ
     *
     * @return array
     */
    private function parseCoursesCBR()
    {
        try {
            $data = $this->loadCoursesCBR();

            if (empty($data)) {
                throw new Exception('Данные по курсам валют ЦБ РФ отсутствуют');
            }

            $pattern = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i";
            preg_match_all($pattern, $data, $courses, PREG_SET_ORDER);

            $result = [];
            foreach ($courses as $course) {
                foreach (self::templateCourses() as $template) {
                    if ($course[2] == $template['iso_n']) {
                        $result[$template['iso_s']]['course'] = str_replace(",", ".", $course[4]);
                        $result[$template['iso_s']]['status'] = '>';
                    }
                }
            }

            return $result;

        } catch (Exception $e) {
            $this->logger('error', $e->getMessage());

            return [];
        }
    }

    /**
     * Загрузка курсов валют с ЦБ РФ
     *
     * @return string Данные по курсам валют
     * @throws Exception
     */
    private function loadCoursesCBR()
    {
        $date = date('d/m/Y');
        $link = self::$xml_path . $date;

        $fd = @fopen($link, "r");

        if (!$fd) {
            throw new Exception('Сервер данных ЦБ РФ не отвечает.');
        }

        $data = '';
        while (!feof($fd)) {
            $data .= @fgets($fd, 4096);
        }
        @fclose($fd);

        //file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/kompleks/cur_cbr.xml', $data);
        //file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/cur_cbr.xml', $data);

        return $data;
    }

    /**
     * Обновляем курсы валют по ЦБ РФ
     *
     * @param array $courses Массив с актуальными курсами валют ЦБ РФ
     * @param array $json Массив последних обновленных данных по курсам валют
     *
     * @return array Обновленный массив данных по курсам валют
     */
    private function updateCoursesCBR(array $courses, array $json)
    {
        $currency_out = [];

        foreach ($courses as $key => $course) {
            $currency_out[$key] = $course;

            if (empty($json['cbr']['data'][$key])) {
                continue;
            }
            $currency_out[$key] = $this->updateCoursesCBRStatus($course, $json['cbr']['data'][$key]);
        }

        $json['cbr']['time'] = time();
        $json['cbr']['data'] = $currency_out;

        return $json;
    }

    /**
     * Обновляем статусы курса валюты ЦБ РФ
     *
     * @param array $course Актуальный курс валюты
     * @param array $json Массив последних обновленных данных по курсам валют
     *
     * @return array Возвращает массив с обновленными статусами курсов валют ЦБ РФ
     */
    private function updateCoursesCBRStatus(array $course, array $json)
    {
        if ($json['course'] === $course['course']) {
            $course['status'] = $json['status'];
        } elseif ($json['course'] > $course['course']) {
            $course['status'] = '<';
        } else {
            $course['status'] = '>';
        }

        return $course;
    }

    /**
     * Создание HTML-файла с курсами валют
     *
     * @param array $json Массив с данными по курсам валют
     */
    private function createHTML(array $json)
    {
        $date = date('d.m.y', $json['tsb']['time']);

        $output = '<!DOCTYPE html>';
        $output .= '<html lang="ru">';
        $output .= '<head>';
        $output .= '<title>Курсы обмена наличной иностранной валюты, установленные банком на ' . $date . '</title>';
        $output .= '<style type="text/css">table {border-collapse: collapse;}td, th {padding: 5px 10px; border-bottom: 1px #999 solid;}th {text-align: left; border-width: 2px;}tr:hover td {background-color: #F3F3F3; border-color: #555;}</style>';
        $output .= '</head>';
        $output .= '<body>';

        $cities = $this->getCity();

        foreach ($cities as $city) {
            $output .= '<h2>' . $city['NAME'] . '</h2>';
            $output .= '<table>';
            $output .= '<thead>';
            $output .= '<tr><th>код</th><th>единиц</th><th>название валюты</th><th>покупка</th><th>продажа</th></tr>';
            $output .= '</thead>';

            if (!empty($city['PROPERTY_ATT_CODE_VALUE'])) {
                $courses = $this->minimumCourse($city, $json);
                //debugg('$courses');
                //debugg($courses);
                //debugg($city);

                foreach ($courses as $key => $course) {
                    if ($course['buy'] == 0) {
                        continue;
                    }

                    //if (in_array($key, ['BYN', 'TRY', 'ILS'])) {
                    //if (in_array($key, ['BYN', 'TRY', 'ILS', 'CAD', 'SAR', 'INR', 'AZN', 'QAR', 'SGD', 'AUD', 'KZT'])) {
                    //if (in_array($key, ['BYN', 'TRY', 'ILS', 'CAD', 'SAR', 'INR', 'AZN', 'QAR', 'SGD', 'AUD', 'KZT', 'AED', 'EGP'])) {
                    if (in_array($key, ['KGS', 'ZAR' ,'BYN', 'TRY', 'ILS', 'CAD', 'SAR', 'INR', 'AZN', 'QAR', 'SGD', 'AUD', 'KZT', 'AED', 'EGP'])) {
                        continue;
                    }

                    $output .= '<tr>';
                    $output .= '<td>' . $key . '</td>';
                    $output .= '<td>' . self::templateCourses()[$key]['count'] . '</td>';
                    $output .= '<td>' . self::templateCourses()[$key]['name'] . '</td>';
                    $output .= '<td>' . str_replace('.', ',', $course['buy']) . '</td>';
                    $output .= '<td>' . str_replace('.', ',', $course['sell']) . '</td>';
                    $output .= '</tr>';
                }
            }

            $output .= '</table>';
        }

        file_put_contents(self::$html_path, $output);
    }

    /**
     * Загрузка курсов валют с ЦБ РФ
     *
     * @return string Данные по курсам валют
     * @throws Exception
     */
    private function loadCurrencyTemplate()
    {
        $data = self::templateCourses();

        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/currency/cur_template.txt', json_encode($data));
    }

    /**
     * Получение списка городов
     *
     * @return array
     */
    private function getCity()
    {
        $cities = [];
        //debugg('getCity');

        if(CModule::IncludeModule("iblock")) {
            $rsCities = CIBlockElement::GetList(
                array(),
                array('IBLOCK_ID' => 17, 'ACTIVE' => 'Y'),  // Банк в городах
                false,
                false,
                array('ID', 'NAME', 'PROPERTY_ATT_CODE')
            );
            while ($arCity = $rsCities->Fetch()) {
                $cities[] = $arCity;
            }
        }

        return $cities;
    }

    /**
     * Получаем курсы валют банка для вывода на сайт
     *
     * @param array $json Массив с курсами валют
     *
     * @return array Возвращает массив курсов валют банка
     * @throws Exception
     */
    private function getCourseTSB(array $json)
    {
        if (empty($json['tsb']['data'])) {
            throw new Exception('Данные по курсам валют банка отсутствуют');
        }
        $data = $json['tsb']['data'];
        //debugg($data);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/getResult_getCourseTSB_data.json', json_encode($data));
        $office_id = \GarbageStorage::get('OfficeId'); // !!!
        //debugg('$office_id');
        //debugg($office_id);
        //$office_id = 407;   // центральный офис

        if (!empty($office_id)) {
            //debugg('$office_id');
            //debugg($office_id);
            $result = $this->getCourseByOffice($office_id, $data);
        } else {
            session_start();
            if (isset($_SESSION['city'])) {
                $selectCity = $_SESSION['city'];
            } else {
                $selectCity = 414; // центральный город  ???
            }

            $result = $this->getCourseByCity($selectCity, $json);
        }
        //debugg('$result');debugg($office_id);debugg($result);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/getResult_getCourseTSB.json', json_encode($result));

        return $result;
    }

    /**
     * Получаем курсы валют банка конкретного офиса
     *
     * @param int $office_id ID офиса банка
     * @param array $data Данные курсов валют
     *
     * @return array Возвращает курсы валют по текущему офису
     * @throws Exception
     */
    private function getCourseByOffice($office_id, array $data)
    {
        //debugg('getCourseByOffice');
        //debugg($office_id);
        $rsOffices = CIBlockElement::GetList(
            array("SORT" => "ASC"),
            array("IBLOCK_ID" => 16, "ID" => $office_id),  // Курс валют банка по офисам
            //array("IBLOCK_ID" => 13),
            false,
            false,
            array("IBLOCK_ID", "ID", "PROPERTY_ATT_CODE")
            //array()
        );
        while ($arOffice = $rsOffices->Fetch()) {
            //debugg('$arOffice');
            //debugg($arOffice);
            if (!empty($arOffice['PROPERTY_ATT_CODE_VALUE'])) {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/getResult_getCourseByOffice.json', json_encode($data[$arOffice['PROPERTY_ATT_CODE_VALUE']]['currency']));
                return $data[$arOffice['PROPERTY_ATT_CODE_VALUE']]['currency'];
            }
        }
        throw new Exception('Не удалось получить данные курсов валют по офису');
    }

    /**
     * Получаем курсы валют банка конкретного города
     *
     * @param int $city ID города
     * @param array $json Данные курсов валют
     *
     * @return array Возвращает курсы валют по текущему городу
     * @throws Exception
     */
    private function getCourseByCity($city, array $json)
    {
        $cities = CIBlockElement::GetList(
            array("SORT" => "ASC"),
            //array("IBLOCK_ID" => "14", "ID" => $city, 'ACTIVE' => 'Y'),
            array("IBLOCK_ID" => "17", "ID" => $city, 'ACTIVE' => 'Y'),
            false,
            false,
            array("IBLOCK_ID", "ID", "NAME", "PROPERTY_ATT_CODE")
        );

        while ($city = $cities->Fetch()) {
            //debugg('$city');
            //debugg($city);
            if (!empty($city['PROPERTY_ATT_CODE_VALUE'])) {
                return $this->minimumCourse($city, $json);
            }
        }

        throw new Exception('Не удалось получить данные курсов валют по городу');
    }

    /**
     * Формирование минимальных курсов валют для выбранного города
     *
     * @param array $city Данные по городу и офисам
     * @param array $json Массив с данными по курсам валют
     *
     * @return array Возвращает минимальные курсы валют под текущий город
     */
    private function minimumCourse(array $city, array $json)
    {
        $courses = [];

        //debugg('minimumCourse');
        /*foreach ($city['PROPERTY_ATT_CODE_VALUE'] as $code) {
            debugg($code);
            if (empty($json['tsb']['data'][$code])
                || ($city['ID'] == 101 && $code != 10013)
            ) {
                continue;
            }

            $course_code = $json['tsb']['data'][$code]['currency'];

            foreach ($course_code as $key => $course) {
                if (empty($courses[$key]) || $courses[$key]['buy'] > $course['buy']) {
                    $courses[$key]['buy'] = $course['buy'];
                    $courses[$key]['sell'] = $course['sell'];
                    $courses[$key]['status'] = $course['status'];
                }
            }
        }*/
        $city_code = $city['PROPERTY_ATT_CODE_VALUE'];
        if (!empty($json['tsb']['data'][$city_code])) {
            foreach($json['tsb']['data'][$city_code]['currency'] as $key=>$currency) {
                $courses[$key] = $currency;
            }
        }
        //debugg($course);

        return $courses;
    }

    /**
     * Получаем курсы валют ЦБ РФ для вывода на сайт
     *
     * @param array $json Массив с курсами валют
     *
     * @return array Возвращает массив курсов валют ЦБ РФ
     * @throws Exception
     */
    private function getCourseCBR(array $json)
    {
        if (empty($json['cbr']['data'])) {
            throw new Exception('Данные по курсам валют ЦБ РФ отсутствуют');
        }
        //debugg('getCourseCBR');
        //debugg($json['cbr']['data']);
        return $json['cbr']['data'];
    }

    /**
     * Устанавливаем курсы валют в csv-файле
     */
    public function setCourses()
    {
        try {
            $json = $this->checkCurrencyJson();  // проверяем существование json-файла и его валидность
            $fpc = file_put_contents(self::$test_path, json_encode($json));
            //debugg('setCourses');
            //debugg($json);

            try {
                $cbr = $this->getCourseCBR($json);
            } catch (Exception $e) {
                $cbr = array();
                $this->logger('error', $e->getMessage());
            }

            $cities = $this->getCity();
            //debugg($cities);
            //debugg($cbr);
            $tsb_courses = array();
            $csv_string = '';
            $date = date('d.m.Y H:i');
            foreach ($cities as $city) {
                $symbol = $city['PROPERTY_ATT_CODE_VALUE'];
                $tsb_courses['time'] = time();
                $tsb_courses['data'][$symbol]['code'] = $city['PROPERTY_ATT_CODE_VALUE'];
                $tsb_courses['data'][$symbol]['name'] = $city['NAME'];
                $tsb_courses['data'][$symbol]['date'] = date('d.m.Y H:i');

                foreach ($cbr as $key => $course) {
                    $csv_string .= $city['PROPERTY_ATT_CODE_VALUE'] . ';' . $city['NAME'] . ';' . $date . ';' . $key . ';' . ($course['course']-.01) . ';' . ($course['course']+.01) . PHP_EOL;
                }
            }
            //debugg($tsb_courses);
            //debugg($csv_string);

            file_put_contents(self::$bank_path, $csv_string);
/*
            // если время последнего обновления курсов банка < времени обновления файла с актуальными курсами, то обновляем курсы в json
            debugg($json['cbr']['time']);
            debugg(filectime(self::$bank_path));
            if ($json['tsb']['time'] < filectime(self::$bank_path)) {
                $tsb_courses = $this->parseCoursesTSB();

                if (!empty($tsb_courses)) {
                    $json = $this->updateCoursesTSB($tsb_courses, $json);
                    $update = true;
                }
            }

            // если курсы валют ЦБ сегодня ещё не обновлялись, то обновляем
            //debugg($json['cbr']['time']);
            //debugg(mktime(0, 0, 0, date('m'), date('d'), date('Y')));
            if ($json['cbr']['time'] < mktime(0, 0, 0, date('m'), date('d'), date('Y'))) {
                $cbr_courses = $this->parseCoursesCBR();
                //debugg('$cbr_courses');debugg($json);//debugg($cbr_courses);
                if (!empty($cbr_courses)) {
                    $json = $this->updateCoursesCBR($cbr_courses, $json);
                    $update = true;

                    $this->addCourseForDynamic($json['cbr']['data']);
                }
            }

            // если обновлились данные по курсам банка или ЦБ, то записываем всё в json-файл
            if (!empty($update)) {
                file_put_contents(self::$json_path, json_encode($json));

                // если запись в json-файл не произошла, заносим в логи ошибку
                if (filectime(self::$json_path) < time() - 120) {
                    $this->logger('error', 'При обновлении json-файла возникла ошибка');
                } else {
                    $this->logger('notice', 'Json-файл успешно обновлен');

                    // обновляем html-файл для банки.ру
                    $this->createHtml($json);
                    $this->add_history_rate($json);
                }
            }

            //$fpc = file_put_contents(self::$test_path, json_encode($json));
            //debugg('$fpc');
            //debugg($fpc);
            //debugg(self::$test_path);
*/
        } catch (Exception $e) {
            $this->logger('error', $e->getMessage());
        }
    }

    /**
     * Добавляем курсы валют ЦБ РФ для динамического графика
     *
     * @param array $data Данные по курсам валют ЦБ РФ
     */
    private function addCourseForDynamic(array $data) // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    {
        debugg('addCourseForDynamic');
        /*
        $el = new CIBlockElement;
        $props = [];

        foreach ($data as $key => $course) {
            $props['ATT_' . $key] = $course['course'];
        }

        $el->Add(array(
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $this->arParams['CBR_IBLOCK_ID'],
            "PROPERTY_VALUES" => $props,
            "NAME" => date("Y-m-d", time()),
            "ACTIVE" => "Y",
            "PREVIEW_TEXT" => "",
            "DETAIL_TEXT" => ""
        ));
        */
    }

    /**
     * Логирование ошибок, предупреждений, действий
     *
     * @param string $type Тип лог-данных
     * @param string $message Сообщение для записи в логи
     */
    private function logger($type, $message)
    {
        file_put_contents(
            $_SERVER['DOCUMENT_ROOT'] . $this->GetPath() . '/log/' . $type . '.log',
            '[' . date('d.m.Y H:i:s') . ']' . $message . PHP_EOL,
            FILE_APPEND
        );
    }

    /**
     * История курсов валюты
     * @param $json
     */
    private function add_history_rate($json) // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    {
        debugg('add_history_rate');
        $settings = ['10013' => ['USD', 'EUR']];
        $path = $_SERVER['DOCUMENT_ROOT'] . '/currency/history/';
        $filename = date('dmY') . '_rate.json';
        $content = file_exists($path . $filename)
            ? json_decode(file_get_contents($path . $filename), true)
            : [];

        foreach ($settings as $key => $value) {
            if (!$office = $json['tsb']['data'][$key]) {
                continue;
            }

            foreach ($value as $currency) {
                if (!$office['currency'][$currency]) {
                    continue;
                }

                $update = true;
                $output_currency = $content[$key][$currency] ? $content[$key][$currency] : [];

                if (isset($content[$key][$currency]) && count($content[$key][$currency]) > 0) {
                    $last_history_item = end($content[$key][$currency]);
                    $update = $last_history_item['buy'] != $office['currency'][$currency]['buy']
                        || $last_history_item['sell'] != $office['currency'][$currency]['sell'];
                }

                if ($update) {
                    $output_currency[] = [
                        'date' => date('d.m.Y H:i:s'),
                        'buy' => $office['currency'][$currency]['buy'],
                        'sell' => $office['currency'][$currency]['sell']
                    ];
                }

                $content[$key][$currency] = $output_currency;
            }
        }

        /*file_put_contents(
            $path . $filename,
            json_encode($content)
        );*/
    }

    /**
     * Шаблонные данные по курсам валют
     * @return array
     */
    private static function templateCourses()
    {
        $courses = [];

        $courses['USD']['name'] = 'Доллар США';
        $courses['USD']['symbol'] = '$';
        $courses['USD']['count'] = 1;
        $courses['USD']['iso_n'] = 840;
        $courses['USD']['iso_s'] = 'USD';

        $courses['EUR']['name'] = 'Евро';
        $courses['EUR']['symbol'] = '€';
        $courses['EUR']['count'] = 1;
        $courses['EUR']['iso_n'] = 978;
        $courses['EUR']['iso_s'] = 'EUR';

        $courses['AUD']['name'] = 'Австралийский доллар';
        $courses['AUD']['symbol'] = '$';
        $courses['AUD']['count'] = 1;
        $courses['AUD']['iso_n'] = '036';
        $courses['AUD']['iso_s'] = 'AUD';

        $courses['AZN']['name'] = 'Азербайджанский манат';
        $courses['AZN']['symbol'] = '₼';
        $courses['AZN']['count'] = 1;
        $courses['AZN']['iso_n'] = 944;
        $courses['AZN']['iso_s'] = 'AZN';

        $courses['BGN']['name'] = 'Болгарский лев';
        $courses['BGN']['symbol'] = 'лв';
        $courses['BGN']['count'] = 1;
        $courses['BGN']['iso_n'] = 975;
        $courses['BGN']['iso_s'] = 'BGN';

        $courses['BYN']['name'] = 'Белорусский рубль';
        $courses['BYN']['symbol'] = 'Br';
        $courses['BYN']['count'] = 1;
        $courses['BYN']['iso_n'] = 933;
        $courses['BYN']['iso_s'] = 'BYN';

        $courses['CAD']['name'] = 'Канадский доллар';
        $courses['CAD']['symbol'] = 'C$';
        $courses['CAD']['count'] = 1;
        $courses['CAD']['iso_n'] = 124;
        $courses['CAD']['iso_s'] = 'CAD';

        $courses['CHF']['name'] = 'Швейцарский франк';
        $courses['CHF']['symbol'] = '₣';
        $courses['CHF']['count'] = 1;
        $courses['CHF']['iso_n'] = 756;
        $courses['CHF']['iso_s'] = 'CHF';

        $courses['CNY']['name'] = 'Китайский юань';
        $courses['CNY']['symbol'] = '¥';
        $courses['CNY']['count'] = 10;
        $courses['CNY']['iso_n'] = 156;
        $courses['CNY']['iso_s'] = 'CNY';

        $courses['CZK']['name'] = 'Чешская крона';
        $courses['CZK']['symbol'] = 'Kč';
        $courses['CZK']['count'] = 10;
        $courses['CZK']['iso_n'] = 203;
        $courses['CZK']['iso_s'] = 'CZK';

        $courses['GBP']['name'] = 'Фунт стерлингов Соединенного королевства';
        $courses['GBP']['symbol'] = '£';
        $courses['GBP']['count'] = 1;
        $courses['GBP']['iso_n'] = 826;
        $courses['GBP']['iso_s'] = 'GBP';

        $courses['HUF']['name'] = 'Венгерский форинт';
        $courses['HUF']['symbol'] = 'F';
        $courses['HUF']['count'] = 100;
        $courses['HUF']['iso_n'] = 348;
        $courses['HUF']['iso_s'] = 'HUF';

        $courses['INR']['name'] = 'Индийская рупия';
        $courses['INR']['symbol'] = 'Rs';
        $courses['INR']['count'] = 100;
        $courses['INR']['iso_n'] = 356;
        $courses['INR']['iso_s'] = 'INR';

        $courses['JPY']['name'] = 'Японская иена';
        $courses['JPY']['symbol'] = '¥';
        $courses['JPY']['count'] = 100;
        $courses['JPY']['iso_n'] = 392;
        $courses['JPY']['iso_s'] = 'JPY';

        $courses['KGS']['name'] = 'Киргизский сом';
        $courses['KGS']['symbol'] = 'с';
        $courses['KGS']['count'] = 100;
        $courses['KGS']['iso_n'] = 417;
        $courses['KGS']['iso_s'] = 'KGS';

        $courses['KZT']['name'] = 'Казахстанский тенге';
        $courses['KZT']['symbol'] = '₸';
        $courses['KZT']['count'] = 1;
        $courses['KZT']['iso_n'] = 398;
        $courses['KZT']['iso_s'] = 'KZT';

        $courses['PLN']['name'] = 'Польский злотый';
        $courses['PLN']['symbol'] = 'zł';
        $courses['PLN']['count'] = 1;
        $courses['PLN']['iso_n'] = 985;
        $courses['PLN']['iso_s'] = 'PLN';

        $courses['SGD']['name'] = 'Сингапурский доллар';
        $courses['SGD']['symbol'] = '$';
        $courses['SGD']['count'] = 1;
        $courses['SGD']['iso_n'] = 702;
        $courses['SGD']['iso_s'] = 'SGD';

        $courses['TRY']['name'] = 'Турецкая лира';
        $courses['TRY']['symbol'] = '₺';
        $courses['TRY']['count'] = 10;
        $courses['TRY']['iso_n'] = 949;
        $courses['TRY']['iso_s'] = 'TRY';

        $courses['ZAR']['name'] = 'Южноафриканский рэнд';
        $courses['ZAR']['symbol'] = 'R';
        $courses['ZAR']['count'] = 10;
        $courses['ZAR']['iso_n'] = 710;
        $courses['ZAR']['iso_s'] = 'ZAR';

        return $courses;
    }
}
