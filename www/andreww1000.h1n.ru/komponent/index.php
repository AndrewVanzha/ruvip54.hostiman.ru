<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Компонент");
?><h1>Случайное фото</h1>
<p>
 <a href="https://www.youtube.com/watch?v=XpddKb-PeYg">https://www.youtube.com/watch?v=XpddKb-PeYg</a>
</p>
<p>
 <a href="https://bxnotes.ru/conspect/lib/bitrix/rasshireniye-tipovykh-vozmozhnostey/komponenty/">https://bxnotes.ru/conspect/lib/bitrix/rasshireniye-tipovykh-vozmozhnostey/komponenty/</a>
</p>
 <?$APPLICATION->IncludeComponent(
	"mycomponents:photo.random",
	"spec-random",
	Array(
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "180",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"DETAIL_URL" => "",
		"IBLOCKS" => array(0=>"3",),
		"IBLOCKS_PROP" => "25",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "company_content",
		"IMG_HEIGHT" => "100",
		"IMG_WIDTH" => "200",
		"PARENT_SECTION" => ""
	)
);?>

<?$APPLICATION->IncludeComponent(
	"mycomponents:photo.upload", 
	".default", 
	array(
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "180",
		"CACHE_TYPE" => "A",
		"DETAIL_URL" => "",
		"IBLOCK_ID" => "12",
		"IBLOCK_TYPE" => "company_content",
		"IMG_HEIGHT" => "280",
		"IMG_WIDTH" => "420",
		"PARENT_SECTION" => "",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>