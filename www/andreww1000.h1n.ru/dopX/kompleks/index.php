<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Комплекс");
/*?>
<div class="container">
</div>
<div class="container">
	<h2 class="kompleks-currency">Операции с валютой</h2>
	 <?$APPLICATION->IncludeComponent(
	"webdo:currency_synch",
	"def",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A"
	)
);?>
</div>
<hr>
<?*/?>
<div class="container v21">
	<h2 class="kompleks-cards">Закажи карту</h2>
    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "card_list",
        Array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
            "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
            "AJAX_MODE" => "N",	// Включить режим AJAX
            "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
            "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
            "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
            "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
            "CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
            "CACHE_GROUPS" => "Y",	// Учитывать права доступа
            "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
            "CACHE_TYPE" => "A",	// Тип кеширования
            "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
            "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
            "DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
            "DISPLAY_DATE" => "N",	// Выводить дату элемента
            "DISPLAY_NAME" => "Y",	// Выводить название элемента
            "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
            "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
            "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
            "FIELD_CODE" => array(	// Поля
                0 => "",
                1 => "",
            ),
            "FILTER_NAME" => "",	// Фильтр
            "HIDE_LINK_WHEN_NO_DETAIL" => "Y",	// Скрывать ссылку, если нет детального описания
            "IBLOCK_ID" => "18",	// Код информационного блока
            "IBLOCK_TYPE" => "company_content",	// Тип информационного блока (используется только для проверки)
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
            "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
            "MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
            "NEWS_COUNT" => "20",	// Количество новостей на странице
            "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
            "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
            "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
            "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
            "PAGER_TEMPLATE" => "round",	// Шаблон постраничной навигации
            "PAGER_TITLE" => "Новости",	// Название категорий
            "PARENT_SECTION" => "",	// ID раздела
            "PARENT_SECTION_CODE" => "",	// Код раздела
            "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
            "PROPERTY_CODE" => array(	// Свойства
                0 => "",
                1 => "",
            ),
            "SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
            "SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
            "SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
            "SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
            "SET_STATUS_404" => "Y",	// Устанавливать статус 404
            "SET_TITLE" => "N",	// Устанавливать заголовок страницы
            "SHOW_404" => "N",	// Показ специальной страницы
            "SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
            "SORT_BY2" => "ACTIVE_FROM",	// Поле для второй сортировки новостей
            "SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
            "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
            "STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа списка
            "COMPONENT_TEMPLATE" => "card_list"
	    ),
	    false
    );?>
Q
    <? $APPLICATION->IncludeComponent(
        "webdo:feedback",
        "v21_card",
        array(
            "ADMIN_EVENT" => "WEBDO_FEEDBACK_CARD_ADMIN", // почтовое событие
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "EVENT_CALLBACK" => function ($post) {
                if ($post['SEX'] == 'Мужской') {
                    $post['RECOURSE'] = 'Уважаемый';
                } else {
                    $post['RECOURSE'] = 'Уважаемая';
                }
                return $post;
            },
            "IBLOCK_ID" => "19",                          //  Заявка на банковскую карту
            "POST_CALLBACK" => function ($post) {
                if (!isset($post['DELIVERYCARD'])) {
                    $post['DELIVERYCARD'] = 'Нет';
                } else {
                    $post['DELIVERYCARD'] = 'Да';
                }
                if (!isset($post['CITYZENSHIP'])) {
                    $post['CITYZENSHIP'] = 'Нет';
                } else {
                    $post['CITYZENSHIP'] = 'Да';
                }
                if (!empty($post['PASS_ADDR_S'])) {
                    $post['PASS_ADDR_F'] = $post['PASS_ADDR_R'];
                }
                if (!empty($post['TYPE_INOY'])) {
                    $post['TYPE_PASS'] = $post['TYPE_INOY'];
                }
                if (!empty($post['FIRST_NAME'])) {
                    $post['NAME'] = $post['LAST_NAME'] . ' ' . $post['FIRST_NAME'] . ' ' . $post['SECOND_NAME'];
                }
                return $post;
            },
            "PROPERTIES" => array("BIRTHDATE", "SEX", "PHONE", "EMAIL", "CITY", "CITYZENSHIP", "TYPE", "TRANSLIT", "CARD_SUMM", "CARD_CURRENCY", "DELIVERYCARD", "TYPE_PASS", "TYPE_INOY", "PASS_SERIYA", "PASS_NUMBER", "PASS_KEM", "PASS_DATA", "PASS_COD", "PASS_MESTO", "PASS_ADDR_R", "PASS_ADDR_F", "PASS_ADDR_S"),
            "SITES" => array("s1"),
            "USER_EVENT" => "WEBDO_FEEDBACK_CARD_USER", // почтовое событие
            "SHOW_DEBETS_CARDS" => "Y"
        )
    ); ?>
</div>
<p>Форма в футере</p>
<?
//Отображаем форму в футере
\GarbageStorage::set('feedback', true);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>