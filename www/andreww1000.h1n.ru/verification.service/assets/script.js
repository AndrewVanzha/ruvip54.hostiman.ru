$(document).ready(function () {
    $('#reload').click(function (e) {
        e.preventDefault();
        $.getJSON('/local/modules/verification.service/process/reload-captcha.php', function (data) {
            $('#captchaImg').attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + data);
            $('#captchaSid').val(data);
        });
        return false;
    });
    $('#daterange').daterangepicker({
        "autoApply": true,
        "startDate": moment().subtract(30, 'days').format('DD/MM/YYYY'),
        "endDate": moment().format('DD/MM/YYYY'),
        "maxDate": moment().format('DD/MM/YYYY'),
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Принять",
            "cancelLabel": "Отменить",
            "fromLabel": "От",
            "toLabel": "До",
            "customRangeLabel": "Пользовательский",
            "weekLabel": "W",
            "daysOfWeek": [
                "Вс",
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб"
            ],
            "monthNames": [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
            "firstDay": 1
        }
    });
});