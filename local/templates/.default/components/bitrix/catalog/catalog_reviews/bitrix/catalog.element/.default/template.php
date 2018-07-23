<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
    /** @var CBitrixComponent $component */
    $this->setFrameMode(true);
    $checkMobile = checkMobile();
    include_once($_SERVER["DOCUMENT_ROOT"].'/custom-scripts/checkdelivery/options.php');
?>
<?global $USER;?>
<?if($arResult["PROPERTIES"]["FOR_ADMIN"]["VALUE"] == "Y" && !$USER->IsAdmin()){
    LocalRedirect('/404.php', '301 Moved permanently');
}?>
<script>
    $(document).ready(function(){
        <!-- //dataLayer GTM -->
        dataLayer.push({
            'stockInfo' : '<?= $StockInfo ?>',
            'productId' : '<?= $arResult["ID"] ?>',
            'productName' : '<?= $arResult["NAME"] ?>',
            'productPrice' : '<?= round (($arPrice["DISCOUNT_VALUE_VAT"]), 2) ?>',
            'videoPresence' : '<?= $videosCount > 0 ? 'WithVideo' : 'WithoutVideo'; ?>'
        });
        <!-- // dataLayer GTM -->

        $(".elementMainPict .overlay").css("height", $(".element_item_img img").height());
        $(".elementMainPict .overlay p").css("margin-top", ($(".elementMainPict .overlay").height() / 2) - 10);
        if ($(".element_item_img img").height() < 562 && $(".element_item_img img").height() > 100) {
            $(".element_item_img").height($(".element_item_img img").height());
        }

        if (window.innerWidth <= 1500) {
            $(".catalogIcon").hide();
            $(".basketIcon").hide();
        }

        $(".buyLater").click(function(){
            $.post("/ajax/ajax_add2wishlist.php", {id: <?= $arResult["ID"] ?>}, function(data){
                $(".layout").show();
                $(".wishlist_info").css("top", window.pageYOffset+"px")
                $(".wishlist_info").show();
                $(".wishlist_info span").html(data);

            })
        });

        docReadyComponent(<?= $arResult["ID"] ?>);
		
		<?if (!empty($arResult["PROPERTIES"]["second_book_name"]["VALUE"]) && !$checkMobile) {?>
			var firstBookName = '<?=$arResult["PROPERTIES"]["SECOND_NAME"]["VALUE"]?>';
			var secondBookName = '<?=$arResult["PROPERTIES"]["second_book_name"]["VALUE"]?>';
			var thirdBookName = '<?=$arResult["PROPERTIES"]["second_book_name"]["VALUE"]?>';

			var mainPicture = '<?=$arResult["PICTURE"]["src"]?>';
			var secondBookImg = '<?=$arResult["SECOND_PICTURE"];?>';
			var thirdBookImg = '<?=$arResult["THIRD_PICTURE"];?>';

			$('.multipleBooks li').click(function() {
				if ($(this).is(':not(.active')) {
					$('.multipleBooks .active').removeClass('active');
					$(this).addClass("active");

					if ($(this).attr("data-book") == 2) {
						$("h1 .secondPart").text(secondBookName);
						$(".bookPreviewLink img").attr('src',secondBookImg);
					} else if ($(this).attr("data-book") == 3) {
						$("h1 .secondPart").text(thirdBookName);
						$(".bookPreviewLink img").attr('src',thirdBookImg);
					} else {
						$("h1 .secondPart").text(firstBookName);
						$(".bookPreviewLink img").attr('src',mainPicture);
					}
				}
			});
		<?}?>
    });
	<?if (!$checkMobile) {?>
		$(document).ready(function(){
			$(".bookPrice span, .newPrice span").html('i');
		});
		$(window).scroll(function() { //Скрываем блок с ценой при скролле вниз, расширяем блок аннотации и опускаем его на уровень глаз
			scrollDepth = $(window).scrollTop();
			if (scrollDepth > 450 && checkReadiness == 0) {
				$(".centerColumn").css("margin-right", "0");
				$(".showAllWrapp").css("padding-top", "110px");

				$(".rightColumn").hide();

				checkReadiness = 1;
			} else if (scrollDepth < 450) {
				$(".centerColumn").css("margin-right", "264px");
				$(".showAllWrapp").css("padding-top", "0");
				$(".rightColumn").show();
				checkReadiness = 0;
			}
		});
	<?}?>
</script>

<script src="/local/templates/.default/components/bitrix/catalog/catalog_template/bitrix/catalog.element/.default/certificate_script.js?<?=filemtime($_SERVER["DOCUMENT_ROOT"].'/local/templates/.default/components/bitrix/catalog/catalog_template/bitrix/catalog.element/.default/certificate_script.js')?>"></script>

<?if (!empty($arResult["PROPERTIES"]["colors"]["VALUE"]) && $arResult["PROPERTIES"]["colors"]["VALUE"] != ',') {
	$arResult["PROPERTIES"]["colors"]["VALUE"] = explode(',',$arResult["PROPERTIES"]["colors"]["VALUE"]);
	$bgcolors[0] = $arResult["PROPERTIES"]["colors"]["VALUE"][1];
	$mincolor['color'] = $arResult["PROPERTIES"]["colors"]["VALUE"][0];

} else {

    include_once($_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/colors.inc.php');

    $image_to_read = $_SERVER["DOCUMENT_ROOT"] . "/" .$arResult["PICTURE"]["src"];

    $colors_to_show = 8;

    $pal = new GetMostCommonColors();
    $pal->image = $image_to_read;
    $colors=$pal->Get_Color();
    $colors_key=array_keys($colors);
    $mincolor = array();

    $bgcolors = array();
    for ($i = 0; $i < $colors_to_show; $i++) {
        $bgcolors[] = "#".$colors_key[$i];
        $hexToRgbMess = hexToRgb($bgcolors[$i]);
        $mincolor[$i]['sum'] = $hexToRgbMess['red'] + $hexToRgbMess['green'] + $hexToRgbMess['blue'];
        $mincolor[$i]['color'] = "#".$colors_key[$i];
    }
    $mincolor = min($mincolor);

    $m = 0;
    $hexToRgbMess = hexToRgb($bgcolors[$m]);
    while ($hexToRgbMess['red'] > 190 && $hexToRgbMess['green'] > 190 && $hexToRgbMess['blue'] > 190 || ($hexToRgbMess['red'] > 200 && $hexToRgbMess['green'] > 200 && $hexToRgbMess['blue'] < 100) || ($hexToRgbMess['red'] > 190 && $hexToRgbMess['green'] < 90 && $hexToRgbMess['blue'] < 90)) {
        $m++;
        $bgcolors[0] = $bgcolors[$m];
        $hexToRgbMess = hexToRgb($bgcolors[$m]);
    }
    $hexToRgbMess = hexToRgb($bgcolors[$m]);
    $bgsum = $hexToRgbMess['red'] + $hexToRgbMess['green'] + $hexToRgbMess['blue'];

    if ($bgsum < 20)
        $bgcolors[0] = "#777777";

    if ($mincolor['sum'] > 320 || ($mincolor['sum'] > 280 && $mincolor['color'] == $bgcolors[0]) || $mincolor['color'] == '#') {
        $mincolor['color'] = "#555";
    }

	CIBlockElement::SetPropertyValuesEx($arResult["ID"], 4, array('colors' => $mincolor['color'].','.$bgcolors[0]));
}
?>
<style>
    .productElementWrapp:before {
        background-color: <?=$bgcolors[0]?>;
        opacity: 0.15;
    }
    .centerColumn .productName, .breadCrump span a, .breadCrump, .centerColumn .engBookName, .centerColumn .productAutor, .catalogIcon span, .basketIcon span, .crr, .crr .mc-star span, #diffversions .passive, .multipleBooks li span,.previewLink {
        color: <?=$mincolor['color']?>!important;
    }
    #diffversions .passive span, .multipleBooks li span,.previewLink {
        border-bottom: 1px dashed <?=$mincolor['color']?>;
    }
    .catalogIcon {
        background: <?=$bgcolors[0]?> url(/img/catalogIco.png) no-repeat center;
        opacity: 0.8;
    }
    .basketIcon {
        background: <?=$bgcolors[0]?> url(/img/basketIcoHovers.png) no-repeat center;
        opacity: 0.8;
    }
</style>

<?
    $templateLibrary = array('popup');
    $currencyList = '';
    if (!empty($arResult['CURRENCIES'])) {
        $templateLibrary[] = 'currency';
        $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
    }
    $templateData = array(
        'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
        'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
        'TEMPLATE_LIBRARY' => $templateLibrary,
        'CURRENCIES' => $currencyList,
        'OG_IMAGE' => $arResult["PICTURE"]["src"]
    );
    unset($currencyList, $templateLibrary);

    $strMainID = $this->GetEditAreaId($arResult['ID']);
    $arItemIDs = array(
        'ID' => $strMainID,
        'PICT' => $strMainID.'_pict',
        'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
        'STICKER_ID' => $strMainID.'_sticker',
        'BIG_SLIDER_ID' => $strMainID.'_big_slider',
        'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
        'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
        'SLIDER_LIST' => $strMainID.'_slider_list',
        'SLIDER_LEFT' => $strMainID.'_slider_left',
        'SLIDER_RIGHT' => $strMainID.'_slider_right',
        'OLD_PRICE' => $strMainID.'_old_price',
        'PRICE' => $strMainID.'_price',
        'DISCOUNT_PRICE' => $strMainID.'_price_discount',
        'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
        'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
        'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
        'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
        'QUANTITY' => $strMainID.'_quantity',
        'QUANTITY_DOWN' => $strMainID.'_quant_down',
        'QUANTITY_UP' => $strMainID.'_quant_up',
        'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
        'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
        'BASIS_PRICE' => $strMainID.'_basis_price',
        'BUY_LINK' => $strMainID.'_buy_link',
        'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
        'BASKET_ACTIONS' => $strMainID.'_basket_actions',
        'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
        'COMPARE_LINK' => $strMainID.'_compare_link',
        'PROP' => $strMainID.'_prop_',
        'PROP_DIV' => $strMainID.'_skudiv',
        'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
        'OFFER_GROUP' => $strMainID.'_set_group_',
        'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
    );
