<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<script type="text/javascript">

    function fShowStore(id, showImages, formWidth, siteId)
    {
        var strUrl = '<?=$templateFolder?>' + '/map.php';
        var strUrlPost = 'delivery=' + id + '&showImages=' + showImages + '&siteId=' + siteId;

        var storeForm = new BX.CDialog({
            'title': '<?=GetMessage('SOA_ORDER_GIVE')?>',
            head: '',
            'content_url': strUrl,
            'content_post': strUrlPost,
            'width': formWidth,
            'height':450,
            'resizable':false,
            'draggable':false
        });

        var button = [
            {
                title: '<?=GetMessage('SOA_POPUP_SAVE')?>',
                id: 'crmOk',
                'action': function ()
                {
                    GetBuyerStore();
                    BX.WindowManager.Get().Close();
                }
            },
            BX.CDialog.btnCancel
        ];
        storeForm.ClearButtons();
        storeForm.SetButtons(button);
        storeForm.Show();
    }

    function GetBuyerStore()
    {
        BX('BUYER_STORE').value = BX('POPUP_STORE_ID').value;
        BX('store_desc').innerHTML = BX('POPUP_STORE_NAME').value;
        BX.show(BX('select_store'));

    }

    function showExtraParamsDialog(deliveryId)
    {
        var strUrl = '<?=$templateFolder?>' + '/delivery_extra_params.php';
        var formName = 'extra_params_form';
        var strUrlPost = 'deliveryId=' + deliveryId + '&formName=' + formName;

        if(window.BX.SaleDeliveryExtraParams)
        {
            for(var i in window.BX.SaleDeliveryExtraParams)
            {
                strUrlPost += '&'+encodeURI(i)+'='+encodeURI(window.BX.SaleDeliveryExtraParams[i]);
            }
        }

        var paramsDialog = new BX.CDialog({
            'title': '<?=GetMessage('SOA_ORDER_DELIVERY_EXTRA_PARAMS')?>',
            head: '',
            'content_url': strUrl,
            'content_post': strUrlPost,
            'width': 500,
            'height':200,
            'resizable':true,
            'draggable':false
        });

        var button = [
            {
                title: '<?=GetMessage('SOA_POPUP_SAVE')?>',
                id: 'saleDeliveryExtraParamsOk',
                'action': function ()
                {
                    insertParamsToForm(deliveryId, formName);
                    BX.WindowManager.Get().Close();
                }
            },
            BX.CDialog.btnCancel
        ];

        paramsDialog.ClearButtons();
        paramsDialog.SetButtons(button);
        paramsDialog.Show();
    }

    function insertParamsToForm(deliveryId, paramsFormName)
    {
        var orderForm = BX("ORDER_FORM"),
        paramsForm = BX(paramsFormName);
        wrapDivId = deliveryId + "_extra_params";

        var wrapDiv = BX(wrapDivId);
        window.BX.SaleDeliveryExtraParams = {};

        if(wrapDiv)
            wrapDiv.parentNode.removeChild(wrapDiv);

        wrapDiv = BX.create('div', {props: { id: wrapDivId}});

        for(var i = paramsForm.elements.length-1; i >= 0; i--)
        {
            var input = BX.create('input', {
                props: {
                    type: 'hidden',
                    name: 'DELIVERY_EXTRA['+deliveryId+']['+paramsForm.elements[i].name+']',
                    value: paramsForm.elements[i].value
                }
                }
            );

            window.BX.SaleDeliveryExtraParams[paramsForm.elements[i].name] = paramsForm.elements[i].value;

            wrapDiv.appendChild(input);
        }

        orderForm.appendChild(wrapDiv);

        BX.onCustomEvent('onSaleDeliveryGetExtraParams',[window.BX.SaleDeliveryExtraParams]);
    }

    BX.addCustomEvent('onDeliveryExtraServiceValueChange', function(){ submitForm(); });

</script>
<?   global $USER;
    //Check if order have certificate
    $isOnlyCertificate = true;
    foreach ($arResult["BASKET_ITEMS"] as $prodId => $arProd) {
        $arElement = CIBlockElement::GetByID($arProd["PRODUCT_ID"])->Fetch();
        if ($arElement["IBLOCK_SECTION_ID"] != 143){
            $isOnlyCertificate = false;
        }
    }

    
