<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//arshow($arResult);
foreach($arResult as $arItem) {
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
		continue;

        $style= "";
        if ($arItem["PARAMS"]["color"]) {
            $style = "target='_blank' style='color: ". $arItem["PARAMS"]["color"]." !important'";    
        }
?>
	<li><a <?=$style?> class="topMenuLink<?if($arItem['SELECTED']){?> topMenuLink_selected<?}?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
<?}?>
