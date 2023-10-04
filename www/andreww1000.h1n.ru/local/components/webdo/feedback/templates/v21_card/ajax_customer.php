<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;

// http://andreww1000.h1n.ru/local/components/webdo/feedback/templates/v21_card/ajax.customer.php

CModule::IncludeModule('iblock');

function sanitizePost(array $data): array
{
    if (!isset($data['DELIVERYCARD'])) {
        $data['DELIVERYCARD'] = 'Нет';
    } else {
        $data['DELIVERYCARD'] = 'Да';
    }
    if (!isset($data['CITYZENSHIP'])) {
        $data['CITYZENSHIP'] = 'Нет';
    } else {
        $data['CITYZENSHIP'] = 'Да';
    }
    if (!empty($data['PASS_ADDR_S'])) {
        $data['PASS_ADDR_F'] = $data['PASS_ADDR_R'];
    }
    if (!empty($data['TYPE_INOY'])) {
        $data['TYPE_PASS'] = $data['TYPE_INOY'];
    }
    if (!empty($data['FIRST_NAME'])) {
        $data['NAME'] = $data['LAST_NAME'] . ' ' . $data['FIRST_NAME'] . ' ' . $data['SECOND_NAME'];
    }
    return $data;
}

function getSex(array $data): array
{
    if ($data['SEX'] === 'Мужской') {
        $data['RECOURSE'] = 'Уважаемый';
    } else {
        $data['RECOURSE'] = 'Уважаемая';
    }
    return $data;
}

function finish(array $result): void
{
    echo json_encode($result);
    exit;
}

$arResult = [];
$arResult["status"] = true;
$arResult["captcha"] = true;
$fields = [];
//echo '<pre>';print_r('$_POST=');print_r($_POST);echo '</pre>';

if ($_POST["fields"]) {
    parse_str($_POST['fields'], $fields);
    //echo '<pre>';print_r($fields);echo '</pre>';
}

if (count($fields)  < 1) {
    $arResult["status"] = false;
    $arResult["message"][] = [
        "text" => "Данные отсутсвуют. Повторите еще раз.",
        "type" => false, //false - сообщение об ошибке
    ];

    finish($arResult);
}
//echo '<pre>';print_r('$fields=');print_r($fields);echo '</pre>';

if (!$APPLICATION->CaptchaCheckCode($fields["CAPTCHA_WORD"], $fields["CAPTCHA_ID"])) {
    $arResult["status"] = false;
    $arResult["captcha"] = false;

    finish($arResult);
}

$fields = sanitizePost($fields);
/*
    [FORM_ID] => 
    [SESSION_ID] => 191f33072cf6457e0cf53f5b8b606a16
    [CARD_TYPE] => 
    [CARD_NAME] => 
    [PARAMS] => {"IBLOCK_ID":"19","PROPERTIES":["BIRTHDATE","SEX","PHONE","EMAIL","CITY","CITYZENSHIP","TYPE","TRANSLIT","CARD_SUMM","CARD_CURRENCY","DELIVERYCARD","TYPE_PASS","TYPE_INOY","PASS_SERIYA","PASS_NUMBER","PASS_KEM","PASS_DATA","PASS_COD","PASS_MESTO","PASS_ADDR_R","PASS_ADDR_F","PASS_ADDR_S"],"ADMIN_EVENT":"WEBDO_FEEDBACK_CARD_ADMIN","USER_EVENT":"WEBDO_FEEDBACK_CARD_USER","SITES":["s1"]}
    [email2] => 
    [TYPE] => Дебетовая карта MasterCard Platinum PayPass
    [PHONE] => +79867422614
    [EMAIL_TO] => av199903@mail.ru
    [CITY] => Нижний Новгород
    [LAST_NAME] => Test
    [FIRST_NAME] => test
    [SECOND_NAME] => 
    [TRANSLIT] => 
    [TYPE_PASS] => Паспорт гражданина РФ
    [SEX] => Мужской
    [PASS_SERIYA] => 11122233333333
    [PASS_NUMBER] => 121212
    [PASS_DATA] => 11111111
    [PASS_KEM] => ovd
    [PASS_COD] => 23455
    [PASS_MESTO] => 
    [BIRTHDATE] => 
    [PASS_ADDR_R] => 
    [PASS_ADDR_F] => 
    [CAPTCHA_ID] => 05c5ff9241bcd9970222ff838d6b4206
    [CAPTCHA_WORD] => DQ7M3
    [politics] => on
    [DELIVERYCARD] => Нет
    [CITYZENSHIP] => Нет
    [NAME] => Test test 
*/
$arParams = json_decode($fields["PARAMS"]);
//print_r($arParams->ADMIN_EVENT);
//echo '<pre>';print_r('$fields=');print_r($fields);echo '</pre>';
//echo '<pre>';print_r('$arParams=');print_r($arParams);echo '</pre>';

