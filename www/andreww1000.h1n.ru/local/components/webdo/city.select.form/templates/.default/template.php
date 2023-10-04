<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) { ?>
    <? die(); ?>
<? } ?>
<?//debugg($arResult['CITY']);?>
<style>
    .ui-front {
        color: #C69643;
        width: 300px;
    }
</style>

<script>
    var cityNames = [];
    var cityIds = [];
</script>

<form action="" method="post" class="city-selector" >

    <?if (CSite::InDir('/en/')) {
        $db_props = CIBlockElement::GetProperty(17, $_SESSION['city'], array("sort" => "asc"), Array("CODE"=>"ATT_ENGLISH"));
        if($ar_props = $db_props->Fetch()) {
            $selectedCity = $ar_props["VALUE"];
        }
    } else {
        $res = CIBlockElement::GetByID($_SESSION['city']);
        if($ar_res = $res->GetNext())
          $selectedCity = $ar_res['NAME'];
    }?>
    <h4 class="popup-form_title page-title--4 page-title">
        <?=GetMessage("YOUR_CITY")?>: <?=$selectedCity?>
    </h4>
    <div class="popup-form_content">
        <div class="city-selector_search clearfix">
            <input type="search" name="search" id="search" placeholder="<?=GetMessage("YOUR_CITY")?>" class="input-field">
            <button type="submit" class="button">
                <?=GetMessage("FIND_THE_CITY")?>
            </button>
        </div>

        <div id="autocomplete"></div>

        <ul class="city-selector_list clearfix">  

           <?foreach($arResult['CITY'] as $city){?>

                <?if (CSite::InDir('/en/')) {
                    $cityName = $city['NAME_ENGLISH'];
                } else {
                    $cityName = $city['NAME'];
                }?>
                <script>
                    cityNames.push("<?=$cityName?>");
                    cityIds.push("<?=$city['ID']?>");
                </script>

                <li>
                    <a href="javascript:void(0);" onclick="$('#select').val('<?=$city['ID']?>');$('#submit').click();">
                        <?if (CSite::InDir('/en/')) {
                            echo $city['NAME_ENGLISH'];
                        } else {
                            echo $city['NAME'];
                        }?>
                    </a>
                </li>
            
			<?}?>
        </ul>
        
        
        <input name="office-id" type="text" hidden value="" id="office-id">
        <input name="select" type="text" hidden value="" id="select">
        <input type="submit" hidden id="submit">

    </div>

</form>

<script type="text/javascript" src="/local/templates/bxbase_A/js/vendor/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        $(function () {
            var options = {
                source: cityNames,
                appendTo: $("#autocomplete"),
                select: function(event, ui) {
                    $.each(cityNames, function (i, name) {
                        if (name == ui.item.value) {
                            index = i;
                            return false;
                        }
                    });
                    $('#select').val(cityIds[index]);
                    $('#submit').click();
                }
            };
            $('#search').autocomplete(options);
        });
    });
</script>

<?if($_REQUEST['search']){?>
<script>
    $('.fancybox-close-small').click(function(){
        location.reload();
    })      
</script>
<?}?>



    