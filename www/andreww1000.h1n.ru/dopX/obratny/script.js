$(document).ready(function () {
    $('#reloadCaptcha').click(function () {
        $.getJSON('/local/modules/tsb_feedback/process/reload_captcha.php', function (data) {
            $('#captchaImg').attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + data);
            $('#captchaSid').val(data);
        });
        return false;
    });
});