?>
<div class="elementDescriptWrap" itemscope itemtype="https://schema.org/Book">
    <meta itemprop="inLanguage" content="ru-RU"/>
    <div class="certificate_popup" style="display:none">
        <form id="certificate_form">
            <div class="certificate_buy_type">
                <ul>
                    <li data-popup-block="natural_person" class="certificate_tab_active"><?= GetMessage("NATURAL_PERSON") ?></li>
                    <li data-popup-block="legal_person"><?= GetMessage("LEGAL_PERSON") ?></li>
                </ul>
            </div>
            <div class="popup_form_data">
                <div class="natural_person active_certificate_block">
                    <input type='text' placeholder="Имя" name="natural_name" id="natural_name">
                    <br>
                    <input type='email' placeholder="Email" name="natural_email" id="natural_email">
                    <br>
                    <a href="#" class="certificate_buy_button" onclick="create_certificate_order(); return false;"><?= GetMessage("PAY") ?></a>
                </div>
                <div class="legal_person">
                    <input type='text' placeholder="Наименование" name="legal_name" id="legal_name">
                    <br>
                    <input type='email' placeholder="Email" name="legal_email" id="legal_email">
                    <br>
                    <input type='text' placeholder="ИНН" name="inn" id="inn">
                    <br>
                    <input type='text' placeholder="КПП" name="kpp" id="kpp">
                    <br>
                    <input type='text' placeholder="БИК" name="bik" id="bik">
                    <br>
                    <input type='text' placeholder="Расчетный счет" name="settlement_account" id="settlement_account">
                    <br>
                    <input type='text' placeholder="Корр. счет" name="corresponded_account" id="corresponded_account">
                    <br>
                    <input type='text' placeholder="Наименование банка" name="bank_title" id="bank_title">
                    <br>
                    <input type='text' placeholder="Юридический адрес" name="legal_address" id="legal_address">
                    <br>
                    <a href="#" class="certificate_buy_button" onclick="create_certificate_order(); return false;"><?= GetMessage("PAY") ?></a>
                </div>
            </div>
            <input type="hidden" name="certificate_name" value="<?= $arResult['NAME'] ?>"/>
            <input type="hidden" name="certificate_quantity" value="1"/>
            <input type="hidden" name="certificate_price" value="<?=$arResult['PRICES']['BASE']['VALUE']?>"/>
            <input type="hidden" name="basket_rule" value="<?= preg_replace("/[^0-9]/", '', $arResult['XML_ID']);?>"/>
        </form>
        <div class="certificate_popup_close closeIcon"></div>
        <div class="rfi_block">
        <?
            $APPLICATION->IncludeComponent(
                "webgk:rfi.widget",
                "",
                Array(
                    "ORDER_ID"      => "CERT_",
                    "OTHER_PAYMENT" => "Y",
                    "OTHER_PARAMS"  => array(
                        "PAYSUM"   => $newPrice,
                        "EMAIL"    => "",
                        "PHONE"    => "",
                        "COMMENT"  => str_replace("#SUM#", $newPrice, "Покупка сертификата на сайте alpinabook.ru на сумму #SUM# рублей")
                    )
                ),
                false
            );
        ?>
        </div>
    </div>
    <div class="leftColumn">
        <div class="elementMainPict">
            <div class="badge">
                <?if (($arResult["PROPERTIES"]["discount_ban"]["VALUE"] != "Y")
                    && $arResult['PROPERTIES']['spec_price']['VALUE']
                    && $arResult['PROPERTIES']['show_discount_icon']['VALUE'] == "Y") {
                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/img/" . $arResult['PROPERTIES']['spec_price']['VALUE'] . "percent.png")) {
                        echo '<img class="discount_badge" src="/img/' . $arResult['PROPERTIES']['spec_price']['VALUE'] . 'percent.png">';
                    }
                }?>
            </div>
            <?
                if (isset($arResult["additional_image"]["DETAIL_PICTURE"]["src"])) {
                    echo '<div class="additional-image" ><img src="' . $arResult["additional_image"]["DETAIL_PICTURE"]["src"] . '"></div>';
                }
            ?>

            <div class="element_item_img">
                <?if (($arResult["PHOTO_COUNT"] > 0) && ($arResult["MAIN_PICTURE"] != '')) {?>
                    <?if (!$checkMobile) {?>
                        <a href="#" class="bookPreviewLink" onclick="getPreview(<?= $arResult["ID"] ?>, <?echo ($arResult['PROPERTIES']['STATE']['VALUE_XML_ID'] != 'soon' && $arResult['PROPERTIES']['STATE']['VALUE_XML_ID'] != 'net_v_nal') ? 1 : 0;?>);return false;">
					<?} else {?>
                        <a href="<?= $arResult["MAIN_PICTURE"] ?>" class="bookPreviewLink">
					<?}?>
					<p class="bookPreviewButton bookPreviewLink"><?= GetMessage("BROWSE_THE_BOOK") ?></p>
				<?} else {?>
					<a href="#" class="bookPreviewLink" onclick="return false;">
				<?}?>

				<?if ($arResult["PICTURE"]["src"]) {?>
					<img src="<?= $arResult["PICTURE"]["src"] ?>" itemprop="image" class="bookPreviewLink" alt="<?= $arResult["NAME"] ?>" title="Обложка книги: <?= $arResult["NAME"] ?>" />
				<?} else {?>
					<img src="/images/no_photo.png">
				<?}?>

				<?if(!empty($arResult["PROPERTIES"]["number_volumes"]["VALUE"])) {?>
					<span class="volumes"><?= $arResult["PROPERTIES"]["number_volumes"]["VALUE"] ?></span>
				<?}?>
				</a>
            </div>
        </div>
        <div class="marks"<?if ($arResult["PROPERTIES"]["page_views_ga"]["VALUE"] > 2) {?> style="min-height:30px;"<?}?>>
            <?if ($arResult["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"] == NEW_BOOK_STATE_XML_ID) {?>
                <div class="newBookMark">
                    <p><?= GetMessage("NEW_BOOK") ?></p>
                    <span class="ttip">
                        <?= GetMessage("NEW_BOOK_TIP") ?>
                    </span>
                </div>
                <?}?>
            <?if ($arResult["PROPERTIES"]["best_seller"]["VALUE_ENUM_ID"] == BESTSELLER_BOOK_XML_ID) {?>
                <div class="bestBookMark">
                    <p><?= GetMessage("BESTSELLER_BOOK") ?></p>
                    <span class="ttip">
                        <?= GetMessage("BESTSELLER_TIP") ?>
                    </span>
                </div>
                <?}?>
            <?if ($arResult["PROPERTIES"]["editors_choice"]["VALUE_ENUM_ID"] == 235) {?>
                <div class="editorsBookMark">
                    <p><?= GetMessage("EDITORS_CHOICE") ?></p>
                    <span class="ttip">
                        <?= GetMessage("EDITORS_CHOICE_TIP") ?>
                    </span>
                </div>
			<?}?>

			<?$frame = $this->createFrame()->begin();?>
                <div class="no-mobile ga-views">
                    <img src="/img/eye_big.png?1" align="center" alt="Просмотров за сутки" />
                    <span class="bookViews"><?=$arResult["PROPERTIES"]["page_views_ga"]["VALUE"]?></span>
                    <span class="ttip"><?=GetMessage("VIEWS_A_DAY");?></span>
                </div>
			<?$frame->end();?>

            <?if ((!empty($arResult["PROPERTIES"]["appstore"]['VALUE']) || !empty($arResult["PROPERTIES"]["rec_for_ad"]['VALUE'])) && $arResult['PROPERTIES']['STATE']['VALUE_XML_ID'] != 'soon' && $arResult["ID"] != 81365 && $arResult['PROPERTIES']['STATE']['VALUE_XML_ID'] != 'net_v_nal'  && !empty($arResult["PROPERTIES"]["alpina_digital_price"]['VALUE'])) {?>
                <?if (!empty($arResult["PROPERTIES"]["appstore"]['VALUE'])) {?>
                    <br />
                    <div class="digitalBookMark">
                        <p><span class="test"><?=GetMessage("FREE_DIGITAL_BOOK") ?></span></p>
                        <span class="ttip"><?=GetMessage("YOU_WILL_GET_FREE_DIGITAL_BOOK")?></span>
                    </div>
                    <?}?>
                <?}?>
        </div>


        <?if ($arResult["PROPERTIES"]["AUTHOR_SIGNING"]["VALUE"]) {?>
            <a href="<?= $arResult["SIGN_PICTURE"] ?>" class="signingPopup">
                <div class="authorSigning">
                </div>

                <div class="authorSigningText">
                    <?= GetMessage("SIGNED_BOOK") ?>
                </div>
            </a>
		<?}?>
		<?$frame = $this->createFrame()->begin();?>
        <?if ($USER -> IsAuthorized()) {
            if ($arResult["WISHLIST_ITEM"]) {?>
            <a href="/personal/cart/?liked=yes" title="<?= GetMessage("WISHLIST_IN_BASKET") ?>">
                <p class="AlreadyInWishlist"><?= GetMessage("ALREADY_IN_WISHLIST") ?></p>
            </a>
            <?} else {?>
            <a href="javascript:void(0); return true;" onclick="dataLayer.push({event: 'addToWishList'});yaCounter1611177.reachGoal('addToWishlist');">
                <p class="buyLater"><?= GetMessage("TO_BUY_LATER") ?></p>
            </a>
            <?}
        }?>
        <div class="wishlist_info">
            <div class="CloseWishlist"><img src="/img/catalogLeftClose.png"></div>
            <span></span>
        </div>
		<?$frame->beginStub();?>
		<?$frame->end();?>
        <?if (!empty($arResult["PROPERTIES"]["glavatitle"]["VALUE"])) {?>
            <style>
                .productElementWrapp {min-height:1300px;}
                .authorBooksWrapp, .weRecomWrap {clear:both;}
            </style>
            <div class="takePartWrap">
                <p class="title"><?= GetMessage("TO_GET_A_CHAPTER") ?></p>
                <p class="text">Глава «<?=$arResult["PROPERTIES"]["glavatitle"]["VALUE"]?>» будет отправлена вам на почту</p>
                <input type="text" placeholder="<?= GetMessage("YOUR_EMAIL") ?>" value="<?= $arResult["MAIL"]; ?>" id="chapter-email" name="email" /><button onclick="sendchapter(<?=$arResult[ID];?>);">
            </div>
            <?}?>
        <?if ($arResult["PROPERTIES"]["ol_opis"]["VALUE_ENUM_ID"] != 233) {?>
            <?if ($arResult["PROPERTIES"]["PUBLISHER"]["VALUE"]) {?>
                <div class="characteris">
                    <p class="title"><?= GetMessage("PUBLISHER") ?></p>
                    <p class="text">
                        <span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                            <span itemprop="name">
                                <?= $arResult["PROPERTIES"]["PUBLISHER"]["VALUE"] ?>
                            </span>
                            <?if (strstr($arResult["PROPERTIES"]["PUBLISHER"]["VALUE"], "Альпина") !== false) {?>
                                <meta itemprop="telephone" content="+7 (495) 980-80-77" />
                                <meta itemprop="address" content="г.Москва, ул.4-ая Магистральная, д.5, подъезд 2, этаж 2" />
                                <?}?>
                        </span>
                    </p>
                </div>
                <?}?> 
            <?if($arResult['IBLOCK_SECTION_ID'] != HANDBAG_SECTION_ID) {?>

            <?if($arResult["PROPERTIES"]["YEAR"]["VALUE"] != "" && $arResult["PROPERTIES"]["ol_opis"]["VALUE_ENUM_ID"] != 233) {?>
                <div class="characteris">
                    <p class="title"><?= $arResult["PROPERTIES"]["YEAR"]["NAME"] ?></p>
                    <p class="text">
                        <span itemprop="datePublished">
                            <?= $arResult["PROPERTIES"]["YEAR"]["VALUE"] ?>
                        </span>
                        г.
                        <?= !empty($arResult["PROPERTIES"]["edition_n"]["VALUE"]) ? '<br /><span itemprop="bookEdition">' . $arResult["PROPERTIES"]["edition_n"]["VALUE"] .'</span>' : ""?>
                    </p>
                </div>
                <?}?>
            <?if ($arResult["PROPERTIES"]["SERIES"]["VALUE"]) {?>
                <div class="characteris">
                    <p class="title"><?= GetMessage("SERIES") ?></p>
                    <a href="/series/<?= $arResult["CURR_SERIES"]["ID"] ?>/">
                        <span class="text"><?= $arResult["CURR_SERIES"]["NAME"] ?></span>
                    </a>
                </div>
                <?}?>
            <?if($arResult["PROPERTIES"]["COVER_TYPE"]["VALUE"] != "") {?>
                <div class="characteris epubHide">
                    <p class="title"><?= GetMessage("COVER_TYPE") ?></p>
                    <p class="text"><?= $arResult["PROPERTIES"]["COVER_TYPE"]["VALUE"] ?></p>
                    <?if ($arResult["PROPERTIES"]['COVER_TYPE']['VALUE_ENUM_ID'] == COVER_TYPE_SOFTCOVER_XML_ID) {?>
                        <link itemprop="bookFormat" href="https://schema.org/Paperback">
                        <?} else if ($arResult["PROPERTIES"]['COVER_TYPE']['VALUE_ENUM_ID'] == COVER_TYPE_HARDCOVER_XML_ID) {?>
                        <link itemprop="bookFormat" href="https://schema.org/Hardcover">
                        <?}?>
                </div>
                <?}?> 

            <div class="characteris epub" style="display:none;">
                <p class="title">Форматы</p>
                <p class="text">epub</p>
            </div>
            <?if ($arResult['CAN_BUY'] && $arResult['PROPERTIES']['STATE']['VALUE_XML_ID'] != 'soon' && $arResult["PROPERTIES"]["COVER_TYPE"]["VALUE"] != 'Аудиодиск' && $arResult["PROPERTIES"]["ol_opis"]["VALUE_ENUM_ID"] != 233) {?>
                <div class="characteris epubHide">
                    <a href="http://www.alpinab2b.ru/product/prodvinut-brend/izdanie-spetstirazha/" title="Издать тираж книги с символикой компании" target="_blank" onclick="dataLayer.push({event: 'otherEvents', action: 'specialEditionLink', label: '<?= $arResult['NAME'] ?>'});"><span class="text noborderlink">Хотите тираж со своим логотипом?</span></a>
                </div>
                <?}?>
            <?if ($arResult["PROPERTIES"]["PAGES"]["VALUE"]) {?>
                <div class="characteris">
                    <p class="title"><?= GetMessage("PAGES_COUNT") ?></p>
                    <p class="text"><span itemprop="numberOfPages"><?= $arResult["PROPERTIES"]["PAGES"]["VALUE"] ?></span><?= GetMessage("PAGES") ?></p>
                </div>
                <?}?>
            <?if ($arResult["PROPERTIES"]["ISBN"]["VALUE"]) {?>
                <div class="characteris">
                    <p class="title"><?= GetMessage("ISBN") ?></p>
                    <p class="text" itemprop="isbn"><?= $arResult["PROPERTIES"]["ISBN"]["VALUE"] ?></p>
                </div>
                <?}?>
            <?if ($arResult['CAN_BUY'] && $arResult['PROPERTIES']['STATE']['VALUE_XML_ID'] != 'soon' && $arResult["PROPERTIES"]["COVER_TYPE"]["VALUE"] != 'Аудиодиск' && $arResult["PROPERTIES"]["ol_opis"]["VALUE_ENUM_ID"] != 233) {?>
                <div class="characteris epubHide">
                    <a href="http://readright.ru/?=alpinabook" target="_blank">
                        <span class="text noborderlink"><?= GetMessage("HOW_TO_READ_A_BOOK_IN_A_HOUR") ?></span>
                    </a>
                </div>
                <?}?>
            <?if ($arResult["PROPERTIES"]["COVER_FORMAT"]["VALUE"]) {?>
                <div class="characteris epubHide">
                    <p class="title"><?= GetMessage("SIZES") ?></p>
                    <p class="text"><?= $arResult["PROPERTIES"]["COVER_FORMAT"]["VALUE"] ?></p>
                </div>
                <?}?>
            <?if ($arResult["PROPERTIES"]["DURATION"]["VALUE"]) {?>
                <div class="characteris">
                    <p class="title"><?= GetMessage("DURATION") ?></p>
                    <p class="text"><?= $arResult["PROPERTIES"]["DURATION"]["VALUE"] ?></p>
                </div>
                <?}?>
            <?}?>
        <?}?>

        <?if ($arResult["CATALOG_WEIGHT"]) {
                $weight = $arResult["CATALOG_WEIGHT"];
            } else if ($arResult["PROPERTIES"]["LATEST_WEIGHT"]["VALUE"]) {
                $weight = $arResult["PROPERTIES"]["LATEST_WEIGHT"]["VALUE"];
            }
            if ($weight) {?>
            <div class="characteris epubHide">
                <p class="title"><?= GetMessage("WEIGHT") ?></p>
                <p class="text"><?= $weight ?><?= GetMessage("GRAMS") ?></p>
            </div>
            <?}?>
        <?#Спонсоры книги?>
        <!-- noindex -->
        <div class="sponsors">

            <?foreach ($arResult["PROPERTIES"]["SPONSORS"]["VALUE"] as $val) {?>
                <span style="color:#627478"><?= $arResult["SPONSOR_PREVIEW_TEXT"] ?> </span><br />
                <?if (!empty($arResult["SPONSOR_PICT"])) {?>
                    <a href="<?= $arResult["SPONSOR_WEBSITE_VALUE"] ?>" class="sponsor_website" target="_blank"><img src="<?= $arResult["SPONSOR_PICT"] ?>"> </a>
                    <?} else {?>
                    <?= $authorFetchedList["NAME"] ?>
                    <?}?>

                <? $authors .= $author_fetched_list["NAME"] . ", ";?>
                <?}?>
        </div>
        <!-- /noindex -->
        <?##Спонсоры книги?>
    </div>
    <div class="rightColumn">
        <?if (!$checkMobile && intval ($arResult["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode (CATALOG_IBLOCK_ID, "STATE", "soon") && !empty ($arResult["PROPERTIES"]["appstore"]['VALUE'])  && !empty($arResult["PROPERTIES"]["alpina_digital_price"]['VALUE'])) {?>
            <div id="diffversions">
                <a href="#" onclick="selectversion($(this).attr('class'), $(this).attr('id'));return false;" id="paperversion" class="active"><span><?=GetMessage("PAPER_V")?></span></a>
                <a href="<?=substr($arResult['ORIGINAL_PARAMETERS']['CURRENT_BASE_PAGE'], 0, -9) . '-ebook/'?>" onclick="selectversion($(this).attr('class'), $(this).attr('id'));return false;" id="digitalversion" class="passive"><span><?=GetMessage("DIGITAL_V")?></span></a>
            </div>
            <?}?>
        <?$frame = $this->createFrame()->begin();?>
		<?if (!$checkMobile) {?>
			<script>
				$(".bookPrice span, .newPrice span").html('i');
			</script>
		<?}?>
        <div class="priceBasketWrap paperVersionWrap" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <meta itemprop="priceCurrency" content="RUB" />
            <link itemprop="itemCondition" href="http://schema.org/NewCondition">
            <meta itemprop="sku" content="<?=$arResult["ID"]?>" />
            <?
			if ($arResult["SAVINGS_DISCOUNT"][0]["SUMM"] > 0 || $arResult["CART_SUM"] > 0) {
				if ($USER->IsAuthorized()) {
                    if ($arResult["ITEM_WITHOUT_DISCOUNT"] == "Y") {
                        $discount = 0;
                    } elseif ($arResult["SAVINGS_DISCOUNT"][0]["SUMM"] < $arResult["SALE_NOTE"][0]["RANGE_FROM"]) {
                        $printDiscountText = "<span class='sale_price'>" . GetMessage("NOT_ENOUGH") . ($arResult["SALE_NOTE"][0]["RANGE_FROM"] - $arResult["SAVINGS_DISCOUNT"][0]["SUMM"]) . GetMessage("AMOUNT_UNTIL_DISCOUNT") . $arResult["SALE_NOTE"][0]["VALUE"] . "%</span><br />";
                    } elseif ($arResult["SAVINGS_DISCOUNT"][0]["SUMM"] < $arResult["SALE_NOTE"][1]["RANGE_FROM"]) {
                        $printDiscountText = "<span class='sale_price'>" . GetMessage("NOT_ENOUGH")  . ($arResult["SALE_NOTE"][1]["RANGE_FROM"] - $arResult["SAVINGS_DISCOUNT"][0]["SUMM"]) . GetMessage("AMOUNT_UNTIL_DISCOUNT") . $arResult["SALE_NOTE"][1]["VALUE"] . "%</span><br />";
                        $discount = $arResult["SALE_NOTE"][0]["VALUE"]; // процент накопительной скидки
                    } else {
                        $discount = $arResult["SALE_NOTE"][1]["VALUE"];  // процент накопительной скидки
                    }
                } else {
                    if ($arResult["ITEM_WITHOUT_DISCOUNT"] == "Y") {
                        $discount = 0;
                    } elseif ($arResult["CART_SUM"] < $arResult["SALE_NOTE"][0]["RANGE_FROM"]) {
                        $printDiscountText = "<span class='sale_price'>" . GetMessage("NOT_ENOUGH")  . ($arResult["SALE_NOTE"][0]["RANGE_FROM"] - $arResult["CART_SUM"]) . GetMessage("AMOUNT_UNTIL_DISCOUNT") . $arResult["SALE_NOTE"][0]["VALUE"] . "%</span><br />";
                    } elseif ($arResult["CART_SUM"] < $arResult["SALE_NOTE"][1]["RANGE_FROM"]) {
                        $printDiscountText = "<span class='sale_price'>" . GetMessage("NOT_ENOUGH")  . ($arResult["SALE_NOTE"][1]["RANGE_FROM"] - $arResult["CART_SUM"]) . GetMessage("AMOUNT_UNTIL_DISCOUNT") . $arResult["SALE_NOTE"][1]["VALUE"] . "%</span><br />";
                        $discount = $arResult["SALE_NOTE"][0]["VALUE"];  // процент накопительной скидки
                    } else {
                        $discount = $arResult["SALE_NOTE"][1]["VALUE"];  // процент накопительной скидки
                    }
				}
			}

			if ($arResult["CART_SUM"] > 0 && $arResult["CART_SUM"] < 2000) {//До бесплатной доставки осталось
				$printDiscountText = "<span class='sale_price'>".GetMessage("GET_FREE_DELIVERY").($arResult["FREE_DELIVERY"] - $arResult["CART_SUM"]).GetMessage("GET_FREE_DELIVERY_ENDING")."</span><br />";
			}?>
            <div class="wrap_prise_top">
                <?$StockInfo = "";
					$printDiscountText = typo($printDiscountText);
                    if (!empty($arResult["PRICES"])) { ?>
                    <?// если свойство товара в состоянии "Новинка" либо не задан - то выводить стандартный блок с ценой,
                        // иначе выводить дату выхода книги либо поле для ввода e-mail для запроса уведомления о поступлении
                        if ((intval ($arResult["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal")) && (intval ($arResult["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "soon"))) {
                            foreach ($arResult["PRICES"] as $code => $arPrice) {?>

                            <meta itemprop="price" content="<?=$arPrice["VALUE_VAT"]?>" />
                            <link itemprop="availability" href="https://schema.org/InStock">

                            <?$StockInfo = "InStock";
                                if (round(($arPrice["VALUE"]) * (1 - $discount / 100), 2) . " " . GetMessage("ROUBLES") == $arPrice["PRINT_VALUE"]) {
                                    $discount = false;
                                };

                                if ($arResult['IBLOCK_SECTION_ID'] != CERTIFICATE_SECTION_ID) {
									if ($arResult['PROPERTIES']['spec_price']['VALUE']) {?>
										<div class="oldPrice"><span class="cross"><?= $arPrice["PRINT_VALUE"] ?></span></div>
										 <p class="newPrice"><?= $arPrice["DISCOUNT_VALUE"] ?> <span>руб.</span></p>
									<?} elseif ($arPrice["DISCOUNT_DIFF_PERCENT"] > 0) {?>
                                    <div class="oldPrice"><span class="cross"><?= $arPrice["PRINT_VALUE"] ?></span> <span class="diff"><?echo '-'.$arPrice["VALUE_VAT"]+$newPrice.' <span style="font-family:RoubleSign"">'.GetMessage("ROUBLES").'</span>';?></span></div>
                                    <?// расчитываем накопительную скидку от стоимости
                                        if ($discount) {
                                            $newPrice = round (($arPrice["DISCOUNT_VALUE"]) * (1 - $discount / 100), 2);
                                            if (strlen (stristr($newPrice, ".")) == 2) {
                                                $newPrice .= "0";
                                            }
                                        } else {
                                            $newPrice = round (($arPrice["DISCOUNT_VALUE"]), 2);
                                            if (strlen (stristr($newPrice, ".")) == 2) {
                                                $newPrice .= "0";
                                            }
                                    }?>
                                    <p class="newPrice"><?= $newPrice ?> <span>руб.</span></p>
                                    <?} else if ($discount) {
                                        $newPrice = round (($arPrice["VALUE"]) * (1 - $discount / 100), 2);
                                        if (strlen (stristr($newPrice, ".")) == 2) {
                                            $newPrice .= "0";
                                    }?>
                                    <div class="oldPrice"><span class="cross"><?= $arPrice["PRINT_VALUE"] ?></span> <span class="diff"><?echo '-'.$arPrice["VALUE_VAT"]+$newPrice.' <span style="font-family:RoubleSign"">'.GetMessage("ROUBLES").'</span>';?></span></div>
                                    <?// расчитываем накопительную скидку от стоимости?>
                                    <p class="newPrice"><?= $newPrice ?> <span>руб.</span></p>
                                    <?} else {
                                        $newPrice = round($arPrice["VALUE_VAT"], 2);
                                        if (strlen(stristr($newPrice, ".")) == 2) {
                                            $newPrice .= "0";
                                    }?>
                                    <p class="newPrice"><?= $newPrice ?> <span>руб.</span></p>
                                    <?}?>
                                <?} else {?>
                                    <p class="newPrice"><?= $arPrice["VALUE"] ?> <span>руб.</span></p>
                                <?}?>

                            <?if ($printDiscountText != '' && $arResult["PROPERTIES"]["ol_opis"]["VALUE_ENUM_ID"] != 233) {
                                echo $printDiscountText; // цена до скидки
                            }?>
                            <button class="inStockCirlce"></button><span>&nbsp;<?= GetMessage("IN_STOCK") ?></span>
                            <?}
                        } else if ($arResult["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"] == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "soon")) { ?>
                        <meta itemprop="price" content="<?=$arPrice["VALUE_VAT"]?>" />
                        <link itemprop="availability" href="https://schema.org/PreOrder">
                        <meta itemprop="availabilityStarts" content="<?=date('Y-m-d', MakeTimeStamp($arResult['PROPERTIES']['SOON_DATE_TIME']['VALUE'], "DD.MM.YYYY HH:MI:SS"))?>" />
                        <p class="newPriceText"><?= GetMessage("EXPECTED_DATE") ?><?= strtolower(FormatDate("j F", MakeTimeStamp($arResult['PROPERTIES']['SOON_DATE_TIME']['VALUE'], "DD.MM.YYYY HH:MI:SS"))); ?></p>

                        <?foreach ($arResult["PRICES"] as $code => $arPrice) {?>
                            <?$StockInfo = "SoonStock";
                                if (round(($arPrice["VALUE"]) * (1 - $discount / 100), 2) . " " . GetMessage("ROUBLES") == $arPrice["PRINT_VALUE"]) {
                                    $discount = false;
                                };
                                if ($arPrice["DISCOUNT_DIFF_PERCENT"] > 0) {?>
                                <div class="oldPrice"><span class="cross"><?= $arPrice["PRINT_VALUE"] ?></span> <span class="diff"><?echo '-'.$arPrice["VALUE_VAT"]+$newPrice.' <span style="font-family:RoubleSign"">'.GetMessage("ROUBLES").'</span>';?></span></div>
                                <?// расчитываем накопительную скидку от стоимости
                                    if ($discount) {
                                        $newPrice = round (($arPrice["DISCOUNT_VALUE"]) * (1 - $discount / 100), 2);
                                        if (strlen (stristr($newPrice, ".")) == 2) {
                                            $newPrice .= "0";
                                        }
                                    } else {
                                        $newPrice = round (($arPrice["DISCOUNT_VALUE"]), 2);
                                        if (strlen (stristr($newPrice, ".")) == 2) {
                                            $newPrice .= "0";
                                        }
                                }?>
                                <p class="newPrice"><?= $newPrice ?> <span>руб.</span></p>
                                <?} else if ($discount) {
                                    $newPrice = round (($arPrice["VALUE"]) * (1 - $discount / 100), 2);
                                    if (strlen (stristr($newPrice, ".")) == 2) {
                                        $newPrice .= "0";
                                }?>
                                <div class="oldPrice"><span class="cross"><?= $arPrice["PRINT_VALUE"] ?></span> <span class="diff"><?echo '-'.$arPrice["VALUE_VAT"]+$newPrice.' <span style="font-family:RoubleSign"">'.GetMessage("ROUBLES").'</span>';?></span></div>
                                <?// расчитываем накопительную скидку от стоимости?>
                                <p class="newPrice"><?= $newPrice ?> <span>руб.</span></p>
                                <?} else {
                                    $newPrice = round($arPrice["VALUE_VAT"], 2);
                                    if (strlen(stristr($newPrice, ".")) == 2) {
                                        $newPrice .= "0";
                                }?>
                                <p class="newPrice"><?= $newPrice ?> <span>руб.</span></p>
                                <?}?>
                            <button style="width:10px; height:10px; background:rgba(255, 255, 0, 0.75); box-shadow: inset 0px 0px 2px 0px rgba(0,0,0,0.12); border-radius:10px;padding: 0;border: 0;margin-left:-20px;vertical-align: middle;"></button><span>&nbsp;<?= GetMessage("ADD_TO_PREORDER") ?></span>
                            <?}?>
                        <?} else {?>
                        <meta itemprop="price" content="<?=$arPrice["VALUE_VAT"]?>" />
                        <link itemprop="availability" href="https://schema.org/OutOfStock">
                        <?$StockInfo = "OutOfStock";?>
                        <?foreach ($arResult["PRICES"] as $code => $arPrice) {
                            if ($arPrice["DISCOUNT_DIFF"]) {?>
                                <div class="oldPrice"><span class="cross"><?= $arPrice["PRINT_VALUE"] ?></span> <span class="diff"><?echo '-'.$arPrice["VALUE_VAT"]+$newPrice.' <span style="font-family:RoubleSign"">'.GetMessage("ROUBLES").'</span>';?></span></div>
                            <?}?>
                            <?if ($arPrice["DISCOUNT_VALUE_VAT"]) {
                                $newPrice = round(($arPrice["DISCOUNT_VALUE_VAT"]), 2);
                                if (strlen(stristr($newPrice, ".")) == 2) {
                                    $newPrice .= "0";
                                }?>
                                <p class="newPrice"><?= $newPrice ?> <span>руб.</span></p>
                                <?} else {
                                    $newPrice = round(($arPrice["ORIG_VALUE_VAT"]), 2);
                                    if (strlen(stristr($newPrice, ".")) == 2) {
                                        $newPrice .= "0";
                                }?>
                                <p class="newPrice"><span><?= $newPrice ?></span> <span>руб.</span></p>
                                <?}?>
                            <?}?>
                        <p class="newPrice notAvailable" style="font-size:28px;"><?= GetMessage("NOT_IN_STOCK") ?></p>
                        <?}?>
                    <?if ((intval($arResult["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal"))) {?>
                        <form>
                            <div>
                                <p>
                                    <span class="subscribeDesc"><?= GetMessage("SUBSCRIBING_DESCRIPTION") ?></span>
                                </p>
                                <input data-book_id="<?= $arResult['ID'] ?>" type="text" value="<?= $arResult["MAIL"]; ?>" name="email" class="subscribeEmail" placeholder="Ваш e-mail" />
                                <input type="button" onclick="newSubFunction(this);" class="getSubscribe" id="outOfStockClick" value="<?= GetMessage("TO_SUBSCRIBE") ?>"/>

                            </div>
                        </form>
                        <?}?>
                    <?} else {?>
                    <p class="newPrice" style="font-size:28px;"><?= GetMessage("NOT_IN_STOCK") ?></p>
                    <form>
                        <div>
                            <p>
                                <span class="subscribeDesc"><?= GetMessage("SUBSCRIBING_DESCRIPTION") ?></span>
                            </p>
                            <input data-book_id="<?= $arResult['ID'] ?>" type="text" value="<?= $arResult["MAIL"]; ?>" name="email" class="subscribeEmail" placeholder="Ваш e-mail" />
                            <input type="button" onclick="newSubFunction(this);" class="getSubscribe" id="outOfStockClick" value="<?= GetMessage("TO_SUBSCRIBE") ?>"/>
                        </div>
                    </form>
                    <?}?>
            </div>
            <?if (!empty ($arResult["PRICES"]) ) {?>
                <?if ((intval($arResult["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal"))) {?>
                    <div class="wrap_prise_bottom">
                        <span class="item_buttons_counter_block">

                            <a href="#" onclick="changeQ('-');return false;" class="minus" id="<?= $arResult['QUANTITY_DOWN']; ?>">&minus;</a>
                            <input id="<?= $arResult['QUANTITY']; ?>" type="text" class="tac transparent_input" value="<?= (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
                                    ? 1
                                    : $arResult['CATALOG_MEASURE_RATIO']
                                ); ?>">
                            <a href="#" onclick="changeQ('+');return false;" class="plus" id="<?= $arResult['QUANTITY_UP']; ?>">+</a>
                        </span>
                        <? if ($arResult['IBLOCK_SECTION_ID'] == CERTIFICATE_SECTION_ID) { ?>
                            <?
                            global $USER;
                            ?>
                            <a href="javascript:void(0);" onclick="buy_certificate_popup(); return false;">
                                <p class="inBasket"><?= GetMessage("CT_BCE_CATALOG_BUY") ?></p>
                            </a>
                            <div id="loadingInfo" style="display:none;"><div class="spinner"><div class="spinner-icon"></div></div></div>
                            <?} elseif ($arResult["ITEM_IN_BASKET"]["QUANTITY"] == 0) {?>
                            <a href="#" onclick="addtocart(<?= $arResult["ID"]; ?>, '<?= $arResult["NAME"]; ?>', '<?= $arResult["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]?>'); addToCartTracking(<?= $arResult["ID"]; ?>, '<?= $arResult["NAME"]; ?>', '<?= $arResult["PRICES"]["BASE"]["VALUE"] ?>', '<?= $arResult['SECTION']['NAME']; ?>', '1'); return false;">
                                <?if(intval ($arResult["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode (CATALOG_IBLOCK_ID, "STATE", "soon")) {?>
                                    <p class="inBasket"><?= GetMessage("ADD_IN_BASKET") ?></p>
                                    <?} else {?>
                                    <p class="inBasket toPreorder"><?= GetMessage("ADD_TO_PREORDER_FULL") ?></p>
                                    <?}?>
                            </a>
                            <div id="loadingInfo" style="display:none;"><div class="spinner"><div class="spinner-icon"></div></div></div>
                            <?} else {?>
                            <a href="/personal/cart/"><p class="inBasket" style="background-color: #A9A9A9;"><?= GetMessage("ALREADY_IN_BASKET") ?></p></a>
                            <?}?>
                        <a href="javascript:void(0);"><p class="buyOneClick"><?= GetMessage("TO_BUY_IN_1_CLICK") ?></p></a>
                    </div>
                    <?}?>
					<!--noindex--><div class="bookid">Код книги: <?=$arResult["ID"]?></div><!--/noindex-->
                <?}?>

            <?
                $rsUser = CUser::GetByID($USER->GetID())->Fetch();
                if (!empty($rsUser[UF_BOOKSBOUGHT])) {
                    $bought = unserialize($rsUser[UF_BOOKSBOUGHT]);
                    if ($arResult[ID] == $bought[$arResult[ID]][ID]) {
                        echo '<center><span style="color: #424c4f;display: inline-block;font-family: \'Walshein_regular\';font-size: 14px;margin-bottom: 5px;line-height: 24px;padding: 4px 22px;background: #fcfcfc none repeat scroll 0 0;width: 220px;"><img src="/images/info.png" align="left" style="margin-left:-10px;margin-top:12px;" />Вы уже купили эту книгу '.$bought[$arResult[ID]]["DATE"].'</span></center>';
                    }
            }?>
        </div>
		<?$frame->beginStub();?>
			<div class="priceBasketWrap paperVersionWrap" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
				<meta itemprop="priceCurrency" content="RUB" />
				<link itemprop="itemCondition" href="http://schema.org/NewCondition">
				<meta itemprop="sku" content="<?=$arResult["ID"]?>" />
				<meta itemprop="price" content="<?=$arPrice["VALUE_VAT"]?>" />
				<link itemprop="availability" href="https://schema.org/InStock">
				<div class="wrap_prise_top">
					<p class="newPrice"><?= round (($arPrice["DISCOUNT_VALUE_VAT"]), 2) ?> <span>руб.</span></p>

					<span class="sale_price"></span><br>

					<button class="inStockCirlce"></button>

					<span>&nbsp;В наличии</span>
				</div>

				<div class="wrap_prise_bottom">
					<span class="item_buttons_counter_block">

						<a href="#" class="minus">−</a>
						<input type="text" class="tac transparent_input" value="1">
						<a href="#" class="plus">+</a>
						</span>
					<a href="#">
						<p class="inBasket">В корзину</p>
					</a>
				</div>
				<div class="priceLoading">
					<div id="loadingInfo" style="margin-top:50%;"><div class="spinner"><div class="spinner-icon"></div></div></div>
				</div>
			</div>
        <?$frame->end();?>

		<?if ($arResult["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"] == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "soon")) {?>
			<form style="margin-top:27px;text-align:center;" class="no-mobile">

				<?if($USER->IsAuthorized()){
					$rsCurUser = CUser::GetByID($USER->GetID());
					$arCurUser = $rsCurUser->Fetch();
					$mail = $arCurUser["EMAIL"];
				}?>
				<div>
					<p>
						<span class="subscribeDesc">Впишите свой <b>e-mail</b>, чтобы получить письмо, как только книгу можно будет заказать</span>
					</p>
					<input data-book_id="<?=$arResult['ID']?>" type="text" value="<?=$mail;?>" name="email" class="subscribeEmail"/>
					<input type="button" onclick="newSubFunction(this);" class="getSubscribe" id="outOfStockClick" value="Подписаться" style="border: 2px solid #c7a271;color: #c7a271; background-color: #fff; padding: 5px 0;"/>

				</div>
			</form>
		<?}?>       

        <?if (!$checkMobile && !empty ($arResult["PROPERTIES"]["appstore"]['VALUE']) && !empty($arResult["PROPERTIES"]["alpina_digital_price"]['VALUE'])) {?>
            <!--noindex-->
            <div class="priceBasketWrap digitalVersionWrap" style="display:none;">
                <div class="wrap_prise_top">
                    <?= GetMessage("EPUB") ?>
                    <p class="newPrice"><?=$arResult["PROPERTIES"]["alpina_digital_price"]['VALUE']?> <span>руб.</span></p>
                </div>        
                          
                <div class="wrap_prise_bottom">
                    <a href="https://ebook.alpina.ru/book/<?=$arResult["PROPERTIES"]["alpina_digital_ids"]['VALUE']?>?utm_source=alpinabook.ru&utm_medium=referral&utm_campaign=alpinamainsite" class="digitalLink" target="_blank" rel="nofollow" onclick="dataLayer.push({'event' : 'selectVersion', 'action' : 'leaveSite', 'label': '<?= $arResult["NAME"]; ?>'});">
                        <p class="inBasket"><?= GetMessage("BUY_EPUB") ?></p>
                    </a>
                </div>
            </div>
            <!--/noindex-->
            <?}?>

        <div class="quickOrderDiv" style="display:none;">
            <form method="post" id="quickOrderForm">
                <input type="hidden" name="frmQuickOrderSent" value="Y">
                <input type="hidden" name="qoProduct" id="id" value="<?= $arResult["ID"] ?>">
                <div class="notify"></div>
                <ul>
                    <li><?= GetMessage("NAME_FIELD_TITLE") ?></li>
                    <li>
                        <input type="text" name="name" value="" class="quickorder-name">
                    </li>
                    <li><?= GetMessage("PHONE_FIELD_TITLE") ?></li>
                    <li>
                        <input type="text" name="phone" value="" class="quickorder-phone">
                    </li>
                    <li><?= GetMessage("EMAIL_FIELD_TITLE") ?></li>
                    <li>
                        <input type="text" name="email" value="" class="quickorder-email">
                    </li>
                    <li class="last">
                        <input type="button" value="Оформить заказ" id="qoSend" class="input2">
                    </li>
                </ul>
                <a title="" href="#" onClick="$('.quickOrderDiv').hide(); $('.layout').hide(); return false;" class="closePopupContainer close1"></a>
            </form>
            <div class="CloseQuickOffer"><img src="/img/catalogLeftClose.png"></div>
        </div>

		<?$frame = $this->createFrame()->begin();?>
        <?if ($arResult['PROPERTIES']['STATE']['VALUE_XML_ID'] != 'net_v_nal' && $arResult['PROPERTIES']['STATE']['VALUE_XML_ID'] != 'soon'  && $arResult["PROPERTIES"]["ol_opis"]["VALUE_ENUM_ID"] != 233) {?>
            <?
                $today = date("w");
                $timenow = date("G");

                if ($today == 5) {
                    if ($timenow < 17) {
                        $samovivoz_day = GetMessage("TODAY");
                    } else {
                        $samovivoz_day = GetMessage("ON_MONDAY");
                    }
                } elseif ($today == 6 || $today == 0) {
                    $samovivoz_day = GetMessage("ON_MONDAY");
                } elseif ($timenow < 17) {
                    $samovivoz_day = GetMessage("TODAY");
                } else {
                    $samovivoz_day = GetMessage("TOMORROW");
                }
                $delivery_day = $setProps['deliveryDayName'];
            ?>
            <ul class="shippings">
                <li><?= GetMessage("MSK_DELIVERY") ?><br /><a href='#' class="getInfoCourier" onclick="getInfo('courier');dataLayer.push({event: 'otherEvents', action: 'infoPopup', label: 'courier'});return false;"><?=$delivery_day?></a></li>
                <li><?= GetMessage("POSTOMATS_COUNT") ?> <a href='#' onclick="getInfo('boxberry');dataLayer.push({event: 'otherEvents', action: 'infoPopup', label: 'boxberry'});return false;"><?= GetMessage("POSTOMATS") ?></a> <?= GetMessage("POSTOMATS_COUNTRY") ?></li>
                <li><?= GetMessage("PICKUP_MSK_DELIVERY") ?><br /><a href='#' onclick="getInfo('pickup');dataLayer.push({event: 'otherEvents', action: 'infoPopup', label: 'pickup'});return false;"><?=$samovivoz_day?></a></li>
                <li><?= GetMessage("MAIL_DELIVERY") ?><br /><a href='#' onclick="getInfo('box');dataLayer.push({event: 'otherEvents', action: 'infoPopup', label: 'box'});return false;"><?=GetMessage("COUNTRY_DELIVERY")?></a></li>
                <li><?= GetMessage("INTERNATIONAL_DELIVERY") ?></li>
            </ul>
		<?}?>
		<?$frame->end();?>

        <div class="typesOfProduct">
            <?if (!empty ($arResult["PROPERTIES"]["appstore"]['VALUE']) ) {?>
                <!--noindex--><div class="productType" onclick="dataLayer.push({event: 'otherEvents', action: 'clickAppStore', label: '<?= $arResult['NAME'] ?>'});">
                    <p class="title"><a target="_blank"
                        href="https://ad.apps.fm/I7nsUqHgFpiU6SjjFxr_lfE7og6fuV2oOMeOQdRqrE2fuH1E_AVE04uUy-835_z8AOyXPgYuNMr8J2cvDXlBe3JGR4QWfzRXdHADIOS0bhIlj-vcR89M4g_uNUXQBYtJhxsaY6DBokwX4FZL6ZW1oPCYagKnjd3JTKLywLOw94o"
                        rel="nofollow"><?= GetMessage("BUY_IN_APPSTORE") ?></a></p>
                </div><!--/noindex-->
                <?}?>
            <?if (!empty ($arResult["PROPERTIES"]["android"]['VALUE']) ) {?>
                <!--noindex--><div class="productType" onclick="dataLayer.push({event: 'otherEvents', action: 'clickAndroid', label: '<?= $arResult['NAME'] ?>'});">
                    <p class="title"><a target="_blank"
                        href="https://ad.apps.fm/JbkeS8Wu40Y4o7v66y0V515KLoEjTszcQMJsV6-2VnHFDLXitVHB6BlL95nuoNYfsPXjJaQ96brr8ncAvMfc6wZkKsYjZn26ZgfIprQwFxiMb6nGA0JPaw88nuXsLm5fGy9o7Q8KyEtAHAeX1UXtzRyIF-zfsrprYF9zs6rj2ac8dDeKR2QfG21w5iR5J8PU"
                        rel="nofollow"><?= GetMessage("BUY_IN_GOOGLEPLAY") ?></a></p>
                </div><!--/noindex-->
                <?}?>
        </div>

        <?if ($arResult["PROPERTIES"]["author_book"]["VALUE"] == "Y") {?>
            <div class="productAction">
                <img src="/img/actionPicture.png">
                <p class="title">Книга с автором</p>
                <p class="text">Участвуй в акции и получи книгу с автографом автора</p>
                <a href="#"><p class="takePart">Принять участие</p></a>
            </div>
            <?}?>
        <?if(!empty($arResult['PROPERTIES']['AUTHORS']['VALUE'][0])){?>
            <? global $author_filter;
                $author_filter = array("PROPERTY_AUTHOR_LINK" => $arResult['PROPERTIES']['AUTHORS']['VALUE'][0]);
                if(!$USER->IsAdmin()){
                    $author_filter["!PROPERTY_FOR_ADMIN_VALUE"] = "Y";
                }
                $APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"lections_announces",
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"FILTER_NAME" => "author_filter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"IBLOCK_ID" => LECTIONS_ANNOUNCES_IBLOCK_ID,
		"IBLOCK_TYPE" => "service",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "1",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "LECTION_DATE",
			2 => "EVENT_LINK",
			3 => "EVENT_TYPE",
			4 => "AUTHOR_LINK",
			5 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"COMPONENT_TEMPLATE" => "lections_announces",
		"STRICT_SECTION_CHECK" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
            <?}?>
    </div>
    <div class="subscr_result"></div>
    <div class="centerColumn">
		<?if (!empty($arResult["PROPERTIES"]["second_book_name"]["VALUE"])) {?>
			<ul class="multipleBooks no-mobile">
				<li class="active" data-book="1"><span><?=GetMessage("FIRST_BOOK")?></span></li>
				<li data-book="2"><span><?=GetMessage("SECOND_BOOK")?></span></li>
			</ul>
		<?}?>
        <h1 class="productName" itemprop="name">
		<span class="secondPart">Рецензии на книгу</span><br><?echo empty($arResult["PROPERTIES"]["SECOND_NAME"]["VALUE"]) ? '<span class="mainPart">'.typo($arResult["NAME"]).'</span><span class="secondPart"></span>' : '<span class="mainPart">'.typo($arResult["PROPERTIES"]["SHORT_NAME"]["VALUE"].'</span><br /><span class="secondPart">'.$arResult["PROPERTIES"]["SECOND_NAME"]["VALUE"]).'</span>';?>
		</h1>
		<p class="productAutor">
			<span><?= $arResult["AUTHOR_NAME"]; ?></span>
		</p>
        <h2 class="engBookName" itemprop="alternateName"><?= $arResult["PROPERTIES"]["ENG_NAME"]["VALUE"] ?></h2>
        <div class="authorReviewWrap">
            <p class="reviews">
                <style>
                    .crr {
                        font-family: "Walshein_light"!important;
                        font-size:16px!important;
                    }
                    .crr .mc-star span {
                        font-size: 18px!important;
                    }
					.crr .mc-star {
						margin-left:0!important;
					}
                    .mc-c .mc-star {
                        vertical-align: bottom !important;
                        color:#f0c15b !important;
                    }
                    .mc-c .mc-btn2 {
                        color: rgba(255, 255, 255, 0.87)!important;
                        background: #5cb85c!important;
                        font-family: Walshein_regular!important;
                    }
                    .mc-c div {
                        font-family: Walshein_light!important;
                        font-size:16px!important;
                    }
                    .cr .mc-review-time {
                        font-size: 14px!important;
                        color:#3f4a4d!important;
                    }
                </style>
                <span class="crr-cnt" data-crr-url="<?=$arResult["ID"]?>" data-crr-chan="<?=$arResult["ID"]?>"></span>
            </p>
			<?if (($arResult["PHOTO_COUNT"] > 0) && ($arResult["MAIN_PICTURE"] != '')) {?><p class="bookPreviewLink previewLink no-mobile" onclick="getPreview(<?=$arResult["ID"]?>, <?echo ($arResult['PROPERTIES']['STATE']['VALUE_XML_ID'] != 'soon' && $arResult['PROPERTIES']['STATE']['VALUE_XML_ID'] != 'net_v_nal') ? 1 : 0;?>);return false;"><?= GetMessage("BROWSE_THE_BOOK") ?></p><?}?>
        </div>

        <ul class="productsMenu">  
            <? if ($arResult['IBLOCK_SECTION_ID'] == CERTIFICATE_SECTION_ID) { ?>
            <li class="tabsInElement" data-id="1"><?= GetMessage("CERTIFICATE_TITLE") ?></li>
            <?} elseif($arResult['IBLOCK_SECTION_ID'] == HANDBAG_SECTION_ID) {?> 
            <li class="tabsInElement" data-id="1"><?= GetMessage("HANDBAG_TITLE") ?></li>    
            <?} else {?>
            <li class="tabsInElement" data-id="1"><?= GetMessage("ANNOTATION_TITLE") ?></li>                  
            <?}?>
            <?if (!empty($arResult["AUTHORS"])) {?><li data-id="4" class="tabsInElement"><?echo count($arResult["AUTHOR"]) == 1 ? GetMessage("ABOUT_AUTHOR_TITLE") : GetMessage("ABOUT_AUTHORS_TITLE");?></li><?}?>
            
            <?if ($arResult["REVIEWS_COUNT"] > 0) {?>
                <li data-id="2" class="tabIsRecenzion active">
                    <a class="ajax_link" href="<?=substr($arResult["DETAIL_PAGE_URL"], 0, -1) . '-reviews/'?>">
                        <?= GetMessage("REVIEWS_TITLE") ?> (<?=$arResult["REVIEWS_COUNT"]?>)
                    </a>                       
                </li>
            <?}?>
            
            <? if ($arResult['IBLOCK_SECTION_ID'] != CERTIFICATE_SECTION_ID) { ?>
                <li data-id="3" class="tabsInElement" id="commentsLink">
                    <a class="ajax_link" href="<?=substr($arResult["DETAIL_PAGE_URL"], 0, -1) . '-comments/'?>">
                        <?= GetMessage("COMMENTS_TITLE") ?>
                    </a>
                </li>
            <?}?>
            
        </ul>

        <div class="annotation" id="prodBlock1" style="display: none;">
            <div class="showAllWrapp">

				<?global $reviewsFilter;
				$reviewsFilter = array ("PROPERTY_BOOK" => $arResult["ID"]);
				$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"this_book_reviews",
				array(
					"IBLOCK_TYPE_ID" => "catalog",
					"IBLOCK_ID" => "31",
					"BASKET_URL" => "/personal/cart/",
					"COMPONENT_TEMPLATE" => "this_book_reviews",
					"IBLOCK_TYPE" => "news",
					"SECTION_ID" => "",
					"SECTION_CODE" => "",
					"SECTION_USER_FIELDS" => array(
						0 => "",
						1 => "",
					),
					"ELEMENT_SORT_FIELD" => "id",
					"ELEMENT_SORT_ORDER" => "desc",
					"ELEMENT_SORT_FIELD2" => "id",
					"ELEMENT_SORT_ORDER2" => "asc",
					"FILTER_NAME" => "reviewsFilter",
					"INCLUDE_SUBSECTIONS" => "Y",
					"SHOW_ALL_WO_SECTION" => "Y",
					"HIDE_NOT_AVAILABLE" => "N",
					"PAGE_ELEMENT_COUNT" => "8",
					"LINE_ELEMENT_COUNT" => "3",
					"PROPERTY_CODE" => array(
						0 => "",
						1 => "name",
						2 => "comment",
						3 => "stars",
						4 => "",
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
					"CACHE_TIME" => "36000",
					"CACHE_GROUPS" => "Y",
					"SET_TITLE" => "N",
					"SET_BROWSER_TITLE" => "N",
					"BROWSER_TITLE" => "-",
					"SET_META_KEYWORDS" => "N",
					"META_KEYWORDS" => "-",
					"SET_META_DESCRIPTION" => "N",
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
					"DISABLE_INIT_JS_IN_COMPONENT" => "N",
					"CUSTOM_FILTER" => "",
					"HIDE_NOT_AVAILABLE_OFFERS" => "N",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
					"DISPLAY_COMPARE" => "N",
					"COMPATIBLE_MODE" => "Y"
				),
				false
				);?>

                <?= typo($arResult["DETAIL_TEXT"]) ?>
            </div>
            <?$videosCount  = 0;
                foreach ($arResult['PROPERTIES']['video_about']['~VALUE'] as $videoYoutube) {
                    $videosCount++;
                }
                if ($arResult['PROPERTIES']['video_about']['~VALUE'] != "") {?>
                <p class="productSelectTitle"><?= GetMessage("VIDEO_PRESENTATIONS") ?> <? if($videosCount > 1) { ?><span><a href="#"><?= GetMessage("SHOW_ALL") ?></a></span><span class="count">(<?= $videosCount ?>)</span><? } ?></p>
                <?}?>

            <div class="videoWrapp">
                <?foreach ($arResult['PROPERTIES']['video_about']['~VALUE'] as $videoYoutube) {
                    echo ($videoYoutube);
                }?>
            </div>


            <?if (!empty ($arResult['TAGS']) ) {
                echo "<p class='productSelectTitle'>" . GetMessage("KEYWORDS") . "</p>";
				echo '<meta itemprop="keywords" content="'.$arResult['TAGS'].'" />';

                echo "<div class='keyWords'>";
                $tags = explode(',', strtolower($arResult['TAGS']));
				foreach ($tags as $tag) {
					$tag = ltrim($tag);
					echo '<a href="/search/index.php?q='.$tag.'">'.$tag.'</a>';
				}

                echo "</div>";
            }?>
        </div>
        <?if ($arResult["REVIEWS_COUNT"] > 0) {?>
            <div class="recenzion" id="prodBlock2" style="display: block;">
                <?foreach ($arResult["REVIEWS"] as $reviewList) {?>
                    <?if (!empty($reviewList["PREVIEW_TEXT"])) {?>
                        <?if (!$checkMobile) {?>
                            <a href="/content/reviews/<?=$reviewList['ID']?>/" onclick="getReview(<?=$reviewList['ID']?>);return false;">
                                <span class="recenz_author_name"><?= $reviewList["NAME"] ?></span>
                            </a>
                            <div class="recenz_text">
                                <?echo substr(strip_tags($reviewList["PREVIEW_TEXT"]),0,400).'... ';?>
                                <a href="/content/reviews/<?=$reviewList['ID']?>/" onclick="getReview(<?=$reviewList['ID']?>);return false;" class="readFullReview"><?=GetMessage("SHOW_FULL_REVIEW")?></a>
                            </div>
                            <?} else {?>
                            <a href="/content/reviews/<?=$reviewList['ID']?>/" target="_blank">
                                <span class="recenz_author_name"><?= $reviewList["NAME"] ?></span>
                            </a>

                            <div class="recenz_text">
                                <?= $reviewList["PREVIEW_TEXT"] ?>
                                <? if ($reviewList["PREVIEW_TEXT"] == "") {
                                        echo $reviewList["DETAIL_TEXT"];
                                    }

                                    /*if (!empty($reviewList["PROPERTY_SOURCE_LINK_VALUE"])) {?><!-- noindex -->
                                    <a href="<?= $reviewList["PROPERTY_SOURCE_LINK_VALUE"] ?>" rel="nofollow" target="_blank"><?= $reviewList["PROPERTY_SOURCE_LINK_VALUE"] ?></a><!-- /noindex -->
                                <?}*/?>
                            </div>
                            <?}?>
                        <?}?>
                    <?}?>
            </div>
            <?}?>
        <div class="review" id="prodBlock3" style="display: none;">
            <div class="ReviewsFormWrap">
                <div id="cackleReviews"></div>
                <?//$APPLICATION-> IncludeComponent("cackle.reviews", ".default", array( "CHANNEL_ID" => $arResult["ID"] ), false);?>
            </div>
        </div>
		<!-- noindex -->
        <div class="aboutAutor" id="prodBlock4" style="display: none;">
            <?if (!empty($arResult["AUTHORS"])) {?>
                <?foreach ($arResult["AUTHOR"] as $author) {
                        $currAuth = CIBlockElement::GetList(array(), array("ID" => $author["ID"]), false, false, array("PROPERTY_AUTHOR_DESCRIPTION")) -> Fetch();
                        $currAuthFull = CIBlockElement::GetByID($author["ID"])->GetNext();
                        if (!empty ($author["PROPERTY_ORIG_NAME_VALUE"])) {
                            $authorFullName = $author["NAME"] . "<br /><span class='origAuthorName'>" . $author["PROPERTY_ORIG_NAME_VALUE"]."</span>";
                        } else {
                            $authorFullName = $author["NAME"];
                    }?>

                    <div class="author_info">
						<?= !empty($author["IMAGE_FILE"]["SRC"]) ? "<img src='".$author["IMAGE_FILE"]["SRC"]."' align='left' style='padding-right:30px;' />" : ""?>
                        <div class="author_name"><a href="<?=$currAuthFull[DETAIL_PAGE_URL]?>"><?=$authorFullName?></a></div>
                        <?=$currAuth["PROPERTY_AUTHOR_DESCRIPTION_VALUE"]["TEXT"]?>

                    </div>
                    <br>

                    <?}?>
                <?}?>
        </div>
		<!-- /noindex -->
		<div class="socialServises" style="text-align: center;padding:40px 0">
			<?require('include/socialbuttons.php'); ?>
		</div>
    </div>
</div>
</div>


	<div class="dopSaleWrap no-mobile">
		<div class="dopSale">
			Накопительные скидки
		</div>

		<div class="percentBlock">
			<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			".default",
			array(
			"AREA_FILE_SHOW" => "file",
			"AREA_FILE_SUFFIX" => "inc",
			"AREA_FILE_RECURSIVE" => "Y",
			"EDIT_TEMPLATE" => "",
			"COMPONENT_TEMPLATE" => ".default",
			"PATH" => "/include/main_discount_left.php"
			),
			false
			);?>
		</div>

		<div class="TwentypercentBlock">
			<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			".default",
			array(
			"AREA_FILE_SHOW" => "file",
			"AREA_FILE_SUFFIX" => "inc",
			"AREA_FILE_RECURSIVE" => "Y",
			"EDIT_TEMPLATE" => "",
			"COMPONENT_TEMPLATE" => ".default",
			"PATH" => "/include/main_discount_right.php"
			),
			false
			);?>
		</div>
	</div>


</div>
</div>

<? /* Получаем от RetailRocket рекомендации для товара */
    global $recommFilter;
    $recsArray = $arResult["STRING_RECS"];

    if ($recsArray[0] > 0) {
        foreach ($recsArray as $recBook) {
            $recommFilter['ID'][] = $recBook;
        }
    }
    $printid = implode(", ", $recsArray);?>
<script>
    function rrAsyncInit() {
        try {rrApi.view(<?= $arResult['ID']; ?>);} catch(e) {}
    }
</script>

<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
    window.criteo_q = window.criteo_q || [];
    window.criteo_q.push(
        { event: "setAccount", account: 18519 },
        <?if ($USER -> IsAuthorized()) {?>
            { event: "setEmail", email: "<?= $USER -> GetEmail() ?>" },
            <?}?>
        { event: "setSiteType", type: "d" },
        { event: "viewItem", item: "<?= $arResult['ID'] ?>" }
    );
</script>

<?if ($recommFilter['ID'][0] > 0) { // Если рекомендации есть, ничего не меняем и отправляем статистику в RR?>
    <script>
        function rrAsyncInit() {
            try {rrApi.recomTrack('UpSellItemToItems', <?= $arResult["ID"] ?>, [<?= $printid ?>]);} catch(e) {}
        }
    </script>
    <div class="weRecomWrap">
        <div class="centerWrapper">
            <p class="tile"><?= GetMessage("ALSO_RECOMMENDED_BOOKS") ?></p>
            <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "all_recommended_books",
                    array(
                        "IBLOCK_TYPE_ID" => "catalog",
                        "IBLOCK_ID" => "4",
                        "BASKET_URL" => "/personal/cart/",
                        "COMPONENT_TEMPLATE" => "all_recommended_books",
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
                        "FILTER_NAME" => "recommFilter",
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
                        "SET_BROWSER_TITLE" => "N",
                        "BROWSER_TITLE" => "-",
                        "SET_META_KEYWORDS" => "N",
                        "META_KEYWORDS" => "-",
                        "SET_META_DESCRIPTION" => "N",
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
                        "PAGER_SHOW_ALWAYS" => "Y",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "SET_STATUS_404" => "N",
                        "SHOW_404" => "N",
                        "MESSAGE_404" => "",
                        "BACKGROUND_IMAGE" => "-"
                    ),
                    false
                );

                unset($RecommFilter);?>
        </div>
    </div>
    <?}?>
<div class="reviewsSliderWrapp">
    <div class="centerWrapper">
		<!--noindex-->
        <div class="giftWrap">
            <form action="/" method="post">
                <input type="text" placeholder="Ваш e-mail" name="email" onkeypress="if (event.keyCode == 13) {return SubmitRequest(event);}">
                <input type="button" value="">
            </form>
            <div class="some_info">
                <?= GetMessage("SUBSCRIPTION_REQUEST_ACCEPTED" )?>
            </div>
            <p class="title">
                <?= GetMessage("GIFT_BOOK_TITLE") ?>
            </p>
            <p>
                <?= GetMessage("GIFT_BOOK_DESCRIPTION") ?>
            </p>
			<div class="pii no-mobile">* подписываясь на рассылку, вы соглашаетесь на обработку персональных данных в соответствии <a href="/content/pii/" target="_blank">с условиями</a></div>
        </div>
		<!--/noindex-->

        <?
		global $arFilter;
		$lastseen = CSaleViewedProduct::GetList(
			array("DATE_VISIT" => "DESC"),
			array("FUSER_ID" => CSaleBasket::GetBasketUserID()),
			false,
			array("nTopCount" => 8),
			array("PRODUCT_ID")
		);
		$lastidids = array();

		while ($lastid = $lastseen->GetNext()) {
			$lastidids[] = $lastid["PRODUCT_ID"];
		}
		if (!empty($lastidids)) {?>
			<p class="sliderName"><a href="/catalog/lastseen/" class="youViewedTitle"><?= GetMessage("VIEWED_BOOKS_TITLE") ?></a></p>


			<?$arFilter = array('ID' => $lastidids, ">DETAIL_PICTURE" => 0);

			$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"viewed_books",
				array(
					"IBLOCK_TYPE_ID" => "catalog",
					"IBLOCK_ID" => "4",
					"BASKET_URL" => "/personal/cart/",
					"COMPONENT_TEMPLATE" => "viewed_books",
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
					"FILTER_NAME" => "arFilter",
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
					"CACHE_TIME" => "36000",
					"CACHE_GROUPS" => "N",
					"SET_TITLE" => "N",
					"SET_BROWSER_TITLE" => "N",
					"BROWSER_TITLE" => "-",
					"SET_META_KEYWORDS" => "N",
					"META_KEYWORDS" => "-",
					"SET_META_DESCRIPTION" => "N",
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
					"DISABLE_INIT_JS_IN_COMPONENT" => "N",
					"CUSTOM_FILTER" => "",
					"HIDE_NOT_AVAILABLE_OFFERS" => "N",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
					"DISPLAY_COMPARE" => "N",
					"COMPATIBLE_MODE" => "Y"
				),


				false
			);
		}?>

    </div>
</div>

<? global $authBooksFilter;
    if (!empty ($arResult["PROPERTIES"]["AUTHORS"]["VALUE"][0]) ) {
        $authBooksFilter = array('PROPERTY_AUTHORS' => $arResult["PROPERTIES"]["AUTHORS"]["VALUE"][0], "!ID" => $arResult["ID"]);

        $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"this_author_books",
	array(
		"IBLOCK_TYPE_ID" => "catalog",
		"IBLOCK_ID" => "4",
		"BASKET_URL" => "/personal/cart/",
		"COMPONENT_TEMPLATE" => "this_author_books",
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
		"FILTER_NAME" => "authBooksFilter",
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
		"CACHE_TIME" => "36000",
		"CACHE_GROUPS" => "N",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "N",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "N",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "N",
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
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"CUSTOM_FILTER" => "",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DISPLAY_COMPARE" => "N",
		"COMPATIBLE_MODE" => "Y"
	),
	false
);
}?>

<div id="ajaxBlock"></div>
<!-- GdeSon -->
<script type="text/javascript" src="//www.gdeslon.ru/landing.js?mode=card&amp;codes=<?= $arResult["ID"] ?>:<?= round (($arPrice["DISCOUNT_VALUE_VAT"]), 2) ?>&amp;mid=79276"></script>

<script type="text/javascript">
    cackle_widget = window.cackle_widget || [];
    cackle_widget.push({
        widget: 'ReviewRating',
        id: 36574,
        html: '{{?(it.numr + it.numv) > 0}}{{=it.stars}} оценок: {{=it.numr+it.numv}}{{?}}'
    });

    cackle_widget.push({
        widget: 'Review',
        id: 36574,
        msg: {
            yRecom: 'Я рекомендую эту книгу',
            recom: 'Рекомендую книгу',
            anonym2: 'Представьтесь, пожалуйста',
            formhead: 'Отзыв о книге',
            vbtitle: 'Этот пользователь купил книгу',
            pros: 'Понравилось'
        },
        callback: {
            ready: [function() {
                $(".mc-rate, .mc-breakdwn, .mc-menu, .mc-c>meta, .mc-c>span").remove();
                $(".mc-c").removeAttr('itemtype').removeAttr('itemscope');
                $('.mc-revtitle:contains("Понравилось")').next().attr("itemprop", "reviewBody");
                $(".ReviewsFormWrap").css("margin-top", "0");
                $(".mc-formbtn").css("cssText", "width: 100%!important; margin-bottom:20px!important;");
            }]
        },
        container: 'cackleReviews',
        channel: <?= $arResult["ID"] ?>,
        providers: 'vkontakte;facebook;twitter;yandex;odnoklassniki;other;'
    });

    function cackleReviewsCount() {
        $.getJSON("https://cackle.me/review/36574/rating", {len: 1, 0:'<?= $arResult["ID"] ?>'}, function(data){
            console.log(data);
            var countReviews = data.res.split(':')[1];
            if (countReviews > 0)
                $("#commentsLink").append(' ('+countReviews+')');
			else
				$("#commentsLink").html("<?=GetMessage("WRITE_COMMENT_TITLE")?>");

            var bookRating = (data.res.split(':')[3] / (parseInt(data.res.split(':')[1]) + parseInt(data.res.split(':')[2]))).toFixed(1);
            if (bookRating > 4.4)
                $(".crr-cnt").after("<style>.mc-c .mcicon-star-half-o:before {content: '\\f005'!important;}</style>");

            $(".crr-cnt").after('<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"><meta itemprop="ratingValue" content="'+ bookRating +'" /><meta itemprop="reviewCount" content="'+ (parseInt(data.res.split(':')[1]) + parseInt(data.res.split(':')[2])) +'" /><meta itemprop="bestRating" content="5" /></span>');
        })
    }
    cackleReviewsCount();

    (function() {
        var mc = document.createElement('script');
        mc.type = 'text/javascript';
        mc.async = true;
        mc.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cackle.me/widget.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
    })();
	
	$(function(){
		
		$('#commentsLink a').click(function(e){
			e.preventDefault();
		});
		
		$('#digitalversion').click(function(e){			
			$('.digitalVersionWrap').html('<div class="wrap_prise_top"><?=GetMessage("EPUB")?><p class="newPrice"><?=$arResult["PROPERTIES"]["alpina_digital_price"]["VALUE"]?> <span>руб.</span></p></div><div class="wrap_prise_bottom"><a href="https://ebook.alpina.ru/book/<?=$arResult["PROPERTIES"]["alpina_digital_ids"]["VALUE"]?>?utm_source=alpinabook.ru&utm_medium=referral&utm_campaign=alpinamainsite" class="digitalLink" target="_blank" rel="nofollow" onclick="dataLayer.push({"event" : "selectVersion", "action" : "leaveSite", "label": "<?=$arResult["NAME"];?>"});"><p class="inBasket"><?=GetMessage("BUY_EPUB")?></p></a></div>');			
			e.preventDefault();
		});
		
		
	});
</script>
