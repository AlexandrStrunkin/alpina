<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

if (!empty($arResult['ITEMS'])){
    //Ресайз картинок обложек книг
    foreach($arResult["ITEMS"] as $key => $value){
        if($value["DETAIL_PICTURE"]["ID"]){
            $arResult["ITEMS"][$key]["DETAIL_PICTURE"]["SRC_RESIZE"] = CFile::ResizeImageGet($value["DETAIL_PICTURE"]["ID"], array('width'=>190, 'height'=>291), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        }

    }
    // END Ресайз картинок обложек книг
}
?>