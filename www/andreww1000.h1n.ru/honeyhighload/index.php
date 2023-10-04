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
			<input type="hidden" name="HIGHLOAD_ID" value="5">
				<div class="form-inner form-inner4">
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
						<input type="email" class="inputtext" name="form_email" value="" size="0" required="">
					</div>

					<div class="form-box tel">
						<p class="form-label">Тел</p>
						<input type="tel" class="inputtext" name="form_tel" value="" size="0" required="">
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
					<h2>Выводим комментарии (Highload-блоки)</h2>
				</div>
			</div>

			<div class="row d-flex justify-content-between"> 
				<?$APPLICATION->IncludeComponent(
	"bitrix:highloadblock.list", 
	"hunter_high_list", 
	array(
		"BLOCK_ID" => "5",
		"CHECK_PERMISSIONS" => "N",
		"DETAIL_URL" => "/honeyhighload/detail.php?IBLOCKID=#BLOCK_ID#&ROW_ID=#ID#",
		"FILTER_NAME" => "",
		"PAGEN_ID" => "page",
		"ROWS_PER_PAGE" => "",
		"SORT_FIELD" => "ID",
		"SORT_ORDER" => "ASC",
		"COMPONENT_TEMPLATE" => "hunter_high_list"
	),
	false
);?>
			</div>

			<ul class="row d-flex justify-content-between message__boxes"> 

	 			<?$arData = read_highload_id(5);?>
				<?foreach($arData as $arItem): ?>
					<li class="coll col-lg-3 col-xs-2 message__box">
						<h3 class="message__box_header <?=($arItem['UF_PERSONAL_NAME'] == 'Маруся')? 'bg-green' : 'bg-blue'; ?>"><?=$arItem["UF_PERSONAL_NAME"]?></h3>
						<p class="message__box_email <?=($arItem['UF_PERSONAL_NAME'] == 'Маруся')? 'color-e2' : 'color-e1'; ?>">
							<a class="txttohtmllink" href="mailto:<?=$arItem["UF_PERSONAL_EMAIL"]?>" title="Написать письмо"><?=$arItem["UF_PERSONAL_EMAIL"]?></a>
						</p>
						<p class="message__box_tel <?=($arItem['UF_PERSONAL_NAME'] == 'Маруся')? 'color-c2' : 'color-c1'; ?>"><?=$arItem["UF_PERSONAL_TEL"]?></p>
						<p class="message__box_comment <?=($arItem['UF_PERSONAL_NAME'] == 'Маруся')? 'color-c2' : 'color-c1'; ?>"><?=$arItem["UF_PERSONAL_COMMENT"]?></p>
					</li>
				<?endforeach; ?>

			</ul>
		</div>
	</div>
</section>
</div>

<?
function read_highload_id($form_id) {
	//global $USER;
	//use Bitrix\Main\Loader; 
	//Loader::includeModule("highloadblock");   // https://devforces.ru/blog/api-d7-rabota-s-highload-blokam-v-bitriks/
	//use Bitrix\Highloadblock as HL; 
	//use Bitrix\Main\Entity;
	$arResult = array();

	CModule::IncludeModule("highloadblock");
	$arFilter = array();
	$arSelect = array('*'); // выберутся все поля

	$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($form_id)->fetch(); 
	$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass(); 

	$rsData = $entity_data_class::getList(array(
		"select" => $arSelect,
		"filter" => $arFilter,
		"order" => array("ID" => "ASC"),
	));

	while($arRes = $rsData->Fetch()){
		$arResult[] = $arRes;
	}
	//echo "<pre>"; print_r($arResult); echo "</pre>";
	return $arResult;
}
?>

<script>
window.addEventListener('DOMContentLoaded', function () {
	let form = document.querySelector('.test-form-block form');

	function callAJAXaction() {
		 const xhr = new XMLHttpRequest();
		let fdata  = new FormData(form);
		const url = '/ajax/add_personal.php';
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
			let elem_p3 = document.createElement('p');

			elem_li.className = 'coll col-lg-3 col-xs-2 message__box';
			if(arrInfo.form_text == 'Маруся') {
				elem_h3.className = 'message__box_header bg-green';
				elem_p1.className = 'message__box_comment color-c2';
				elem_p2.className = 'message__box_email color-e2';
				elem_p3.className = 'message__box_tel color-c2';
			} else {
				elem_h3.className = 'message__box_header bg-blue';
				elem_p1.className = 'message__box_comment color-c1';
				elem_p2.className = 'message__box_email color-e1';
				elem_p3.className = 'message__box_tel color-c1';
			}
			elem_h3.innerHTML = arrInfo.form_text;
			elem_p1.innerHTML = arrInfo.form_textarea;
			elem_p3.innerHTML = arrInfo.form_tel;
			elem_a.className = 'txttohtmllink';
			elem_a.href = 'mailto:' + arrInfo.form_email;
			elem_a.title = 'Написать письмо';
			elem_a.innerHTML = arrInfo.form_email;

			elem_p2.append(elem_a);
			elem_li.append(elem_h3);
			elem_li.append(elem_p3);
			elem_li.append(elem_p2);
			elem_li.append(elem_p1);
			infoBox.append(elem_li);
		}
	}

});
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>