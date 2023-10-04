<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<!--div class=""-->
	<?//=$arResult["FORM_NOTE"]?>
	<?if ($arResult["isFormNote"] != "Y" || 1) {
	?>
	<?=$arResult["FORM_HEADER"]?>
	<?//debugg($arResult);?>

	<?if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y" || 1): ?>
		<div class="form-inner">
			<?foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion): ?>
				<?//debugg($arQuestion);?>
				<?if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') {
					echo $arQuestion["HTML_CODE"];
				} else { ?>
					<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'text'): ?>
						<div class="form-box text">
							<p class="form-label">
								<?=$arQuestion["CAPTION"]?>
								<?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
							</p>
							<?=$arQuestion["HTML_CODE"]?>
						</div>
					<?endif; // form_text_8 = name?>
					<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'textarea'): ?>
						<div class="form-box textarea">
							<p class="form-label">
								<?=$arQuestion["CAPTION"]?>
								<?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
							</p>
							<?=$arQuestion["HTML_CODE"]?>
						</div>
					<?endif; // form_textarea_9 = comment?>
					<?if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'email'): ?>
						<div class="form-box email">
							<p class="form-label">
								<?=$arQuestion["CAPTION"]?>
								<?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
							</p>
							<?//=$arQuestion["HTML_CODE"]?>
							<input type="tel" class="inputtext" name="form_email_10" value="" size="0" required>
						</div>
					<?endif; // form_email_10 = email?>
				<? } ?>

			<?endforeach; ?>
		</div>

		<input class="submit-button" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="Записать" />
		<input type="hidden" name="web_form_apply" value="Y" />
	<?endif; ?>

	<?=$arResult["FORM_FOOTER"]?>
	<?
	} //endif (isFormNote)
	?>
<!--/div-->

<?
$FORM_ID = 4;
$arFields = array();
$arFilter["FIELDS"] = $arFields;
//$is_filtered = false;

$rsResults = CFormResult::GetList($FORM_ID, 
    ($by="s_timestamp"), 
    ($order="desc"), 
    $arFilter, 
    $is_filtered, 
    "Y", 
    10);
while ($arRes = $rsResults->Fetch()) {
	//echo "<pre>"; print_r($arRes); echo "</pre>";
}
?>

<?
function get_last_id($result_id) {
	$RESULT_ID = 2; // ID результата
	//$arResultt = array();
	// получим данные по всем вопросам
	$arAnswerr = CFormResult::GetDataByID(
	    $result_id, 
	    array(), 
	    $arResultt, 
	    $arAnswer2);

	// выведем поля результата
	//echo "<pre>"; print_r($arResultt); echo "</pre>";

	// выведем значения ответов
	echo "<pre>"; print_r($arAnswerr); echo "</pre>";

	// выведем значения ответов в несколько ином формате
	//echo "<pre>"; print_r($arAnswer2); echo "</pre>";
}
?>

<script>
window.addEventListener('DOMContentLoaded', function () {
	let form = document.querySelector('.test-form-block form');

	function callAJAXaction() {
		 const xhr = new XMLHttpRequest();
		let fdata  = new FormData(form);
		const url = '/ajax/make_records.php';
		console.log('+');

		xhr.open('POST', url, true); // async
		xhr.addEventListener("readystatechange", () => {
			if (xhr.readyState === 4 && xhr.status === 200) {
				console.log('++');
				//console.log(JSON.parse(xhr.responseText));
				renderNewData(JSON.parse(xhr.responseText)); // прорисовка новой информации
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
			console.log(arrInfo);
			let elem_li = document.createElement('li');
			let elem_h3 = document.createElement('h3');
			let elem_p1 = document.createElement('p');
			let elem_p2 = document.createElement('p');
			let elem_a = document.createElement('a');

			elem_li.className = 'coll col-lg-3 col-xs-2 message__box';
			if(arrInfo.i8.USER_TEXT == 'Маруся') {
				elem_h3.className = 'message__box_header bg-green';
				elem_p1.className = 'message__box_comment color-c2';
				elem_p2.className = 'message__box_email color-e2';
			} else {
				elem_h3.className = 'message__box_header bg-blue';
				elem_p1.className = 'message__box_comment color-c1';
				elem_p2.className = 'message__box_email color-e1';
			}
			elem_h3.innerHTML = arrInfo.i8.USER_TEXT;
			elem_p1.innerHTML = arrInfo.i9.USER_TEXT;
			elem_a.className = 'txttohtmllink';
			elem_a.href = 'mailto:' + arrInfo.i10.USER_TEXT;
			elem_a.title = 'Написать письмо';
			elem_a.innerHTML = arrInfo.i10.USER_TEXT;

			elem_p2.append(elem_a);
			elem_li.append(elem_h3);
			elem_li.append(elem_p1);
			elem_li.append(elem_p2);
			infoBox.append(elem_li);
		}
	}

});
</script>
