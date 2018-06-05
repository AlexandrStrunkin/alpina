<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="section">
    <script type="text/javascript">
        function changePaySystem(param)
        {
            if (BX("account_only") && BX("account_only").value == 'Y') // PAY_CURRENT_ACCOUNT checkbox should act as radio
            {
                if (param == 'account')
                {
                    if (BX("PAY_CURRENT_ACCOUNT"))
                    {
                        BX("PAY_CURRENT_ACCOUNT").checked = true;
                        BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
                        BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');

                        // deselect all other
                        var el = document.getElementsByName("PAY_SYSTEM_ID");
                        for(var i=0; i<el.length; i++)
                            el[i].checked = false;
                    }
                }
                else
                {
                    BX("PAY_CURRENT_ACCOUNT").checked = false;
                    BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
                    BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
                }
            }
            else if (BX("account_only") && BX("account_only").value == 'N')
            {
                if (param == 'account')
                {
                    if (BX("PAY_CURRENT_ACCOUNT"))
                    {
                        BX("PAY_CURRENT_ACCOUNT").checked = !BX("PAY_CURRENT_ACCOUNT").checked;

                        if (BX("PAY_CURRENT_ACCOUNT").checked)
                        {
                            BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
                            BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
                        }
                        else
                        {
                            BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
                            BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
                        }
                    }
                }
            }

            submitForm();
        }
    </script>
    <?global $USER?>
    <div class="grayLine"></div>
    <?if($arResult['ORDER_DATA']['DELIVERY_LOCATION'] == MOSCOW_LOCATION_ID);?>
    <div class="bx_section">
        <p class="blockTitle">Способ оплаты</p>                                                                                                                                                                                                            
        <?
            uasort($arResult["PAY_SYSTEM"], "cmpBySort"); // resort arrays according to SORT value
            foreach($arResult["PAY_SYSTEM"] as $arPaySystem) {   
                $delivery_state = "Y";
                if ( $_SESSION["DATE_DELIVERY_STATE"] && ($arPaySystem["ID"] == CASHLESS_PAYSYSTEM_ID || $arPaySystem["ID"] == RFI_PAYSYSTEM_ID || $arPaySystem["ID"] == SBERBANK_PAYSYSTEM_ID ) ) { 
                    $delivery_state = "Y";
                } else if ( $_SESSION["DATE_DELIVERY_STATE"] ) {
                    $delivery_state = "";
                }
                if( $delivery_state ) { 
                //Убираем PayPal для Москвы и МО
                if ((strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) > 0 || intval($arPaySystem["PRICE"]) > 0) && !($arResult['ORDER_DATA']['DELIVERY_LOCATION'] == MOSCOW_LOCATION_ID && $arPaySystem['ID'] == PAYPAL_PAYSYSTEM_ID) ) {
                    $arPay = CSaleDelivery::GetByID($arPaySystem["ID"]);
                    $pict = CFile::ResizeImageGet($arPaySystem["PSA_LOGOTIP"]["ID"], array("width" => 100, "height" => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
                <?if($arPaySystem["PAY_SYSTEM_ID"] == PLATBOX_PAYSISTEM_ID && $USER->IsAdmin()){?>
                    <div>
                    <input type="radio"
                        class="radioInp"
                        id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
                        name="PAY_SYSTEM_ID"
                        value="<?=$arPaySystem["ID"]?>"
                        <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
                        onclick="changePaySystem();" />
                    <label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();" class="faceText">
                        <?=$arPaySystem["PSA_NAME"];?>
                    </label>

                    <p class="shipingText">
                        <?if (!empty($pict["src"])) {?>
                            <img src="<?=$pict["src"]?>" align="left" style="padding-right:20px;" class="no-mobile" />
                        <?}?>
                        <?
                            if (intval($arPaySystem["PRICE"]) > 0)
                                echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
                            else
                                echo $arPaySystem["DESCRIPTION"];
                        ?>
                    </p>
                    <div class="clear"></div>
                    </div>              
                <?} else if($arPaySystem["PAY_SYSTEM_ID"] != PLATBOX_PAYSISTEM_ID){ ?>
               
                    <div>
                    <input type="radio"
                        class="radioInp"
                        id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
                        name="PAY_SYSTEM_ID"
                        value="<?=$arPaySystem["ID"]?>"
                        <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
                        onclick="changePaySystem();" />
                    <label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();" class="faceText">
                        <?=$arPaySystem["PSA_NAME"];?>
                    </label>

                    <p class="shipingText">
                        <?if (!empty($pict["src"])) {?>
                            <img src="<?=$pict["src"]?>" align="left" style="padding-right:20px;" class="no-mobile" />
                        <?}?>
                        <?
                            if (intval($arPaySystem["PRICE"]) > 0)
                                echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
                            else
                                echo $arPaySystem["DESCRIPTION"];
                        ?>
                    </p>
                    <div class="clear"></div>
                    </div>
                  <?}?>
                <?
                    //варианты оплаты для электронных платежей
                    if($arPaySystem['ID'] == RFI_PAYSYSTEM_ID && $arResult["USER_VALS"]['PAY_SYSTEM_ID'] == RFI_PAYSYSTEM_ID){?>
                    <ul class="rfi_bank_vars">
                        <li data-rfi-payment="wm">WebMoney</li>
                        <li data-rfi-payment="ym">Яндекс деньги</li>
                        <li data-rfi-payment="qiwi">QIWI</li>
                        <li data-rfi-payment="spg">Visa/Mastercard</li>
                        <li data-rfi-payment="mc">Мобильный платеж</li>
                    </ul>
                    <? /*if ($arResult["UF_RECURRENT_ID"]) { ?>
                        <ul class="recurrent_tabs">
                            <li class="active_recurrent_tab" data-rfi-recurrent-type="new"><?= GetMessage("RFI_RECURRENT_NEW_CARD") ?></li>
                            <li data-rfi-recurrent-type="next"><?= $arResult["UF_RECURRENT_CARD_ID"] ?></li>
                            <li><?= GetMessage("RFI_RECURRENT_DESCRIPTION") ?></li>
                        </ul>
                        <? }*/ ?>
                    <?}?>
                <?}
               // arshow($USER->IsAdmin());
                if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) == 0 && intval($arPaySystem["PRICE"]) == 0 && (!$USER->IsAdmin() && $arPaySystem["PAY_SYSTEM_ID"] == PLATBOX_PAYSISTEM_ID))
                {?>
                    <div>
                    <?if (count($arResult["PAY_SYSTEM"]) == 1)
                    {
                    ?>
                    <input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
                    <input type="radio"
                        class="radioInp"
                        id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
                        name="PAY_SYSTEM_ID"
                        value="<?=$arPaySystem["ID"]?>"
                        <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
                        onclick="changePaySystem();"
                        />
                    <label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();" class="faceText">
                        <?=$arPaySystem["PSA_NAME"];?>
                    </label>
                    <div class="clear"></div>
                    <?
                    }
                    else // more than one
                    {
                    ?>
                    <input type="radio"
                        class="radioInp"
                        id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
                        name="PAY_SYSTEM_ID"
                        value="<?=$arPaySystem["ID"]?>"
                        <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
                        onclick="changePaySystem();" />

                    <label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();" class="faceText">
                        <?=$arPaySystem["PSA_NAME"];?>
                    </label>

                    <?
                    }?>
                    </div>
                <?}
            }
            }
        ?>
    </div>
</div>