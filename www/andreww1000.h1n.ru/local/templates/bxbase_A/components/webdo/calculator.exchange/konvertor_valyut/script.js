$(document).ready(function () {
    $('#exchange-date').text($('.v21-exchange-info__date > span').text().replace('данные на ', ''));

    function renderYandexMapWindow(data, place) {
        //console.log(JSON.parse(data));
        //console.log(data);
        //console.log(place);

        place.children('.v21-intro-map__popup_yandex')[0].innerHTML = data;
    }

    function renderGoogleMapWindow(data, place) {
        //console.log(JSON.parse(data));
        //console.log(data);
        //console.log(place);

        place.children('.v21-intro-map__popup_google')[0].innerHTML = data;
    }

    /*
    $('.js-select-yandex-geobox').on('click', function () {
        let $this = $(this);
        //console.log($this);
        let yandex_geobox_popup = $this.parent().next();
        //console.log(yandex_geobox_popup);

        yandex_geobox_popup.addClass('v21-intro-map__popup--show');
        yandex_geobox_popup.children('.v21-intro-map__popup_yandex').addClass('v21-yandex-map--show');
        $(yandex_geobox_popup.children('.js-v21-intro-map__popup--close')).on('click', function () {
            $(this).parent('.v21-intro-map__popup').removeClass('v21-intro-map__popup--show');
            $(this).next('.v21-intro-map__popup_yandex').removeClass('v21-yandex-map--show');
        });

        let data_office = $this.attr('data-office');
        let data_position = $this.attr('data-position').split(',');
        //console.log(data_office);
        //console.log($this.attr('data-office'));
        //console.log(data_position);

        let url = '/chastnym-klientam/konvertor-valyut/ajax_yandex_map.php';
        let xhr = new XMLHttpRequest();
        url += '?OFFICE=' + data_office + '&LAT=' + data_position[0] + '&LON=' + data_position[1];
        //console.log(url);
        xhr.open('GET', url, true);
        xhr.addEventListener("readystatechange", () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                //console.log(xhr.responseText);
                renderYandexMapWindow(xhr.responseText, yandex_geobox_popup); // прорисовка карты
            }
        });
        xhr.send();
        xhr.onerror = function() {
            console.log('error with ajax_yandex_map.php');
        };
    });
    */
    /*
    $('.js-select-google-geobox').on('click', function () {
        let $this = $(this);
        //console.log($this);
        let google_geobox_popup = $this.parent().next();
        //console.log(google_geobox_popup);

        google_geobox_popup.addClass('v21-intro-map__popup--show');
        google_geobox_popup.children('.v21-intro-map__popup_google').addClass('v21-google-map--show');
        $(google_geobox_popup.children('.js-v21-intro-map__popup--close')).on('click', function () {
            $(this).parent('.v21-intro-map__popup').removeClass('v21-intro-map__popup--show');
            //$(this).next('.v21-intro-map__popup_google').removeClass('v21-google-map--show'); // не работает?
            $(this).next().next().removeClass('v21-google-map--show');
        });

        let data_office = $this.attr('data-office');
        let data_position = $this.attr('data-position').split(',');
        //console.log(data_office);
        //console.log(data_position);

        let url = '/chastnym-klientam/konvertor-valyut/ajax_google_map.php';
        let xhr = new XMLHttpRequest();
        url += '?OFFICE=' + data_office + '&LAT=' + data_position[0] + '&LON=' + data_position[1];
        //console.log(url);
        xhr.open('GET', url, true);
        xhr.addEventListener("readystatechange", () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                //console.log(xhr.responseText);
                renderGoogleMapWindow(xhr.responseText, google_geobox_popup); // прорисовка карты
            }
        });
        xhr.send();
        xhr.onerror = function() {
            console.log('error with ajax_google_map.php');
        };

    });
    */

    function makeGismap(num, lat, lon) {
        //console.log(num);
        //console.log(lat);
        //console.log(lon);
        var map_gis;
        DG.then(function() {
            map_gis = DG.map('map_gis_'+num, {
                center: [lat, lon],
                //center: [55.714996361286, 37.632732992065],
                //center: [data_position[0], data_position[1]],
                zoom: 12,
                //scrollWheelZoom: false
            });
            //var markers = DG.featureGroup();
            var markers_icon = DG.icon({
                iconUrl: '/local/templates/czebra_home/components/bitrix/news.list/maps/images/map-marker-1.png',
                iconSize: [26, 34],
                //className: 'map-icon',
            });
            var comment = "пункт обмена валюты";
            //DG.marker([lat, lon], {icon: markers_icon}).addTo(markers).bindLabel(comment);
            DG.marker([lat, lon], {icon: markers_icon}).addTo(map_gis);
            //markers.addTo(map_gis);
            //map_gis.fitBounds(markers.getBounds());
        });
    }

    /*
    const check_gis_geobox = document.querySelectorAll('.js-select-gis-geobox');
    [].forEach.call(check_gis_geobox, function (elem) {
        //console.log(elem);
        let data_position = $(elem).attr('data-position').split(',');
        let data_num = $(elem).attr('data-num');
        //console.log(data_position);
        //console.log(data_num);
        makeGismap(data_num, data_position[0], data_position[1]);
    });

    $('.js-select-gis-geobox').on('click', function () {
        let $this = $(this);
        //console.log($this);
        let gis_geobox_popup = $this.parent().next();
        //console.log(gis_geobox_popup);

        gis_geobox_popup.addClass('v21-intro-map__popup--show');
        gis_geobox_popup.children('.v21-intro-map__popup_gis').addClass('v21-gis-map--show');
        $(gis_geobox_popup.children('.js-v21-intro-map__popup--close')).on('click', function () {
            $(this).parent('.v21-intro-map__popup').removeClass('v21-intro-map__popup--show');
            //$(this).next('.v21-intro-map__popup_google').removeClass('v21-google-map--show'); // не работает?
            $(this).next().next().next().removeClass('v21-gis-map--show');
        });
    });
    */

});

