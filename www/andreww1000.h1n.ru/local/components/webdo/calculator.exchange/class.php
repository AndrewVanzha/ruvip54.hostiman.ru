<?php
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true ) die();
use \Bitrix\Main;
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;


class CalculatorExchange extends CBitrixComponent
{
    public $MessageError = array();
    public $MessageSend = array();


    #Перезаписываем $this->arParams (Удаляем не нужное)
    public function onPrepareComponentParams($params)
    {
        $result = array(
            "CACHE_TIME"                => $params['CACHE_TIME'],
            "OFFICE_IBLOCK_ID"          => $params['OFFICE_IBLOCK_ID']
        );
        return $result;
    }

    #Проверяет подключение необходиимых модулей
    protected function checkModules()
    {
        if (!Loader::includeModule('iblock')){
            throw new Main\LoaderException('Ошибка модуля iblock');
        }
    }

    protected function load_kurs_csv()
    {
        $json = file_get_contents($_SERVER['DOCUMENT_ROOT']."/dopX/currency/currency.json");
        $json = json_decode($json, true);

        //$request = Application::getInstance()->getContext()->getRequest();
        $officeId = $_GET["office"];

        if(!empty($officeId)){
            \GarbageStorage::set('OfficeId', $officeId);
            $office = \GarbageStorage::get('OfficeId');
        } else {
            $office = \GarbageStorage::get('OfficeId');
        }
        debugg('officeId=');
        debugg($officeId);
        //debugg($this->arParams['OFFICE_IBLOCK_ID']); // 16

        $rsOffices = CIBlockElement::GetList(
            Array("SORT"=>"ASC"),
            Array("IBLOCK_ID"=>$this->arParams['OFFICE_IBLOCK_ID'], "ID"=>$office, "ACTIVE"=>"Y"),
            false,
            false,
            Array("IBLOCK_ID", "ID", "EN_NAME", "NAME", "PROPERTY_ATT_CODE", "PROPERTY_ATT_ADDRESS", "PROPERTY_ATT_PHONE")
        );
        while($arOffice = $rsOffices->Fetch()){
            $res = $json['tsb']['data'][$arOffice['PROPERTY_ATT_CODE_VALUE']]['currency'];

            $res['name'] = $arOffice['NAME'];
            $res['address'] = $arOffice['PROPERTY_ATT_ADDRESS_VALUE'];
            $res['phone'] = $arOffice['PROPERTY_ATT_PHONE_VALUE'];
            $res['en_name'] = $arOffice['PROPERTY_EN_OFFICE_NAME_VALUE'];

            return $res;
        }

    }