if ($fields["email2"]) {
    $arResult["status"] = false;
    $arResult["message"][] = [
        "text" => "Извините, но что-то пошло не так.",
        "type" => false,
    ];
    finish($arResult);
}

$element = new CIBlockElement;

$properties = [];
$propertiesPost = [];

$propertiesPre = CIBlockProperty::GetList(
    [],
    ["IBLOCK_ID" => $arParams->IBLOCK_ID]
);
$propertiesList = [];

while ($property = $propertiesPre->Fetch()) {
    $propertiesList[$property['CODE']] = $property['ID'];
}

unset($property);

foreach ($arParams->PROPERTIES as $property) {
    if (isset($fields[$property])) {
        $properties[$propertiesList[$property]] = $fields[$property];
        $propertiesPost[$property] = $fields[$property];
    }
}
//file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/ajax_customer_properties.json', json_encode($properties));
file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/ajax_customer_params.txt', $arParams->PROPERTIES);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/ajax_customer_properties.txt', $properties);
//file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/ajax_customer_post.json', json_encode($_POST));
file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/ajax_customer_post.txt', $_POST);

$elementFields = array(
    "IBLOCK_SECTION_ID" => false,
    "IBLOCK_ID"         => $arParams->IBLOCK_ID,
    "PROPERTY_VALUES"   => $properties,
    "ACTIVE"            => "Y",
    "DATE_CREATE"       => date('d.m.Y H:i:s', time()),
);

$elementFields['NAME']         = isset($fields['NAME'])         ? $fields['NAME']         : 'Новое обращение';
$elementFields['PREVIEW_TEXT'] = isset($fields['PREVIEW_TEXT']) ? $fields['PREVIEW_TEXT'] : '';
$elementFields['DETAIL_TEXT']  = isset($fields['DETAIL_TEXT'])  ? $fields['DETAIL_TEXT']  : '';
$elementFields['CODE']  = isset($fields['CODE']) ? $fields['CODE']  : "карта";
//$elementFields['CODE']  = isset($fields['CODE']) ? $fields['CODE']  : -1;

$id = $element->Add($elementFields);

//echo '<pre>';print_r($elementFields);echo '</pre>';
//echo '<pre>';print_r('$element=');print_r($element);echo '</pre>';
//echo '<pre>';print_r('$id='.$id);echo '</pre>';

if ($id) {
    $arResult["message"][] = [
        "text" => "Заявка успешно отправлена",
        "type" => true,
    ];

    $postFields = array_merge($fields, $propertiesPost);
    $postFields['APPLICATION_ID'] = $id;
    $postFields['DATE_CREATE'] = $elementFields['DATE_CREATE'];

    $postFields = getSex($postFields);

    //print_r('<pre>');print_r($postFields);print_r('</pre>');
    //print_r('<pre>');print_r($arParams->ADMIN_EVENT);print_r('</pre>');
    //print_r('<pre>');print_r($arParams->SITES);print_r('</pre>');
    if ($arParams->ADMIN_EVENT != 'NONE') {
        //print_r('<pre>');print_r($postFields);print_r('</pre>');
        $qq = CEvent::Send($arParams->ADMIN_EVENT, $arParams->SITES, $postFields);
        //print_r($qq);
    }
    if ($arParams->USER_EVENT != 'NONE') {
        //print_r('<pre>');print_r($postFields);print_r('</pre>');
        $qq = CEvent::Send($arParams->USER_EVENT, $arParams->SITES, $postFields);
        //print_r($qq);
    }

    //$mail="andreww1000@mail.ru"; // ваша почта
    $mail="andreww1762@gmail.com"; // ваша почта
    //$admin_mail="hostiman@andreww1000.h1n.ru";
    $subject ="Test" ; // тема письма
    $text= "Line 1\nLine 2\nLine 3"; // текст письма
    if( mail($mail, $subject, $text) )  {
        //echo 'Успешно отправлено! ';
    }
    else {
        echo 'Отправка не удалась! ';
    }

} else {
    $arResult["status"] = false;
    $arResult["message"][] = [
        "text" => $element->LAST_ERROR,
        "type" => false,
    ];
}

finish($arResult);

// https://thisis-blog.ru/problema-s-otpravkoj-pisem-v-bitriks/
