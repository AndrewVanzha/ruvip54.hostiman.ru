const timerInterval = {};
(function ($) {
    $(document).ready(function () {

        $.ajaxSetup({ cache: false });

        window.addEventListener('focus', function(e){
            rrTimerUpdate();
        });

        (function (){
            const type = $('#rr-form-type').val();
            const currency = $('#rr-form-currency').val();
            const type_cur = type + '-' + currency.toLowerCase();
            $(`[data-rr_type="${type_cur}"]`).addClass('rr-options__checkbox_active');
        })();

        //запуск таймера
        rrTimerUpdate();

        /**
         * Ползунок выбора суммы
         */
        $("#rr-amount-range").ionRangeSlider({
            from: 5000,
            min: 300,
            max: 12000,
            onChange: function (v) {
                $('#rr-amount-input').val(v.from)
            },
            onFinish: function () {
                $('#rr-amount-input').change()
            }
        });

        /**
         * Выбор типа операции
         */
        $('.rr-options__checkbox').click(function () {
            $('.rr-options__checkbox_active').removeClass('rr-options__checkbox_active');
            $(this).addClass('rr-options__checkbox_active');
            updateSummary();
        });

        /**
         * Запретить ввод символов кроме цифр
         */
        $('#rr-amount-input').bind("change keyup input click", function () {
            if (this.value.match(/[^0-9]/g)) {
                this.value = this.value.replace(/[^0-9]/g, '');
            }
        });

        /**
         * Ввод суммы сделки
         */
        $('#rr-amount-input').change(function () {
            if (!$(this).hasClass('rr-options__amount-init')) {
                $.fancybox.open('' +
                    '<div class="popup-form" style="display: inline-block">' +
                    '<h4 class="popup-form_title page-title--4 page-title">Предупреждение</h4>' +
                    '<div class="popup-form_content">При посещении Банка необходимо предоставить документ, удостоверяющий личность, а так же документы, подтверждающие происхождение денежных средств</div>' +
                    '<button data-fancybox-close="" class="fancybox-close-small">×</button>' +
                    '</div>');
                $(this).addClass('rr-options__amount-init');
            }
            updateSummary();
        });

        /**
         * Сообщение перед отправкой
         */
        $('.rr-form__button').click(function (e) {
            e.preventDefault()
            $.fancybox.open('' +
                '<div class="popup-form" style="display: inline-block">' +
                '<h4 class="popup-form_title page-title--4 page-title">Предупреждение</h4>' +
                '<div class="popup-form_content">' +
                '<p>Уважаемый клиент!</p>' +
                '<p>Обращаем Ваше внимание, что перечисление обеспечительного платежа должно быть осуществлено с именной банковской карты, владельцем которой Вы являетесь. Для проведения валютно-обменной операции в офисе Банка Вам необходимо предъявить данную Банковскую карту.</p>' +
                '<button class="button" onclick="$(\'.reservation-rate form\').submit()">Зарегистрировать</button>' +
                '</div>' +
                '<button data-fancybox-close="" class="fancybox-close-small">×</button>' +
                '</div>');
        });

        /**
         * Проверка валидности полей
         */
        $('#rr-form-fio, #rr-form-phone, #rr-form-email, #rr-accept').change(function () {
            let email = validateEmail()
            let phone = validatePhone()
            let fio = validateFIO()

            if (
                $('#rr-form-type').val() !== ''
                && $('#rr-amount-input').val() !== ''
                && $('#rr-form-currency').val() !== ''
                && $('#rr-form-rate').val() !== ''
                && fio
                && email
                && phone
                && $('#rr-accept').prop('checked')
            ) {
                $('.rr-form__button').prop('disabled', false);
            } else {
                $('.rr-form__button').prop('disabled', true)
            }
        });
    })
})(jQuery)

/**
 * Таймер
 */
function rrTimerUpdate() {
    const timePeriod = 3 * 60;
    if(!timerInterval.date || new Date() > new Date(timerInterval.date.getTime() + timePeriod * 1000)){
    //if(!timerInterval.date || new Date() > new Date(timerInterval.date.getTime() + 300 * 1000)){
        getCurrency();
        clearInterval(timerInterval.timer);
        let time = timePeriod;
        //let time = 300;
        timerInterval.date = new Date()
        timerInterval.timer = setInterval(() => {
            if (time === 0) {
                rrTimerUpdate();
                time = timePeriod + 1;
                //time = 301;
            }
            $('.rr-timer__time').text(getCorrectTime(--time))
        }, 1000)
    }
}

/**
 * Получение корректного формата времени в таймере
 * @param time
 * @returns {string}
 */
function getCorrectTime(time) {
    let minute = Math.floor(time / 60);
    let second = time % 60;

    if (String(second).length === 1) second = '0' + second;

    return minute + ':' + second
}

/**
 * Получение корректного формата суммы
 * @param amount
 * @returns {string}
 */
function correctFormatAmount(amount) {
    return String(amount).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ')
}

/**
 * Обновление данных по заявки
 * @returns {Promise<void>}
 */
