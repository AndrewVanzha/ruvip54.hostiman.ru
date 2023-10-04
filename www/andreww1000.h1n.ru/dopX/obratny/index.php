<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ДопX");
?><div class="container">
    <?
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/modules/tsb.feedback/views/index.php')) {
    include($_SERVER['DOCUMENT_ROOT'] . '/local/modules/tsb.feedback/views/index.php');
    }
    ?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>