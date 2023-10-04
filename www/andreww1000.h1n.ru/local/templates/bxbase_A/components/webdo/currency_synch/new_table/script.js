    window.addEventListener('DOMContentLoaded', function () {
    function notesListEventListeners() {
        const check_note_table = document.querySelector('.js-v21-exchange-note__list-check');
        const note_table = document.querySelector('.v21-exchange-note__list-box');
        const note_table_close = document.querySelector('.js-v21-exchange-note__list-box--close');
        if(check_note_table) {
            check_note_table.addEventListener('click', function (event) {
                note_table.classList.add('v21-input-group');
            });
            note_table_close.addEventListener('click', function (event) {
                note_table.classList.remove('v21-input-group');
            });
        }
    }

    notesListEventListeners();

    function notesEventListeners() {
    const check_notes = document.querySelector('.js-exchange-note__items');
    let arNotesText = [];
    let ii = 0;
    if(check_notes) {
    [].forEach.call(check_notes.children, function (elem) { // сделал массив с текстом сносок (не понадобился)
    if(elem.children[0]) {
    if(elem.children[0].nodeName == 'SUP') {
    arNotesText[ii] = elem.children[1].innerText;
    ii += 1;
}
}

});
}

    const check_notes_text = document.querySelectorAll('.js-show-notetext');
    [].forEach.call(check_notes_text, function (elem) { // клик на каждую сноску
    elem.addEventListener('click', function (event) {
    event.path[1].nextElementSibling.classList.toggle('v21-exchange-table__text-subline--show');
    //console.log(event.path[1]);
    if(event.path[1].nextElementSibling.children[1]) {
    event.path[1].nextElementSibling.children[1].addEventListener('click', function (ev) {
    //console.log(ev.path);
    ev.path[2].classList.remove('v21-exchange-table__text-subline--show');
});
}
});
});
}

    notesEventListeners();

    function checkWorkHoursPeriod() {
    let date = new Date();

    const exchange_calc_button = document.querySelector('.v21-exchange-calc__button');
    let wStart = date.getUTCHours() >= 6 && date.getMinutes() >= 0; // с 9 до 19 МСК
    let wEnd = date.getUTCHours() <= 15 && date.getMinutes() <= 59;
    let wDay = date.getDay() != 0 && date.getDay() != 6;
    if(exchange_calc_button) {
    if(wStart && wEnd && wDay) {
    exchange_calc_button.classList.remove('v21-exchange-calc__button-disable');
} else {
    exchange_calc_button.classList.add('v21-exchange-calc__button-disable');
}
}
}

    checkWorkHoursPeriod();

    function renderCurrencyTable(data) {
    let key_string = 'synch.currency.result';
    let arr_start = data.indexOf(key_string);
    let html_text = data.slice(0, arr_start);
    let arCurObj = JSON.parse(data.slice(arr_start + key_string.length));

    //const check_currency_table = document.querySelector('.js-currency-table tbody');
    const check_currency_table = document.querySelector('.js-currency-table');
    let num_td = 0;
    [].forEach.call(check_currency_table.children, function (elem) {
    //if(elem.classList[0] == 'body-table') { // измеряю длину массива с валютами на сайте
    if(elem.classList[0] == 'v21-grid-table') { // измеряю длину массива с валютами на сайте
    num_td += 1;
}
});
    let num = 0;
    if(arCurObj.length == num_td) {
    [].forEach.call(check_currency_table.children, function (elem) {   // обновляю валюты поэлеметно
    //if(elem.classList[0] == 'body-table') {
    if(elem.classList[0] == 'v21-grid-table') {
    elem.children[2].children[1].children[0].innerHTML = arCurObj[num].buy;
    elem.children[3].children[1].children[0].innerHTML = arCurObj[num].sell;
    num += 1;
}
});
} else {
    const exchange_block_table = document.querySelector('.js-v21-exchange-block'); // обновляю весь блок валют
    exchange_block_table.innerHTML = html_text;
    notesListEventListeners();
    notesEventListeners();
}
}


    function displayTime() {
    let date = new Date();
    //console.log(date.toLocaleTimeString());
    //console.log('*');

    checkWorkHoursPeriod();

    //console.log('office=');
    //console.log(office);

    let url = '/dopX/currency/ajax_currency_table.php' + '?office=' + office;
    let xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.addEventListener("readystatechange", () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
    //console.log(xhr.responseText);
    renderCurrencyTable(xhr.responseText); // прорисовка таблицы
}
});
    xhr.send();
    xhr.onerror = function() {
    console.log('error with ajax_currency_table.php');
};

}

    const createClock = setInterval(displayTime, 15000);
});
