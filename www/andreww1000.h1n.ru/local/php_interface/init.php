<?php
define('PUBLIC_KEY', '6LdncNYZAAAAAI39wyuiHFQWaK0IMYzGMc_ERv21');
define('PRIVATE_KEY', '6LdncNYZAAAAAMJmxZNiVJHilYwcgAjfd_bnVczC');
?>
<?php
use \Bitrix\Main;
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;

define('LOG_FILENAME', $_SERVER['DOCUMENT_ROOT'].'/log.txt'); // лог для проверки работы агента
//CAgent::AddAgent("loadKursBank();");

require_once ($_SERVER['DOCUMENT_ROOT']."/local/php_interface/functions.php");

function route($name) {
    $routes = array(
        'user-politics' => '/politics/'    
    );
    
    return $routes[$name];
}

// https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=2290
// https://www.acrit-studio.ru/pantry-programmer/knowledge-base/agenty/primer-sozdaniya-agenta/
// https://askaron.ru/api_help/course1/lesson161/?LESSON_PATH=34.84.161

function loadKursBank(){
    //CModule::IncludeModule('iblock');
	CBitrixComponent::includeComponentClass("webdo:currency_synch");

    //AddMessage2Log(date('d-m-Y H:i:s'));

    $json = 'JSON';
    $fpc = file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/test.json', json_encode($json));
    /*debugg('$fpc');
    debugg($fpc);
    debugg($_SERVER['DOCUMENT_ROOT'] . '/test.json');*/

	$kurs = new SynchCurrency("def");
	$kurs->updateCourses();
	
	return "loadKursBank();";  // агент
}


function debugg($data) {
    global $USER;
    //echo '<pre>' . print_r($data, 1) . '</pre>';
    if ($USER->IsAdmin()) {
        echo '<pre>' . print_r($data, 1) . '</pre>';
    }
}

// https://www.google.com/recaptcha/admin/site/433483879

/*
AddEventHandler("main", "OnBeforeUserLogin", "MyOnBeforeUserLoginHandler");
function MyOnBeforeUserLoginHandler($arFields) {

    global $APPLICATION;
}
*/

// https://www.youtube.com/watch?v=kzjDnjXM7H0
//AddEventHandler('form', 'onBeforeResultAdd', 'checkReCaptcha');

