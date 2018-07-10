<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?=$arResult["FORM_NOTE"]?>

<?if ($arResult["isFormNote"] != "Y")
{
?>
<?=$arResult["FORM_HEADER"]?>

<table>
<?
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
?>
	<tr>
		<td><?
/***********************************************************************************
					form header
***********************************************************************************/
if ($arResult["isFormTitle"])
{
?>
	<h3><?//=$arResult["FORM_TITLE"]?></h3>
<?
} //endif ;

	if ($arResult["isFormImage"] == "Y")
	{
	?>
	<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
	<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
	<?
	} //endif
	?>

			<p><?=$arResult["FORM_DESCRIPTION"]?></p>
		</td>
	</tr>
	<?
} // endif
	?>
</table>
<br />
<?
/***********************************************************************************
						form questions
***********************************************************************************/
?>
<table class="form-table data-table">
	<thead>
		<tr>
			<th colspan="2">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
	?>
		<tr>
			<td>
				<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
				<span class="error-fld" title="<?=$arResult["FORM_ERRORS"][$FIELD_SID]?>"></span>
				<?endif;?>
				<?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
				<?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>
			</td>
			<td><?=$arQuestion["HTML_CODE"]?></td>
		</tr>
	<?
		}
	} //endwhile
	?>
<?
/*if($arResult["isUseCaptcha"] == "Y")
{
?>
		<tr>
			<th colspan="2"><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b></th>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
		</tr>
		<tr>
			<td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></td>
			<td><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
		</tr>
<?
}*/ // isUseCaptcha
?>
<tr>
    <td colspan="2">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <div class="g-recaptcha" id="g-recaptcha" data-sitekey="6Lf5Cl4UAAAAAL7Ml9GXI188N-vX0DfTPNVwjU6w"></div>
        <noscript>
            <div>
                <div style="width: 302px; height: 422px; position: relative;">
                    <div style="width: 302px; height: 422px; position: absolute;">
                        <iframe src="https://www.google.com/recaptcha/api/fallback?k=6Lf5Cl4UAAAAAL7Ml9GXI188N-vX0DfTPNVwjU6w"
                            frameborder="0" scrolling="no"
                            style="width: 302px; height:422px; border-style: none;">
                        </iframe>
                    </div>
                </div>
                <div style="width: 300px; height: 60px; border-style: none;
                    bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px;
                    background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">
                    <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                        class="g-recaptcha-response"
                        style="width: 250px; height: 40px; border: 1px solid #c1c1c1;
                        margin: 10px 25px; padding: 0px; resize: none;" >
                    </textarea>
                </div>
            </div>
        </noscript>
    </td>
</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">
				<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />

			</th>
		</tr>
	</tfoot>
</table>
<p>
<?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
</p>
<br>
<?=$arResult["FORM_FOOTER"]?>
<?
} //endif (isFormNote)
?>
<script>
    var allowSubmit = false;
    $(".howToBodyWrap form").submit(function(e){
        var form = $(this);
        var data = form.serialize();
        if ($("input[name='form_text_111']").val() == "") {
            $("input[name='form_text_111']").css("border", "2px solid red");
        } else {
			$("input[name='form_text_111']").css("border", "1px solid #c1c5c8");
		}

        if ($("input[name='form_email_114']").val() == "" || isEmail($("input[name='form_email_114']").val()) == false) {
			$("input[name='form_email_114']").css("border", "2px solid red");
        } else {
			$("input[name='form_email_114']").css("border", "1px solid #c1c5c8");
		}

        if ($("input[name='form_text_117']").val() == "") {
			$("input[name='form_text_117']").css("border", "2px solid red");
        } else {
			$("input[name='form_text_117']").css("border", "1px solid #c1c5c8");
		}

        if ($("input[name='form_text_111']").val() == "" || $("input[name='form_email_114']").val() == "" || $("input[name='form_text_117']").val() == "" || isEmail($("input[name='form_email_114']").val()) == false) {
            e.preventDefault();
        } else {
			if (!allowSubmit) {
				$.ajax({
					type: 'POST',
					url: '/ajax/recaptcha_sending.php',
					dataType: 'json',
					data: data,
					success: function(data){
						if (data.result == "ERROR") {
							form.find('input[type="submit"]').prop('disabled', true);
							$(".g-recaptcha iframe").css("border", "2px solid red");
							$(".g-recaptcha").show();
						} else {
							form.find('input[type="submit"]').prop('disabled', false);
							allowSubmit = true;
							form.find('input[type="submit"]').trigger("click");
						}
					},
					complete :function(data){
						form.find('input[type="submit"]').prop('disabled', false);


					}
				});
			}
			return allowSubmit;
		}
    })
</script>