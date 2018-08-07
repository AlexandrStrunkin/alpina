<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	if ($_REQUEST['preorder']) {
		header("Location: /personal/cart/"); /* Redirect browser */
		exit;
	}
    /** @var array $arParams */
    /** @var array $arResult */
    /** @global CMain $APPLICATION */
    /** @global CUser $USER */
    /** @global CDatabase $DB */
    /** @var CBitrixComponentTemplate $this */
    /** @var string $templateName */
    /** @var string $templateFile */
    /** @var string $templateFolder */
    /** @var string $componentPath */
    /** @var CBitrixBasketComponent $component */
    $curPage = $APPLICATION->GetCurPage().'?'.$arParams["ACTION_VARIABLE"].'=';
    $arUrls = array(
        //"delete" => $curPage."delete&id=#ID#",
        "delete" => "/personal/cart/?".$arParams["ACTION_VARIABLE"]."=delete&id=#ID#",
        "delay" => $curPage."delay&id=#ID#",
        "add" => $curPage."add&id=#ID#",
    );
    unset($curPage);

    $arBasketJSParams = array(
        'SALE_DELETE' => GetMessage("SALE_DELETE"),
        'SALE_DELAY' => GetMessage("SALE_DELAY"),
        'SALE_TYPE' => GetMessage("SALE_TYPE"),
        'TEMPLATE_FOLDER' => $templateFolder,
        'DELETE_URL' => $arUrls["delete"],
        'DELAY_URL' => $arUrls["delay"],
        'ADD_URL' => $arUrls["add"]
    );
?>
<div class="breadCrumpWrap">
    <div class="centerWrapper">
        <p><a href="/personal/cart/" class="afterImg active" onclick="dataLayer.push({event: 'EventsInCart', action: '1st Step', label: 'bigLinksCartClick'});">Корзина</a><a href="javascript:void(0)" onclick="checkOut();dataLayer.push({event: 'EventsInCart', action: '1st Step', label: 'bigLinksCheckoutClick'});" class="afterImg">Оформление</a><a href="#" onclick="dataLayer.push({event: 'EventsInCart', action: '1st Step', label: 'bigLinksCompleteClick'});return false;">Завершение</a></p>
    </div>
</div>