    protected function getOffice()
    {
        session_start();
        if (isset($_SESSION['city'])) {
            $selectCity = $_SESSION['city'];
        } else {
            $selectCity = 414; // Банк в городах 17 - Москва
        }
        //debugg('$selectCity=');
        //debugg($selectCity);
        //debugg($this->arParams['OFFICE_IBLOCK_ID']); // 16

        $OfficeCodes = [];
        $arOffice = array();
        $rsElements = CIBlockElement::GetList(
            Array("SORT"=>"ASC"),
            Array("IBLOCK_ID"=> "17"/*$this->arParams['IBLOCK_ID']*/, "ID"=>$selectCity),  // Банк в городах
            false,
            false,
            Array("IBLOCK_ID", "ID", "NAME", "PROPERTY_ATT_CODE", "PROPERTY_ATT_WHERE")
        );

        while($arElement = $rsElements->Fetch()) {
            //debugg($arElement);
            $rsOffices = CIBlockElement::GetList(
                Array("SORT"=>"ASC"),
                Array("IBLOCK_ID"=>$this->arParams['OFFICE_IBLOCK_ID'], "PROPERTY_ATT_CODE"=>$arElement['PROPERTY_ATT_CODE_VALUE'], "ACTIVE"=>"Y"),
                false,
                false,
                //Array()
                Array("IBLOCK_ID","ID", "NAME", "PROPERTY_ATT_ADDRESS", "PROPERTY_ATT_ADDRESS_CITY", "PROPERTY_ATT_YANDEX_LOCATION", "PROPERTY_ATT_YANDEX_POS", "PROPERTY_ATT_2GIS_LOCATION", "PROPERTY_ATT_OFFICE_HOURS", "PROPERTY_ATT_PHONE", "PROPERTY_ATT_PHONE_LINK", "PROPERTY_ATT_EMAIL")
            );
            while($arOffices = $rsOffices->Fetch()){
                $arOffice[] = $arOffices;
                $OfficeCodes[] = $arElement['PROPERTY_ATT_CODE_VALUE'];
            }
            //debugg('$arOffice=');
            //debugg($arOffice);
            //debugg($OfficeCodes);
            /*
            foreach ($arElement["PROPERTY_ATT_CODE_VALUE"] as $code) {   // так было в оригинале
                $OfficeCodes[] = $code;
                $rsOffices = CIBlockElement::GetList(
                    Array("SORT"=>"ASC"),
                    Array("IBLOCK_ID"=>$this->arParams['OFFICE_IBLOCK_ID'], "PROPERTY_ATT_CODE"=>$code, "ACTIVE"=>"Y"),
                    false,
                    false,
                    Array()
                    //Array("IBLOCK_ID","ID", "NAME", "PROPERTY_ATT_ADDRESS", "PROPERTY_ATT_YANDEX_LOCATION", "PROPERTY_ATT_YANDEX_POS", "PROPERTY_ATT_2GIS_LOCATION")
                );
                while($arOffices = $rsOffices->Fetch()){
                    $arOffice[] = $arOffices;
                }
            }
            */
        }

        /*
        $rsOnlineOffice = CIBlockElement::GetList(   // так было в оригинале
            Array("SORT"=>"ASC"),
            Array("IBLOCK_ID"=>$this->arParams['OFFICE_IBLOCK_ID'], "PROPERTY_ATT_CODE"=>407, "ACTIVE"=>"Y"), // Курс валют банка по офисам - Центральный Офис / iSimple
            false,
            false,
            Array("IBLOCK_ID","ID", "NAME", "PROPERTY_ATT_CODE", "PROPERTY_ATT_YANDEX_LOCATION", "PROPERTY_ATT_YANDEX_POS", "PROPERTY_ATT_2GIS_LOCATION")
        );
        while($onlineOffice = $rsOnlineOffice->Fetch()){
            $arOffice[] = $onlineOffice;
        }
        */
        for($ii=0; $ii<count($arOffice); $ii++) {
            $arOffice[$ii]['PROPERTY_ATT_CODE'] = $OfficeCodes[$ii];
        }
        //debugg('$arOffice=');
        //debugg($arOffice);
        //debugg($OfficeCodes);

        //Передаем значение дефолтного офиса
        \GarbageStorage::set('OfficeId', $arOffice['0']['ID']);  // = 407
        \GarbageStorage::set('OfficeCode', $OfficeCodes[0]);     // = 10013
        return $arOffice;
    }


