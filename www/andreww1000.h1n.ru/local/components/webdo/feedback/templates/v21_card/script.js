$(document).ready(function () {
    function requiredFields() {
        var fields = [
            {
                nameField: 'input[name="PHONE"]',
                firstPage: true,
                activePage: false
            },
            {
                nameField: 'input[name="EMAIL"]',
                firstPage: true,
                activePage: false
            },
            {
                nameField: 'input[name="LAST_NAME"]',
                firstPage: true,
                activePage: false
            },
            {
                nameField: 'input[name="FIRST_NAME"]',
                firstPage: true,
                activePage: false
            },
            {
                nameField: 'input[name="PASS_SERIYA"]',
                firstPage: false,
                activePage: false,
            },
            {
                nameField: 'input[name="PASS_NUMBER"]',
                firstPage: false,
                activePage: false
            },
            {
                nameField: 'input[name="PASS_DATA"]',
                firstPage: false,
                activePage: false
            },
            {
                nameField: 'input[name="PASS_KEM"]',
                firstPage: false,
                activePage: false
            },
            {
                nameField: 'input[name="PASS_COD"]',
                firstPage: false,
                activePage: false
            }

        ];

        fields.forEach(function (value) {
            if ($(value.nameField).val() == '') {
                $(value.nameField).parent().addClass("is-error");
                value.activePage = true;
            } else {
                $(value.nameField).parent().removeClass("is-error");
                value.activePage = false;
            }
        });

        for (let i = 0; i < fields.length; i++) {
            if (fields[i].activePage == true) {
                if (fields[i].firstPage == true) {
                    if ($('.v21_plasticOrder2').hasClass("is-active")) {
                        //tsb21.modal.toggleModal('v21_plasticOrder1');
                        console.log("toggleModal('v21_plasticOrder1')");
                    }
                }
                return false;
            }
        }

        return true;
    }

    $('#orderCard').submit(function (e) {
        e.preventDefault();
        if ($("#politics").prop("checked")) {
            $('#politics').parent().parent().removeClass("is-error");
            console.log("checked");
            if (requiredFields()) {
                $.ajax({
                    type: "POST",
                    url: '/local/components/webdo/feedback/templates/v21_card/ajax_customer.php',
                    data: {
                        'fields': $(this).serialize(),
                    },
                    dataType: "json",
                    success: function (data) {
                        $('#reloadCaptcha').click();
                        console.log(data);

                        console.log('fields');
                        if (data.message && data.message.length > 0) {
                            $(".v21_alert_orderCard_item").remove();
                            $(".v21 .v21-modal").addClass("is-active");
                            $.each(data.message, function (key, field) {
                                $('#v21_alert_orderCard .v21-modal__window').append(
                                    '<div class="v21-grid__item v21_alert_orderCard_item" style="font-size: 20px; padding: 0; text-align: center;">' + field.text + '</div>'
                                );
                                console.log(field);

                                if (!field.type) {
                                    $('.v21_alert_orderCard_item').css("color", "red");
                                }
                            });
                        }
                        if (data.status) {
                            $("#orderCard")[0].reset();
                        }

                        if (!data.captcha) {
                            $('input[name="CAPTCHA_WORD"]').parent().addClass("is-error");
                        } else {
                            $('input[name="CAPTCHA_WORD"]').parent().removeClass("is-error");
                            console.log("toggleModal('v21_alert_orderCard')");
                            //tsb21.modal.toggleModal('v21_alert_orderCard');
                        }
                    }
                });
            }
        } else {
            $('#politics').parent().parent().addClass("is-error");
            console.log('not checked');
        }
    });

    // Доставка карты
    $('.block_deliveryHome').hide();
    checkDeliveryCard();

    $('select[name="CITY"]').on('change', function () {
        checkDeliveryCard();
    });

    /*const newSelect = new tsb21.choices('select[name="TYPE"]', {
        searchEnabled: false,
        itemSelectText: '',
        shouldSort: false,
    });
    console.log('tsb21');
    console.log(tsb21);*/

    $('a[href="#v21_plasticOrder1"].open').on('click', function () {
        let cardName = $(this).data('name');
        console.log('a v21_plasticOrder1 opened');
        //newSelect.setChoiceByValue([cardName]);
        //let $this = $(this);
        //console.log($this);
        //console.log($this[0]);

        console.log('$(this)');
        console.log($(this));
        console.log('cardName');
        console.log(cardName);
        let cardImg = $(this).data('img');
        console.log('cardImg');
        console.log(cardImg);

        let images = $('.v21-tabs-content__img')[0].children;
        $.each(images, function (ix, item) {
            $(item).removeClass('v21-display');
            $(item).removeClass('is-active');
            if(ix == cardImg) {
                $(item).addClass('v21-display');
                $(item).addClass('is-active');
            }
        });

        document.querySelector('#v21_plasticOrder1 .v21-select').selectedIndex = cardImg;
        tsb21.tabs.showTab(cardName);
        console.log('tsb21');
        console.log(tsb21);
    });

    $('.v21_plasticOrder1').on('click', function () {
        console.log('button v21_plasticOrder1 opened');
        let cardName = $(this).data('name');
        let cardImg = $(this).data('img');
        $(this).addClass('is-active');
        $('#v21_plasticOrder2').removeClass('is-active');
        $('#v21_plasticOrder1').addClass('is-active');
        $('.v21-input--field').attr('data-item', cardName);
        $('.v21-input--field').text(cardName);
        let images = $('.v21-tabs-content__img')[0].children;
        $.each(images, function (ix, item) {
            $(item).removeClass('v21-display');
            $(item).removeClass('is-active');
            if(ix == cardImg) {
                $(item).addClass('v21-display');
                $(item).addClass('is-active');
            }
        });
        tsb21.cardname = cardName;
        tsb21.cardchoice = cardImg;
        console.log('v21_plasticOrder1 on');
        console.log(cardName);
        console.log('cardImg');
        console.log(cardImg);
        //console.log(images);
        //console.log(tsb21);
        //$('#v21_plasticOrder1 .v21-select option:eq(2)').prop('selected',true)
        document.querySelector('#v21_plasticOrder1 .v21-select').selectedIndex = cardImg;
    });
    $('.v21-modal__close').on('click', function () {
        //let cardName = $(this).data('name');
        $(this).addClass('is-active');
        $('.js-v21-modal').removeClass('is-active');

    });
    $('.v21_plasticOrder2').on('click', function () {
        //let cardName = $(this).data('name');
        //let cardImg = $(this).data('img');
        $(this).addClass('is-active');
        $('#v21_plasticOrder1').removeClass('is-active');
        $('#v21_plasticOrder2').addClass('is-active');
    });

    $('#reloadCaptcha').click(function () {
        console.log('reloadCaptcha script');
        $.getJSON('/local/components/webdo/feedback/reload_captcha.php', function (data) {
            console.log('data=');
            console.log(data);
            $('#captchaImg').attr('src', '/local/tools/captcha.php?captcha_sid=' + data);
            $('#captchaSid').val(data);
        });
        return false;
    });

});

function checkDeliveryCard() {
    let city = $('select[name="CITY"]').val();
    let typeCard = $('select[name="TYPE"]').val();

    if (city === 'Москва' && typeCard !== '') {
        $('.block_deliveryHome').show();
        $('input#v21_deliveryHome').prop("disabled", false).prop("checked", false);

    } else {
        $('.block_deliveryHome').hide();
        $('input#v21_deliveryHome').prop("disabled", true).prop("checked", false);
    }

    /*if (typeCard === 'Visa Gold' || typeCard === 'Visa Platinum') {
        $('.v21-grid__item .translit').show();
    } else {
        $('.v21-grid__item .translit').hide();
        $('input[name="TRANSLIT"]').val('');
    }*/

    $('input#v21_deliveryHome').change();
}

