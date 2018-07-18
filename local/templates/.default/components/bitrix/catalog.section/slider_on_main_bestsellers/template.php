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

<div class="sliderOnMaineBlock no-mobile">
    <p class="titleMain"><a href="/catalog/bestsellers/"><?=GetMessage("BESTCELLERS_SLIDER_TITLE_SLIDER")?></a></p>
    <div class="bestcellersBooksSliderConteiner sliderConteiner">
        <ul>
            <?foreach ($arResult["ITEMS"] as $arItem) {
                $pict = $arItem["DETAIL_PICTURE"]["SRC_RESIZE"];
                $author = $arItem["DISPLAY_PROPERTIES"]["AUTHORS"]["LINK_ELEMENT_VALUE"];?>
                <li class="LiSliderElement">
                    <div class="divSliderElementConteiner">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                            <div class="imgSliderItem">
                                <?if($pict["src"] != ''){?>
                                    <img src="<?=$pict["src"]?>" alt="Обложка книги «<?=$arItem["NAME"]?>»">
                                <?} else {?>
                                    <img src="/images/no_photo.png">
                                <?}?>
                            </div>
                        </a>
                        <div class="sliderItemDescriptionContaner">
                            <?if($arItem["PROPERTIES"]["SHORT_NAME"]["VALUE"]){?>
                                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                                    <p class="sliderBookName" title="<?=$arItem["NAME"]?>">
                                        <?if(mb_strlen($arItem["PROPERTIES"]["SHORT_NAME"]["VALUE"]) > 39){
                                            echo mb_substr((strstr($arItem["PROPERTIES"]["SHORT_NAME"]["VALUE"],'(', true) ? strstr($arItem["PROPERTIES"]["SHORT_NAME"]["VALUE"],'(', true) : $arItem["PROPERTIES"]["SHORT_NAME"]["VALUE"]), 0, 38)."...";
                                            }else{
                                            echo strstr($arItem["PROPERTIES"]["SHORT_NAME"]["VALUE"],'(', true) ? strstr($arItem["PROPERTIES"]["SHORT_NAME"]["VALUE"],'(', true) : $arItem["PROPERTIES"]["SHORT_NAME"]["VALUE"];
                                            }
                                        ?>
                                    </p>
                                </a>
                            <?}elseif($arItem["NAME"]){?>
                                <p class="sliderBookName" title="<?=mb_substr($arItem["NAME"], 0, 38)?>"></p>
                            <?}?>
                            <?if($author){
                                if(is_array($author)){
                                    foreach($author as $value){?>
                                        <p class="sliderBookSeveralAutor" title="Перейтина страницу автора"><?=$value["NAME"]?></p>
                                    <?}
                                }else{?>
                                    <p class="sliderBookAutor" title="Перейти на страницу автора"><?=$author["NAME"]?></p>
                                <?}?>
                            <?}?>
                            <?if($arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]){?>
                                <p class="sliderBookOfPack"><?=$arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]?></p>
                            <?}?>
                            <?if($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"] != STATE_SOON){?>
                                <p class="sliderBookPrice"><?=$arItem["PRICES"]["BASE"]["DISCOUNT_VALUE_VAT"]?> <span class="rub_symbol">i</span></p>
                            <?//Свойство "Нет в наличии", "Под заказ", "Скоро в продаже", "Новинка"
                            }elseif($arItem["PROPERTIES"]["STATE"]["VALUE"]){?>
                                <p class="sliderBookPrice"><?=$arItem["PROPERTIES"]["STATE"]["VALUE"]?></p>
                            <?}elseif($arItem["PROPERTIES"]["SOON_DATE_TIME"]["VALUE"]){?>
                                <p class="sliderBookPrice"><?=$arItem["PROPERTIES"]["SOON_DATE_TIME"]["VALUE"]?></p>
                            <?}?>
                        </div>
                    </div>
                </li>
            <?}?>
        </ul>
    </div>
    <?if(count($arResult["ITEMS"]) > 6){?>
        <img src="/img/arrowLeft.png" class="bestcellersBooksleftArrow leftArrow">
        <img src="/img/arrowRight.png" class="bestcellersBooksRightArrow RightArrow">
    <?}?>
</div>