    protected function getResult()
    {
        $this->arResult['OFFICE'] = $this->getOffice();
        $csv = $this->load_kurs_csv();
        //debugg($csv);
        $this->arResult['NAME_OFFICE'] = $csv['name'];
        $this->arResult['ADDRESS_OFFICE'] = $csv['address'];
        $this->arResult['PHONE_OFFICE'] = $csv['phone'];
        $this->arResult['CUR']['USD'] = array("NAME"=>'USD', "BUY"=>$csv['USD']['buy'], "SELL"=>$csv['USD']['sell'], "DATE"=>$csv['USD']['date'], "LONGNAME"=>'Доллар США');
        $this->arResult['CUR']['EUR'] = array("NAME"=>'EUR', "BUY"=>$csv['EUR']['buy'], "SELL"=>$csv['EUR']['sell'], "DATE"=>$csv['EUR']['date'], "LONGNAME"=>'Евро');
        $this->arResult['CUR']['GBP'] = array("NAME"=>'GBP', "BUY"=>$csv['GBP']['buy'], "SELL"=>$csv['GBP']['sell'], "DATE"=>$csv['GBP']['date'], "LONGNAME"=>'Фунт стерлингов');
        $this->arResult['CUR']['CHF'] = array("NAME"=>'CHF', "BUY"=>$csv['CHF']['buy'], "SELL"=>$csv['CHF']['sell'], "DATE"=>$csv['CHF']['date'], "LONGNAME"=>'Швейцарский франк');
        $this->arResult['CUR']['JPY'] = array("NAME"=>'JPY', "BUY"=>$csv['JPY']['buy'], "SELL"=>$csv['JPY']['sell'], "DATE"=>$csv['JPY']['date'], "LONGNAME"=>'Японская иена');
        $this->arResult['CUR']['CNY'] = array("NAME"=>'CNY', "BUY"=>$csv['CNY']['buy'], "SELL"=>$csv['CNY']['sell'], "DATE"=>$csv['CNY']['date'], "LONGNAME"=>'Китайский юань');
        $this->arResult['CUR']['PLN'] = array("NAME"=>'PLN', "BUY"=>$csv['PLN']['buy'], "SELL"=>$csv['PLN']['sell'], "DATE"=>$csv['PLN']['date'], "LONGNAME"=>'Польский злотый');

        $this->arResult['CUR']['AUD'] = array("NAME"=>'AUD', "BUY"=>$csv['AUD']['buy'], "SELL"=>$csv['AUD']['sell'], "DATE"=>$csv['AUD']['date'], "LONGNAME"=>'Австралийский доллар');
        $this->arResult['CUR']['AZN'] = array("NAME"=>'AZN', "BUY"=>$csv['AZN']['buy'], "SELL"=>$csv['AZN']['sell'], "DATE"=>$csv['AZN']['date'], "LONGNAME"=>'Азербайджанский манат');
        //$this->arResult['CUR']['AMD'] = array("NAME"=>'AMD', "BUY"=>$csv['AMD']['buy'], "SELL"=>$csv['AMD']['sell'], "DATE"=>$csv['AMD']['date'], "LONGNAME"=>'Армянский драм');
        $this->arResult['CUR']['BYN'] = array("NAME"=>'BYN', "BUY"=>$csv['BYN']['buy'], "SELL"=>$csv['BYN']['sell'], "DATE"=>$csv['BYN']['date'], "LONGNAME"=>'Белорусский рубль');
        $this->arResult['CUR']['BGN'] = array("NAME"=>'BGN', "BUY"=>$csv['BGN']['buy'], "SELL"=>$csv['BGN']['sell'], "DATE"=>$csv['BGN']['date'], "LONGNAME"=>'Болгарский лев');
        $this->arResult['CUR']['HUF'] = array("NAME"=>'HUF', "BUY"=>$csv['HUF']['buy'], "SELL"=>$csv['HUF']['sell'], "DATE"=>$csv['HUF']['date'], "LONGNAME"=>'Венгерский форинт');
        //$this->arResult['CUR']['HKD'] = array("NAME"=>'HKD', "BUY"=>$csv['HKD']['buy'], "SELL"=>$csv['HKD']['sell'], "DATE"=>$csv['HKD']['date'], "LONGNAME"=>'Гонконгский доллар');
        //$this->arResult['CUR']['DKK'] = array("NAME"=>'DKK', "BUY"=>$csv['DKK']['buy'], "SELL"=>$csv['DKK']['sell'], "DATE"=>$csv['DKK']['date'], "LONGNAME"=>'Датская крона');
        $this->arResult['CUR']['INR'] = array("NAME"=>'INR', "BUY"=>$csv['INR']['buy'], "SELL"=>$csv['INR']['sell'], "DATE"=>$csv['INR']['date'], "LONGNAME"=>'Индийская рупия');
        $this->arResult['CUR']['KZT'] = array("NAME"=>'KZT', "BUY"=>$csv['KZT']['buy'], "SELL"=>$csv['KZT']['sell'], "DATE"=>$csv['KZT']['date'], "LONGNAME"=>'Казахстанский тенге');
        $this->arResult['CUR']['CAD'] = array("NAME"=>'CAD', "BUY"=>$csv['CAD']['buy'], "SELL"=>$csv['CAD']['sell'], "DATE"=>$csv['CAD']['date'], "LONGNAME"=>'Канадский доллар');
        $this->arResult['CUR']['KGS'] = array("NAME"=>'KGS', "BUY"=>$csv['KGS']['buy'], "SELL"=>$csv['KGS']['sell'], "DATE"=>$csv['KGS']['date'], "LONGNAME"=>'Киргизский сом');
        //$this->arResult['CUR']['MDL'] = array("NAME"=>'MDL', "BUY"=>$csv['MDL']['buy'], "SELL"=>$csv['MDL']['sell'], "DATE"=>$csv['MDL']['date'], "LONGNAME"=>'Молдавский лей');
        $this->arResult['CUR']['SGD'] = array("NAME"=>'SGD', "BUY"=>$csv['SGD']['buy'], "SELL"=>$csv['SGD']['sell'], "DATE"=>$csv['SGD']['date'], "LONGNAME"=>'Сингапурский доллар');
        //$this->arResult['CUR']['TJS'] = array("NAME"=>'TJS', "BUY"=>$csv['TJS']['buy'], "SELL"=>$csv['TJS']['sell'], "DATE"=>$csv['TJS']['date'], "LONGNAME"=>'Таджикский сомони');
        $this->arResult['CUR']['TRY'] = array("NAME"=>'TRY', "BUY"=>$csv['TRY']['buy'], "SELL"=>$csv['TRY']['sell'], "DATE"=>$csv['TRY']['date'], "LONGNAME"=>'Турецкая лира');
        $this->arResult['CUR']['CZK'] = array("NAME"=>'CZK', "BUY"=>$csv['CZK']['buy'], "SELL"=>$csv['CZK']['sell'], "DATE"=>$csv['CZK']['date'], "LONGNAME"=>'Чешская крона');
        $this->arResult['CUR']['ZAR'] = array("NAME"=>'ZAR', "BUY"=>$csv['ZAR']['buy'], "SELL"=>$csv['ZAR']['sell'], "DATE"=>$csv['ZAR']['date'], "LONGNAME"=>'Южноафриканский рэнд');
        //$this->arResult['CUR']['KRW'] = array("NAME"=>'KRW', "BUY"=>$csv['KRW']['buy'], "SELL"=>$csv['KRW']['sell'], "DATE"=>$csv['KRW']['date'], "LONGNAME"=>'Южнокорейская вона');

    }

    protected function actionMessage()
    {
        $this->arResult["MESSAGE_ERROR"] = $this->MessageError;
        $this->arResult["MESSAGE_SEND"] = $this->MessageSend;
        foreach($this->arResult['MESSAGE_ERROR'] as $error){
            echo "<p style='color: red;'>{$error}</p>";
        }
        foreach($this->arResult['MESSAGE_SEND'] as $send){
            echo "<p style='color: green;'>{$send}</p>";
        }
    }

    public function executeComponent()
    {
        try{
            // if ($this->startResultCache()) {
            $this -> arResult["COMPONENT_ID"] = 'CE';
            $this -> checkModules();
            $this -> getResult();
            $this -> actionMessage();

            $this -> includeComponentTemplate();
            // }
        }catch (Exception $e){
            ShowError($e->getMessage());
        }
    }
}
