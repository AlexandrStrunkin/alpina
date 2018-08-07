<?
    /**
    * Bitrix Framework
    * @package bitrix
    * @subpackage main
    * @copyright 2001-2014 Bitrix
    */

    /**
    * Bitrix vars
    * @global CMain $APPLICATION
    * @param array $arParams
    * @param array $arResult
    * @param CBitrixComponentTemplate $this
    */

    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="bx-auth">
    <?
        ShowMessage($arParams["~AUTH_RESULT"]);
    ?>
    <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
        <p><?echo GetMessage("AUTH_EMAIL_SENT")?></p>
        <?else:?>

        <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
            <p><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></p>
            <?endif?>
    <noindex>
        <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
            <?
                if (strlen($arResult["BACKURL"]) > 0)
                {
                ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                <?
                }
            ?>
            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="REGISTRATION" />

            <table class="data-table bx-registration-table">
                <thead>
                    <tr>
                        <td><b><?//=GetMessage("AUTH_REGISTER")?></b></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="USER_NAME" maxlength="50" value="<?=$arResult["USER_NAME"]?>" class="bx-auth-input" placeholder="<?=GetMessage("AUTH_NAME")?>"/></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="USER_LAST_NAME" maxlength="50" value="<?=$arResult["USER_LAST_NAME"]?>" class="bx-auth-input" placeholder="<?=GetMessage("AUTH_LAST_NAME")?>"/></td>
                    </tr>
                    <?/*?>
                        <tr>
                        <td><span class="starrequired">*</span><?=GetMessage("AUTH_LOGIN_MIN")?></td>
                        <td><input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" class="bx-auth-input" /></td>
                        </tr>
                    <?*/?>
                    <tr>
                        <td><input type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" class="bx-auth-input" placeholder="<?=GetMessage("AUTH_EMAIL")?>"/></td>
                    </tr>
                    <tr>
                        <td><input type="password" class="reg_password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" placeholder="<?=GetMessage("AUTH_PASSWORD_REQ")?>"/>
                            <p class="paswordIncorrectly"><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
                            <?if($arResult["SECURE_AUTH"]):?>
                                <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                                    <div class="bx-auth-secure-icon"></div>
                                </span>
                                <noscript>
                                    <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                                        <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                                    </span>
                                </noscript>
                                <script type="text/javascript">
                                    document.getElementById('bx_auth_secure').style.display = 'inline-block';
                                </script>
                                <?endif?>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="password" class="reg_confirm_password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" placeholder="<?=GetMessage("AUTH_CONFIRM")?>"/>
                        </td>
                    </tr>
                    <?// ********************* User properties ***************************************************?>
                    <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
                        <tr><td><?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></td></tr>
                        <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
                            <tr><?/*?><td><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;
                                ?><?=$arUserField["EDIT_FORM_LABEL"]?>:</td><?*/?><td>
                                    <?$APPLICATION->IncludeComponent(
                                            "bitrix:system.field.edit",
                                            $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                                        array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
                            <?endforeach;?>
                        <?endif;?>
                    <?// ******************** /User properties ***************************************************

                        /* CAPTCHA */
                        if ($arResult["USE_CAPTCHA"] == "Y")
                        {
                        ?>
                        <tr>
                            <td><b><?=GetMessage("CAPTCHA_REGF_TITLE")?></b></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                                <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="captcha_word" maxlength="50" value="" /></td>
                        </tr>
                        <?
                        }
                        /* CAPTCHA */
                    ?>
                    <tr>
                        <td>
                            <div class="remembMeContainer">
                                <input type="checkbox" name="USER_SUBSCRIBE" id="subscription" hidden checked="checked" />
                                <label for="subscription" class="remembMeText">Я хочу подписаться на рассылку.</label>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td><input type="submit" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" onclick="return checkRegisterFields();" /></td>
                    </tr>
                </tfoot>
            </table>

        </form>
    </noindex>
    <script type="text/javascript">
        document.bform.USER_NAME.focus();

        function checkRegisterFields(){
            flag = true;
            if($('input[name=USER_NAME]').val() == ''){
                flag = false;
                $('input[name=USER_NAME]').css('border-color','#FF0000');
            }
            if($('input[name=USER_LAST_NAME]').val() == ''){
                flag = false;
                $('input[name=USER_LAST_NAME]').css('border-color','#FF0000');
            }
            if(isEmail($('input[name=USER_EMAIL]').val()) == false){
                flag = false;
                $('input[name=USER_EMAIL]').css('border-color','#FF0000');
            }
            if($('.reg_password').val().length < 6){
                flag = false;
                $('.reg_password').css('border-color','#FF0000');
            }
            if($('.reg_password').val() != $('.reg_confirm_password').val()){
                flag = false;
                $('.reg_confirm_password').css('border-color','#FF0000');
            }

            return flag;

        }

    </script>

    <?endif?>
</div>
