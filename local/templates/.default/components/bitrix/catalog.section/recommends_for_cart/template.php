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
<?/*
*/?>

<div class="saleSlider">
    <ul>

        <?foreach ($arResult["ITEMS"] as $arItem) {
            foreach ($arItem["PRICES"] as $code => $arPrice) {
                if ($arPrice["PRINT_DISCOUNT_VALUE"]) {
                    $pict = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>142, 'height'=>210), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                ?>
                <li>
                    <div class="bookWrapp">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" onclick="productClickTracking(<?= $arItem["ID"];?>, '<?= $arItem["NAME"];?>', '<?= ceil($arPrice["DISCOUNT_VALUE_VAT"])?>','<?= $arResult["NAME"]?>', '', 'Cart');dataLayer.push({event: 'EventsInCart', action: '1st Step', label: 'recsProductClick'});<?if (!checkMobile()) echo 'getBookInfo('.$arItem["ID"].',1);return false';?>">
                            <div class="section_item_img">
                                <?if($pict["src"] != ''){?>
                                    <img src="<?=$pict["src"]?>">    
                                    <?} else {?>
                                    <img src="/images/no_photo.png">      
                                    <?}?>
                            </div>
                            <p class="bookName" title="<?=$arItem["NAME"]?>"><?=$arItem['NAME']?></p>
                            <p class="tapeOfPack"><?=$arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]?></p>
                            <p class="bookPrice"><?=$arPrice['DISCOUNT_VALUE_VAT']?><span></span></p>
                        </a>
                        <a class="product<?=$arItem["ID"];?>" onmousedown="try { rrApi.addToBasket(<?=$arItem["ID"]?>) } catch(e) {}" href="<?echo $arItem["ADD_URL"]?>" onclick="dataLayer.push({event: 'EventsInCart', action: '1st Step', label: 'recsAddToCart'});delete_href(<?=$arItem["ID"];?>)"><p class="basketBook">Добавить к заказу</p></a>
                    </div>    
                </li>    
                <?}
            }
        }?>
    </ul>
    <img src="/img/arrowLeft.png" class="left">
    <img src="/img/arrowRight.png" class="right">
</div>