<div class="cartWrapper">
    <div class="centerWrapper">

        <script type="text/javascript">
            var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
        </script>
        <?
            $APPLICATION->AddHeadScript($templateFolder."/script.js");


        ?>

        <div class="cartMenuWrap">
            <?//Проверяем только ли предзаказ в корзине?>
            <?$onlyPreorder = false;?>
            <?$hasItems = false;?>
            <?$hasPreorderItems = false;?>
            <?foreach($arResult["GRID"]["ROWS"] as $k => $arItem) {
                if($arItem["DELAY"] == "N") {
                    $hasItems = true;
                }
                if($arItem["DELAY"] == "Y") {
                    $hasPreorderItems = true;
                }
            }
            if (!$hasItems && $hasPreorderItems) {
                $onlyPreorder = true;
            }?>
            <div class="basketItems <?if(!$onlyPreorder && !$_REQUEST['preorder']){ echo 'active'; }?>" data-id="1" onclick="dataLayer.push({event: 'EventsInCart', action: '1st Step', label: 'readyForOrderClick'});"><p>Готовые к заказу <span>(<?=count($arResult["ITEMS"]["AnDelCanBuy"])?>)</span></p></div>
            <div class="basketItems" data-id="2" onclick="dataLayer.push({event: 'EventsInCart', action: '1st Step', label: 'wishlistBookmarkClick'});"><p>Список желаний <span>(0)</span></p></div>
            <?/*if(count($arResult["ITEMS"]["DelDelCanBuy"]) > 0) {?>
                <div class="basketItems <?if($onlyPreorder || $_REQUEST['preorder']){ echo 'active'; }?>" data-id="3" onclick="dataLayer.push({event: 'EventsInCart', action: '1st Step', label: 'readyForPreorderClick'});"><p>Предзаказ <span>(<?=count($arResult["ITEMS"]["DelDelCanBuy"])?>)</span></p></div>
            <?}*/?>
        </div>

        <?
            if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
            {
            ?>


            <div id="warning_message">
                <?
                    if (!empty($arResult["WARNING_MESSAGE"]) && is_array($arResult["WARNING_MESSAGE"]))
                    {
                        foreach ($arResult["WARNING_MESSAGE"] as $v)
                            ShowError($v);
                    }
                ?>
            </div>

            <?

                $normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
                $normalHidden = ($normalCount == 0) ? 'style="display:none;"' : '';

                $delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
                $delayHidden = ($delayCount == 0) ? 'style="display:none;"' : '';

                $subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
                $subscribeHidden = ($subscribeCount == 0) ? 'style="display:none;"' : '';

                $naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
                $naHidden = ($naCount == 0) ? 'style="display:none;"' : '';

            ?>
            <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">

                <div id="basket_form_container">
                    <div class="bx_ordercart">

                        <?
                            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
                            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delay.php");
                            //include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delayed.php");
                        ?>

                        <div class="yourBooks" id="cardBlock2">
                            <?//здесь wishlist?>
                            <?
                                /*$WishFilter = array ("ID" => array());
                                if ($_REQUEST["list"])
                                {
                                $el_list = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 17, "NAME" => $_REQUEST["list"]), false, false, array("ID"));
                                while ($el_fetch = $el_list -> Fetch())
                                {
                                $WishFilter["ID"][] = $el_fetch["ID"];
                                }
                                }
                                else
                                {
                                $el_list = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 17, "NAME" => $USER -> GetID()), false, false, array("ID"));
                                while ($el_fetch = $el_list -> Fetch())
                                {
                                $WishFilter["ID"][] = $el_fetch["ID"];
                                }
                                }
                                arshow($WishFilter);*/
                                $uID = $USER -> GetID();

                                if ($_REQUEST["list"]) {
                                    $list_user = CUser::GetByID($_REQUEST["list"]) -> Fetch();
                                    $list_user_name = $list_user["NAME"]." ".$list_user["LAST_NAME"];
                                }
                                else {
                                    $list_user = CUser::GetByID($uID) -> Fetch();
                                    $list_user_name = $list_user["NAME"]." ".$list_user["LAST_NAME"];
                                }

                                global $WishFilter;
                                $WishFilter["NAME"] = $list_user_name;
                                $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.section",
                                    "wish_list",
                                    array(
                                        "IBLOCK_TYPE_ID" => "catalog",
                                        "IBLOCK_ID" => "17",
                                        "BASKET_URL" => "/personal/cart/",
                                        "COMPONENT_TEMPLATE" => "wish_list",
                                        "IBLOCK_TYPE" => "wishlist",
                                        "SECTION_ID" => $_REQUEST["SECTION_ID"],
                                        "SECTION_CODE" => "",
                                        "SECTION_USER_FIELDS" => array(
                                            0 => "",
                                            1 => "",
                                        ),
                                        "ELEMENT_SORT_FIELD" => "id",
                                        "ELEMENT_SORT_ORDER" => "desc",
                                        "ELEMENT_SORT_FIELD2" => "id",
                                        "ELEMENT_SORT_ORDER2" => "desc",
                                        "FILTER_NAME" => "WishFilter",
                                        "INCLUDE_SUBSECTIONS" => "Y",
                                        "SHOW_ALL_WO_SECTION" => "N",
                                        "HIDE_NOT_AVAILABLE" => "N",
                                        "PAGE_ELEMENT_COUNT" => "100",
                                        "LINE_ELEMENT_COUNT" => "6",
                                        "PROPERTY_CODE" => array(
                                            0 => "PRODUCTS",
                                            1 => "",
                                        ),
                                        "OFFERS_FIELD_CODE" => array(
                                            0 => "",
                                            1 => "",
                                        ),
                                        "OFFERS_PROPERTY_CODE" => array(
                                            0 => "COLOR_REF",
                                            1 => "SIZES_SHOES",
                                            2 => "SIZES_CLOTHES",
                                            3 => "",
                                        ),
                                        "OFFERS_SORT_FIELD" => "sort",
                                        "OFFERS_SORT_ORDER" => "desc",
                                        "OFFERS_SORT_FIELD2" => "id",
                                        "OFFERS_SORT_ORDER2" => "desc",
                                        "OFFERS_LIMIT" => "5",
                                        "TEMPLATE_THEME" => "site",
                                        "PRODUCT_DISPLAY_MODE" => "Y",
                                        "ADD_PICT_PROP" => "-",
                                        "LABEL_PROP" => "-",
                                        "OFFER_ADD_PICT_PROP" => "-",
                                        "OFFER_TREE_PROPS" => array(
                                            0 => "COLOR_REF",
                                            1 => "SIZES_SHOES",
                                            2 => "SIZES_CLOTHES",
                                        ),
                                        "PRODUCT_SUBSCRIPTION" => "N",
                                        "SHOW_DISCOUNT_PERCENT" => "N",
                                        "SHOW_OLD_PRICE" => "Y",
                                        "SHOW_CLOSE_POPUP" => "N",
                                        "MESS_BTN_BUY" => "Купить",
                                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                                        "MESS_BTN_SUBSCRIBE" => "Подписаться",
                                        "MESS_BTN_DETAIL" => "Подробнее",
                                        "MESS_NOT_AVAILABLE" => "Нет в наличии",
                                        "SECTION_URL" => "",
                                        "DETAIL_URL" => "",
                                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                                        "SEF_MODE" => "N",
                                        "AJAX_MODE" => "N",
                                        "AJAX_OPTION_JUMP" => "N",
                                        "AJAX_OPTION_STYLE" => "Y",
                                        "AJAX_OPTION_HISTORY" => "N",
                                        "AJAX_OPTION_ADDITIONAL" => "",
                                        "CACHE_TYPE" => "A",
                                        "CACHE_TIME" => "36000000",
                                        "CACHE_GROUPS" => "N",
                                        "SET_TITLE" => "Y",
                                        "SET_BROWSER_TITLE" => "Y",
                                        "BROWSER_TITLE" => "-",
                                        "SET_META_KEYWORDS" => "Y",
                                        "META_KEYWORDS" => "-",
                                        "SET_META_DESCRIPTION" => "Y",
                                        "META_DESCRIPTION" => "-",
                                        "SET_LAST_MODIFIED" => "N",
                                        "USE_MAIN_ELEMENT_SECTION" => "N",
                                        "ADD_SECTIONS_CHAIN" => "N",
                                        "CACHE_FILTER" => "N",
                                        "ACTION_VARIABLE" => "action",
                                        "PRODUCT_ID_VARIABLE" => "id",
                                        "PRICE_CODE" => array(
                                            0 => "BASE",
                                        ),
                                        "USE_PRICE_COUNT" => "N",
                                        "SHOW_PRICE_COUNT" => "1",
                                        "PRICE_VAT_INCLUDE" => "Y",
                                        "CONVERT_CURRENCY" => "N",
                                        "USE_PRODUCT_QUANTITY" => "N",
                                        "PRODUCT_QUANTITY_VARIABLE" => "",
                                        "ADD_PROPERTIES_TO_BASKET" => "Y",
                                        "PRODUCT_PROPS_VARIABLE" => "prop",
                                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                                        "PRODUCT_PROPERTIES" => array(
                                        ),
                                        "OFFERS_CART_PROPERTIES" => array(
                                            0 => "COLOR_REF",
                                            1 => "SIZES_SHOES",
                                            2 => "SIZES_CLOTHES",
                                        ),
                                        "ADD_TO_BASKET_ACTION" => "ADD",
                                        "PAGER_TEMPLATE" => "round",
                                        "DISPLAY_TOP_PAGER" => "N",
                                        "DISPLAY_BOTTOM_PAGER" => "Y",
                                        "PAGER_TITLE" => "Товары",
                                        "PAGER_SHOW_ALWAYS" => "N",
                                        "PAGER_DESC_NUMBERING" => "N",
                                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                        "PAGER_SHOW_ALL" => "N",
                                        "PAGER_BASE_LINK_ENABLE" => "N",
                                        "SET_STATUS_404" => "N",
                                        "SHOW_404" => "N",
                                        "MESSAGE_404" => "",
                                        "BACKGROUND_IMAGE" => "-",
                                        "DISABLE_INIT_JS_IN_COMPONENT" => "N"
                                    ),
                                    false
                                );?>
                        </div>
                    </div>
                </div>

				<input type="hidden" name="BasketOrder" value="BasketOrder" />
				<?
				/* Получаем рекомендации для корзины от RetailRocket */
				global $arrFilter;
				//echo $retailRocketRecs;
				//$retailRocketRecs = (substr($retailRocketRecs,0,-1));
				$stringRecs = file_get_contents('https://api.retailrocket.ru/api/1.0/Recomendation/CrossSellItemToItems/50b90f71b994b319dc5fd855/'.(substr($retailRocketRecs,0,-1)));
				$recsArray = json_decode($stringRecs);
				$arrFilter = Array('ID' => (array_slice($recsArray,0,6)));
				?>
				<?
				if($_SERVER["HTTP_X_REAL_IP"] == "91.201.253.5") {
					$rrBooksIds = array();
					foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $bookItem) {
						$rrBooksIds[] = $bookItem["ID"];
 					}
					$rrBooksIdsString = '';
					$rrBooksIdsString = implode(", ", $rrBooksIds);
				}
				?>
				<div data-retailrocket-markup-block="5b55e33197a5250e28c19cb2" data-products="<?=$rrBooksIdsString?>"></div>
				<?
				if ($arrFilter['ID'][0] > 0) { // Если персональные рекомендаций нет, не показываем блок?>
				<div class="recomendation">
					<p class="grayTitle">С заказанными книгами читают</p>
					<?
						$APPLICATION->IncludeComponent(
							"bitrix:catalog.section",
							"recommends_for_cart",
							array(
								"IBLOCK_TYPE_ID" => "catalog",
								"IBLOCK_ID" => "4",
								"BASKET_URL" => "/personal/cart/",
								"COMPONENT_TEMPLATE" => "recommended_books",
								"IBLOCK_TYPE" => "catalog",
								"SECTION_ID" => $_REQUEST["SECTION_ID"],
								"SECTION_CODE" => "",
								"SECTION_USER_FIELDS" => array(
									0 => "",
									1 => "",
								),
								"ELEMENT_SORT_FIELD" => "id",
								"ELEMENT_SORT_ORDER" => "desc",
								"ELEMENT_SORT_FIELD2" => "id",
								"ELEMENT_SORT_ORDER2" => "desc",
								"FILTER_NAME" => "arrFilter",
								"INCLUDE_SUBSECTIONS" => "Y",
								"SHOW_ALL_WO_SECTION" => "Y",
								"HIDE_NOT_AVAILABLE" => "N",
								"PAGE_ELEMENT_COUNT" => "12",
								"LINE_ELEMENT_COUNT" => "3",
								"PROPERTY_CODE" => array(
									0 => "",
									1 => "",
								),
								"OFFERS_FIELD_CODE" => array(
									0 => "",
									1 => "",
								),
								"OFFERS_PROPERTY_CODE" => array(
									0 => "COLOR_REF",
									1 => "SIZES_SHOES",
									2 => "SIZES_CLOTHES",
									3 => "",
								),
								"OFFERS_SORT_FIELD" => "sort",
								"OFFERS_SORT_ORDER" => "desc",
								"OFFERS_SORT_FIELD2" => "id",
								"OFFERS_SORT_ORDER2" => "desc",
								"OFFERS_LIMIT" => "5",
								"TEMPLATE_THEME" => "site",
								"PRODUCT_DISPLAY_MODE" => "Y",
								"ADD_PICT_PROP" => "BIG_PHOTO",
								"LABEL_PROP" => "-",
								"OFFER_ADD_PICT_PROP" => "-",
								"OFFER_TREE_PROPS" => array(
									0 => "COLOR_REF",
									1 => "SIZES_SHOES",
									2 => "SIZES_CLOTHES",
								),
								"PRODUCT_SUBSCRIPTION" => "N",
								"SHOW_DISCOUNT_PERCENT" => "N",
								"SHOW_OLD_PRICE" => "Y",
								"SHOW_CLOSE_POPUP" => "N",
								"MESS_BTN_BUY" => "Купить",
								"MESS_BTN_ADD_TO_BASKET" => "В корзину",
								"MESS_BTN_SUBSCRIBE" => "Подписаться",
								"MESS_BTN_DETAIL" => "Подробнее",
								"MESS_NOT_AVAILABLE" => "Нет в наличии",
								"SECTION_URL" => "",
								"DETAIL_URL" => "",
								"SECTION_ID_VARIABLE" => "SECTION_ID",
								"SEF_MODE" => "N",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"AJAX_OPTION_HISTORY" => "N",
								"AJAX_OPTION_ADDITIONAL" => "",
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => "36000000",
								"CACHE_GROUPS" => "N",
								"SET_TITLE" => "N",
								"SET_BROWSER_TITLE" => "Y",
								"BROWSER_TITLE" => "-",
								"SET_META_KEYWORDS" => "Y",
								"META_KEYWORDS" => "-",
								"SET_META_DESCRIPTION" => "Y",
								"META_DESCRIPTION" => "-",
								"SET_LAST_MODIFIED" => "N",
								"USE_MAIN_ELEMENT_SECTION" => "N",
								"ADD_SECTIONS_CHAIN" => "N",
								"CACHE_FILTER" => "N",
								"ACTION_VARIABLE" => "action",
								"PRODUCT_ID_VARIABLE" => "id",
								"PRICE_CODE" => array(
									0 => "BASE",
								),
								"USE_PRICE_COUNT" => "N",
								"SHOW_PRICE_COUNT" => "1",
								"PRICE_VAT_INCLUDE" => "Y",
								"CONVERT_CURRENCY" => "N",
								"USE_PRODUCT_QUANTITY" => "N",
								"PRODUCT_QUANTITY_VARIABLE" => "",
								"ADD_PROPERTIES_TO_BASKET" => "Y",
								"PRODUCT_PROPS_VARIABLE" => "prop",
								"PARTIAL_PRODUCT_PROPERTIES" => "N",
								"PRODUCT_PROPERTIES" => array(
								),
								"OFFERS_CART_PROPERTIES" => array(
									0 => "COLOR_REF",
									1 => "SIZES_SHOES",
									2 => "SIZES_CLOTHES",
								),
								"ADD_TO_BASKET_ACTION" => "ADD",
								"PAGER_TEMPLATE" => "round",
								"DISPLAY_TOP_PAGER" => "N",
								"DISPLAY_BOTTOM_PAGER" => "Y",
								"PAGER_TITLE" => "Товары",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"PAGER_BASE_LINK_ENABLE" => "N",
								"SET_STATUS_404" => "N",
								"SHOW_404" => "N",
								"MESSAGE_404" => "",
								"BACKGROUND_IMAGE" => "-",
								"DISABLE_INIT_JS_IN_COMPONENT" => "N"
							),
							false
						);?>
				</div>
				<?}?>
                <!-- <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> -->
            </form>
            <script type="text/javascript">
                dataLayer.push({
                    'ecommerce': {
                        'checkout': {
                            'actionField': {'step':1},
                            'products': [
                                <?foreach($_SESSION['gtmEnchECommerceCheckout'] as $googleItem){?>
                                    {
                                        <?=$googleItem?>
                                    },
                                <?}?>
                            ]
                        }
                    }
                });

            </script>

            <script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>

            <script type="text/javascript">
                window.criteo_q = window.criteo_q || [];
                window.criteo_q.push(
                    { event: "setAccount", account: 18519 },

                    { event: "setSiteType", type: "d" },
                    <?if($USER->IsAuthorized()){?>
                        { event: "setEmail", email: "<?=$USER->GetEmail()?>" },
                        <?} else {?>
                        { event: "setEmail", email: "" },
                        <?}?>
                    { event: "viewBasket", item: [
                        <?foreach($_SESSION['itemsForCriteo'] as $criteoItem){?>
                            {
                                <?=$criteoItem?>
                            },
                            <?}?>
                ]});
            </script>


            <?
            }
            else
            {
            ?>
            <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">

                <div id="basket_form_container">
                <div class="bx_ordercart">
                    <div id="basket_items_list">
                        <div class="yourBooks" id="cardBlock1">
                            <?
                                ShowError($arResult["ERROR_MESSAGE"]);
                            ?>

                        </div>

                        <div class="yourBooks" id="cardBlock2">
                            <?//здесь wishlist?>
                            <?
                                /*$WishFilter = array ("ID" => array());
                                if ($_REQUEST["list"])
                                {
                                $el_list = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 17, "NAME" => $_REQUEST["list"]), false, false, array("ID"));
                                while ($el_fetch = $el_list -> Fetch())
                                {
                                $WishFilter["ID"][] = $el_fetch["ID"];
                                }
                                }
                                else
                                {
                                $el_list = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 17, "NAME" => $USER -> GetID()), false, false, array("ID"));
                                while ($el_fetch = $el_list -> Fetch())
                                {
                                $WishFilter["ID"][] = $el_fetch["ID"];
                                }
                                }
                                arshow($WishFilter);*/
                                $uID = $USER -> GetID();

                                if ($_REQUEST["list"]) {
                                    $list_user = CUser::GetByID($_REQUEST["list"]) -> Fetch();
                                    $list_user_name = $list_user["NAME"]." ".$list_user["LAST_NAME"];
                                }
                                else {
                                    $list_user = CUser::GetByID($uID) -> Fetch();
                                    $list_user_name = $list_user["NAME"]." ".$list_user["LAST_NAME"];
                                }

                                global $WishFilter;
                                $WishFilter["NAME"] = $list_user_name;

                                $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.section",
                                    "wish_list",
                                    array(
                                        "IBLOCK_TYPE_ID" => "catalog",
                                        "IBLOCK_ID" => "17",
                                        "BASKET_URL" => "/personal/cart/",
                                        "COMPONENT_TEMPLATE" => "wish_list",
                                        "IBLOCK_TYPE" => "wishlist",
                                        "SECTION_ID" => $_REQUEST["SECTION_ID"],
                                        "SECTION_CODE" => "",
                                        "SECTION_USER_FIELDS" => array(
                                            0 => "",
                                            1 => "",
                                        ),
                                        "ELEMENT_SORT_FIELD" => "id",
                                        "ELEMENT_SORT_ORDER" => "desc",
                                        "ELEMENT_SORT_FIELD2" => "id",
                                        "ELEMENT_SORT_ORDER2" => "desc",
                                        "FILTER_NAME" => "WishFilter",
                                        "INCLUDE_SUBSECTIONS" => "Y",
                                        "SHOW_ALL_WO_SECTION" => "N",
                                        "HIDE_NOT_AVAILABLE" => "N",
                                        "PAGE_ELEMENT_COUNT" => "100",
                                        "LINE_ELEMENT_COUNT" => "6",
                                        "PROPERTY_CODE" => array(
                                            0 => "PRODUCTS",
                                            1 => "",
                                        ),
                                        "OFFERS_FIELD_CODE" => array(
                                            0 => "",
                                            1 => "",
                                        ),
                                        "OFFERS_PROPERTY_CODE" => array(
                                            0 => "COLOR_REF",
                                            1 => "SIZES_SHOES",
                                            2 => "SIZES_CLOTHES",
                                            3 => "",
                                        ),
                                        "OFFERS_SORT_FIELD" => "sort",
                                        "OFFERS_SORT_ORDER" => "desc",
                                        "OFFERS_SORT_FIELD2" => "id",
                                        "OFFERS_SORT_ORDER2" => "desc",
                                        "OFFERS_LIMIT" => "5",
                                        "TEMPLATE_THEME" => "site",
                                        "PRODUCT_DISPLAY_MODE" => "Y",
                                        "ADD_PICT_PROP" => "-",
                                        "LABEL_PROP" => "-",
                                        "OFFER_ADD_PICT_PROP" => "-",
                                        "OFFER_TREE_PROPS" => array(
                                            0 => "COLOR_REF",
                                            1 => "SIZES_SHOES",
                                            2 => "SIZES_CLOTHES",
                                        ),
                                        "PRODUCT_SUBSCRIPTION" => "N",
                                        "SHOW_DISCOUNT_PERCENT" => "N",
                                        "SHOW_OLD_PRICE" => "Y",
                                        "SHOW_CLOSE_POPUP" => "N",
                                        "MESS_BTN_BUY" => "Купить",
                                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                                        "MESS_BTN_SUBSCRIBE" => "Подписаться",
                                        "MESS_BTN_DETAIL" => "Подробнее",
                                        "MESS_NOT_AVAILABLE" => "Нет в наличии",
                                        "SECTION_URL" => "",
                                        "DETAIL_URL" => "",
                                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                                        "SEF_MODE" => "N",
                                        "AJAX_MODE" => "N",
                                        "AJAX_OPTION_JUMP" => "N",
                                        "AJAX_OPTION_STYLE" => "Y",
                                        "AJAX_OPTION_HISTORY" => "N",
                                        "AJAX_OPTION_ADDITIONAL" => "",
                                        "CACHE_TYPE" => "A",
                                        "CACHE_TIME" => "36000000",
                                        "CACHE_GROUPS" => "N",
                                        "SET_TITLE" => "Y",
                                        "SET_BROWSER_TITLE" => "Y",
                                        "BROWSER_TITLE" => "-",
                                        "SET_META_KEYWORDS" => "Y",
                                        "META_KEYWORDS" => "-",
                                        "SET_META_DESCRIPTION" => "Y",
                                        "META_DESCRIPTION" => "-",
                                        "SET_LAST_MODIFIED" => "N",
                                        "USE_MAIN_ELEMENT_SECTION" => "N",
                                        "ADD_SECTIONS_CHAIN" => "N",
                                        "CACHE_FILTER" => "N",
                                        "ACTION_VARIABLE" => "action",
                                        "PRODUCT_ID_VARIABLE" => "id",
                                        "PRICE_CODE" => array(
                                            0 => "BASE",
                                        ),
                                        "USE_PRICE_COUNT" => "N",
                                        "SHOW_PRICE_COUNT" => "1",
                                        "PRICE_VAT_INCLUDE" => "Y",
                                        "CONVERT_CURRENCY" => "N",
                                        "USE_PRODUCT_QUANTITY" => "N",
                                        "PRODUCT_QUANTITY_VARIABLE" => "",
                                        "ADD_PROPERTIES_TO_BASKET" => "Y",
                                        "PRODUCT_PROPS_VARIABLE" => "prop",
                                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                                        "PRODUCT_PROPERTIES" => array(
                                        ),
                                        "OFFERS_CART_PROPERTIES" => array(
                                            0 => "COLOR_REF",
                                            1 => "SIZES_SHOES",
                                            2 => "SIZES_CLOTHES",
                                        ),
                                        "ADD_TO_BASKET_ACTION" => "ADD",
                                        "PAGER_TEMPLATE" => "round",
                                        "DISPLAY_TOP_PAGER" => "N",
                                        "DISPLAY_BOTTOM_PAGER" => "Y",
                                        "PAGER_TITLE" => "Товары",
                                        "PAGER_SHOW_ALWAYS" => "N",
                                        "PAGER_DESC_NUMBERING" => "N",
                                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                        "PAGER_SHOW_ALL" => "N",
                                        "PAGER_BASE_LINK_ENABLE" => "N",
                                        "SET_STATUS_404" => "N",
                                        "SHOW_404" => "N",
                                        "MESSAGE_404" => "",
                                        "BACKGROUND_IMAGE" => "-",
                                        "DISABLE_INIT_JS_IN_COMPONENT" => "N"
                                    ),
                                    false
                                );?>
                        </div>
                    </div>
                </div>
            </form>
            <div class="interestSlideWrap">
			<style>
			.cartWrapper .bookImg {
				padding-left: 0;
				padding-top: 0;
				width: auto;
			}
			</style>
                <?
                if (isset($_COOKIE["rrpusid"])){
                    global $arrFilter;
                    $stringRecs = file_get_contents('https://api.retailrocket.ru/api/1.0/Recomendation/PersonalRecommendation/50b90f71b994b319dc5fd855/?rrUserId='.$_COOKIE["rrpusid"]);
                    $recsArray = json_decode($stringRecs);
                    $arrFilter = Array('ID' => (array_slice($recsArray, 0, 6)));
                }
                if ($arrFilter['ID'][0] > 0) {
                    $APPLICATION->IncludeComponent("bitrix:catalog.section", "interesting_items", Array(
                        "IBLOCK_TYPE_ID" => "catalog",
                        "IBLOCK_ID" => CATALOG_IBLOCK_ID,    // Инфоблок
                        "BASKET_URL" => "/personal/cart/",    // URL, ведущий на страницу с корзиной покупателя
                        "COMPONENT_TEMPLATE" => "template1",
                        "IBLOCK_TYPE" => "catalog",    // Тип инфоблока
                        "SECTION_ID" => "",    // ID раздела
                        "SECTION_CODE" => "",    // Код раздела
                        "SECTION_USER_FIELDS" => array(    // Свойства раздела
                            0 => "",
                            1 => "",
                        ),
                        "ELEMENT_SORT_FIELD" => "id",    // По какому полю сортируем элементы
                        "ELEMENT_SORT_ORDER" => "desc",    // Порядок сортировки элементов
                        "ELEMENT_SORT_FIELD2" => "id",    // Поле для второй сортировки элементов
                        "ELEMENT_SORT_ORDER2" => "desc",    // Порядок второй сортировки элементов
                        "FILTER_NAME" => "arrFilter",    // Имя массива со значениями фильтра для фильтрации элементов
                        "INCLUDE_SUBSECTIONS" => "Y",    // Показывать элементы подразделов раздела
                        "SHOW_ALL_WO_SECTION" => "Y",    // Показывать все элементы, если не указан раздел
                        "HIDE_NOT_AVAILABLE" => "N",    // Не отображать товары, которых нет на складах
                        "PAGE_ELEMENT_COUNT" => "12",    // Количество элементов на странице
                        "LINE_ELEMENT_COUNT" => "3",    // Количество элементов выводимых в одной строке таблицы
                        "PROPERTY_CODE" => array(    // Свойства
                            0 => "",
                            1 => "",
                        ),
                        "OFFERS_FIELD_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "OFFERS_PROPERTY_CODE" => array(
                            0 => "COLOR_REF",
                            1 => "SIZES_SHOES",
                            2 => "SIZES_CLOTHES",
                            3 => "",
                        ),
                        "OFFERS_SORT_FIELD" => "sort",
                        "OFFERS_SORT_ORDER" => "desc",
                        "OFFERS_SORT_FIELD2" => "id",
                        "OFFERS_SORT_ORDER2" => "desc",
                        "OFFERS_LIMIT" => "5",    // Максимальное количество предложений для показа (0 - все)
                        "TEMPLATE_THEME" => "site",    // Цветовая тема
                        "PRODUCT_DISPLAY_MODE" => "Y",
                        "ADD_PICT_PROP" => "BIG_PHOTO",    // Дополнительная картинка основного товара
                        "LABEL_PROP" => "-",    // Свойство меток товара
                        "OFFER_ADD_PICT_PROP" => "-",
                        "OFFER_TREE_PROPS" => array(
                            0 => "COLOR_REF",
                            1 => "SIZES_SHOES",
                            2 => "SIZES_CLOTHES",
                        ),
                        "PRODUCT_SUBSCRIPTION" => "N",    // Разрешить оповещения для отсутствующих товаров
                        "SHOW_DISCOUNT_PERCENT" => "N",    // Показывать процент скидки
                        "SHOW_OLD_PRICE" => "Y",    // Показывать старую цену
                        "SHOW_CLOSE_POPUP" => "N",    // Показывать кнопку продолжения покупок во всплывающих окнах
                        "MESS_BTN_BUY" => "Купить",    // Текст кнопки "Купить"
                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",    // Текст кнопки "Добавить в корзину"
                        "MESS_BTN_SUBSCRIBE" => "Подписаться",    // Текст кнопки "Уведомить о поступлении"
                        "MESS_BTN_DETAIL" => "Подробнее",    // Текст кнопки "Подробнее"
                        "MESS_NOT_AVAILABLE" => "Нет в наличии",    // Сообщение об отсутствии товара
                        "SECTION_URL" => "",    // URL, ведущий на страницу с содержимым раздела
                        "DETAIL_URL" => "",    // URL, ведущий на страницу с содержимым элемента раздела
                        "SECTION_ID_VARIABLE" => "SECTION_ID",    // Название переменной, в которой передается код группы
                        "SEF_MODE" => "N",    // Включить поддержку ЧПУ
                        "AJAX_MODE" => "N",    // Включить режим AJAX
                        "AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
                        "AJAX_OPTION_STYLE" => "Y",    // Включить подгрузку стилей
                        "AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
                        "AJAX_OPTION_ADDITIONAL" => "",    // Дополнительный идентификатор
                        "CACHE_TYPE" => "A",    // Тип кеширования
                        "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
                        "CACHE_GROUPS" => "Y",    // Учитывать права доступа
                        "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
                        "SET_BROWSER_TITLE" => "Y",    // Устанавливать заголовок окна браузера
                        "BROWSER_TITLE" => "-",    // Установить заголовок окна браузера из свойства
                        "SET_META_KEYWORDS" => "Y",    // Устанавливать ключевые слова страницы
                        "META_KEYWORDS" => "-",    // Установить ключевые слова страницы из свойства
                        "SET_META_DESCRIPTION" => "Y",    // Устанавливать описание страницы
                        "META_DESCRIPTION" => "-",    // Установить описание страницы из свойства
                        "SET_LAST_MODIFIED" => "N",    // Устанавливать в заголовках ответа время модификации страницы
                        "USE_MAIN_ELEMENT_SECTION" => "N",    // Использовать основной раздел для показа элемента
                        "ADD_SECTIONS_CHAIN" => "N",    // Включать раздел в цепочку навигации
                        "CACHE_FILTER" => "N",    // Кешировать при установленном фильтре
                        "ACTION_VARIABLE" => "action",    // Название переменной, в которой передается действие
                        "PRODUCT_ID_VARIABLE" => "id",    // Название переменной, в которой передается код товара для покупки
                        "PRICE_CODE" => array(    // Тип цены
                            0 => "BASE",
                        ),
                        "USE_PRICE_COUNT" => "N",    // Использовать вывод цен с диапазонами
                        "SHOW_PRICE_COUNT" => "1",    // Выводить цены для количества
                        "PRICE_VAT_INCLUDE" => "Y",    // Включать НДС в цену
                        "CONVERT_CURRENCY" => "N",    // Показывать цены в одной валюте
                        "USE_PRODUCT_QUANTITY" => "N",    // Разрешить указание количества товара
                        "PRODUCT_QUANTITY_VARIABLE" => "",    // Название переменной, в которой передается количество товара
                        "ADD_PROPERTIES_TO_BASKET" => "Y",    // Добавлять в корзину свойства товаров и предложений
                        "PRODUCT_PROPS_VARIABLE" => "prop",    // Название переменной, в которой передаются характеристики товара
                        "PARTIAL_PRODUCT_PROPERTIES" => "N",    // Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
                        "PRODUCT_PROPERTIES" => "",    // Характеристики товара
                        "OFFERS_CART_PROPERTIES" => array(
                            0 => "COLOR_REF",
                            1 => "SIZES_SHOES",
                            2 => "SIZES_CLOTHES",
                        ),
                        "ADD_TO_BASKET_ACTION" => "ADD",    // Показывать кнопку добавления в корзину или покупки
                        "PAGER_TEMPLATE" => "round",    // Шаблон постраничной навигации
                        "DISPLAY_TOP_PAGER" => "N",    // Выводить над списком
                        "DISPLAY_BOTTOM_PAGER" => "Y",    // Выводить под списком
                        "PAGER_TITLE" => "Товары",    // Название категорий
                        "PAGER_SHOW_ALWAYS" => "N",    // Выводить всегда
                        "PAGER_DESC_NUMBERING" => "N",    // Использовать обратную навигацию
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",    // Время кеширования страниц для обратной навигации
                        "PAGER_SHOW_ALL" => "N",    // Показывать ссылку "Все"
                        "PAGER_BASE_LINK_ENABLE" => "N",    // Включить обработку ссылок
                        "SET_STATUS_404" => "N",    // Устанавливать статус 404
                        "SHOW_404" => "N",    // Показ специальной страницы
                        "MESSAGE_404" => "",    // Сообщение для показа (по умолчанию из компонента)
                        "BACKGROUND_IMAGE" => "-",    // Установить фоновую картинку для шаблона из свойства
                        ),
                        false
                    );
                } else {?>
					<!-- <p class="titleMain">Бестселлеры</p> -->
					<?
					$APPLICATION->IncludeComponent(
						"bitrix:catalog.section",
						"slider_on_main_bestsellers",
						array(
							"IBLOCK_TYPE_ID" => "catalog",
							"IBLOCK_ID" => "4",
							"BASKET_URL" => "/personal/cart/",
							"COMPONENT_TEMPLATE" => "slider_on_main_bestsellers",
							"IBLOCK_TYPE" => "catalog",
							"SECTION_ID" => $_REQUEST["SECTION_ID"],
							"SECTION_CODE" => "",
							"SECTION_USER_FIELDS" => array(
								0 => "",
								1 => "",
							),
							//"ELEMENT_SORT_FIELD" => "PROPERTY_SALES_CNT",
							"ELEMENT_SORT_FIELD" => "PROPERTY_POPULARITY",
							"ELEMENT_SORT_ORDER" => "desc",
							"ELEMENT_SORT_FIELD2" => "rand",
							"ELEMENT_SORT_ORDER2" => "desc",
							"FILTER_NAME" => "BestsOnMain",
							"INCLUDE_SUBSECTIONS" => "Y",
							"SHOW_ALL_WO_SECTION" => "Y",
							"HIDE_NOT_AVAILABLE" => "N",
							"PAGE_ELEMENT_COUNT" => "12",
							"LINE_ELEMENT_COUNT" => "3",
                            "PROPERTY_CODE" => array(
                                0 => "AUTHORS",
                                1 => "PROPERTY_AUTHORS.NAME",
                            ),
							"OFFERS_FIELD_CODE" => array(
								0 => "",
								1 => "",
							),
							"OFFERS_PROPERTY_CODE" => array(
								0 => "COLOR_REF",
								1 => "SIZES_SHOES",
								2 => "SIZES_CLOTHES",
								3 => "",
							),
							"OFFERS_SORT_FIELD" => "sort",
							"OFFERS_SORT_ORDER" => "desc",
							"OFFERS_SORT_FIELD2" => "id",
							"OFFERS_SORT_ORDER2" => "desc",
							"OFFERS_LIMIT" => "5",
							"TEMPLATE_THEME" => "site",
							"PRODUCT_DISPLAY_MODE" => "Y",
							"ADD_PICT_PROP" => "BIG_PHOTO",
							"LABEL_PROP" => "-",
							"OFFER_ADD_PICT_PROP" => "-",
							"OFFER_TREE_PROPS" => array(
								0 => "COLOR_REF",
								1 => "SIZES_SHOES",
								2 => "SIZES_CLOTHES",
							),
							"PRODUCT_SUBSCRIPTION" => "N",
							"SHOW_DISCOUNT_PERCENT" => "N",
							"SHOW_OLD_PRICE" => "Y",
							"SHOW_CLOSE_POPUP" => "N",
							"MESS_BTN_BUY" => "Купить",
							"MESS_BTN_ADD_TO_BASKET" => "В корзину",
							"MESS_BTN_SUBSCRIBE" => "Подписаться",
							"MESS_BTN_DETAIL" => "Подробнее",
							"MESS_NOT_AVAILABLE" => "Нет в наличии",
							"SECTION_URL" => "",
							"DETAIL_URL" => "",
							"SECTION_ID_VARIABLE" => "SECTION_ID",
							"SEF_MODE" => "N",
							"AJAX_MODE" => "N",
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "Y",
							"AJAX_OPTION_HISTORY" => "N",
							"AJAX_OPTION_ADDITIONAL" => "",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "36000000",
							"CACHE_GROUPS" => "N",
							"SET_TITLE" => "N",
							"SET_BROWSER_TITLE" => "Y",
							"BROWSER_TITLE" => "-",
							"SET_META_KEYWORDS" => "Y",
							"META_KEYWORDS" => "-",
							"SET_META_DESCRIPTION" => "Y",
							"META_DESCRIPTION" => "-",
							"SET_LAST_MODIFIED" => "N",
							"USE_MAIN_ELEMENT_SECTION" => "N",
							"ADD_SECTIONS_CHAIN" => "N",
							"CACHE_FILTER" => "N",
							"ACTION_VARIABLE" => "action",
							"PRODUCT_ID_VARIABLE" => "id",
							"PRICE_CODE" => array(
								0 => "BASE",
							),
							"USE_PRICE_COUNT" => "N",
							"SHOW_PRICE_COUNT" => "1",
							"PRICE_VAT_INCLUDE" => "Y",
							"CONVERT_CURRENCY" => "N",
							"USE_PRODUCT_QUANTITY" => "N",
							"PRODUCT_QUANTITY_VARIABLE" => "",
							"ADD_PROPERTIES_TO_BASKET" => "Y",
							"PRODUCT_PROPS_VARIABLE" => "prop",
							"PARTIAL_PRODUCT_PROPERTIES" => "N",
							"PRODUCT_PROPERTIES" => array(
							),
							"OFFERS_CART_PROPERTIES" => array(
								0 => "COLOR_REF",
								1 => "SIZES_SHOES",
								2 => "SIZES_CLOTHES",
							),
							"ADD_TO_BASKET_ACTION" => "ADD",
							"PAGER_TEMPLATE" => "round",
							"DISPLAY_TOP_PAGER" => "N",
							"DISPLAY_BOTTOM_PAGER" => "Y",
							"PAGER_TITLE" => "Товары",
							"PAGER_SHOW_ALWAYS" => "N",
							"PAGER_DESC_NUMBERING" => "N",
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
							"PAGER_SHOW_ALL" => "N",
							"PAGER_BASE_LINK_ENABLE" => "N",
							"SET_STATUS_404" => "N",
							"SHOW_404" => "N",
							"MESSAGE_404" => "",
							"BACKGROUND_IMAGE" => "-",
							"DISABLE_INIT_JS_IN_COMPONENT" => "N"
						),
						false
					);?>
					<div data-retailrocket-markup-block="5b55e34397a528425c3cea68"></div>
				<?}?>
            </div>
            <?
            }
        ?>


    </div>
</div>
<script>
    $(document).ready(function(){
        <?/*if ($_REQUEST["action"]) {?>
            $(".cartMenuWrap .basketItems:first-child").removeClass("active");
            $('.cartMenuWrap .basketItems:nth-child(2)').addClass("active");
            $("#cardBlock2").show();
		<?} else if (!$_REQUEST["liked"]) {?>
            $('.cartMenuWrap .basketItems:nth-child(2)').removeClass("active");
            $('.cartMenuWrap .basketItems:first-child').addClass("active");
            $("#cardBlock1").show();
		<?}*/?>
		dataLayer.push({event: 'EventsInCart', action: '1st Step', label: 'pageLoaded'});
        if ($(".gifts_block").find("div").size() > 0) {
            $(".gifts_block").show();
        }
		<?if (checkMobile()) {?>
			$('#cardBlock1').show();
		<?}?>
        $(".bx_ordercart_coupon span").on("click", function(){
            <?if ($_SESSION["CUSTOM_COUPON"]["DEFAULT_COUPON"] == "N" && $_SESSION["CUSTOM_COUPON"]["COUPON_VALUE"] > 0) {
                $_SESSION["CUSTOM_COUPON"] = array();
            }?>
        });
    });
</script>
