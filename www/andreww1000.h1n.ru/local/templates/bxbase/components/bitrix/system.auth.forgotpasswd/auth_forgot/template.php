<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

ShowMessage($arParams["~AUTH_RESULT"]);

//debugg($arParams["~AUTH_RESULT"]);
//debugg($arResult);
?>
<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?
if ($arResult["BACKURL"] <> '')
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="SEND_PWD">

	<p><?echo GetMessage("sys_forgot_pass_label")?></p>

	<div style="margin-top: 16px">
		<div><b><?=GetMessage("sys_forgot_pass_login1")?></b></div>
		<div>
            <input type="text" name="USER_LOGIN" value="<?=$arResult["USER_LOGIN"]?>" />
            <!--input type="text" name="USER_EMAIL" value="" /-->
			<input type="hidden" name="USER_EMAIL" />
		</div>
		<div><?//echo GetMessage("sys_forgot_pass_note_email")?></div>
        <div><? echo $APPLICATION->arAuthResult["MESSAGE"]; ?></div>
	</div>

<?if($arResult["PHONE_REGISTRATION"]):?>

	<div style="margin-top: 14px">
		<div><b><?=GetMessage("sys_forgot_pass_phone")?></b></div>
		<div><input type="text" name="USER_PHONE_NUMBER" value="<?=$arResult["USER_PHONE_NUMBER"]?>" /></div>
		<div><?echo GetMessage("sys_forgot_pass_note_phone")?></div>
	</div>
<?endif;?>

<?if($arResult["USE_CAPTCHA"]):?>
	<div style="margin-top: 18px">
		<div>
			<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
		</div>
		<div><?echo GetMessage("system_auth_captcha")?></div>
		<div><input type="text" name="captcha_word" maxlength="50" value="" /></div>
	</div>
<?endif?>
	<div style="margin-top: 20px">
		<input type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
	</div>
</form>

<div style="margin-top: 20px">
    <?print_r($arResult);?>
	<p><a href="<?=$arResult["AUTH_AUTH_URL"].'&'.'USER_LOGIN='.$arResult["USER_LOGIN"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a></p>
</div>

<? echo '<pre>'; print_r($APPLICATION->arAuthResult); echo '</pre>';?>


<script type="text/javascript">
    //console.log(document.bform.USER_EMAIL.value);
    /*console.log(document.bform.USER_LOGIN.value);

	<p>$arResult["AUTH_AUTH_URL"]</p> - было так !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    console.log($('input[name="USER_LOGIN"]').val());
    console.log($('input[name="USER_EMAIL"]').val());*/
    document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
    //document.bform.onsubmit = function(){document.bform.USER_EMAIL.value;};
    document.bform.USER_LOGIN.focus();
</script>
