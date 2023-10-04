<?php
/**
 * @var $APPLICATION
 * @var $USER
 */

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;
//use Verification\Service\General;
use Webdo\Verification\General;
//use Verification\Service\Logger;
use Webdo\Verification\Logger;

global $USER;
//$module_id = 'verification.service';
$module_id = 'webdo.verification';

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Сервис верификации");
Asset::getInstance()->addCss("/local/modules/$module_id/process/assets/style.css");
//Asset::getInstance()->addCss("/verification.service/assets/style.css");
Asset::getInstance()->addCss("/local/modules/$module_id/process/assets/daterangepicker.css");
//Asset::getInstance()->addCss("/verification.service/assets/daterangepicker.css");
Asset::getInstance()->addJs("/local/modules/$module_id/process/assets/moment.min.js");
//Asset::getInstance()->addJs("/verification.service/assets/moment.min.js");
Asset::getInstance()->addCss("/local/modules/$module_id/process/assets/daterangepicker.min.js");
//Asset::getInstance()->addJs("/verification.service/assets/daterangepicker.min.js");
Asset::getInstance()->addJs("/local/modules/$module_id/process/assets/script.js");
//Asset::getInstance()->addJs("/verification.service/assets/script.js");
try {
    if (Loader::IncludeModule($module_id)) {
        try {
            $request = Application::getInstance()->getContext()->getRequest();
            $get = $request->getQueryList();
            $post = $request->getPostList();
            $check = 1;
            $check = General::check_access($get['h']);

            //print_r('$request');
            print_r('<br>$get=');
            print_r($get['page']);
            print_r($get['result']);
            print_r('<br>$post=');
            print_r($post);
            print_r('<br>$check=');
            print_r($check);
            //if ($check != 0) die($check);

            switch ($check) {
                case 1:
                    $APPLICATION->IncludeFile("/local/modules/$module_id/views/init/manager.php", array(
                        'module_id' => $module_id,
                        'get' => $get,
                        'post' => $post
                    ));
                    break;
                case 2:
                    $APPLICATION->IncludeFile("/local/modules/$module_id/views/init/user.php", array(
                        'module_id' => $module_id,
                        'hash' => $get['h'],
                        'get' => $get,
                        'post' => $post
                    ));
                    break;
                default:
                    $APPLICATION->IncludeFile("/local/modules/$module_id/views/init/forbidden.php");
                    //LocalRedirect('/v/');/*dop*/
            }
        } catch (Exception $e) {
            Logger::write('error', $e->getMessage());
        }
    }
} catch (Exception $e) {
    Logger::write('error', $e->getMessage());
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