async function updateSummary() {
    const amount_min = 30000 // минимальная сумма в рублях
    const amount_max = 800000 // максимальная сумма в рублях

    let type_text = '';
    let currency_text = '';
    let currency_symbol = '';
    let type_input = '';
    let type = $('.rr-options__checkbox_active').data('rr_type');
    let rate = $('.rr-options__checkbox_active').data('rr_rate');
    let amount = Number($('.rr-options__amount-input').val());
    let min = Math.floor(amount_min / rate);
    let max = Math.floor(amount_max / rate);
    let end_date = getExpiredDate()

    if (amount < min) amount = min
    if (amount > max) amount = max

    let full_amount = Math.round((rate * amount) * 100) / 100;
    let secure_amount = Math.round(((full_amount * 4) / 100) * 100) / 100;

    $('.rr-options__amount-input').val(amount);

    switch (type) {
        case 'buy-usd':
            type_text = 'Покупка USD по курсу';
            type_input = 'buy';
            currency_symbol = '$';
            currency_text = 'USD';
            break;
        case 'sell-usd':
            type_text = 'Продажа USD по курсу';
            type_input = 'sell';
            currency_symbol = '$';
            currency_text = 'USD';
            break;
        case 'buy-eur':
            type_text = 'Покупка EUR по курсу';
            type_input = 'buy';
            currency_symbol = '€';
            currency_text = 'EUR';
            break;
        case 'sell-eur':
            type_text = 'Продажа EUR по курсу';
            type_input = 'sell';
            currency_symbol = '€';
            currency_text = 'EUR';
            break;
    }

    let range_amount = $("#rr-amount-range").data("ionRangeSlider")

    range_amount.update({
        from: amount,
        min: min,
        max: max,
        prefix: currency_symbol
    })

    $('.rr-options__amount-currency').text(currency_text);
    $('.rr-summary__rate_label').text(type_text);
    $('.rr-summary__rate').text(rate + ' ₽');
    $('.rr-summary__amount').text(currency_symbol + correctFormatAmount(amount));
    $('.rr-summary__full').text(correctFormatAmount(full_amount) + ' ₽');
    $('.rr-summary__secure').text(correctFormatAmount(secure_amount) + ' ₽');
    $('.rr-summary__date').text(end_date);
    $('#rr-form-type').val(type_input);
    $('#rr-form-currency').val(currency_text);
    $('#rr-form-rate').val(rate);
}

/**
 * Получение актуальных курсов валют
 */
function getCurrency() {
    new Promise(done => $.getJSON("/currency/currency.json", function (data) {
        const type = ['buy-usd', 'sell-usd', 'buy-eur', 'sell-eur']
        const session = {}

        type.forEach(function (e) {
            let type = e.split('-');
            let correct_type = type[0] === 'buy' ? 'sell' : 'buy';
            let checkbox = $('.rr-options__checkbox[data-rr_type="' + e + '"]');
            let rate = data['tsb']['data'][10013]['currency'][type[1].toUpperCase()][correct_type]
            checkbox.data('rr_rate', rate);
            checkbox.parent('.rr-options__td').find('.rr-options__checkbox_label').text(rate)
            session[e] = rate
        })

        $.ajax({
            type: "POST",
            url: "/bitrix/reservation.rate/session.php",
            data: session,
            success: function () {
                console.log('update', session)
            }
        });

        updateSummary()

        done();
    }))
}

/**
 * Получение даты окончания резерва
 * @returns {string}
 */
function getExpiredDate() {
    let date = new Date()

    do {
        date.setDate(date.getDate() + 1);
    } while (date.getUTCDay() === 6 || date.getUTCDay() === 0)

    let date_format = ''
    if (date.getDate() > 9) date_format += date.getDate()
    else date_format += '0' + date.getDate()
    if (date.getMonth() > 8) date_format += '.' + (date.getMonth() + 1)
    else date_format += '.0' + (date.getMonth() + 1)
    date_format += '.' + date.getFullYear()

    return date_format
}

/**
 * Валидация ФИО
 * @returns {boolean}
 */
function validateFIO() {
    let fio = $('#rr-form-fio')

    if (fio.val() !== '') {
        fio.removeClass('rr-input__error')
        return true
    }

    fio.addClass('rr-input__error')

    return false
}

/**
 * Валидация email
 * @returns {boolean}
 */
function validateEmail() {
    let email = $('#rr-form-email')
    let re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;

    if (email.val() !== '') {
        if (re.test(String(email.val()).toLowerCase())) {
            email.removeClass('rr-input__error')
            return true
        }
    }

    email.addClass('rr-input__error')

    return false
}

/**
 * Валидация телефона
 * @returns {boolean}
 */
function validatePhone() {
    let obj_phone = $('#rr-form-phone')
    let phone = obj_phone.val()

    if (phone !== '') {
        phone = phone.replace(/[^+\d]/g, '')
        phone = phone.substring(phone.length - 10)

        if (phone.length === 10) {
            obj_phone.removeClass('rr-input__error')
            return true
        }
    }

    obj_phone.addClass('rr-input__error')

    return false
}