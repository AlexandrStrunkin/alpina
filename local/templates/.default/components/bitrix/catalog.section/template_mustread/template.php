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


                <div class="book bookMust">
                    <div class="firstWrapp">
                        <div class="coverSmall">
                            <?$left_upper_pict = CFile::ResizeImageGet($arResult["ITEMS"][1]["DETAIL_PICTURE"]["ID"], array('width'=>169, 'height'=>254), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                            $left_upper_author = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 29, "ID" => $arResult["ITEMS"][1]["PROPERTIES"]["AUTHORS"]["VALUE"][0]), false, false, array("ID", "NAME")) -> Fetch();?>
                            <a href="<?=$arResult["ITEMS"][1]["DETAIL_PAGE_URL"]?>" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'bookClickHBR', 'label' : 'block1'});">
                            <img src="<?=$left_upper_pict["src"]?>" title="<?=$left_upper_author["NAME"].' '.$arResult["ITEMS"][1]["NAME"]?>">
                            <?if(!empty($arResult["ITEMS"][1]["PROPERTIES"]["number_volumes"]["VALUE"])){?>
                              <span class="volumes"><?=$arResult["ITEMS"][1]["PROPERTIES"]["number_volumes"]["VALUE"]?></span>
                            <?}?>
                            </a>    
                        </div>
                        <div class="coverSmall">
                            <?$left_lower_pict = CFile::ResizeImageGet($arResult["ITEMS"][2]["DETAIL_PICTURE"]["ID"], array('width'=>169, 'height'=>254), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                            $left_lower_author = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 29, "ID" => $arResult["ITEMS"][2]["PROPERTIES"]["AUTHORS"]["VALUE"][0]), false, false, array("ID", "NAME")) -> Fetch();?>
                            <a href="<?=$arResult["ITEMS"][2]["DETAIL_PAGE_URL"]?>" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'bookClickHBR', 'label' : 'block2'});">
                            <img src="<?=$left_lower_pict["src"]?>" title="<?=$left_lower_author["NAME"].' '.$arResult["ITEMS"][2]["NAME"]?>">
                            <?if(!empty($arResult["ITEMS"][2]["PROPERTIES"]["number_volumes"]["VALUE"])){?>
                              <span class="volumes"><?=$arResult["ITEMS"][2]["PROPERTIES"]["number_volumes"]["VALUE"]?></span>
                            <?}?>
                            </a>            
                        </div>
                    </div>
                    <div class="secondWrapp">
                        <div class="cover">
                            <?$main_pict = CFile::ResizeImageGet($arResult["ITEMS"][0]["DETAIL_PICTURE"]["ID"], array('width'=>371, 'height'=>556), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                            $main_author = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 29, "ID" => $arResult["ITEMS"][0]["PROPERTIES"]["AUTHORS"]["VALUE"][0]), false, false, array("ID", "NAME")) -> Fetch();?>
                            <a href="<?=$arResult["ITEMS"][0]["DETAIL_PAGE_URL"]?>" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'bookClickHBR', 'label' : 'blockBig'});">
                            <img src="<?=$main_pict["src"]?>" title="<?=$main_author["NAME"].' '.$arResult["ITEMS"][0]["NAME"]?>">
                            <?if(!empty($arResult["ITEMS"][0]["PROPERTIES"]["number_volumes"]["VALUE"])){?>
                              <span class="volumes"><?=$arResult["ITEMS"][0]["PROPERTIES"]["number_volumes"]["VALUE"]?></span>
                            <?}?>
                            </a>        
                        </div>    
                    </div>
                    <div class="thirdWrapp">
                        
                        <div class="container">
                            <div class="coverSmall">
                                <?$right_upper_pict = CFile::ResizeImageGet($arResult["ITEMS"][3]["DETAIL_PICTURE"]["ID"], array('width'=>169, 'height'=>254), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                $right_upper_author = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 29, "ID" => $arResult["ITEMS"][3]["PROPERTIES"]["AUTHORS"]["VALUE"][0]), false, false, array("ID", "NAME")) -> Fetch();?>
                                <a href="<?=$arResult["ITEMS"][3]["DETAIL_PAGE_URL"]?>" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'bookClickHBR', 'label' : 'block3'});">
                                <img src="<?=$right_upper_pict["src"]?>" title="<?=$right_upper_author["NAME"].' '.$arResult["ITEMS"][3]["NAME"]?>">
                                <?if(!empty($arResult["ITEMS"][3]["PROPERTIES"]["number_volumes"]["VALUE"])){?>
                                  <span class="volumes"><?=$arResult["ITEMS"][3]["PROPERTIES"]["number_volumes"]["VALUE"]?></span>
                                <?}?>
                                </a>    
                            </div>
                            <div class="coverSmall">
                                <?$right_lower_pict = CFile::ResizeImageGet($arResult["ITEMS"][4]["DETAIL_PICTURE"]["ID"], array('width'=>169, 'height'=>254), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                 $right_lower_author = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 29, "ID" => $arResult["ITEMS"][4]["PROPERTIES"]["AUTHORS"]["VALUE"][0]), false, false, array("ID", "NAME")) -> Fetch();?>
                                <a href="<?=$arResult["ITEMS"][4]["DETAIL_PAGE_URL"]?>" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'bookClickHBR', 'label' : 'block4'});">
                                <img src="<?=$right_lower_pict["src"]?>" title="<?=$right_lower_author["NAME"].' '.$arResult["ITEMS"][4]["NAME"]?>">
                                <?if(!empty($arResult["ITEMS"][4]["PROPERTIES"]["number_volumes"]["VALUE"])){?>
                                  <span class="volumes"><?=$arResult["ITEMS"][4]["PROPERTIES"]["number_volumes"]["VALUE"]?></span>
                                <?}?>
                                </a>    
                            </div>    
                        </div>
                        
                        <a href="/catalog/sale/" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'bookClickHBR', 'label' : 'allBooks'});">
                        <div class="text">
                            <p>Новые скидки каждый день</p>
                            Смотреть все
                        </div>          
                        </a>
                    </div>
                </div>

