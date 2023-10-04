<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("HoneyHunters");
$web_form_id = 4;
?><div class="contain">
<section class="test-form-block">
	<div class="form-wrapper">
		<div class="icon-mail">
 			<img alt="лого компании" src="upload/images/mail-icon.png">
		</div>
		<form name="form_5" action="/honeyhunters/" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="sessid" id="sessid" value="111">
			<input type="hidden" name="FORM_ID" value="12">
				<div class="form-inner">
					<div class="form-box text">
						<p class="form-label">Имя<font color="red"><span class="form-required starrequired">*</span></font>
						</p>
						<input type="text" class="inputtext" name="form_text" value="">
					</div>

					<div class="form-box textarea">
						<p class="form-label">Комментарий</p>
						<textarea name="form_textarea" cols="40" rows="5" class="inputtextarea"></textarea>
					</div>

					<div class="form-box email">
						<p class="form-label">E-mail</p>
						<input type="tel" class="inputtext" name="form_email" value="" size="0" required="">
					</div>

				</div>
			<input class="submit-button" type="submit" name="form_submit" value="Записать">
			<input type="hidden" name="form_apply" value="Y">

		</form>

	</div>
</section> 

<section class="form-response-block">
	<div class="response-wrapper">
		<div class="container-fluid">
			<div class="row d-flex justify-content-center header-block">
				<div class="col-lg-12">
					<h2>Выводим комментарии (Инфоблоки)</h2>
				</div>
			</div>
			<!--ul class="row d-flex justify-content-between message__boxes"--> 

				 <?$APPLICATION->IncludeComponent(
					"bitrix:news.list", 
					"personal_data_list", 
					Array(
						"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
						"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
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
						"DISPLAY_NAME" => "N",	// Выводить название элемента
						"DISPLAY_PICTURE" => "N",	// Выводить изображение для анонса
						"DISPLAY_PREVIEW_TEXT" => "N",	// Выводить текст анонса
						"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
						"FIELD_CODE" => array(	// Поля
							0 => "",
							1 => "",
						),
						"FILTER_NAME" => "",	// Фильтр
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
						"IBLOCK_ID" => "12",	// Код информационного блока
						"IBLOCK_TYPE" => "company_content",	// Тип информационного блока (используется только для проверки)
						"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// Включать инфоблок в цепочку навигации
						"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
						"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
						"NEWS_COUNT" => "20",	// Количество новостей на странице
						"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
						"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
						"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
						"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
						"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
						"PAGER_TITLE" => "Новости",	// Название категорий
						"PARENT_SECTION" => "",	// ID раздела
						"PARENT_SECTION_CODE" => "",	// Код раздела
						"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
						"PROPERTY_CODE" => array(	// Свойства
							0 => "P_NAME",
							1 => "",
						),
						"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
						"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
						"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
						"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
						"SET_STATUS_404" => "N",	// Устанавливать статус 404
						"SET_TITLE" => "N",	// Устанавливать заголовок страницы
						"SHOW_404" => "N",	// Показ специальной страницы
						"SORT_BY1" => "ID",	// Поле для первой сортировки новостей
						"SORT_BY2" => "ACTIVE_FROM",	// Поле для второй сортировки новостей
						"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
						"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
						"STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа списка
					),
					false
				);?>

			<!--/ul-->
		</div>
	</div>
</section>
</div>

<script>
window.addEventListener('DOMContentLoaded', function () {
	let form = document.querySelector('.test-form-block form');

	function callAJAXaction() {
		const xhr = new XMLHttpRequest();
		let fdata  = new FormData(form);
		const url = '/ajax/add_record.php';
		console.log('+');

		xhr.open('POST', url, true); // async
		xhr.addEventListener("readystatechange", () => {
			if (xhr.readyState === 4 && xhr.status === 200) {
				console.log('++');
				//console.log(JSON.parse(xhr.responseText));
				renderNewData(JSON.parse(xhr.responseText)); // прорисовка новой информации
				form.reset();
			}
		});
		xhr.send(fdata);
		xhr.onerror = function() {
			console.log('error');
		};

	}

	form.addEventListener("submit", function (event) {
		//console.log(form);
		event.preventDefault();
		callAJAXaction();
	});

	function renderNewData(arrInfo) {
		let infoBox = document.querySelector('.message__boxes');
		if(typeof(arrInfo) == "string") {
			console.log(arrInfo);
		} else {
			//console.log(arrInfo);
			let elem_li = document.createElement('li');
			let elem_h3 = document.createElement('h3');
			let elem_p1 = document.createElement('p');
			let elem_p2 = document.createElement('p');
			let elem_a = document.createElement('a');

			elem_li.className = 'coll col-lg-3 col-xs-2 message__box';
			if(arrInfo.form_text == 'Маруся') {
				elem_h3.className = 'message__box_header bg-green';
				elem_p1.className = 'message__box_comment color-c2';
				elem_p2.className = 'message__box_email color-e2';
			} else {
				elem_h3.className = 'message__box_header bg-blue';
				elem_p1.className = 'message__box_comment color-c1';
				elem_p2.className = 'message__box_email color-e1';
			}
			elem_h3.innerHTML = arrInfo.form_text;
			elem_p1.innerHTML = arrInfo.form_textarea;
			elem_a.className = 'txttohtmllink';
			elem_a.href = 'mailto:' + arrInfo.form_email;
			elem_a.title = 'Написать письмо';
			elem_a.innerHTML = arrInfo.form_email;

			elem_p2.append(elem_a);
			elem_li.append(elem_h3);
			elem_li.append(elem_p1);
			elem_li.append(elem_p2);
			infoBox.append(elem_li);
		}
	}

});
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>