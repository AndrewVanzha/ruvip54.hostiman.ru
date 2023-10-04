<?
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/modules/webdo.verification/process/init.php')) {
    include($_SERVER['DOCUMENT_ROOT'] . '/local/modules/webdo.verification/process/init.php');
}


/**
 * @var $APPLICATION
 * @var $USER
 */

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;
//use Verification\Service\General;
//use Verification\Service\Logger;

global $APPLICATION;
global $USER;
$module_id = 'verification.service';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Верификация");
Asset::getInstance()->addCss("/verification.service/assets/style.css");
Asset::getInstance()->addCss("/verification.service/assets/daterangepicker.css");
Asset::getInstance()->addJs("/verification.service/assets/moment.min.js");
Asset::getInstance()->addJs("/verification.service/assets/daterangepicker.min.js");
Asset::getInstance()->addJs("/verification.service/assets/script.js");

try {
    $request = Application::getInstance()->getContext()->getRequest();
    $get = $request->getQueryList();
    $post = $request->getPostList();
    $check = 1;
    //$check = General::check_access($get['h']);

    //print_r('$request');
    print_r('$get=');
    print_r($get);
    print_r('$post=');
    print_r($post);
    print_r('$check=');
    print_r($check);

    switch ($check) {
        case 1:
            //$APPLICATION->IncludeFile("/local/modules/$module_id/views/init/manager.php", array(
            $APPLICATION->IncludeFile("/verification.service/service/modules/$module_id/views/init/manager.php", array(
                'module_id' => $module_id,
                'get' => $get,
                'post' => $post
            ));
            break;
        default:
            $APPLICATION->IncludeFile("/local/modules/$module_id/views/init/forbidden.php");
            //LocalRedirect('/v/');
    }
} catch (Exception $ex) {
    debugg('error: ' . $ex);
}

?>
    Верификация
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>