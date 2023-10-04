<?php
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true ) die();

use \Bitrix\Main;
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;


class CitySelectForm extends CBitrixComponent
{
    public $MessageError = array();
    public $MessageSend = array();

    #Перезаписываем $this->arParams (Удаляем не нужное)
    public function onPrepareComponentParams($params)
    {
        $result = array(
            "AJAX_MODE"              => $params['AJAX_MODE']              ? $params['AJAX_MODE']              : '',
            "AJAX_OPTION_ADDITIONAL" => $params['AJAX_OPTION_ADDITIONAL'] ? $params['AJAX_OPTION_ADDITIONAL'] : '',
            "AJAX_OPTION_HISTORY"    => $params['AJAX_OPTION_HISTORY']    ? $params['AJAX_OPTION_HISTORY']    : '',
            "AJAX_OPTION_JUMP"       => $params['AJAX_OPTION_JUMP']       ? $params['AJAX_OPTION_JUMP']       : '',
            "AJAX_OPTION_STYLE"      => $params['AJAX_OPTION_STYLE']      ? $params['AJAX_OPTION_STYLE']      : '',
            "CACHE_TIME"             => $params['CACHE_TIME'],

            "IBLOCK_ID"              => $params['IBLOCK_ID'],
            "OFFICE_IBLOCK_ID"       => $params['OFFICE_IBLOCK_ID'],

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

    protected function session()
    {
        $request = Application::getInstance()->getContext()->getRequest(); 
        $selectCity = $request->getPost("select");
        //$selectOffice = $request->getPost("office-id");
        debugg('$selectCity=');
        debugg($selectCity);
        //debugg('$selectOffice=');
        //debugg($selectOffice);

        session_start();

        //$OfficeCodes = [];
        if(!empty($selectCity)) {
            $_SESSION['city'] = $selectCity;

/*
            $rsElements = CIBlockElement::GetList( // getResult()
                Array("SORT"=>"ASC"),
                //Array("IBLOCK_ID"=> $this->arParams['IBLOCK_ID'], "ID"=>$selectCity),
                Array("IBLOCK_ID"=> "17", "ID"=>$selectCity),                           // банк в городах
                false,
                false,
                Array("IBLOCK_ID", "ID", "NAME", "PROPERTY_ATT_CODE", "PROPERTY_ATT_WHERE")
            );
            while($arElement = $rsElements->Fetch()) {
                $arOffice = array();
                //debugg('$arElement=');
                //debugg($arElement);
                foreach ($arElement["PROPERTY_ATT_CODE_VALUE"] as $code) {
                    //debugg($code);
                    $OfficeCodes[] = $code;
                    $rsOffices = CIBlockElement::GetList(
                        Array("SORT"=>"ASC"),
                        Array("IBLOCK_ID"=>$this->arParams['OFFICE_IBLOCK_ID'], "PROPERTY_ATT_CODE"=>$code, "ACTIVE"=>"Y"),
                        false,
                        false,
                        //Array()
                        //Array("IBLOCK_ID","PROPERTY_EN_OFFICE_NAME", "ID", "NAME", "PROPERTY_ATT_ADDRESS", "PROPERTY_ATT_PHONE")
                        Array("IBLOCK_ID","ID", "NAME")
                    );
                    while($arOffices = $rsOffices->Fetch()){
                        //$arOffice[$code] = $arOffices;
                        $arOffice[] = $arOffices;
                        //debugg('getOffice=');
                        //debugg($arOffices);
                    }
                }
            }
            //debugg('$selectCity=');
            //debugg($selectCity);
            //debugg('$arOffice=');
            //debugg($arOffice);
            //debugg('$OfficeCodes=');
            //debugg($OfficeCodes);
            $officeId = $arOffice[0]['ID'];
            //debugg($officeId);
            \GarbageStorage::set('OfficeId', $officeId);
            \GarbageStorage::set('OfficeCodes', $OfficeCodes[0]);
*/

            echo "<script>location.reload();</script>";
        }

        $this->arResult['SELECTED'] = $_SESSION['city'];
    }


    protected function getResult()
    {
        $rsElements = CIBlockElement::GetList(
            Array("SORT"=>"ASC"),
            Array("IBLOCK_ID"=>$this->arParams['IBLOCK_ID']),
            false,
            false,
            //Array("IBLOCK_ID", "ID", "NAME", "ACTIVE", "PROPERTY_ATT_ENGLISH", "PROPERTY_ATT_FORM", "PROPERTY_ATT_CODE", "PROPERTY_ATT_WHERE")
            Array("IBLOCK_ID", "ID", "NAME", "ACTIVE", "PROPERTY_ATT_ENGLISH", "PROPERTY_ATT_FORM", "PROPERTY_ATT_WHERE")
        );
        $arOffice = array();

        while($arElement = $rsElements->Fetch()){
            //debugg('$this->arParams[OFFICE_IBLOCK_ID] ');
            //debugg($this->arParams['OFFICE_IBLOCK_ID']);

            if ($arElement['ACTIVE'] == 'Y') {

                $id = $arElement['ID'];

                $name = $arElement['NAME'];
                $nameWhere = $arElement['PROPERTY_ATT_WHERE_VALUE'] ?? $arElement['NAME'];
                $nameEnglish = $arElement['PROPERTY_ATT_ENGLISH_VALUE'];

                $rsCodes = CIBlockElement::GetList(              // лишние обращения к БД в цикле, можно сделать оптимальнее
                    Array("SORT"=>"ASC"),
                    Array("IBLOCK_ID"=>$this->arParams['IBLOCK_ID'] ),
                    false,
                    false,
                    Array("IBLOCK_ID", "ID", "NAME", "PROPERTY_ATT_CODE")
                );
                while($arCodes = $rsCodes->Fetch()){
                    //debugg('$arCodes');
                    //debugg($arCodes);
                    if($arCodes['ID'] == $id) {
                        $arElement['CODES'][$arCodes['PROPERTY_ATT_CODE_VALUE_ID']] = $arCodes['PROPERTY_ATT_CODE_VALUE'];
                    }
                }

                //debugg('$arElement');
                //debugg($arElement);

                //foreach ($arElement["PROPERTY_ATT_CODE_VALUE"] as $code) {
                foreach ($arElement["CODES"] as $code) {
                    $rsOffices = CIBlockElement::GetList(
                        Array("SORT"=>"ASC"),
                        Array("IBLOCK_ID"=>$this->arParams['OFFICE_IBLOCK_ID'], "PROPERTY_ATT_CODE"=>$code ),
                        false,
                        false,
                        Array("IBLOCK_ID", "ID", "NAME")
                    );
                    while($arOffices = $rsOffices->Fetch()){
                        $arOffice[] = $arOffices;
                    }
                }

                //debugg('$arElement');
                //debugg($arElement);
                //debugg('$arOffice');
                //debugg($arOffice);


                //$arCity[] = array('ID'=>$id, 'NAME'=>$name, 'NAME_ENGLISH'=>$nameEnglish, 'NAME_WHERE'=>$nameWhere, 'FORM' => $arElement['PROPERTY_ATT_FORM_VALUE'], 'CODE' =>$arElement['PROPERTY_ATT_CODE_VALUE'], 'OFFICES' => $arOffice);
                $arCity[$id] = array('ID'=>$id, 'NAME'=>$name, 'NAME_ENGLISH'=>$nameEnglish, 'NAME_WHERE'=>$nameWhere, 'FORM' => $arElement['PROPERTY_ATT_FORM_VALUE'], 'CODE' =>$arElement['CODES'], 'OFFICES' => $arOffice);
                unset($arOffice);
            }
        }
        
        $this->arResult['CITY'] = $arCity;
        //debugg('$arCity');
        //debugg($this->arResult['CITY']);

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
                $this -> arResult["COMPONENT_ID"] = 'CSF';
                $this -> checkModules();
                $this -> session();
                $this -> getResult();
                $this -> actionMessage();


                $this -> includeComponentTemplate();
            // }
		}catch (Exception $e){
			ShowError($e->getMessage());
		}
    }

};
