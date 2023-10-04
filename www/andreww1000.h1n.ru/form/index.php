<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Форма");
?><div class="container">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"hor_multi",
        Array(
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "left",
            "COMPONENT_TEMPLATE" => "hor_multi",
            "DELAY" => "N",
            "MAX_LEVEL" => "3",
            "MENU_CACHE_GET_VARS" => array(),
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "ROOT_MENU_TYPE" => "hormulti",
            "USE_EXT" => "N"
        )
    );?>
    <h2 class="askquestion-header"><span>Задать вопрос</span>
        <svg class="askquestion-box" width="22" height="22" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 482.9 482.9" style="enable-background:new 0 0 482.9 482.9;">
            <g>
                <path d="M239.7,260.2c0.5,0,1,0,1.6,0c0.2,0,0.4,0,0.6,0c0.3,0,0.7,0,1,0c29.3-0.5,53-10.8,70.5-30.5
                                            c38.5-43.4,32.1-117.8,31.4-124.9c-2.5-53.3-27.7-78.8-48.5-90.7C280.8,5.2,262.7,0.4,242.5,0h-0.7c-0.1,0-0.3,0-0.4,0h-0.6
                                            c-11.1,0-32.9,1.8-53.8,13.7c-21,11.9-46.6,37.4-49.1,91.1c-0.7,7.1-7.1,81.5,31.4,124.9C186.7,249.4,210.4,259.7,239.7,260.2z
                                             M164.6,107.3c0-0.3,0.1-0.6,0.1-0.8c3.3-71.7,54.2-79.4,76-79.4h0.4c0.2,0,0.5,0,0.8,0c27,0.6,72.9,11.6,76,79.4
                                            c0,0.3,0,0.6,0.1,0.8c0.1,0.7,7.1,68.7-24.7,104.5c-12.6,14.2-29.4,21.2-51.5,21.4c-0.2,0-0.3,0-0.5,0l0,0c-0.2,0-0.3,0-0.5,0
                                            c-22-0.2-38.9-7.2-51.4-21.4C157.7,176.2,164.5,107.9,164.6,107.3z"/>
                <path d="M446.8,383.6c0-0.1,0-0.2,0-0.3c0-0.8-0.1-1.6-0.1-2.5c-0.6-19.8-1.9-66.1-45.3-80.9c-0.3-0.1-0.7-0.2-1-0.3
                                            c-45.1-11.5-82.6-37.5-83-37.8c-6.1-4.3-14.5-2.8-18.8,3.3c-4.3,6.1-2.8,14.5,3.3,18.8c1.7,1.2,41.5,28.9,91.3,41.7
                                            c23.3,8.3,25.9,33.2,26.6,56c0,0.9,0,1.7,0.1,2.5c0.1,9-0.5,22.9-2.1,30.9c-16.2,9.2-79.7,41-176.3,41
                                            c-96.2,0-160.1-31.9-176.4-41.1c-1.6-8-2.3-21.9-2.1-30.9c0-0.8,0.1-1.6,0.1-2.5c0.7-22.8,3.3-47.7,26.6-56
                                            c49.8-12.8,89.6-40.6,91.3-41.7c6.1-4.3,7.6-12.7,3.3-18.8c-4.3-6.1-12.7-7.6-18.8-3.3c-0.4,0.3-37.7,26.3-83,37.8
                                            c-0.4,0.1-0.7,0.2-1,0.3c-43.4,14.9-44.7,61.2-45.3,80.9c0,0.9,0,1.7-0.1,2.5c0,0.1,0,0.2,0,0.3c-0.1,5.2-0.2,31.9,5.1,45.3
                                            c1,2.6,2.8,4.8,5.2,6.3c3,2,74.9,47.8,195.2,47.8s192.2-45.9,195.2-47.8c2.3-1.5,4.2-3.7,5.2-6.3
                                            C447,415.5,446.9,388.8,446.8,383.6z"/>
            </g>
        </svg>
        <span>
            <svg class="close-box" width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                <defs>
                    <style>.cls-1{fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style>
                </defs>
                <title/>
                <g id="cross">
                    <line class="cls-1" x1="7" x2="25" y1="7" y2="25"/>
                    <line class="cls-1" x1="7" x2="25" y1="25" y2="7"/>
                </g>
            </svg>
        </span>
    </h2>

    <section class="form-block form-block-show">
        <?$web_form_id = 1;?>
		<h3>WEB_FORM_ID = <?=$web_form_id?></h3>
        <?$APPLICATION->IncludeComponent(
            "bitrix:form.result.new",
            ".default",
            Array(
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CHAIN_ITEM_LINK" => "",
                "CHAIN_ITEM_TEXT" => "",
                "COMPONENT_TEMPLATE" => ".default",
                "EDIT_URL" => "",
                "IGNORE_CUSTOM_TEMPLATE" => "N",
                "LIST_URL" => "",
                "SEF_MODE" => "N",
                "SUCCESS_URL" => "/success.php",
                "USE_EXTENDED_ERRORS" => "N",
                "VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID",),
                "WEB_FORM_ID" => $web_form_id,
            )
        );?>
    </section>

    <h2 class="callback-header"><span>Обратный звонок</span>
        <?/*?>
        <svg class="callback-box" width="22" height="22" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 482.9 482.9" style="enable-background:new 0 0 482.9 482.9;">
            <g>
                <path d="M239.7,260.2c0.5,0,1,0,1.6,0c0.2,0,0.4,0,0.6,0c0.3,0,0.7,0,1,0c29.3-0.5,53-10.8,70.5-30.5
                                            c38.5-43.4,32.1-117.8,31.4-124.9c-2.5-53.3-27.7-78.8-48.5-90.7C280.8,5.2,262.7,0.4,242.5,0h-0.7c-0.1,0-0.3,0-0.4,0h-0.6
                                            c-11.1,0-32.9,1.8-53.8,13.7c-21,11.9-46.6,37.4-49.1,91.1c-0.7,7.1-7.1,81.5,31.4,124.9C186.7,249.4,210.4,259.7,239.7,260.2z
                                             M164.6,107.3c0-0.3,0.1-0.6,0.1-0.8c3.3-71.7,54.2-79.4,76-79.4h0.4c0.2,0,0.5,0,0.8,0c27,0.6,72.9,11.6,76,79.4
                                            c0,0.3,0,0.6,0.1,0.8c0.1,0.7,7.1,68.7-24.7,104.5c-12.6,14.2-29.4,21.2-51.5,21.4c-0.2,0-0.3,0-0.5,0l0,0c-0.2,0-0.3,0-0.5,0
                                            c-22-0.2-38.9-7.2-51.4-21.4C157.7,176.2,164.5,107.9,164.6,107.3z"/>
                <path d="M446.8,383.6c0-0.1,0-0.2,0-0.3c0-0.8-0.1-1.6-0.1-2.5c-0.6-19.8-1.9-66.1-45.3-80.9c-0.3-0.1-0.7-0.2-1-0.3
                                            c-45.1-11.5-82.6-37.5-83-37.8c-6.1-4.3-14.5-2.8-18.8,3.3c-4.3,6.1-2.8,14.5,3.3,18.8c1.7,1.2,41.5,28.9,91.3,41.7
                                            c23.3,8.3,25.9,33.2,26.6,56c0,0.9,0,1.7,0.1,2.5c0.1,9-0.5,22.9-2.1,30.9c-16.2,9.2-79.7,41-176.3,41
                                            c-96.2,0-160.1-31.9-176.4-41.1c-1.6-8-2.3-21.9-2.1-30.9c0-0.8,0.1-1.6,0.1-2.5c0.7-22.8,3.3-47.7,26.6-56
                                            c49.8-12.8,89.6-40.6,91.3-41.7c6.1-4.3,7.6-12.7,3.3-18.8c-4.3-6.1-12.7-7.6-18.8-3.3c-0.4,0.3-37.7,26.3-83,37.8
                                            c-0.4,0.1-0.7,0.2-1,0.3c-43.4,14.9-44.7,61.2-45.3,80.9c0,0.9,0,1.7-0.1,2.5c0,0.1,0,0.2,0,0.3c-0.1,5.2-0.2,31.9,5.1,45.3
                                            c1,2.6,2.8,4.8,5.2,6.3c3,2,74.9,47.8,195.2,47.8s192.2-45.9,195.2-47.8c2.3-1.5,4.2-3.7,5.2-6.3
                                            C447,415.5,446.9,388.8,446.8,383.6z"/>
            </g>
        </svg>
        <span>
            <svg class="close-box" width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                <defs>
                    <style>.cls-1{fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style>
                </defs>
                <title/>
                <g id="cross">
                    <line class="cls-1" x1="7" x2="25" y1="7" y2="25"/>
                    <line class="cls-1" x1="7" x2="25" y1="25" y2="7"/>
                </g>
            </svg>
        </span>
        <?*/?>
    </h2>

    <section class="callform-block callform-block-show">
        <?$web_form_id = 2;?>
		<h3>WEB_FORM_ID = <?=$web_form_id?></h3>
        <?$APPLICATION->IncludeComponent("bitrix:form.result.new", "ask_callback",
            Array(
                "CACHE_TIME" => "3600",	// Время кеширования (сек.)
                "CACHE_TYPE" => "A",	// Тип кеширования
                "CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
                "CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
                "COMPONENT_TEMPLATE" => "ask_callback",
                "EDIT_URL" => "",	// Страница редактирования результата
                "IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
                "LIST_URL" => "",	// Страница со списком результатов
                "SEF_MODE" => "N",	// Включить поддержку ЧПУ
                "SUCCESS_URL" => "/success.php",	// Страница с сообщением об успешной отправке
                "USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
                "VARIABLE_ALIASES" => array(
                    "WEB_FORM_ID" => "WEB_FORM_ID",
                    "RESULT_ID" => "RESULT_ID",
                ),
                "WEB_FORM_ID" => $web_form_id,	// ID веб-формы
            ),
            false
        );?>
    </section>

    <h2 class="callback-header"><span>Регистрация</span></h2>
        <?$web_form_id = 3;?>
		<h3>WEB_FORM_ID = <?=$web_form_id?></h3>

    <section class="regform-block regform-block-show">
        <?$APPLICATION->IncludeComponent(
                "bitrix:form.result.new",
                "reg_form", Array(
                    "CACHE_TIME" => "3600",	// Время кеширования (сек.)
                    "CACHE_TYPE" => "A",	// Тип кеширования
                    "CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
                    "CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
                    "EDIT_URL" => "",	// Страница редактирования результата
                    "IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
                    "LIST_URL" => "",	// Страница со списком результатов
                    "SEF_MODE" => "N",	// Включить поддержку ЧПУ
                    "SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
                    "USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
                    "VARIABLE_ALIASES" => array(
                    	"RESULT_ID" => "RESULT_ID",
                    	"WEB_FORM_ID" => "WEB_FORM_ID",
                    ),
                    "WEB_FORM_ID" => $web_form_id,	// ID веб-формы
                ),
                false
             );?>
    </section>
    <br>

        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            ".default",
            Array(
                "AREA_FILE_RECURSIVE" => "Y",
                "AREA_FILE_SHOW" => "page",
                "AREA_FILE_SUFFIX" => "inc",
                "COMPONENT_TEMPLATE" => ".default",
                "EDIT_TEMPLATE" => ""
            )
        );?>
         <br>
         <b>тут мой старый сниппет<br>
         </b> <b>тут мой новый сниппет<br>
         </b>
        <table border="1" cellpadding="1" cellspacing="1" style="width: 45%; height: 120px;" id="sn_1">
         <caption>Таблица-сниппет</caption>
        <tbody>
        <tr>
            <th style="color: red; text-align: center;">
                 &nbsp;
            </th>
            <th style="color: red; text-align: center;">
                 &nbsp;
            </th>
            <th style="color: red; text-align: center;">
                 &nbsp;
            </th>
            <th style="color: red; text-align: center;">
                 &nbsp;
            </th>
        </tr>
        <tr>
            <th>
                 &nbsp;
            </th>
            <td>
                 &nbsp;
            </td>
            <td>
                 &nbsp;
            </td>
            <td>
                 &nbsp;
            </td>
        </tr>
        <tr>
            <th>
                 &nbsp;
            </th>
            <td>
                 &nbsp;
            </td>
            <td>
                 &nbsp;
            </td>
            <td>
                 &nbsp;
            </td>
        </tr>
        </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() { // клик на заголовок формы
            $('.askquestion-box').on('click', null, function (event) {
                console.log('*');
                $('.form-block').css('display', 'block');
            });
            $('.close-box').on('click', null, function (event) {
                console.log('x');
                $('.form-block-show').css('display', 'none');
            });

        });

    </script>


    <section class="count-block">
        <?$APPLICATION->IncludeComponent(
            "bitrix:statistic.table",
            "",
            Array(
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => 20,
                "CACHE_FOR_ADMIN" => "N"
            )
        );?>
    </section>


    <div class="dcontainer">
      <div class="main-block">
        <h2>JavaScript / возня с определением клика</h2>
      </div>
      <div class="button-block">
        <button class="button_class edit-button">Редактировать</button>
        <button class="button_class save-button">Сохранить</button>
        <button class="button_class refuse-button">Отменить</button>
      </div>
      <div class="tech-block">
        <button class="button_class initial-button">get inital</button>
        <button class="button_class clear-button">clear divs</button>
        <button class="button_class form-button">show form</button>
      </div>
    </div>

    <script>

        window.addEventListener('DOMContentLoaded', function () {

            let buttonElements = document.querySelectorAll(".button_class"); // все кнопки button_class
            let clickButton = document.querySelector(".initial-button"); // кнопка initial
            let changeButton = document.querySelector(".form-button"); // кнопка form
            let clearButton = document.querySelector(".clear-button"); // кнопка clear

            //console.log(buttonElements);

            clickButton.addEventListener('click', function (ev) { // обработчик события click - кнопка initial
                formMoreButtons(clickButton);
            });

            clearButton.addEventListener('click', function (ev) { // обработчик события click - кнопка clear
                removeMoreButtons();
            });

            document.addEventListener('click', function (ev) { // обработчик события click
                //ev.preventDefault(); // не допустить перезагрузки страницы

                //console.log(ev);
                //console.log(ev.this);
                //console.log(ev.target);

                [].forEach.call(buttonElements, function (elem) {  // пробежаться по всем buttonElements
                    if(elem == ev.target) {
                    //console.log(elem);
                        elem.classList.add('make_active'); // подкрасить одну из button
                        setTimeout(function () {
                            elem.classList.remove('make_active');
                        }, 2000);
                    }

                });

                if(ev.target == changeButton) { // обработчик события click - кнопка form
                    let divElements = document.querySelectorAll(".new-div"); // все элементы с .new-div
                    //console.log(divElements);
                    //[].forEach.call(divElements, function (elem) {  // пробежаться по всем divElements
                    divElements.forEach(function (elem) {  // пробежаться по всем divElements
                    elem.classList.add('make_active');
                    setTimeout(function () {
                            elem.classList.remove('make_active');
                        }, 2000);
                    });
                }

            });

            document.querySelector(".dcontainer").addEventListener('click', function (ev) { // отрабатываю клик по новому div
                let elemClasses = ev.target.classList;
                //console.log(ev.target);
                //console.log('getAttribute=');
                //console.log(ev.target.getAttribute('class'));
                //console.log('contains=');
                //console.log(ev.target.classList.contains('new-div'));
                if(elemClasses.contains('new-div')) {
                //if(ev.target.getAttribute('class') == 'new-div') {
                    elemClasses.add('make_active');
                    setTimeout(function () {
                        elemClasses.remove('make_active');
                    }, 2000);
                }

            });

        });

        /* функция формирует еще пару div */
        function formMoreButtons(parentEl) {

            //console.log(parentEl);
            let new_div = document.createElement('div');
            new_div.innerHTML = 'new div';
            let elem = parentEl.parentElement.parentElement;
            elem.append(new_div);
            //console.log(elem);

            new_div.classList.add('new-div');
            elem.insertAdjacentHTML("beforeend", '<div class="new-div">Привет</div>');
        }

        /* функция убирает эту пару div */
        function removeMoreButtons(parentEl) {

            let divElements = document.querySelectorAll(".new-div"); // все .new-div
            //console.log(divElements);
            [].forEach.call(divElements, function (elem) {  // пробежаться по всем divElements
                //console.log(elem);
                elem.remove();
            });

        }

    </script>

    <div class="dcontainer">
        <h2>Use tabs</h2>
        <ul class="tabs__block">
            <li class="tabs__block_item"><button class="tabs__block_button tabs__block_button-active" data-path="one">tab 1</button></li>
            <li class="tabs__block_item"><button class="tabs__block_button" data-path="two">tab 2</button></li>
            <li class="tabs__block_item"><button class="tabs__block_button" data-path="three">tab 3</button></li>
        </ul>
        <div class="tab-content tab-content-active" data-target="one">
            <h3>tab 1</h3>
            <p>Сайт предназначен прежде всего для общения единомышленников. В качестве основной формы такого общения выбран блог – сетевой журнал. К настройкам самих блогов мы еще вернемся. А пока нам нужно внедрить в шаблон компонент Новые сообщения блога. С его помощью будут выводиться на всех страницах тестового шаблона новые сообщения в блогах.</p>
        </div>
        <div class="tab-content" data-target="two">
            <h3>tab 2</h3>
            <p>В исходном варианте дизайна в качестве новых сообщений выводится только текст. Без авторства и даты, но с аватаром. Задумка красивая, но есть одно «Но». Эта идея с аватарами накладывает ограничения на их размер, что не совсем удобно. Это – мелочи, в общем-то, можно потерпеть мелкие аватары в самих блогах. Серьезнее другое: для реализации этого варианта нам придется модифицировать код самого компонента. Это выходит за рамки примера. Потому отойдем от дизайна и вместо аватара выведем картинку с блога с параметрами, заданными в исходном шаблоне.</p>
        </div>
        <div class="tab-content" data-target="three">
            <h3>tab 3</h3>
            <p>Маловероятно, что пользователи буду грузить картинки в пропорциях нужных для правильного отображения картинки на главной странице сайта. Значит разработчик должен будет предусмотреть модификацию вывода компонента с помощью файла result_modifier.php с целью формирования картинки в нужном размере.</p>
        </div>
    </div>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        let tabButtons = document.querySelectorAll('.tabs__block_button');
        tabButtons.forEach(function (tabsBtn) { // перебираю все кнопки
            tabsBtn.addEventListener('click', function (event) {
                //console.log(event.currentTarget);
                //console.log(event.target);
                tabButtons.forEach(function (tabsBtn2) { // перебираю все кнопки
                    tabsBtn2.classList.remove('tabs__block_button-active');
                });

                event.currentTarget.classList.add('tabs__block_button-active');
                const pathEl = event.currentTarget.dataset.path;
                console.log(pathEl);
                [].forEach.call(document.querySelectorAll('.tab-content'), function (elem) { // перебираю все таб-контенты
                    //console.log(elem);
                    elem.classList.remove('tab-content-active');
                    /*const contentBlock = elem.dataset.target;
                    if(contentBlock == pathEl) {
                        console.log(contentBlock);
                        elem.classList.add('tab-content-active');
                    }*/
                });
                document.querySelector(`[data-target="${pathEl}"]`).classList.add('tab-content-active');
            })
        });
    });
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>