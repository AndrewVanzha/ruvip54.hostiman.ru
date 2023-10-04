Компонент положить в local/components/webtu/feedback

Пример вызова:  
```
<?$APPLICATION->IncludeComponent(
    "webtu:feedback", 
    ".default", 
    array(
        "AJAX_MODE" => "Y",
        "COMPONENT_TEMPLATE" => ".default",
        "IBLOCK_ID" => "5",
        "PROPERTIES" => array(
            0 => "PHONE",
            1 => "EMAIL",
        ),
        "EVENT" => "WEBTU_FEEDBACK_QUESTION",
        "SITES" => array(
            0 => "s1",
        ),
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_ADDITIONAL" => ""
    ),
    false
);?>
```
Пример вызова с коллбеками:
```
<?$APPLICATION->IncludeComponent(
    "webtu:feedback",
    "credit",
    array(
        "AJAX_MODE" => "Y",
        "COMPONENT_TEMPLATE" => "callback",
        "IBLOCK_ID" => "7",
        "PROPERTIES" => array(
            "PHONE",
            "CREDIT_NAME",
            "CREDIT_SUMM",
            "CREDIT_CURRENCY",
            "CREDIT_PERCENT",
            "CREDIT_CLIENT_TYPE",
            "CREDIT_ENSURANCE",
            "CREDIT_PLEDGE",
            "CREDIT_CLIENT_TYPE_VALUE",
            "CREDIT_ENSURANCE_VALUE",
            "CREDIT_PLEDGE_VALUE",
            "CREDIT_TIME",
            "CREDIT_PAYMENT",
            "LAST_NAME",
            "FIRST_NAME",
            "SECOND_NAME",
            "SEX",
            "BIRTHDATE",
            "EMAIL",
            "CITIZENSHIP",
        ),
        "ADMIN_EVENT" => "WEBTU_FEEDBACK_CREDIT",
        "USER_EVENT"  => "WEBTU_FEEDBACK_CREDIT_USER",
        "SITES" => array(
            0 => "s1",
        ),
        "POST_CALLBACK" => function ($post) {
            if (!isset($post['CITIZENSHIP'])) {
                $post['CITIZENSHIP'] = 'Нет';
            } else {
                $post['CITIZENSHIP'] = 'Да';
            }
            
            return $post;
        },
        "EVENT_CALLBACK" => function ($post) {
            if ($post['SEX'] == 'Мужской') {
                $post['RECOURSE'] = 'Уважаемый';
            } else {
                $post['RECOURSE'] = 'Уважаемая';
            }

            return $post;
        },
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "CREDIT_NAME"        => "Кредит 'Молодежный'",
        "CREDIT_SUMM"        => "100 000",
        "CREDIT_CURRENCY"    => "RUB",
        "CREDIT_PERCENT"     => "14%",
        "CREDIT_CLIENT_TYPE" => "Да",
        "CREDIT_ENSURANCE"   => "Да",
        "CREDIT_PLEDGE"      => "Да", 
        "CREDIT_TIME"        => "1 год",
        "CREDIT_PAYMENT"     => "1000",
        "CREDIT_CLIENT_TYPE_VALUE" => "1%",
        "CREDIT_ENSURANCE_VALUE"   => "1%",
        "CREDIT_PLEDGE_VALUE"      => "1%",
    ),
    false
);?>
 ```
Стили для отображения ошибок и успеха:
```
.alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
.alert-danger { color: #a94442; background-color: #f2dede; border-color: #ebccd1; }
.alert-success { color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6; }
```