<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
		</main>
		<footer class="footer-container">
			<div class="container">
				footer
			</div>
		</footer>


<div class="popup-form" id="citySelector">
    <? $APPLICATION->IncludeComponent(
        "webdo:city.select.form",
        "",
        array(
            "AJAX_MODE" => "Y",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "IBLOCK_ID" => "17",           // банк в городах
            "OFFICE_IBLOCK_ID" => "16"     // курс валют банка
        )
    ); ?>
    <button data-fancybox-close="" class="fancybox-close-small">×</button>
</div>

	</body>
</html>