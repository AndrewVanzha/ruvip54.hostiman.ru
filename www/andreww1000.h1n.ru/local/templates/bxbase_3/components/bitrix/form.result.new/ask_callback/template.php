<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?=$arResult["FORM_NOTE"]?>

<?if ($arResult["isFormNote"] != "Y")
{
?>
<?=$arResult["FORM_HEADER"]?>

<div>
<?/*
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
//					form header
    if ($arResult["isFormTitle"])
    {
    ?>
        <h3><?=$arResult["FORM_TITLE"]?></h3>
    <?
    } //endif ;
	if ($arResult["isFormImage"] == "Y")
	{
	?>
	<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>">
        <img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" />
    </a>
	<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
	<?
	} //endif
	?>
		<p><?=$arResult["FORM_DESCRIPTION"]?></p>
	<?
} // endif
	*/?>
</div>

<?
//str_replace('form', );
//debugg($arResult["FORM_HEADER"]);
?>

<?
//						form questions
?>
<table class="form-table data-table">
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
	?>
		<tr>
			<td>
				<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
				<span class="error-fld" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>"></span>
				<?endif;?>
				<?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
				<?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>
			</td>
			<td><?=$arQuestion["HTML_CODE"]?></td>
		</tr>
	<?
		}
	} //endwhile
	?>
<?
if($arResult["isUseCaptcha"] == "Y")
{
?>
		<tr>
			<th colspan="2"><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b></th>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
		</tr>
		<tr>
			<td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></td>
			<td><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
		</tr>
<?
} // isUseCaptcha
?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">
				<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="call_web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
				&nbsp;<input type="reset" value="<?=GetMessage("FORM_RESET");?>" />
			</th>
		</tr>
	</tfoot>
</table>
<p>
<?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
</p>
<?=$arResult["FORM_FOOTER"]?>
    <p class="modal__ok">Форма отправлена</p>
<?
} //endif (isFormNote)
?>

<script>
    // https://www.youtube.com/watch?v=kzjDnjXM7H0

    document.querySelector('form[name="SIMPLE_FORM_2"]').id = 'form2_submit';
    //console.log(document.querySelector('form[name="SIMPLE_FORM_2"]'));

    let delayShow = 5000; // задержка при демонстрации окон

    document.addEventListener("DOMContentLoaded", function() {
        function showDataOK() {
            console.log('data ok');
            let formW = $('.modal__ok').width();
            //console.log(formW);
            $('.modal__ok').css({
                'display': 'block',
                'left': formW*.1,
                'width': formW*.8
            });
            setTimeout(function () {
                $('.modal__ok').css({
                    'display': 'none'
                });
            }, delayShow);
        }

        $('.callform-block form').validate({
            rules: {
                form_text_5: {
                    required: true,
                },
                form_text_6: {
                    required: true,
                },
                form_radio_SIMPLE_QUESTION_573: {
                    required: true,
                },
            },
            messages: {
                form_text_5: {
                    required: 'Это поле обязательно для заполнения',
                },
                form_text_6: {
                    required: 'Это поле обязательно для заполнения',
                },
                form_radio_SIMPLE_QUESTION_573: {
                    required: 'Это поле обязательно для выбора',
                },
            },
            submitHandler(form) {
                let th = $(form);
                let $this = $(this)
                //console.log('th=');
                //console.log(th);
                //let $this = $(this), $form = $this.closest('form');
                let err = 0;
                //console.log('$this=');
                //console.log($this);

                if(!th.find('[name="g-recaptcha-response"]').length) {
                    console.log('no grecaptcha input');
                    //console.log('th=');
                    //console.log(th);
                    grecaptcha.ready(function () {
                        console.log('make grecaptcha ready');
                        grecaptcha.execute("<?=PUBLIC_KEY?>", {action: 'form2_submit'}).then(function (token) {
                            let captchaInput = document.createElement('input');
                            captchaInput.value = token;
                            captchaInput.name = 'g-recaptcha-response';
                            captchaInput.type = 'hidden';
                            th.append(captchaInput);
                            th.click();
                            console.log('grecaptcha executed');

                            let $form = $(form);
                            console.log("$form=");
                            console.log($form.find('[name="g-recaptcha-response"]')[0]);
                            ajax_send($form);

                        });
                    });
                    //return false;
                } else {
                    console.log('grecaptcha exists');
                    let $form = $(form);
                    console.log("$form=");
                    console.log($form.find('[name="g-recaptcha-response"]')[0]);
                    ajax_send($form);
                }

                return false;
            }
        });

        function ajax_send(form) {
            console.log("form=");
            console.log(form.find('[name="g-recaptcha-response"]')[0]);
            $.ajax({
                type: 'POST',
                url: '/ajax/mail.php',
                data: form.serialize(),
            }).done((msg) => {

                form.trigger('reset');
                console.log("msg=");
                console.log(msg);
                showDataOK();
                setTimeout(function() {
                    form.trigger('reset');
                }, (delayShow+100));
            });
        }
    });

</script>
