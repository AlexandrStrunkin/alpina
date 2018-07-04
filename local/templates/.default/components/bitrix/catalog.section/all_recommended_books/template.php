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
$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$is_bot_detected = false;
if (isset($_SERVER["HTTP_USER_AGENT"]) && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])) {
    $is_bot_detected = true;
}?>

<div class="weRecomBlock">
    <?foreach ($arResult["ITEMS"] as $arItem) {
        
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
        $strMainID = $this->GetEditAreaId($arItem['ID']);

        $arItemIDs = array(
            'ID' => $strMainID,
            'PICT' => $strMainID.'_pict',
            'SECOND_PICT' => $strMainID.'_secondpict',
            'STICKER_ID' => $strMainID.'_sticker',
            'SECOND_STICKER_ID' => $strMainID.'_secondsticker',
            'QUANTITY' => $strMainID.'_quantity',
            'QUANTITY_DOWN' => $strMainID.'_quant_down',
            'QUANTITY_UP' => $strMainID.'_quant_up',
            'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
            'BUY_LINK' => $strMainID.'_buy_link',
            'BASKET_ACTIONS' => $strMainID.'_basket_actions',
            'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
            'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
            'COMPARE_LINK' => $strMainID.'_compare_link',

            'PRICE' => $strMainID.'_price',
            'DSC_PERC' => $strMainID.'_dsc_perc',
            'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',
            'PROP_DIV' => $strMainID.'_sku_tree',
            'PROP' => $strMainID.'_prop_',
            'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
            'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
        );
        
        $pict = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>147, 'height'=>216), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        foreach ($arItem["PRICES"] as $code => $arPrice) {?>
        <div class="bookWrapp" id=<?= $strMainID ?>>
            <?if($arItem["PROPERTIES"]["TRANSPARENT_CORNER"]["VALUE_XML_ID"] == "Y"){?>  
                <?$corner_1 = "Y";?> 
            <?} else if($arItem["PROPERTIES"]["TRANSPARENT_CORNER_1_2"]["VALUE_XML_ID"] == "Y"){?>
                <?$corner_2 = "Y";?>  
            <?} else {
                $corner_1 = '';
                $corner_2 = '';
            }?>   
            <link itemprop="relatedLink" href="<?=$arItem["DETAIL_PAGE_URL"]?>" />
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" >
                <div class="section_item_img">
                    <img src="<?=$pict["src"]?>" title="<?=$arItem["NAME"]?>" alt="<?=$arItem["NAME"]?>" style="<?=($corner_1)?'border-radius: 15px 15px 15px 15px;':''?> <?=($corner_2)?'border-radius: 0px 15px 15px 0px;':''?>"/>
                </div>
                <p class="bookName" title="<?=$arItem["NAME"]?>"><?=$arItem["NAME"]?></p>
                <p class="tapeOfPack"><?=$arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]?></p>
                 <?
                    foreach ($arItem["PRICES"] as $code => $arPrice) {
                        if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "soon")
                            && intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal")) {
                        ?>
                        <?
                            if ($arResult["ITEM_IN_BASKET"][$arBasketItems["PRODUCT_ID"]]["QUANTITY"] == 0) {?>
                            <a class="product<?= $arItem["ID"]; ?>" href="javascript:void(0)" onclick="addtocart(<?= $arItem["ID"]; ?>, '<?= $arItem["NAME"]; ?>'); addToCartTracking(<?= $arItem["ID"]; ?>, '<?= $arItem["NAME"]; ?>', '<?= $arPrice["VALUE"] ?>', '<?= ($arResult["NAME"]) ? $arResult["NAME"] : GetMessage("BEST") ?>', '1'); return false;">
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
                        <p class="priceOfBook"><?= strtolower(FormatDate("j F Y", MakeTimeStamp($arItem['PROPERTIES']['SOON_DATE_TIME']['VALUE'], "DD.MM.YYYY HH:MI:SS"))); ?></p>
                        <p class="basketBook">Предзаказ</p>
                        <?
                        }
                    }
                    ?>
                <?
                if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != 22 
                    && intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != 23) {
                ?>
                    <p class="bookPrice"><?=ceil($arPrice["DISCOUNT_VALUE_VAT"])?><span></span></p>
                <?
                } else if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) == 23) {
                ?>
                    <p class="bookPrice"><?=$arItem["PROPERTIES"]["STATE"]["VALUE"]?></p>
                <?
                } else {
                ?>
                    <p class="bookPrice">Выйдет <?=FormatDate("X", MakeTimeStamp($arItem["PROPERTIES"]["SOON_DATE_TIME"]["VALUE"]))?></p>
                <?    
                }
                ?>        
            </a>
        </div>
        <?}?>
    <?}?>            
                
</div>