?>

<div <?if($isOnlyCertificate == true) { echo 'style="display:none;"';}?> class="grayLine"></div>
 <?//arshow($_POST,false)?>
<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult["BUYER_STORE"]?>" />
<div <?if($isOnlyCertificate == true) { echo 'style="display:none;"';}?> class="bx_section js_delivery_block">
    <?
        if(!empty($arResult["DELIVERY"]))
        {
            $width = ($arParams["SHOW_STORES_IMAGES"] == "Y") ? 850 : 700;
        ?>
        <p class="blockTitle">Способ доставки<span class="deliveriWarming">Укажите способ доставки</span></p>
        <?

            foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery) {
                if($arDelivery["ID"]!=22 && $isOnlyCertificate==true) {
                    continue;
                }
                if($arDelivery["ID"]==22 && $isOnlyCertificate!=true) {
                    continue;
                }
                if($arDelivery["ID"]==22 && $isOnlyCertificate==true) {
                    $arDelivery["CHECKED"]='Y';
                }
               /* if(stristr($_POST["ORDER_PROP_2"], 0000)) {
                    continue;
                }    */
                // если это юр лицо и вес больше 10кг, то мимо
               // if (($arDelivery["ID"] == PICKPOINT_DELIVERY_ID && !$USER->IsAdmin())) { continue; }

                // если это юр лицо и вес больше 10кг, то мимо
                if (($arDelivery["ID"] == GURU_DELIVERY_ID && !$USER->IsAdmin())
                    || ($arDelivery["ID"] == GURU_DELIVERY_ID && $arResult["USER_VALS"]['PERSON_TYPE_ID'] == LEGAL_ENTITY_PERSON_TYPE_ID && $arResult['ORDER_WEIGHT'] > GURU_LEGAL_ENTITY_MAX_WEIGHT)) { continue; }

                if($arDelivery["ISNEEDEXTRAINFO"] == "Y")
                    $extraParams = "showExtraParamsDialog('".$delivery_id."');";
                else
                    $extraParams = "";

                if (count($arDelivery["STORE"]) > 0)
                    $clickHandler = "onClick = \"fShowStore('".$arDelivery["ID"]."','".$arParams["SHOW_STORES_IMAGES"]."','".$width."','".SITE_ID."')\";";
                else
                    $clickHandler = "onClick = \"BX('ID_DELIVERY_ID_".$arDelivery["ID"]."').checked=true;".$extraParams."submitForm();\"";

            ?>
            <?/*if( ($arDelivery["ID"] == DELIVERY_COURIER_1 || $arDelivery["ID"] == DELIVERY_COURIER_2 || $arDelivery["ID"] == DELIVERY_COURIER_MKAD || $arDelivery["ID"] == DELIVERY_BOXBERRY_PICKUP) && date_deactive() ) {

            } else {*/?>
            <div class="<?if ($arDelivery["CHECKED"]=="Y") echo " check_delivery";?>">
                <?
                $arDeliv = CSaleDelivery::GetByID($arDelivery["ID"]);
                $pict = CFile::ResizeImageGet($arDeliv["LOGOTIP"], array("width" => 75, "height" => 150), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                ?>
                <input type="radio"
                    class="radioInp"
                    id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>"
                    data-city="<?=$_POST["ORDER_PROP_2"]?>"
                    name="<?=htmlspecialcharsbx($arDelivery["FIELD_NAME"])?>"
                    value="<?= $arDelivery["ID"] ?>"
                    <?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>
                    onclick="submitForm();"
                    />

                <label for="ID_DELIVERY_ID_<?=$arDelivery["ID"]?>" class="faceText">
                <?if($arDelivery["ID"] == PICKPOINT_DELIVERY_ID){  ?>
                    <?= htmlspecialcharsbx($arDelivery["OWN_NAME"])?>
                <?} else {?>
                    <?//if(stristr($arDelivery["NAME"], '(', true) != false){?>
                        <?//= htmlspecialcharsbx(stristr($arDelivery["NAME"], '(', true))?>
                    <?//} else {?>
                        <?= htmlspecialcharsbx($arDelivery["NAME"])?>
                    <?//}?>
                <?}?>-
                    <?if (($arDelivery["ID"] == PICKPOINT_DELIVERY_ID && !isset($arDelivery["PRICE"]))) {?>
                        <b class="ID_DELIVERY_ID_<?=$arDelivery["ID"]?>">
                            <?echo "Выберите местоположение";?>
                        </b>
                    <?}?>
                    <?if(isset($arDelivery["PRICE"])):?>
                        <b class="ID_DELIVERY_ID_<?=$arDelivery["ID"]?>">
                            <? if (($arDelivery["ID"] == PICKPOINT_DELIVERY_ID && empty($arDelivery['PRICE'])) || $arDelivery["ID"] == FLIPPOST_ID || $arDelivery["ID"] == GURU_DELIVERY_ID ||  $arDelivery["ID"] == BOXBERRY_PICKUP_DELIVERY_ID) {
                                echo "Выберите местоположение";
                            }  else if($arDelivery["ID"] == BOXBERY_ID){
                                echo "Введите индекс города";
                            } else { ?>
                                <?=(strlen($arDelivery["PRICE_FORMATED"]) > 0 ? $arDelivery["PRICE_FORMATED"] : number_format($arDelivery["PRICE"], 2, ',', ' '))?>
                            <? } ?>
                        </b>
                        <?
                            if ($arDelivery["PACKS_COUNT"] > 1)
                            {
                                echo '<br />';
                                echo GetMessage('SALE_SADC_PACKS').': <b>'.$arDelivery["PACKS_COUNT"].'</b>';
                            }
                            if (strlen($arDelivery["PERIOD_TEXT"])>0) {
                                if($arDelivery["LOGOTIP"]["MODULE_ID"] == 'shiptor.delivery'){
                                   $text = strripos($arDelivery["PERIOD_TEXT"], 'руб.');
                                   echo " <b>".$text."</b>"; 
                                } else {
                                   echo " <b>".$arDelivery["PERIOD_TEXT"]."</b>"; //Временно убираем 
                                }
                                
                            ?><br /><?
                            }
                        ?>
                        <?endif;?>
                </label>


                <p class="shipingText" <?=$clickHandler?>>
                    <?if (!empty($pict["src"])) {?>
                        <img src="<?=$pict["src"]?>" align="left" style="padding-right:20px;" class="no-mobile" />
                    <?}?>
                    <?
                        global $close_date;
                        global $open_date;

                        $date = date_create(date('j.n.Y'));
                        $date->modify('+1 day');
                        $new_today = $date->format('j.n.Y'); // выводим дату завтрашнего дня
                        if($arDelivery["ID"] == DELIVERY_PICKUP) {
                            if(intval(date('w') == 6)) {
                                echo str_replace('#DATE_DELIVERY#',date_day_today(1), $arDelivery["DESCRIPTION"])."<br />";
                            } elseif (intval(date('w') == 0)) {
                                echo str_replace('#DATE_DELIVERY#',date_day_today(1), $arDelivery["DESCRIPTION"])."<br />";     
                            } else {
                                if(intval(date('H')) < 17) {
                                    echo str_replace('#DATE_DELIVERY#',date_day_today(0), $arDelivery["DESCRIPTION"])."<br />";
                                } else {
                                    if(intval(date('w') == 5)) {
                                        echo str_replace('#DATE_DELIVERY#',date_day_today(3), $arDelivery["DESCRIPTION"])."<br />";  
                                    } else {
                                        echo str_replace('#DATE_DELIVERY#',date_day_today(1), $arDelivery["DESCRIPTION"])."<br />";
                                    }
                                }
                            }
                        } else if(($arDelivery["ID"] == DELIVERY_COURIER_1 || $arDelivery["ID"] == DELIVERY_COURIER_2) && !date_deactive() ) {
                            if(in_array(date('j.n.Y'), $close_date) && !in_array($new_today, $close_date) && !in_array(date('j.n.Y'), $open_date)) {
                                echo str_replace('#DATE_DELIVERY#',date_day_courier($setProps['nextDay']), $arDelivery["DESCRIPTION"])."<br />";
                            } else if(in_array($new_today, $close_date) && !in_array(date('j.n.Y'), $open_date)){
                                echo str_replace('#DATE_DELIVERY#',date_day_courier($setProps['nextDay'] + 1), $arDelivery["DESCRIPTION"])."<br />";
                            } else if(in_array(date('j.n.Y'), $open_date)){
                                echo str_replace('#DATE_DELIVERY#',date_day_courier(0), $arDelivery["DESCRIPTION"])."<br />";
                            } else {
                                if(date('H:i') <= DELIVERY_TIME){
                                    echo str_replace('#DATE_DELIVERY#',date_day_courier(0), $arDelivery["DESCRIPTION"])."<br />";
                                } else {
                                    echo str_replace('#DATE_DELIVERY#',date_day_courier($setProps['nextDay']), $arDelivery["DESCRIPTION"])."<br />";
                                }
                            }
                        } else if($arDelivery["ID"] == DELIVERY_COURIER_MKAD && !date_deactive()) {
                                echo str_replace('#DATE_DELIVERY#',date_day(1), $arDelivery["DESCRIPTION"])."<br />";
                        } else if(!date_deactive()){
                            if (strlen($arDelivery["DESCRIPTION"])>0){     
                                echo str_replace('#DATE_DELIVERY#',date_day_courier($setProps['nextDay']).' - '.date_day_courier($setProps['nextDay']+1), $arDelivery["DESCRIPTION"])."<br />";
                            }
                        } else {
                            if (strlen($arDelivery["DESCRIPTION"])>0){
                                echo str_replace('#DATE_DELIVERY#','', $arDelivery["DESCRIPTION"])."<br />";
                            }
                        }
                        ?><p class="delivery_date_shiptor"><?
                        if($arDelivery["LOGOTIP"]["MODULE_ID"] == 'shiptor.delivery'){
                            $date_delivery_shiptor = preg_replace('~\D+~','',explode('руб.', $arDelivery["PERIOD_TEXT"])[0]); 
                            if($date_delivery_shiptor){
                                echo GetMessage('BOXBERRY_ERROR').' '.date_day_today($date_delivery_shiptor);
                            }
                        }
                        ?></p><?
      
                        if (count($arDelivery["STORE"]) > 0):
                        ?>
                        <span id="select_store"<?if(strlen($arResult["STORE_LIST"][$arResult["BUYER_STORE"]]["TITLE"]) <= 0) echo " style=\"display:none;\"";?>>
                            <span class="select_store"><?=GetMessage('SOA_ORDER_GIVE_TITLE');?>: </span>
                            <span class="ora-store" id="store_desc"><?=htmlspecialcharsbx($arResult["STORE_LIST"][$arResult["BUYER_STORE"]]["TITLE"])?></span>
                        </span>
                        <?
                        endif;
                    ?>
                </p>

                <?if ($arDelivery['CHECKED'] == 'Y'):?>
                    <table class="delivery_extra_services">
                        <?foreach ($arDelivery['EXTRA_SERVICES'] as $extraServiceId => $extraService):?>
                            <?if(!$extraService->canUserEditValue()) continue;?>
                            <tr>
                                <td class="name">
                                    <?=$extraService->getName()?>
                                </td>
                                <td class="control">
                                    <?=$extraService->getEditControl('DELIVERY_EXTRA_SERVICES['.$arDelivery['ID'].']['.$extraServiceId.']')    ?>
                                </td>
                                <td rowspan="2" class="price">
                                    <?

                                        if ($price = $extraService->getPrice()) {
                                            echo GetMessage('SOA_TEMPL_SUM_PRICE').': ';
                                            echo '<strong>'.SaleFormatCurrency($price, $arResult['BASE_LANG_CURRENCY']).'</strong>';
                                        }

                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="description">
                                    <?=$extraService->getDescription()?>
                                </td>
                            </tr>
                            <?endforeach?>
                    </table>
                    <?endif?>

                <?  if ($delivery_id =="21") { ?>
                    <div id="IML_PVZ"></div>
                    <? } ?>

                <? if ($arDelivery["ID"] == FLIPPOST_ID) { ?>
                    <div class="flippostSelectContainer">

                    </div>
                    <div class="flippost_error"><?= GetMessage('FLIPPOST_SELECT_EMPTY') ?></div>
                    <div id="flippost_delivery_time" class="flippost_delivery_time"><?= GetMessage("FLIPPOST_DELIVERY_TIME")?>: <span></span></div>
                    <input type="hidden" id="flippost_address" name="flippost_address" value="">
                    <input type="hidden" id="flippost_cost" name="flippost_cost" value="">
                <? } ?>

                <? if ($arDelivery["ID"] == BOXBERY_ID && $USER->IsAdmin()) { ?>
                    <div class="boxberySelectContainer">

                    </div>
                    <div class="boxbery_error"><?= GetMessage('BOXBERY_SELECT_EMPTY') ?></div>
                    <?if(empty($_SESSION["DATE_DELIVERY_STATE"])){?>
                        <?if($arDelivery["ID"] == BOXBERY_ID){ ?>
                            <div id="boxbery_delivery_time delivery_date" class="boxbery_delivery_time"> <span></span></div>
                        <?} else {?>
                            <div id="boxbery_delivery_time delivery_date" class="boxbery_delivery_time"><?= GetMessage("FLIPPOST_DELIVERY_TIME")?>: <span></span></div>
                        <?}?>
                    <?}?>
                    <input type="hidden" id="boxbery_address" name="boxbery_address" value="">
                    <input type="hidden" id="boxbery_cost" name="boxbery_cost" value="">
                    <input type="hidden" id="boxbery_price" name="boxbery_price" value="">
                <? } ?>

                <? if ($arDelivery["ID"] == GURU_DELIVERY_ID && $USER->IsAdmin()) { ?>
                    <div class="guru_delivery_wrapper">
                        <div class="guru_error"><?= GetMessage('GURU_ERROR') ?></div>
                        <b><?= GetMessage('SEARCH_ON_MAP') ?></b>
                        <br><span id="close_map" style="position:fixed; top:-2000px; cursor:pointer; z-index:999; right:75px; background:#cccccc; display:inline-block; padding:2px 4px; padding-bottom:4px; text-decoration:underline;">закрыть</span>
                        <span style="cursor:pointer; display:block; text-decoration:underline;" class="message-map-link"><?= GetMessage('CHOSE_ON_MAP') ?></span>
                        <div id="YMapsID"></div>
                        <div class="guru_point_addr"></div>
                        <?if(empty($_SESSION["DATE_DELIVERY_STATE"])){?>
                            <div id="guru_delivery_time" class="guru_delivery_time delivery_date"><?= GetMessage("GURU_DELIVERY_TIME")?>: <span></span></div>
                        <?}?>
                        <input type="hidden" id="guru_delivery_data" name="guru_delivery_data" value="">
                        <input type="hidden" id="guru_cost" name="guru_cost" value="">
                        <input type="hidden" id="guru_selected" name="guru_selected" value="">
                    </div>
                <? } ?>
                <? if ($arDelivery["ID"] == BOXBERRY_PICKUP_DELIVERY_ID) { ?>
                    <div class="boxberry_delivery_wrapper">
                        <div class="boxberry_error delivery_date"><?= GetMessage('BOXBERRY_ERROR') ?></div>
                        <a href="#" class="message-map-link" style="cursor: pointer; display: block;  text-decoration: underline; color:#000;" onclick="boxberry.open('boxberry_callback', '<?= BOXBERRY_TOKEN_API?>', 'Москва', '68', <?= $arResult['ORDER_DATA']['ORDER_PRICE']?>, <?= $arResult['ORDER_DATA']['ORDER_WEIGHT']?>, 0, 50, 50, 50); return false"><?= GetMessage('CHOSE_ON_MAP') ?></a>
                        <div class="boxberry_point_addr"></div>
                        <?if(empty($_SESSION["DATE_DELIVERY_STATE"])){?>
                            <div id="boxberry_delivery_time" class="boxberry_delivery_time delivery_date"><?= GetMessage("GURU_DELIVERY_TIME")?>: <span></span></div>
                        <?}?>
                        <input type="hidden" id="boxberry_delivery_data" name="boxberry_delivery_data" value="">
                        <input type="hidden" id="boxberry_cost" name="boxberry_cost" value="">
                        <input type="hidden" id="boxberry_selected" name="boxberry_selected" value="">
                    </div>
                <? } ?>

                <div class="clear"></div>
            </div>
            <?//}?>
            <?
            }
        }
    ?>

</div>