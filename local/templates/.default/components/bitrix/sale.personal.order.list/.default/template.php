<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!empty($arResult['ERRORS']['FATAL'])):?>

    <?foreach($arResult['ERRORS']['FATAL'] as $error):?>
        <?//=ShowError($error)?>
    <?endforeach?>

    <?$component = $this->__component;?>
    <?if($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])):?>
        <?$APPLICATION->AuthForm('', false, false, 'N', false);?>
    <?endif?>

<?else:?>

    <?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

        <?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
            <?=ShowError($error)?>
        <?endforeach?>

    <?endif?>
</section>
</div>
    <div class="orderHistorWrap">
    <p class="personal_title"><?echo $APPLICATION->GetTitle();?></p>

    <div class="historyWrap">
     <?

        $key = 0;

        if (!empty($arResult["ORDERS"])) {
        ?>
        <div class="tableTitle">
            <p class="numbTitle"><?= GetMessage("NUMBER"); ?></p>
            <p class="dateTitle"><?= GetMessage("DATE"); ?></p>
            <p class="quantTitle"><?= GetMessage("QUANTITY"); ?></p>
            <p class="statTitle"><?= GetMessage("STATUS"); ?></p>
            <p class="quantTitle"><?= GetMessage("SALE"); ?></p>
            <p class="sumTitle"><?= GetMessage("SUMM"); ?></p>
        </div>
            <?
            foreach ($arResult["ORDERS"] as $k => $order) {

                if($_SERVER["HTTP_X_REAL_IP"] == "91.201.253.5") {
                    if ($k > 10) {
                        die();
                    }
                }

                $quantity = 0;

                //Р•СЃР»Рё Сѓ РЅР°СЃ РїСЂРµРґР·Р°РєР°Р·, С‚Рѕ СЂР°Р·СЂРµС€РёРј РІС‹РІРѕРґ РёРЅС„РѕСЂРјР°С†РёРё Рѕ СЃСЂРѕРєР°С… РІС‹С…РѕРґР° РєРЅРёРіРё
                if(count($order["BASKET_ITEMS"]) == 1) {
                    $basketItem = $order["BASKET_ITEMS"];
                    $basketItem = array_pop($basketItem);
                    $itemID = $basketItem["PRODUCT_ID"];

                    $preOrder = '';
                    $res = CIBlockElement::GetList(Array(), Array("ID" => IntVal($itemID)), false, Array(), Array("ID", "PROPERTY_SOON_DATE_TIME", "PROPERTY_STATE"));
                    if($arFields = $res->Fetch()) {
                        if(intval($arFields["PROPERTY_STATE_ENUM_ID"]) == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "soon")){
                            $preOrder = 'Y';
                        }
                    }
                };

                foreach ($order["BASKET_ITEMS"] as $order_key => $arBaskItem) {
                    $quantity += round($arBaskItem["QUANTITY"]);
                }

                $key++;

                ?>
                <div class="orderNumbLine">
                    <p class="ordTitle" data-id="<?= $key ?>"><span><?= GetMessage("SPOL_ORDER") . " " . GetMessage("SPOL_NUM_SIGN") . $order["ORDER"]["ID"] ?></span></p>
                    <p class="ordDate"><?= $order["ORDER"]["DATE_INSERT_FORMATED"] ?></p>
                    <p class="ordQuant"><?= $quantity ?></p>
                    <p class="ordStatus"><?= $arResult["INFO"]["STATUS"][$order["ORDER"]["STATUS_ID"]]["NAME"] ?></p>
                    <p class="ordSum"><span><?= ceil($order["ORDER"]["PRICE"]) ?> </span><?= GetMessage("ROUBLES") ?></p>
                </div>
                <div class="hiddenOrderInf hidOrdInfo<?= $key ?>">
                    <div class="infoAddrWrap">
                        <div>
                            <p class="dopInfoTitle firstCol"><?= GetMessage("CUSTOMER_INFO") ?></p>
                            <p class="dopInfoText"><?= $arResult["USER_INFO"][$order["ORDER"]["USER_ID"]]["LAST_NAME"] . " " . $arResult["USER_INFO"][$order["ORDER"]["USER_ID"]]["NAME"] . " " . $arResult["USER_INFO"][$order["ORDER"]["USER_ID"]]["SECOND_NAME"] ?></p>
                            <p class="dopInfoText"><?= $arResult["USER_INFO"][$order["ORDER"]["USER_ID"]]["PERSONAL_PHONE"] ?></p>
                            <p class="dopInfoText"><?= $arResult["USER_INFO"][$order["ORDER"]["USER_ID"]]["EMAIL"] ?></p>
                            <p class="dopInfoTitle thiCol"><?= GetMessage("DELIVERY_ADDR") ?></p>
							<?if ($order["ORDER"]["DELIVERY_ID"] == PICKPOINT_DELIVERY_ID) {
								$db_props = CSaleOrderPropsValue::GetOrderProps($order["ORDER"]["ID"]);
								while ($arProps = $db_props->Fetch()) {
									if ($arProps['CODE']=='ADRESS_PICKPOINT') {
										$PickPointAddress = explode("<br>", $arProps['VALUE']);
										$PickPointAddress = $PickPointAddress[0].'<br />'.$PickPointAddress[1];?>
										<p class="dopInfoText"><?=$PickPointAddress?></p>
									<?}
								}
							} else {?>
								<?if($arResult["ORDER_INFO"][$order["ORDER"]["ID"]]["DELIVERY_CITY"]) {?>
                                <??>
                                    <div style="font-size: 14px;">
                                    <? if($order["ORDER"]["DELIVERY_ID"]== DELIVERY_MAIL || $order["ORDER"]["DELIVERY_ID"] == DELIVERY_MAIL_2 || $order["ORDER"]["DELIVERY_ID"] == DELIVERY_MAIL_3 || $order["ORDER"]["DELIVERY_ID"] == DELIVERY_MAIL_4){
                                            $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $order["ORDER"]["ID"], "CODE" => array("INDEX", "CITY_DELIVERY")));
                                            while ($arVals = $db_vals -> Fetch()) {
                                                if(!empty($arVals["VALUE"])){
                                                    $adress .=  " ".$arVals['NAME'].": ".$arVals["VALUE"]."<br>";
                                                }
                                            }
                                            $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $order["ORDER"]["ID"], "CODE" => array("COUNTRY_DELIVERY", "COUNTRY", "CITY", "STREET", "HOUSE")));
                                            while ($arVals = $db_vals -> Fetch()) {
                                                if(!empty($arVals["VALUE"])){
                                                    $adress .=  " ".$arVals['NAME'].": ".$arVals["VALUE"]."<br>";
                                                }
                                            }
                                            echo $adress;
                                        } else { ?>
                                            <p class="dopInfoText"><?= GetMessage("CITY") ?><?= $arResult["ORDER_INFO"][$order["ORDER"]["ID"]]["DELIVERY_CITY"]["CITY_NAME"] ?></p>
                                       <? }
                                    ?>
                                    </div>
								<?}?>
								<p class="dopInfoText"><?= $arResult["ORDER_INFO"][$order["ORDER"]["ID"]]["DELIVERY_ADDR"] ?></p>
							<?}?>
                            <p class="dopInfoTitle thiCol"><?= GetMessage("PHONE") ?></p>
                            <p class="dopInfoText"><?= $arResult["ORDER_INFO"][$order["ORDER"]["ID"]]["ORDER_PHONE"] ?></p>
                        </div>
                        <div>
                            <p class="dopInfoTitle"><?= GetMessage("DELIVERY_TYPE") ?></p>
                            <p class="dopInfoText"><?= $arResult["INFO"]["DELIVERY"][$order["ORDER"]["DELIVERY_ID"]]["NAME"] ?></p>
                            <p class="dopInfoTitle thiCol"<?if($order["ORDER"]['STATUS_ID'] == PREORDER_STATUS_ID) { echo 'style="display:none"'; }?>><?= GetMessage("SPOL_PAYSYSTEM") ?></p> <!--РєР»Р°СЃСЃ РѕС‚СЃС‚СѓРїР° СЃРІРµСЂС…Сѓ -->

                            <p class="dopInfoText" <?if($order["ORDER"]['STATUS_ID'] == PREORDER_STATUS_ID) { echo 'style="display:none"'; }?>>
                                <?if (in_array($order["ORDER"]["PAY_SYSTEM_ID"], array(RFI_PAYSYSTEM_ID, SBERBANK_PAYSYSTEM_ID)) && $order["ORDER"]["PAYED"] != "Y" ){?>
                                    <a href="/personal/order/payment/?ORDER_ID=<?=$order["ORDER"]["ID"]?>"><?= $arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"] ?></a>
                                <?} else {?>
                                    <?= $arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"] ?>
                                <?}?></p>
                            <?if ($order["ORDER"]["DELIVERY_ID"] == PICKPOINT_DELIVERY_ID) {?>
                                <p class="dopInfoTitle thiCol"><?= GetMessage("DELIVERY_DATE") ?></p> <!--РєР»Р°СЃСЃ РѕС‚СЃС‚СѓРїР° СЃРІРµСЂС…Сѓ -->
                                <p class="dopInfoText"><?= CustomPickPoint::getDeliveryDate($order["ORDER"]["ID"]) ?></p>
                                <?}?>
                            <?if (in_array($order["ORDER"]["PAY_SYSTEM_ID"], array(RFI_PAYSYSTEM_ID, SBERBANK_PAYSYSTEM_ID))) {
                                ?>
                                <?if($order["ORDER"]["DELIVERY_ID"] == DELIVERY_MAIL ||
                                    $order["ORDER"]["DELIVERY_ID"] == DELIVERY_MAIL_2 ||
                                    $order["ORDER"]["DELIVERY_ID"] == DELIVERY_PICK_POINT ||
                                    $order["ORDER"]["DELIVERY_ID"] == DELIVERY_FLIPOST ||
                                    $order["ORDER"]["DELIVERY_ID"] == BOXBERRY_PICKUP_DELIVERY_ID) {?>

                                   <?
                                    $origin_identifier = \Bitrix\Sale\Order::load($order["ORDER"]["ID"]);

                                    /** @var \Bitrix\Sale\ShipmentCollection $shipmentCollection */
                                    $shipmentCollection = $origin_identifier->getShipmentCollection();
                                    foreach ($shipmentCollection as $shipment) {
                                    if($shipment->isSystem())
                                        continue;
                                        $track = $shipment->getField('TRACKING_NUMBER');
                                    }?>
                                    <?if($order["ORDER"]["DELIVERY_ID"] == DELIVERY_MAIL || $order["ORDER"]["DELIVERY_ID"] == DELIVERY_MAIL_2) {?>
                                        <p class="dopInfoTitle thiCol"><?= GetMessage("TRACK_NUMBER") ?></p>
                                        <p class="dopInfoText"><?=GetMessage("TRACK_NUMBER_MAIL", Array ("#TRACK#" => $track));?></p>
                                    <?}elseif($order["ORDER"]["DELIVERY_ID"] == DELIVERY_PICK_POINT && $arResult["INFO"]["STATUS"][$order["ORDER"]["STATUS_ID"]]["ID"] == "I"){?>
                                        <p class="dopInfoTitle thiCol"><?= GetMessage("TRACK_MESSAGE_PICK_POINT") ?></p>
                                        <p class="dopInfoText"><?=GetMessage("TRACK_NUMBER_PICK_POINT") ?></p>
                                    <?}elseif($order["ORDER"]["DELIVERY_ID"] == DELIVERY_FLIPOST && $arResult["INFO"]["STATUS"][$order["ORDER"]["STATUS_ID"]]["ID"] == "I" && !empty($track)){?>
                                        <p class="dopInfoTitle thiCol"><?= GetMessage("TRACK_MESSAGE_PICK_POINT") ?></p>
                                        <p class="dopInfoText"><?=GetMessage("TRACK_NUMBER_FLIPOST") ?></p>
                                    <?}elseif(empty($track) && $order["ORDER"]["DELIVERY_ID"] == DELIVERY_MAIL || $order["ORDER"]["DELIVERY_ID"] == DELIVERY_MAIL_2){?>
                                        <p class="dopInfoTitle thiCol"><?= GetMessage("TRACK_NUMBER") ?></p>
                                        <p class="dopInfoText"><?echo GetMessage("TRACK_NUMBER_NULL");?></p>
                                    <?}elseif($order["ORDER"]["DELIVERY_ID"] == DELIVERY_PICK_POINT || $order["ORDER"]["DELIVERY_ID"] == DELIVERY_FLIPOST && $arResult["INFO"]["STATUS"][$order["ORDER"]["STATUS_ID"]]["ID"] != "I") {?>
                                        <p class="dopInfoTitle thiCol"><?= GetMessage("TRACK_MESSAGE_PICK_POINT") ?></p>
                                        <p class="dopInfoText"><?=GetMessage("TRACK_MESSAGE_PICK_POINT_NULL");?></p>
                                     <?}elseif($order["ORDER"]["DELIVERY_ID"] == BOXBERRY_PICKUP_DELIVERY_ID  && !empty($track)) {?>
                                        <p class="dopInfoTitle thiCol"><?= GetMessage("TRACK_NUMBER") ?></p>
                                        <p class="dopInfoText"><?=GetMessage("TRACK_NUMBER_BOXBERRY", Array ("#TRACK#" => $track));?></p>
                                     <?}?>
                                <?}?>

                            <?}?>
                        </div>
                        <? if ($order["ORDER"]["DELIVERY_ID"] == PICKPOINT_DELIVERY_ID) {?>
                            <div class="issuing_ordering_items">
                                <p class="dopInfoTitle"><?= GetMessage("PVZ") ?></p>
                                <p class="dopInfoText"><?= $order["ORDER"]["USER_DESCRIPTION"] ?></p>
                            </div>
                        <?}?>
                    </div>
                    <div>
                        <p class="ordBooksTitle"><?= GetMessage("SPOL_ORDER_DETAIL") ?></p>
                        <table class="orderBooks">
                            <?foreach ($order["BASKET_ITEMS"] as $arBaskItem) {
                                $discount_price = round(($arBaskItem["DISCOUNT_PRICE"] * 100) / $arBaskItem["BASE_PRICE"]);

                                ?>
                                <tr>
                                    <td class="infoTextTab infBookName"><a href="<?=$arBaskItem["DETAIL_PAGE_URL"]?>"><?= $arBaskItem["NAME"] ?></a></td>
                                    <td class="infoQuant"><?= $arBaskItem["QUANTITY"] ?></td>
                                    <td class="infoSoonDate">
                                        <?if ($preOrder == 'Y') {?>
                                            <?= GetMessage("SOON_DATE") ?><br><div><?= strtolower(FormatDate("j F", MakeTimeStamp($arFields['PROPERTY_SOON_DATE_TIME_VALUE'], "DD.MM.YYYY HH:MI:SS"))); ?></div>
                                        <?}?>
                                    </td>
                                    <td class="infosale">
                                        <?if ($discount_price > 0) {?>
                                            <?=$discount_price?><?=GetMessage('PROCENT')?>
                                        <?}?>
                                    </td>
                                    <td class="infoPriceTd"><?= ceil($arBaskItem["PRICE"]) * $arBaskItem["QUANTITY"] ?> <?= GetMessage("ROUBLES") ?></td>
                                </tr>
                            <?}?>
                            <?if (intval($order["ORDER"]["PRICE_DELIVERY"]) > 0) {?>
                                <tr>
                                    <td class="infoTextTab infBookName"><?= GetMessage("SPOL_DELIVERY") ?></td>
                                    <td class="infoQuant"></td>
                                    <td class="infoSoonDate"></td>
                                    <td class="infosale"></td>
                                    <td class="infoPriceTd"><?= ceil($order["ORDER"]["PRICE_DELIVERY"]) ?> <?= GetMessage("ROUBLES") ?></td>
                                </tr>
                            <?}?>
                            <tr>
                                <td class="infoTextTab"><?= GetMessage("FINAL_SUMM") ?></td>
                                <td class="infoQuant"></td>
                                <td class="infoSoonDate"></td>
                                <td class="infosale"></td>
                                <td class="infoPriceTd"><?= ceil($order["ORDER"]["PRICE"]) ?> <?= GetMessage("ROUBLES") ?></td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <?/*<p class="orderCancel"><a href="<?= $order["ORDER"]["URL_TO_CANCEL"] ?>"><?= GetMessage("SPOL_CANCEL_ORDER") ?></a></p> */// РЈР±РёСЂР°РµРј РєРЅРѕРїРєСѓ РѕС‚РјРµРЅС‹ Р·Р°РєР°Р·Р°?>
                    </div>
                </div>
            <?}
        }?>

    </div>
    </div>
<?endif?>

<script>
$(document).ready(function() {
    $(".tableTitle").next(".orderNumbLine").addClass("active");
    $(".tableTitle").next(".orderNumbLine").next(".hiddenOrderInf").css("display", "block");

    if ($(".issuing_ordering_items").size() > 0) {
       // $(".infoAddrWrap").css("height", "300px");
    }
});
</script>