<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персонал");
?>
    <div class="container">
        <h2>Параметры пользователя</h2>
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.profile",
            "",
            Array(
                "CHECK_RIGHTS" => "N",
                "SEND_INFO" => "N",
                "SET_TITLE" => "Y",
                "USER_PROPERTY" => array(),
                "USER_PROPERTY_NAME" => ""
            )
        );?>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>