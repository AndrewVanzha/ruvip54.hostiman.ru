<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Доп1");
?>
<h2>Доп 1</h2>
<h1>смешанное menu со своим инфоблоком</h1>
<?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
    "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
    "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
    "DELAY" => "N",	// Откладывать выполнение шаблона меню
    "MAX_LEVEL" => "2",	// Уровень вложенности меню
    "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
        0 => "",
    ),
    "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
    "MENU_CACHE_TYPE" => "N",	// Тип кеширования
    "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
    "ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
    "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
),
    false
);?>zz
    <div class="container">
        <div class="frame-wrapper">
            <div class="block-map">
                <div class="buttons">
                    <button class="button button_1">Офисы</button>
                    <button class="button button_2">Банкоматы</button>
                </div>
                <div id="map" style="width:500px; height:400px"></div>
                <script type="text/javascript">
                    let map, ii;
                    let markers1_coord = [{ lat: 55.76, lon: 37.59}, { lat: 55.74, lon: 37.573}];
                    let markers2_coord = [{ lat: 55.74, lon: 37.686}, { lat: 55.75, lon: 37.679}, { lat: 55.76, lon: 37.676}];
                    let btn1 = document.querySelector(".button.button_1");
                    let btn2 = document.querySelector(".button.button_2");

                    DG.then(function () {
                        map = DG.map('map', {
                            center: [55.751, 37.619],
                            zoom: 11
                        });
                        let markers1 = DG.featureGroup();
                        let markers2 = DG.featureGroup();
                        let markers1_icon = DG.icon({
                            iconUrl: 'https://maps.api.2gis.ru/2.0/example_logo.png',
                            iconSize: [42, 42]
                        });
                        //let markers2_icon = DG.icon();

                        for(ii=0; ii<2; ii++) {
                            console.log(markers1_coord[ii]);
                            DG.marker([markers1_coord[ii].lat, markers1_coord[ii].lon], {icon: markers1_icon}).addTo(markers1).bindLabel('Тут офис!');
                        }
                        for(ii=0; ii<3; ii++) {
                            console.log(markers2_coord[ii]);
                            DG.marker([markers2_coord[ii].lat, markers2_coord[ii].lon]).addTo(markers2).bindLabel('Тут банкомат!');
                        }
                        //marker1 = DG.marker([marker1_coord.lat, marker1_coord.lon]).addTo(map).bindPopup('Тут офис!');
                        //marker2 = DG.marker([marker2_coord.lat, marker2_coord.lon]).addTo(map).bindPopup('Тут банкомат!');

                        function hideMarkers() {
                            markers1.removeFrom(map);
                            markers2.removeFrom(map);
                        }

                        function showMarkers1() {
                            markers1.addTo(map);
                            map.fitBounds(markers1.getBounds());
                        }

                        function showMarkers2() {
                            markers2.addTo(map);
                            map.fitBounds(markers2.getBounds());
                        }

                        btn1.onclick = function() {
                            console.log(1);
                            hideMarkers();
                            showMarkers1();
                            //marker1.openPopup();
                        }
                        btn2.onclick = function() {
                            console.log(2);
                            hideMarkers();
                            showMarkers2();
                            //marker2.openPopup();
                        }
                    });
                </script>

            </div>

            <div class="block-movie">
                <!--iframe width="560" height="315" src="https://www.youtube.com/embed/84gvPdRv6NU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe-->
                <section class="v21 new_year-container">
                    <?
                    $headerLogo = "/local/templates/template_card/img/logo.svg";
                    //$headerLogoDesktop = "/dop1/img/logo_desktop.svg";
                    $headerLogoDesktop = "img/logo_desktop.png";
                    //$headerLogoMobile = "/dop1/img/logo_mobile.svg";
                    $headerLogoMobile = "img/logo_mobile.png";
                    ?>
                    <div class="new_year-container--logo logo-desktop">
                        <a href="/"><img src="<?=$headerLogoDesktop?>" alt="АКБ «Трансстройбанк»"></a>
                    </div>
                    <div class="new_year-container--logo logo-mobile">
                        <a href="/"><img src="<?=$headerLogoMobile?>" alt="АКБ «Трансстройбанк»"></a>
                    </div>
                    <div class="new_year-container--wrap">
                        <div class="new_year-container--circle circle-65"></div>
                        <div class="new_year-container--circle circle-63"></div>
                        <div class="new_year-container--circle circle-62"></div>
                        <div class="new_year-container--circle circle-66"></div>

                        <div class="kino--wrap">
                            <figure class="kino">
                                <video controls="true" autoplay muted loop playsinline>
                                    <source src="img/tiger_card.mp4" type="video/mp4"/>
                                    <?/*?>
                    <source src="img/Drone_Tigers_cut.mp4" type="video/mp4"/>
                    <source src="img/Drone_Tigers_cut.webm" type="video/webm"/>
<?*/?>
                                </video>
                            </figure>
                        </div>

                        <div class="congratulate-block">
                            <div class="congratulate-wrap">
                                <div class="congratulate-header">
                                    <span>Поздравляем вас с Новым годом!</span>
                                </div>
                                <div class="congratulate-star">
                                    <img src="img/star.png" alt="Звездочка">
                                    <!--img src="/local/templates/template_card/img/star.png" alt="Звездочка"-->
                                </div>
                                <div class="congratulate-text">
                                    <span>По восточному календарю 2022 год пройдёт под знаком Тигра. В Китае верили, что этот зверь является символом силы и здоровья, отгоняет злых духов и болезни. После двух лет мировой пандемии, пусть 2022-й подарит успех, станет годом великих свершений и благоприятных событий. Осваивайте новые умения, двигайтесь вперёд, смело и энергично, как король усурийской тайги — амурский тигр!</span>
                                </div>
                                <div class="congratulate-wave">
                                    <img src="img/wave.png" alt="Значок волны">
                                    <!--img src="/local/templates/template_card/img/wave.png" alt="Значок волны"-->
                                </div>
                                <div class="congratulate-footer">
                                    <span>С наилучшими пожеланиями, Трансстройбанк.</span>
                                </div>
                            </div>
                            <div class="congratulate-mobile-wrap">
                                <div class="congratulate-wave">
                                    <img src="img/wave.png" alt="Значок волны">
                                </div>
                                <div class="congratulate-footer">
                                    <span>С наилучшими пожеланиями, Трансстройбанк.</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--iframe width="560" height="315" src="https://www.youtube.com/embed/84gvPdRv6NU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe-->
                </section>
            </div>

        </div>

        <div class="api-ping">
            <h2>Проверка работы АПИ - запись в БД на jino</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" class="form-input" name="title" placeholder="text" value="puck" required>
                <button type="submit" name="upload" class="submit-button btn">ping</button>
            </form>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', function () {
                /*document.querySelector('.main-block__button').addEventListener('click', (event) => {
                    document.querySelector('.popup-form').classList.add('popup-form--show');
                });*/
                /*document.querySelector('.popup__block_close').addEventListener('click', (event) => {
                    document.querySelector('.popup-form').classList.remove('popup-form--show');
                });*/

                let fform = document.querySelector('.api-ping form');
                console.log(fform);
                fform.onsubmit = async (event) => {
                    console.log('form');
                    event.preventDefault();
                    let readData = new FormData(fform);

                    let response = await fetch('/ajax/api_sender.php', {
                        method: 'POST',
                        body: readData
                        //body: JSON.stringify(readData)
                    });

                    let result = await response.json();
                    console.log('result');
                    console.log(result);
                    fform.reset();
                };

            });//
        </script>

    </div>

<?/*$APPLICATION->IncludeComponent(
	"bitrix:form.result.list",
	"",
	Array(
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "result_edit.php",
		"NEW_URL" => "result_new.php",
		"NOT_SHOW_FILTER" => array("",""),
		"NOT_SHOW_TABLE" => array("",""),
		"SEF_MODE" => "N",
		"SHOW_ADDITIONAL" => "N",
		"SHOW_ANSWER_VALUE" => "N",
		"SHOW_STATUS" => "Y",
		"VIEW_URL" => "result_view.php",
		"WEB_FORM_ID" => "4"
	)
);*/?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>