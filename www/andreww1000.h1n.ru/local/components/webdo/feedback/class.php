<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

IncludeTemplateLangFile(__FILE__);

class WebdoFeedback extends CBitrixComponent
{
    public $errors  = array();
    public $success = array();
    public $post    = array();

    public function executeComponent()
    {
        global $APPLICATION;

        CModule::IncludeModule('iblock');

        $this->arResult['FORM_ID'] = $this->arParams['AJAX_ID']; // AJAX_ID ???
        //debugg("$this->arParams['AJAX_ID']=");
        //debugg($this->arParams['AJAX_ID']);

        if (isset($_POST['WEBDO_FEEDBACK'])) {
            $this->post();
        }
        //debugg($_POST);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/post_feedback_class.json', json_encode($_POST));

        if ($this->arParams["SHOW_DEBETS_CARDS"] === "Y") {
            $arSelect = array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "PREVIEW_PICTURE");
            $arFilter = array("IBLOCK_ID" => "18", "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");    // Карты
            $res = CIBlockElement::GetList(array("SORT" => "ASC", "NAME" => "ASC"), $arFilter, false, false, $arSelect);
            while ($ob = $res->GetNextElement()) {
                $this->arResult['DEBETS_CARDS'][] = $ob->GetFields();
            }
        }

        $this->arResult['ERRORS']  = $this->getErrors();
        $this->arResult['SUCCESS'] = $this->getSuccess();
        $this->arResult['CAPTCHA'] = htmlspecialchars($APPLICATION->CaptchaGetCode());

        $this->includeComponentTemplate();
    }

    public function post()
    {

        global $APPLICATION;

        $post = $this->sanitizePost();

        if ($post['FORM_ID'] !== $this->arResult['FORM_ID']) {
            return false;
        }

        if (!check_bitrix_sessid('SESSION_ID')) {
            return false;
        }

        if (!$APPLICATION->CaptchaCheckCode($post["CAPTCHA_WORD"], $post["CAPTCHA_ID"])) {
            $this->addError(GetMessage("WEBDO_FEEDBACK_WRONG_CAPTCHA"));
            $this->arResult['POST'] = $this->post;

            return false;
        }

        $element = new CIBlockElement;

        $properties = array();
        $propertiesPost = array();

        $propertiesPre = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $this->arParams["IBLOCK_ID"]));
        $propertiesList = array();

        while ($property = $propertiesPre->Fetch()) {
            $propertiesList[$property['CODE']] = $property['ID'];
        }

        unset($property);

        foreach ($this->arParams['PROPERTIES'] as $property) {
            if (isset($post[$property])) {
                $properties[$propertiesList[$property]] = $post[$property];
                $propertiesPost[$property] = $post[$property];
            }
        }

        $fields = array(
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID"         => $this->arParams['IBLOCK_ID'],
            "PROPERTY_VALUES"   => $properties,
            "ACTIVE"            => "Y",
            "DATE_CREATE"       => date('d.m.Y H:i:s', time()),
        );

        $fields['NAME']         = isset($post['NAME'])         ? $post['NAME']         : 'Новое обращение';
        $fields['PREVIEW_TEXT'] = isset($post['PREVIEW_TEXT']) ? $post['PREVIEW_TEXT'] : '';
        $fields['DETAIL_TEXT']  = isset($post['DETAIL_TEXT'])  ? $post['DETAIL_TEXT']  : '';

        if ($id = $element->Add($fields)) {
            $this->addSuccess(GetMessage("WEBDO_FEEDBACK_SUCCESS"));

            $postFields = array_merge($fields, $propertiesPost);
            $postFields['APPLICATION_ID'] = $id;

            if (isset($this->arParams['EVENT_CALLBACK'])) {
                if (is_callable($this->arParams['EVENT_CALLBACK'])) {
                    $postFields = $this->arParams['EVENT_CALLBACK']($postFields);
                }
            }

            $this->arResult['POST'] = $this->post;

            if ($this->arParams['ADMIN_EVENT'] != 'NONE') {
                CEvent::Send($this->arParams['ADMIN_EVENT'], $this->arParams['SITES'], $postFields);
            }

            if ($this->arParams['USER_EVENT'] != 'NONE') {
                CEvent::Send($this->arParams['USER_EVENT'], $this->arParams['SITES'], $postFields);
            }

            return $id;
        } else {
            $this->addError($element->LAST_ERROR);
            $this->arResult['POST'] = $this->post;

            return false;
        }
    }

    public function sanitizePost()
    {
        $post = array();

        foreach ($_POST as $key => $string) {
            $post[$key] = $string;
        }

        if (isset($this->arParams['POST_CALLBACK'])) {
            if (is_callable($this->arParams['POST_CALLBACK'])) {
                $post = $this->arParams['POST_CALLBACK']($post);
            }
        }

        $this->post = $post;

        return $post;
    }

    public function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function addSuccess($success)
    {
        $this->success[] = $success;
    }

    public function getSuccess()
    {
        return $this->success;
    }
}