function checkReCaptcha()
{
    $captcha = $_REQUEST['g-recaptcha-response'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $request = new \Bitrix\Main\Web\HttpClient();
    $response = $request->post("https://www.google.com/recaptcha/api/siteverify", array(
        "secret" => PRIVATE_KEY,
        "response" => $captcha,
        "remoteip" => $ip,
    ));
    $response = json_decode($response);
    if ($response->success !== true) {
        global $APPLICATION;
        $APPLICATION->ThrowException('Проверка recaptcha не была пройдена. Попробуйте снова.');
    }
}


//AddEventHandler("forum", "onBeforeMessageAdd", "checkReCaptchaForum");

function checkReCaptchaForum()
{
    $captcha = $_REQUEST['g-recaptcha-response'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $request = new \Bitrix\Main\Web\HttpClient();
    $response = $request->post("https://www.google.com/recaptcha/api/siteverify", array(
        "secret" => PRIVATE_KEY,
        "response" => $captcha,
        "remoteip" => $ip,
    ));
    $response = json_decode($response); // валидация в script_deferred.js - ValidateForm()
    if ($response->success !== true) {
        global $APPLICATION;
        $APPLICATION->ThrowException('Проверка recaptcha не была пройдена. Попробуйте снова.');
        return false;
    }
}

// обработчика, который при сохранении элемента переводит в транслит его заголовок, добавляет к заголовку текущую дату (для уникальности) и передает в поле "Символьный код"
// регистрирую обработчик -
AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("CymCode", "OnBeforeIBlockElementAddHandler"));

class CymCode
{

// создаю обработчик события "OnBeforeIBlockElementAdd"
    function OnBeforeIBlockElementAddHandler(&$arFields)  {
        //debugg('$arFields');
        //debugg($arFields["CODE"]);
        if(mb_strlen($arFields["CODE"])>0 && $arFields["CODE"]=="карта") {
            $arFields["CODE"] = CymCode::imTranslite($arFields["CODE"])."_".time();
            //debugg($arFields["CODE"]);
            return;
        }
        //if(strlen($arFields["CODE"])<=0)
        if(mb_strlen($arFields["CODE"])<=0)
        {
            //$arFields["CODE"] = CymCode::imTranslite($arFields["NAME"])."_".date('dmY');
            $arFields["CODE"] = CymCode::imTranslite($arFields["NAME"])."_".time();
            //CymCode::log_array($arFields); // убрать после отладки
            return;
        }
    }

    function imTranslite($str) {
// транслитерация корректно работает на страницах с любой кодировкой
// ISO 9-95
        static $tbl= array(
            'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ж'=>'g', 'з'=>'z',
            'и'=>'i', 'й'=>'y', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p',
            'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'ы'=>'y', 'э'=>'e', 'А'=>'A',
            'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D', 'Е'=>'E', 'Ж'=>'G', 'З'=>'Z', 'И'=>'I',
            'Й'=>'Y', 'К'=>'K', 'Л'=>'L', 'М'=>'M', 'Н'=>'N', 'О'=>'O', 'П'=>'P', 'Р'=>'R',
            'С'=>'S', 'Т'=>'T', 'У'=>'U', 'Ф'=>'F', 'Ы'=>'Y', 'Э'=>'E', 'ё'=>"yo", 'х'=>"h",
            'ц'=>"ts", 'ч'=>"ch", 'ш'=>"sh", 'щ'=>"shch", 'ъ'=>"", 'ь'=>"", 'ю'=>"yu", 'я'=>"ya",
            'Ё'=>"YO", 'Х'=>"H", 'Ц'=>"TS", 'Ч'=>"CH", 'Ш'=>"SH", 'Щ'=>"SHCH", 'Ъ'=>"", 'Ь'=>"",
            'Ю'=>"YU", 'Я'=>"YA", ' '=>"_", '№'=>"", '«'=>"<", '»'=>">", '—'=>"-"
        );
        return strtr($str, $tbl);
    }

// записывает все что передадут в /bitrix/log.txt
    function log_array() {
        $arArgs = func_get_args();
        $sResult = '';
        foreach($arArgs as $arArg) {
            $sResult .= "\n\n".print_r($arArg, true);
        }

        if(!defined('LOG_FILENAME')) {
            define('LOG_FILENAME', $_SERVER['DOCUMENT_ROOT'].'/bitrix/log.txt');
        }
        AddMessage2Log($sResult, 'log_array -> ');
    }

}


//Данные для текущего города
if (Loader::includeModule('iblock')) {
    session_start();
    $citySes = ($_SESSION['city']) ? $_SESSION['city'] : 414; // Москва - центр.офис
    $rsList = CIBlockElement::GetList(
        Array("SORT"=>"ASC"),
        Array("IBLOCK_ID"=>17, "ID"=>$citySes), // банк в городах
        false,
        false,
        Array("IBLOCK_ID", "ID", "NAME", "PROPERTY_ATT_PHONE", "PROPERTY_ATT_EMAIL", "PROPERTY_ATT_ADDRESS", "PROPERTY_ATT_TIME", "PROPERTY_ATT_WHERE")
    );
    while($arList = $rsList->Fetch()) {
        //file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/post_feedback_class.json', json_encode($arList));
        //file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/dopX/currency/arlist.txt', $arList);
        \GarbageStorage::set('name', $arList['NAME']);
        \GarbageStorage::set('nameWhere', $arList['PROPERTY_ATT_WHERE_VALUE'] ?? $arList['NAME']);
        \GarbageStorage::set('phone', $arList['PROPERTY_ATT_PHONE_VALUE']);
        \GarbageStorage::set('email', $arList['PROPERTY_ATT_EMAIL_VALUE']);
        \GarbageStorage::set('address', $arList['PROPERTY_ATT_ADDRESS_VALUE']);
        \GarbageStorage::set('time', $arList['PROPERTY_ATT_TIME_VALUE']);
    }
}

session_start();
CModule::AddAutoloadClasses(   //           ??????????????????????????????
    '', // не указываем имя модуля
    array(
        // ключ - имя класса, значение - путь относительно корня сайта к файлу с классом
        //'BFPict' => $_SERVER['DOCUMENT_ROOT']."/local/php_interface/classPict.php",
        '\BFPict\Pict' => "/local/php_interface/classPict.php",
    )
);

