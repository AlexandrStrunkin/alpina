<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    if ($_REQUEST["ORDER_ID"]) {?>
    <style>
        .orderBody {
            background-color: #f4f4f4;
        }
    </style>
    <?}?>

<?
    if (!empty($arResult["ORDER"]) ) {
    ?>
    <?
        //получаем значение свойств из заказа
        $orderProps = CSaleOrderPropsValue::GetList(array(),array("ORDER_ID"=>$arResult["ORDER"]["ID"]), false, false, array());
        while ($arOrderProps = $orderProps->Fetch()) {
            $arResult["ORDER_PROPS"][$arOrderProps["CODE"]] = $arOrderProps;
        } if ($arResult["ORDER_PROPS"]["F_CONTACT_PERSON"]["VALUE"]) {
            $userName = $arResult["ORDER_PROPS"]["F_CONTACT_PERSON"]["VALUE"]; //для физлица
            $phone_val = $arResult["ORDER_PROPS"]["PHONE"]["VALUE"];
        } else {
            $userName = $arResult["ORDER_PROPS"]["F_COMPANY_NAME"]["VALUE"];
            $phone_val = $arResult["ORDER_PROPS"]["F_PHONE"]["VALUE"]; //для юрлица
        }
    ?>
    <?
        $arName = explode( " ", $userName);
        if (count($arName)==2) {
            $name=$arName[0];
            $last_name=$arName[1];
        } else {
            $name=$arName[0];
            $last_name=$arResult["ORDER"]["USER_LAST_NAME"];
        }
    ?>
    <?
        foreach ($_SESSION["CATALOG_USER_COUPONS"] as $coupon) {
            $couponStr.=$coupon;
            if (count($_SESSION["CATALOG_USER_COUPONS"])>1) {
                $couponStr.=', ';
            }
        }

		$orderedBooks = '<div class="orderedBooks">';
        $dbItemsInOrder = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $arResult["ORDER"]["ID"]));
        while ($arItems = $dbItemsInOrder->Fetch()) {
			//$pict = CFile::ResizeImageGet($arItems["DETAIL_PICTURE"], array("width" => 140, "height" => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$orderedBooks .= "<div class='bookRow'>";
			$orderedBooks .= "<a href='https://www.alpinabook.ru".$arItems["DETAIL_PAGE_URL"]."'>";
			//$orderedBooks .= "<div class='bookImg'><img src=".$pict." /></div>";
			$orderedBooks .= "<div class='bookTitle'>".$arItems['NAME']."</div>";
			$orderedBooks .= "<div class='bookQuantity'>".$arItems['QUANTITY']."</div>";
			$orderedBooks .= "<div class='bookPrice'>".$arItems['PRICE']."</div>";
			$orderedBooks .= "</a>";
			$orderedBooks .= "</div>";
        }
		$orderedBooks .= "</div>";
    ?>

    <script type="text/javascript" src="https://www.gdeslon.ru/landing.js?mode=basket&amp;codes=<?=substr($gdeslon,0,-1)?>&amp;mid=79276" async></script>
    <?if (!empty($_SESSION['gtmEnchECommerceCheckout'])) {?>
        <!--Criteo-->
        <script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
        <script type="text/javascript">
            window.criteo_q = window.criteo_q || [];
            window.criteo_q.push(
                { event: "setAccount", account: 18519 },
                <?if($USER->IsAuthorized()){?>
                    { event: "setEmail", email: "<?=$USER->GetEmail()?>" },
                    <?}?>
                { event: "setSiteType", type: "d" },
                { event: "trackTransaction", id: <?=$arResult["ORDER"]["ID"]?>, item: <?=$_SESSION['criteo']?>}
            );
        </script>


        <!--google eCommerce-->
        <?/* Enhanced Ecommerce новый код 2016.05.23 для поля category и coupon */?>
        <script>
            dataLayer.push({
                'ecommerce': {
                    'purchase': {
                        'actionField': {
                            'id': '<?=$arResult["ORDER"]["ID"]?>',                         // Transaction ID. Required for purchases and refunds.
                            'affiliation': 'Alpinabook',
                            'revenue': '<?=$arResult['ORDER']['PRICE']?>',                     // Total transaction value (incl. tax and shipping)
                            'tax':'<?=$arResult['ORDER']['TAX_VALUE']?>',
                            'shipping': '<?=$arResult['ORDER']['PRICE_DELIVERY']?>',
                            'coupon': '<?=$couponStr?>'
                        },
                        'products': [
                            <?foreach($_SESSION['gtmEnchECommerceCheckout'] as $gtmEnchECommerceCheckout){?>
                                {
                                    <?=$gtmEnchECommerceCheckout?>
                                },
                                <?}?>
                        ]
                    }
                },
                'discountPerc': '<?=$_SESSION['EMAIL_DISCOUNT_PERCENT_MED']?>',
                'discountRUB': '<?=substr($_SESSION['EMAIL_DISCOUNT_SUM_TOTAL'],0,-5)?>'
            });
        </script>

		<!-- Admitad.com -->
		<script type="text/javascript">
			(function (d, w) {
				w._admitadPixel = {
					response_type: 'img',
					action_code: '1',
					campaign_code: 'c4ab8a6bed'
				};
				w._admitadPositions = w._admitadPositions || [];
				<?foreach($_SESSION['itemsForAdmitad'] as $itemForAdmitad) {?>
					w._admitadPositions.push({
						<?=$itemForAdmitad?>
						order_id: '<?=$arResult["ORDER"]["ID"]?>'
					});
				<?}?>
				var id = '_admitad-pixel';
				if (d.getElementById(id)) { return; }
				var s = d.createElement('script');
				s.id = id;
				var r = (new Date).getTime();
				var protocol = (d.location.protocol === 'https:' ? 'https:' : 'http:');
				s.src = protocol + '//cdn.asbmit.com/static/js/npixel.js?r=' + r;
				var head = d.getElementsByTagName('head')[0];
				head.appendChild(s);
			})(document, window)
		</script>

        <?//получаем email из заказа. у физлиц будет EMAIL, у юрлиц F_EMAIL
			$userEmail = Message::getClientEmail($arResult["ORDER"]["ID"]);
        ?>


        <!-- Facebook Conversion Code for Оформление заказов - Альпина 1 -->
        <script>
        (function() {
                var _fbq = window._fbq || (window._fbq = []);
                if (!_fbq.loaded) {
                    var fbds = document.createElement('script');
                    fbds.async = true;
                    fbds.src = '//connect.facebook.net/en_US/fbds.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(fbds, s);
                    _fbq.loaded = true;
                }
            })();
            window._fbq = window._fbq || [];
            window._fbq.push(['track', '6027030777492', {'value':'<?=$arResult['ORDER']['PRICE']?>','currency':'RUB'}]);
        </script>
        <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6027030777492&amp;cd[value]=<?=$arResult['ORDER']['PRICE']?>&amp;cd[currency]=RUB&amp;noscript=1" /></noscript>


        <script type="text/javascript">
            window.flocktory = window.flocktory || [];
            window.flocktory.push(['postcheckout', {
                user: {
                    name: '<?=$userName?>',
                    email: '<?=$userEmail?>',
                },
                order: {
                    id: '<?=$arResult["ORDER"]["ID"]?>',
                    price: <?=$arResult["ORDER"]["PRICE"]?>,
                    items: <?=$_SESSION['floctory']?>
                },
            }]);
        </script>

        <script>
            dataLayer.push({event: 'EventsInCart', action: '3rd Step', label: 'paymentID <?=$arResult["ORDER"]["PAY_SYSTEM_ID"]?>'});
            dataLayer.push({event: 'EventsInCart', action: '3rd Step', label: 'deliveryID <?=$arResult["ORDER"]["DELIVERY_ID"]?>'});
            dataLayer.push({event: 'EventsInCart', action: '3rd Step', label: 'personType <?=$arResult["ORDER"]["PERSON_TYPE_ID"]?>'});
        </script>
        <!-- gdeslon -->
        <script type="text/javascript" src="//www.gdeslon.ru/landing.js?mode=thanks&amp;mid=79276&amp;codes=<?=$_SESSION['gdeslon']?>"></script>
        <script type="text/javascript" src="//www.gdeslon.ru/thanks.js?codes=001:<?=($arResult["ORDER"]["PRICE"]-$arResult['ORDER']['PRICE_DELIVERY'])?>&amp;order_id=<?=$arResult["ORDER"]["ID"]?>&amp;merchant_id=79276"></script>
        <?unset($_SESSION['criteo'])?>
        <?unset($_SESSION['gtmEnchECommerceCheckout'])?>
        <?unset($_SESSION['floctory'])?>
        <?unset($_SESSION['retailRocket'])?>
        <?unset($_SESSION['gdeslon'])?>
		<?unset($_SESSION['itemsForAdmitad'])?>
	<?}?>


    <div class="confirmWrapper">
            <div class="finishOrdWrap">
                <div class="centerWrapper">
					<div class="rightBlockWrap">
                        <p class="blockTitle">Уважаемый клиент!</p>
                        <p class="blokText">В качестве благодарности за покупку вам предоставляется возможность выбрать один из подарков наших партнеров.</p>
                        <p class="giftCont"><a href="#">Получить подарок</a></p>
                    </div>
                    <div class="mainInfoWrap">

						<?if ($arResult['ORDER']['STATUS_ID'] == 'PR') {?>
							<p class="ordTitle">Предварительный заказ №<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?> успешно оформлен!</p>
							<p class="ordHint">Вы сможете воспользоваться ссылкой на оплату после того, как книга появится в продаже.</p>

						<?} else {?>
							<p class="ordTitle">Заказ №<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?> успешно оформлен...</p>

							<p class="new_ordHint">
								...и уже принят в работу! Мы <b>не</b> будем звонить без необходимости. Нужная информация представлена ниже и отправлена на адрес <?=$userEmail?>.
								<br /><br />
								А пока можете <a href="/content/team/">посмотреть на команду интернет-магазина</a>, которая займется подготовкой и доставкой заказанных книг ☺
                                <br /><br />
                                <?if($arResult["PAY_SYSTEM"]["ID"] == RFI_PAYSYSTEM_ID){?>
                                    <? $APPLICATION->IncludeComponent(
                                        "webgk:rfi.widget",
                                        "",
                                        Array(
                                            "ORDER_ID" => $_REQUEST["ORDER_ID"]
                                        ),
                                        false
                                    ); ?>
                                <?} else if($arResult["PAY_SYSTEM"]["ID"] != 1 && $arResult["PAY_SYSTEM"]["ID"] != 11 && $arResult["PAY_SYSTEM"]["ID"] != 17 && $arResult["PAY_SYSTEM"]["ID"] != 14){?>
                                    <a class="platbox_button submit_platbox" style="color: #fff;">Оплатить</a>
                                <?} elseif($arResult["PAY_SYSTEM"]["ID"] == 14) {?>
                                    <a class="platbox_button" href="/personal/order/payment/?ORDER_ID=<?=$arResult['ORDER']['ID'];?>" style="color: #fff;">Оплатить</a>
                                <?}?>
								<br /><br />
								Спасибо за хороший выбор!
							</p>
						<?}?>
                 <p class="ordHint"></p>
        <?if (!empty($arResult["PAY_SYSTEM"]) && $arResult['ORDER']['STATUS_ID'] != 'PR') {?>
            <br /><br />
            <div id="promocode-element-container"></div>
            <?if ($arResult["PAY_SYSTEM"]["ID"] == RFI_PAYSYSTEM_ID) {?>

            <? } else if ($arResult["PAY_SYSTEM"]["ID"] == 24){
                $merchant_id = CSalePaySystemAction::GetParamValue("MERCHANT_ID");
                $secret_key = CSalePaySystemAction::GetParamValue("SKEY");
                $order_id = (strlen(CSalePaySystemAction::GetParamValue("PAYMENT_ID")) > 0) ? CSalePaySystemAction::GetParamValue(
    "PAYMENT_ID"
) : $GLOBALS["SALE_INPUT_PARAMS"]["PAYMENT"]["ID"];

                /*$order_info = CSaleOrder::GetByID($order_id);
                $order_props = CSaleOrderProps::GetOrderProps($order_id);
                while ($arProps = $order_props -> Fetch()) {
                    if ($arProps["ORDER_PROPS_ID"] == "EMAIL") {
                        $user_email = $arProps["VALUE"];
                    }
                }*/
                //if (!empty($order_info)) {
                    //$account = ({"id" : $order_info["USER_ID"]});
                    $user_email    = CSalePaySystemAction::GetParamValue("EMAIL");
                    $account = ["id" => $user_email];
                    //$amount = $order_info["PRICE"] * 100;
                    $amount = (string) round(CSalePaySystemAction::GetParamValue("PAYMENT_SUM") * 100.0);
                    //$currency = $order_info["CURRENCY"];
                    $currency = (strlen(CSalePaySystemAction::GetParamValue("CURRENCY")) > 0) ? CSalePaySystemAction::GetParamValue(
    "CURRENCY"
) : $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"];
                    $currency = getCorrectCurrency($currency);
                    //$payer = ["phone_number" => str_replace(array(")", "(", "-"), "", substr($phone_val, 2))];
                    //$order = ({"type" : "order_id", "order_id" : $order_id});
                    $order = ["type" => "order_id", "order_id" => (string)$order_id];
                    //$project = "alpinabook";
                    $project = CSalePaySystemAction::GetParamValue("PROJECT");
                    $resultUrl = CSalePaySystemAction::GetParamValue("PATH_TO_RESULT_URL");
                    $merchant_info = [
                        "merchant_id" => rawurldecode($merchant_id),
                        "account" => json_encode($account),
                        //"payer" => json_encode($payer),
                        "redirect_url" => rawurldecode($resultUrl),
                        "amount" => rawurldecode($amount),
                        "val" => "second",
                        "currency" => $currency,
                        "order" => json_encode($order),
                        "project" => rawurldecode($project)
                    ];
                    ksort($merchant_info);
                    $str = json_encode($merchant_info);
                    //$sign = hash_hmac("SHA256", $str, $secret_key);
                    $sign = getSignature($str);
                    $merchant_info["sign"] = $sign;
                //}
            ?>

            <?} else if ($arResult["PAY_SYSTEM"]["ID"] != 1 && $arResult["PAY_SYSTEM"]["ID"] != 12) {?>
                <table class="sale_order_full_table" >
                    <tr <? /*if ($arResult["PAY_SYSTEM"]["ID"] == RFI_PAYSYSTEM_ID && $_SESSION['rfi_recurrent_type'] == "next" && $_SESSION['rfi_bank_tab'] == "spg" && $arResult["UF_RECURRENT_ID"]) { ?> style="display: none" <? }*/ ?>>
                        <? if ($arResult["PAY_SYSTEM"]["ID"] != RFI_PAYSYSTEM_ID) { ?>
                            <td class="ps_logo">
                                <div class="pay_name"><?=GetMessage("SOA_TEMPL_PAY")?></div>
                                <?if($arResult["PAY_SYSTEM"]["ID"] == PAYPAL_PAYSYSTEM_ID){?>
                                    <div class = "PayPal_button">
                                        <?
										$service = \Bitrix\Sale\PaySystem\Manager::getObjectById($arResult["ORDER"]['PAY_SYSTEM_ID']);
										if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y") {?>
                                            <script language="JavaScript">
                                                window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>&PAYMENT_ID=<?=$arResult['ORDER']["PAYMENT_ID"]?>');
                                            </script>
                                            <?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&PAYMENT_ID=".$arResult['ORDER']["PAYMENT_ID"]))?>
                                            <?
												if (CSalePdf::isPdfAvailable() && $service->isAffordPdf()) {?>
													<br />
													<?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&PAYMENT_ID=".$arResult['ORDER']["PAYMENT_ID"]."&pdf=1&DOWNLOAD=Y")) ?>
                                                <?}
                                            } else {
                                                if ($service) {
                                                    /** @var \Bitrix\Sale\Order $order */
                                                    $order = \Bitrix\Sale\Order::load($arResult["ORDER_ID"]);

                                                    /** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
                                                    $paymentCollection = $order->getPaymentCollection();

                                                    /** @var \Bitrix\Sale\Payment $payment */
                                                    foreach ($paymentCollection as $payment)
                                                    {
                                                        if (!$payment->isInner())
                                                        {
                                                            $context = \Bitrix\Main\Application::getInstance()->getContext();
                                                            $service->initiatePay($payment, $context->getRequest());
                                                            break;
                                                        }
                                                    }
                                                } else {
                                                    echo '<span style="color:red;">'.GetMessage("SOA_TEMPL_ORDER_PS_ERROR").'</span>';
                                                }
                                            }
                                        ?>
                                    </div>
                                    <?} else {?>
                                    <?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 100, 100, "border=0", "", false);?>
                                    <div class="paysystem_name"><?= $arResult["PAY_SYSTEM"]["NAME"] ?></div><br>
                                    <?}?>
								</td>
								<td>
								<?if ($arResult["PAY_SYSTEM"]["ID"] == "13") {?>
									<?= $arResult["PAY_SYSTEM"]["BUFFERED_OUTPUT"]?>
								<?}?>
								</td>
                            <?} else {?>
                            <td colspan="2">
                                <? if ($arResult["PAY_SYSTEM"]["ID"] == "13")
                                    {?>
                                    <?= $arResult["PAY_SYSTEM"]["BUFFERED_OUTPUT"]?>
                                    <?}?>
                            </td>
                            <?}?>
                    </tr>
                    <?if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0) { ?>
                        <tr>
                            <td>
                                <span <?if($arResult["PAY_SYSTEM"]["ID"] == PAYPAL_PAYSYSTEM_ID) echo "style='display:none'"?>>
                                <?
                                    $service = \Bitrix\Sale\PaySystem\Manager::getObjectById($arResult["ORDER"]['PAY_SYSTEM_ID']);

                                    if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y") {?>
                                    <script language="JavaScript">
                                        window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>&PAYMENT_ID=<?=$arResult['ORDER']["PAYMENT_ID"]?>');
                                    </script>
                                    <?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&PAYMENT_ID=".$arResult['ORDER']["PAYMENT_ID"]))?>
                                    <?
                                        if (CSalePdf::isPdfAvailable() && $service->isAffordPdf())
                                        {
                                        ?><br />
                                        <?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&PAYMENT_ID=".$arResult['ORDER']["PAYMENT_ID"]."&pdf=1&DOWNLOAD=Y")) ?>
                                        <?
                                        }
                                    } else {
                                        if ($service) {
                                            /** @var \Bitrix\Sale\Order $order */
                                            $order = \Bitrix\Sale\Order::load($arResult["ORDER_ID"]);

                                            /** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
                                            $paymentCollection = $order->getPaymentCollection();

                                            /** @var \Bitrix\Sale\Payment $payment */
                                            foreach ($paymentCollection as $payment)
                                            {
                                                if (!$payment->isInner())
                                                {
                                                    $context = \Bitrix\Main\Application::getInstance()->getContext();
                                                    $service->initiatePay($payment, $context->getRequest());
                                                    break;
                                                }
                                            }
                                        } else {
                                            echo '<span style="color:red;">'.GetMessage("SOA_TEMPL_ORDER_PS_ERROR").'</span>';
                                        }
                                    }
                                ?>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <?}?>
                </table>
                </span>
                <?} elseif ($arResult["PAY_SYSTEM"]["ID"] == CASHLESS_PAYSYSTEM_ID && $arResult["ORDER"]["PERSON_TYPE_ID"] != LEGAL_ENTITY_PERSON_TYPE_ID) {
                    echo '<span style="font-size:18px;color:#424d4f">'.GetMessage("WAIT_FOR_BILL").'</span>';
                }?>
                <br>
		<?}?>
						<div class="orderInfo">
							<div class="infoTitle">Информация о заказе</div>
							<div class="infoRow">
								<div class="fieldq">Покупатель</div><div class="fielda"><?=$userName?></div>
							</div>
							<div class="infoRow">
								<div class="fieldq">Телефон</div><div class="fielda"><?=$phone_val?></div>
							</div>
							<div class="infoRow">
								<div class="fieldq">E-mail</div><div class="fielda"><?=$userEmail?></div>
							</div>
							<div class="infoRow">
								<div class="fieldq">Способ оплаты</div><div class="fielda"><?=getOrderPaySystemName($arResult["ORDER"]['PAY_SYSTEM_ID'])?></div>
							</div>
							<div class="infoRow">
								<div class="fieldq">Способ доставки</div><div class="fielda"><?=getOrderDeliverySystemName($arResult["ORDER"]["DELIVERY_ID"])?></div>
							</div>
							<div class="infoRow">
								<div class="fieldq">К оплате</div><div class="fielda"><?=$arResult['ORDER']['PRICE']?></div>
							</div>
							<?=$orderedBooks?>
						</div>
                    </div>
                </div>
            </div>

			<div class="i-flocktory" data-fl-action="exchange" data-fl-spot="some_spot" data-fl-user-name="<?=$userName?>" data-fl-user-email="<?=$userEmail?>"></div>
    </div>

    <?} else {?>
		<b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />

		<table class="sale_order_full_table">
			<tr>
				<td>
					<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
					<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
				</td>
			</tr>
		</table>
    <?}?>


<script>
    $(function(){
        var result = $(".confirmWrapper").html();
        $(".orderBody").parent().html(result);
    });
    $(document).ready(function(){
        dataLayer.push({event: 'EventsInCart', action: '3rd Step', label: 'pageLoaded'});
        $(".submit_platbox").on("click", function(){
            $(".layout").show();
            $(".platbox_iframe_block").show();
        });
        $(".layout").on("click", function(){
            if ($(".platbox_iframe_block").css("display") == "block") {
                $(".platbox_iframe_block").hide();
            }
        });
        $(".platbox_iframe_closing").on("click", function(){
            if ($(".platbox_iframe_block").css("display") == "block") {
                $(".platbox_iframe_block").hide();
                $(".layout").hide();
            }
        })
    });
</script>