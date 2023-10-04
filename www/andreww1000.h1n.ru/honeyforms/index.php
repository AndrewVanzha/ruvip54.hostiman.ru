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
		 <?$APPLICATION->IncludeComponent(
			"bitrix:form.result.new",
			//".default",
			"form_HHs",
			Array(
				"CACHE_TIME" => "3600",
				"CACHE_TYPE" => "A",
				"CHAIN_ITEM_LINK" => "",
				"CHAIN_ITEM_TEXT" => "",
				//"COMPONENT_TEMPLATE" => ".default",
				"COMPONENT_TEMPLATE" => "form_HHs",
				"EDIT_URL" => "",
				"IGNORE_CUSTOM_TEMPLATE" => "N",
				"LIST_URL" => "",
				"SEF_MODE" => "N",
				"SUCCESS_URL" => "/honeyforms/index.php",
				"USE_EXTENDED_ERRORS" => "N",
				"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
				"WEB_FORM_ID" => $web_form_id,
			)
		);?>
	</div>
</section>
<section class="form-response-block">
	<div class="response-wrapper">
		<div class="container-fluid">
			<div class="row d-flex justify-content-center header-block">
				<div class="col-lg-12">
					<h2>Выводим комментарии (web-формы)</h2>
				</div>
			</div>
			<!--div class="row d-flex justify-content-around body-block"-->
				<?$APPLICATION->IncludeComponent(
					"bitrix:form.result.list", 
					"form_HHs", 
					Array(
						"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
						"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
						"EDIT_URL" => "",	// Страница редактирования результата
						"NEW_URL" => "index.php",	// Страница добавления результата
						"NOT_SHOW_FILTER" => array(	// Коды полей которые нельзя показывать в фильтре
							0 => "",
							1 => "",
						),
						"NOT_SHOW_TABLE" => array(	// Коды полей которые нельзя показывать в таблице
							0 => "",
							1 => "",
						),
						"SEF_MODE" => "N",	// Включить поддержку ЧПУ
						"SHOW_ADDITIONAL" => "N",	// Показать дополнительные поля веб-формы
						"SHOW_ANSWER_VALUE" => "N",	// Показать значение параметра ANSWER_VALUE
						"SHOW_STATUS" => "Y",	// Показать текущий статус результата
						"VIEW_URL" => "index.php",	// Страница просмотра результата
						"WEB_FORM_ID" => $web_form_id,	// ID веб-формы
					),
					false
				);?>

			<!--/div-->
		</div>
	</div>
</section>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>