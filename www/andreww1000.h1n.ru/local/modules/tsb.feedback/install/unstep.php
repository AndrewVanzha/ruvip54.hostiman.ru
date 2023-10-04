<?php
/**
 * @var $APPLICATION
 */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (!check_bitrix_sessid()) {
    return;
}

echo(CAdminMessage::ShowNote(Loc::getMessage("S_VERIFICATION_UNSTEP")));
?>

<form action="<? echo($APPLICATION->GetCurPage()); ?>">
    <input type="hidden" name="lang" value="<? echo(LANG); ?>"/>
    <input type="submit" value="<? echo(Loc::getMessage("S_VERIFICATION_UNSTEP_SUBMIT_BACK")); ?>">
</form>