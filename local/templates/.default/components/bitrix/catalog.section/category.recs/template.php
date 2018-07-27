<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<style>
.sliderElementMin{
    width: 234px;   
}       
</style>

<div class="bestSlider">
    <div>
        <ul>
        <?foreach ($arResult["ITEMS"] as $arItem) {
            $pict = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>147, 'height'=>216), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            foreach ($arItem["PRICES"] as $code => $arPrice) {?>
            <li>
                <div class="bookWrapp">
                    <?$curr_author = CIBlockElement::GetByID($arItem["PROPERTIES"]["AUTHORS"]["VALUE"][0]) -> Fetch();?>
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" onclick="productClickTracking(<?= $arItem["ID"];?>, '<?= $arItem["NAME"];?>', '<?= ceil($arPrice["DISCOUNT_VALUE_VAT"])?>','', '', 'Catalog Recs');">
                        <div class="section_item_img">
                            <?if ($pict["src"]) {?>
                                <img src="<?=$pict["src"]?>">
                            <?} else {?>
                                <img src="/images/no_photo.png">
                            <?}?>
                            <?if(!empty($arItem["PROPERTIES"]["number_volumes"]["VALUE"])){?>
								<span class="volumes"><?=$arItem["PROPERTIES"]["number_volumes"]["VALUE"]?></span>
                            <?}?>
                        </div>
                        <?if($arItem["NAME"]){?>
                            <p class="bookName" title="<?=$arItem["NAME"]?>"><?=$arItem["NAME"]?></p>
                        <?}?>
                        <?if($curr_author["NAME"]){?>
                            <p class="bookAutor"><?=$curr_author["NAME"]?></p>
                        <?}?>
                        <?if($arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]){?>
                            <p class="tapeOfPack"><?=$arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]?></p>
                        <?}?>
                        <?
                        if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != 22 && intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != 23 && $arItem["IBLOCK_SECTION_ID"] != CERTIFICATE_SECTION_ID) {?>
                            <p class="bookPrice"><?=ceil($arPrice["DISCOUNT_VALUE_VAT"])?> <span></span></p>
                        <?} else if ($arItem["IBLOCK_SECTION_ID"] == CERTIFICATE_SECTION_ID) {?>               
                            <p class="bookPrice"><?=ceil($arPrice["VALUE_VAT"])?> <span></span></p>
                        <?} else if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) == 23) {?>
                            <p class="bookPrice"><?=$arItem["PROPERTIES"]["STATE"]["VALUE"]?></p>
                        <?} else {?>
                            <p class="bookPrice"><?=$arItem["PROPERTIES"]["SOON_DATE_TIME"]["VALUE"]?></p>    
                        <?}?>
                    </a>  
                    
                    <?
					$dbBasketItems = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "PRODUCT_ID" => $arItem["ID"]), false, false, array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS"))->Fetch();?>
					<?if(intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != 23) {
                        if ($dbBasketItems["QUANTITY"] == 0 && $arItem["IBLOCK_SECTION_ID"] != CERTIFICATE_SECTION_ID){?>
                            <a class="product<?=$arItem["ID"];?>" onmousedown="try { rrApi.addToBasket(<?=$arItem["ID"]?>) } catch(e) {}" href="<?echo $arItem["ADD_URL"]?>" onclick="addtocart(<?=$arItem["ID"];?>, '<?=$arItem["NAME"];?>');addToCartTracking(<?= $arItem["ID"];?>, '<?= $arItem["NAME"];?>', '<?= ceil($arPrice["DISCOUNT_VALUE_VAT"])?>','', '1');return false;">
                                <?if(intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode (CATALOG_IBLOCK_ID, "STATE", "soon")) {?>
                                    <p class="basketBook"><?=GetMessage("CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET")?></p> 
                                <?} else {?>
                                    <p class="basketBook"><?=GetMessage("CT_BCS_TPL_MESS_BTN_ADD_TO_PREORDER")?></p>                                                 
                                <?}?>                                
                            </a>
                        <?} elseif($arItem["IBLOCK_SECTION_ID"] == CERTIFICATE_SECTION_ID) {?>
                            <a class="product<?=$arItem["ID"];?>" href="<?=$arItem['DETAIL_PAGE_URL']?>"><p class="basketBook">Купить</p></a>                         
                        <?} else {?>
                            <a class="product<?=$arItem["ID"];?>" href="/personal/cart/"><p class="basketBook" style="background-color: #A9A9A9;color: white;">Оформить</p></a>                         
                        <?}
					}?>
                </div>        
            </li>
        <?}
        }
        ?>
        </ul>
    </div>        
</div>
<div class="busket_senk">Товар успешно добавлен</div>
