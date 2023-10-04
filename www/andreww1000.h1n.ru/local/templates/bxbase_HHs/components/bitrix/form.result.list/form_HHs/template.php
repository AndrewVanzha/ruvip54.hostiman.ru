<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
$bg_color_class = "";
$email_class = "";
$comment_class = "";

if(count($arResult["arrResults"]) > 0) : ?>
	<ul class="row d-flex justify-content-between message__boxes">
		<?//debugg($arResult["arrAnswers"]["arrSubresult"]);?>
	<? foreach($arResult["arrAnswers"]["arrSubresult"] as $ii=>$arItem): ?>
		<li class="coll col-lg-3 col-xs-2 message__box">
			<? foreach($arItem as $key=>$item): ?>
				<? if($item == 'Вася') { 
					$bg_color_class = "bg-blue"; 
					$email_class = "color-e1"; 
					$comment_class = "color-c1"; 
				} ?>
				<? if($item == 'Маруся') { 
					$bg_color_class = "bg-green"; 
					$email_class = "color-e2"; 
					$comment_class = "color-c2"; 
				} ?>
				<? if($key == 8):  // name ?>
					<h3 class="message__box_header <?=$bg_color_class?>">
						<?=$item ?>
					</h3>
				<? endif; ?>
				<? if($key == 9):  // email ?>
					<p class="message__box_email <?=$email_class?>">
						<?=$item ?>
					</p>
				<? endif; ?>
				<? if($key == 10):  // comment ?>
					<p class="message__box_comment <?=$comment_class?>">
						<?=$item ?>
					</p>
				<? endif; ?>
			<? endforeach; ?>

		</li>
	<?endforeach; ?>
	</ul>

<? endif; ?>
