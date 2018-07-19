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
?>

<div class="saleSlider">  <!--СЃР»Р°Р№РґРµСЂ Р±Р»РѕРєР° "РњС‹ СЂРµРєРѕРјРµРЅРґСѓРµРј"-->
    <ul>
        <?foreach ($arResult["ITEMS"] as $cell => $arItem) {
                foreach ($arItem["PRICES"] as $code => $arPrice) {
                    if ($arPrice["PRINT_DISCOUNT_VALUE"]) {
                        $pict = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>147, 'height'=>216), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                        $author = $arItem["DISPLAY_PROPERTIES"]["AUTHORS"]["LINK_ELEMENT_VALUE"];
                    ?>
                    <li>
                        <div class="bookWrapp">
                            <div class="sect_badge">
                                <? if (($arItem["PROPERTIES"]["discount_ban"]["VALUE"] != "Y") 
                                        && $arItem['PROPERTIES']['spec_price']['VALUE'] ) {
                                            switch ($arItem['PROPERTIES']['spec_price']['VALUE']) {
                                                case 10:
                                                    echo '<img class="discount_badge" src="/img/10percent.png">';
                                                    break;
                                                case 15:
                                                    echo '<img class="discount_badge" src="/img/15percent.png">';
                                                    break;
                                                case 20:
                                                    echo '<img class="discount_badge" src="/img/20percent.png">';
                                                    break;
                                                case 30:
                                                    echo '<img class="discount_badge" src="/img/30percent.png">';
                                                    break;
                                                case 40:
                                                    echo '<img class="discount_badge" src="/img/40percent_black.png">';
                                                    break;
												case 50:
                                                    echo '<img class="discount_badge" src="/img/50percent.png">';
                                                    break;
												case 60:
                                                    echo '<img class="discount_badge" src="/img/60percent.png">';
                                                    break;
												case 70:
                                                    echo '<img class="discount_badge" src="/img/70percent.png">';
                                                    break;
												case 80:
                                                    echo '<img class="discount_badge" src="/img/80percent.png">';
                                                    break;
												case 90:
                                                    echo '<img class="discount_badge" src="/img/90percent.png">';
                                                    break;
                                            } 
                                }?>
                            </div>
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" onclick="productClickTracking(<?= $arItem["ID"];?>, '<?= $arItem["NAME"];?>', '<?= ceil($arPrice["DISCOUNT_VALUE_VAT"])?>','', <?= ($cell+1)?>, 'Discounted Main');">
                                <div class="section_item_img">
                                    <?if($pict["src"] != ''){?>
                                        <img src="<?=$pict["src"]?>">    
                                    <?}else{?>
                                        <img src="/images/no_photo.png">      
                                    <?}?>
                                </div>
                                <p class="bookName" title="<?=$arItem["NAME"]?>"><?=$arItem["NAME"]?></p>
                            </a>
                                <?if($author){
                                    if(is_array($author)){
                                        foreach($author as $value){?>
                                            <p class="sliderBookSeveralAutor" title="Перейтина страницу автора"><?=$value["NAME"];?></p>
                                        <?}
                                    }else{?>
                                        <p class="sliderBookAutor" title="Перейти на страницу автора"><?=$value["NAME"]; ?></p>
                                    <?}?>
                                <?}?>
                                <p class="tapeOfPack"><?=$arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]?></p>
                                <p class="bookPriceLine"><?=ceil($arPrice["PRINT_VALUE_VAT"])?><span class="rubsign"></span></p>
                                <p class="bookPrice"><?=ceil($arPrice["DISCOUNT_VALUE_VAT"])?><span></span></p>
                            <?  
                                if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "soon")
                                    && intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal")) {
                                ?>
                                <?
                                    if ($arResult["ITEM_IN_BASKET"][$arBasketItems["PRODUCT_ID"]]["QUANTITY"] == 0) {?>
                                    <a class="product<?= $arItem["ID"]; ?>" onmousedown="try { rrApi.addToBasket(<?= $arItem["ID"]; ?>) } catch(e) {}"  href="javascript:void(0)" onclick="addtocart(<?= $arItem["ID"]; ?>, '<?= $arItem["NAME"]; ?>'); addToCartTracking(<?= $arItem["ID"]; ?>, '<?= $arItem["NAME"]; ?>', '<?= $arPrice["VALUE"] ?>', '<?= ($arResult["NAME"]) ? $arResult["NAME"] : GetMessage("BEST") ?>', '1'); return false;">
                                        <p class="basketBook">В корзину</p>
                                    </a>
                                    <?} else {?>
                                    <a class="product<?= $arItem["ID"]; ?>" href="/personal/cart/">
                                        <p class="basketBook" style="background-color: #A9A9A9;color: white;">Оформить</p>
                                    </a>
                                    <?}
                                } else if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal")) {
                                ?>
                                <p class="priceOfBook"><?= $arItem["PROPERTIES"]["STATE"]["VALUE"] ?></p>
                                <?
                                } else {
                                ?>
                                <p class="basketBook">Предзаказ</p>
                                <?
                                }
                            ?>
                        </div>    
                    </li>
                    <?}
                }
        }?>
    </ul>
    <img src="/img/arrowLeft.png" class="left">
    <img src="/img/arrowRight.png" class="right">
</div> 

