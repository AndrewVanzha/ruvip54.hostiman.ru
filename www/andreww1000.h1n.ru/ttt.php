<?
// https://coder-diary.ru/tips-and-tricks/kak-pomenyat-parol-ot-adminki-bitrix/
// https://habr.com/ru/articles/323152/

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тест");
?>
ttt.php
<?
$psw = 'zse4$%5TGB';
//file_put_contents("/home/bitrix/www/andreww1000.h1n.ru".'/logs' . '/a_request.log', 'ttt ', FILE_APPEND);
//$USER->Update(1, array('PASSWORD'=>$psw));

//$USER->Authorize(1); // укажите ID вашего пользователя
//LocalRedirect('/bitrix/admin/');

file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/logs' . '/a_request.log', $psw);
;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>