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
<?if ($_REQUEST["DIRECTION"] == "DESC") {?>
    <style>
        .filterParams .active p:after {
            -moz-transform: scaleX(-1);
            -o-transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
            transform: scaleX(-1);
            position: absolute;
        }
        .wrapperCategor .filterParams li.active {
            width:128px;
        }
    </style>

<?}?>
<style>
.wrapperCategor, .categoryWrapper .contentWrapp {height:auto;}
</style>
<?
$navnum = $arResult["NAV_RESULT"]->NavNum;
if ($_REQUEST["PAGEN_" . $navnum]) {
    //$_SESSION[$APPLICATION -> GetCurDir()] = $_REQUEST["PAGEN_" . $navnum];
}
if($arResult["ID"] == SECTION_ID_FOR_CHILDREN){
    $for_chyldren = "";
}
$is_bot_detected = false;
if (isset($_SERVER["HTTP_USER_AGENT"]) && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])) {
    $is_bot_detected = true;
}?>
<?if($for_chyldren){?>
    <link rel="stylesheet" href="/local/css/style_for_children.css" type="text/css">
    <div class="soc_service_wrap">
        <p>Мы в соцсетях</p>
        <ul>
            <li><a href="" class="net_1"></a></li>
            <li><a href="" class="net_2"></a></li>
            <li><a href="https://twitter.com/AlpinaBookRu" class="net_3"><img src="/img/twitterImg.png"></a></li>
            <li><a href="http://vk.com/ideabooks" class="net_4"><img src="/img/vkImg.png"></a></li>
        </ul>
    </div>
<?}?>

<div class="wrapperCategor">
    <div class="categoryWrapper">
        <div class="catalogIcon">
        </div>
        <div class="basketIcon">
        </div>
        <div class="contentWrapp">
            <p class="breadCrump no-mobile" itemprop="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                    <a href="/" title="Книги Альпина" itemprop="item">
                        <span itemprop="name">Книги Альпина</span>
                    </a>
                    <meta itemprop="position" content="1">
                </span>
                <?
                $num = 2;
                $navChain = CIBlockSection::GetNavChain(4, $arResult["ID"]);
                $stopNum = $navChain->nSelectedCount + 1;
                while ($arNav = $navChain->GetNext()) {?>
                <span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                    <span class="gap"></span>
                    <?if ($num != $stopNum) {?>
                        <a href="/catalog<?=$arNav[SECTION_PAGE_URL]?>" title="<?=$arNav[NAME]?>" itemprop="item">
                    <?}?>
                        <span itemprop="name"><?=$arNav[NAME]?></span>
                    <?if ($num != $stopNum) {?>
                        </a>
                    <?}?>
                    <meta itemprop="position" content="<?=$num?>">
                </span>
                <?
                $num++;
                }?>
            </p>
            <div itemprop="mainEntity" itemscope itemtype="http://schema.org/OfferCatalog">
            <link itemprop="url" href="<?=$_SERVER['REQUEST_URI']?>" />
            <?if($for_chyldren){?>
                <img src="/img/for_children/page-1.png" class="image_header">
            <?}?>

            <h1 itemprop="name"><?= $arResult["NAME"]?></h1>


            <?
            $arData = array();
            $arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL");
            $arFilter = Array("IBLOCK_ID" => 80, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_THIS_SECTION" => $arResult["ID"]);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            while($ob = $res->GetNextElement()) {
                $arData[] = $ob->GetFields();
            }

            if(count($arData) > 0) {?>
                <div class="doner_tags">
                    <span>Популярные категории</span>
                    <?foreach($arData as $data) {?>
                        <a href="<?=$data["DETAIL_PAGE_URL"]?>"><?=$data["NAME"]?></a>
                    <?}?>
                </div>
            <?}?>
            <?if($for_chyldren){?>
                <?
                $arFilter = Array('IBLOCK_ID'=>$arResult['IBLOCK_ID'],'ID'=>$arResult["ID"], 'GLOBAL_ACTIVE'=>'Y');
                $db_list = CIBlockSection::GetList(Array(), $arFilter, false, Array("ID","UF_TEXT_WRAP_1"));
                 if($uf_value = $db_list->GetNext()){
                     $text_wrap_1 = $uf_value["UF_TEXT_WRAP_1"];
                   };
                ?>
                <div class="wrap_style_1">
                    <p><?=$text_wrap_1?> </p>
                    <img src="/img/for_children/bitmap1.png">
                </div>
            <?}?>

            <?if(!$for_chyldren){?>
                <? global $SectionRoundBanner;
                $SectionRoundBanner = array("PROPERTY_BIND_TO_SECTION" => $arResult["ID"]);
                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "section_banners",
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
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "COMPONENT_TEMPLATE" => "section_banners",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array(
                            0 => "DETAIL_PICTURE",
                            1 => "",
                        ),
                        "FILTER_NAME" => "SectionRoundBanner",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "6",
                        "IBLOCK_TYPE" => "news",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "20",
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
                            0 => "SECT_BANNER_LINK",
                            1 => "",
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
                        "SORT_ORDER2" => "ASC"
                    ),
                    false
                );?>

            <? /* Получаем от RetailRocket рекомендации для товара */
            $stringRecs = file_get_contents('https://api.retailrocket.ru/api/1.0/Recomendation/CategoryToItems/50b90f71b994b319dc5fd855/' . $arResult["ID"]);
            $recsArray = json_decode($stringRecs);
            global $BestsellFilter;
            if ($recsArray[0] > 0) {
                $printid2 = array_slice($recsArray, 0, 4);
                foreach ($printid2 as $rec_book) {
                    $BestsellFilter['ID'][] = $rec_book;
                }
            }
            $printid = implode(", ", $printid2);

            if ($BestsellFilter['ID'][0] > 0) {?>
                <p class="grayTitle"><?= GetMessage("POPULAR_ITEMS_TITLE")?></p>
                <?
                if(!$USER->IsAdmin()){
                    $BestsellFilter["!PROPERTY_FOR_ADMIN_VALUE"] = "Y";
                }
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "category.recs",
                    array(
                        "IBLOCK_TYPE" => "catalog",
                        "IBLOCK_ID" => "4",
                        "SECTION_ID" => $arResult["ID"],
                        "SECTION_CODE" => "",
                        "IBLOCK_HEADER_TITLE" => "",
                        "ELEMENT_SORT_FIELD" => "PROPERTY_SALES_CNT",
                        "ELEMENT_SORT_ORDER" => "desc",
                        "FILTER_NAME" => "BestsellFilter",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "SHOW_ALL_WO_SECTION" => "Y",
                        "PAGE_ELEMENT_COUNT" => "10",
                        "LINE_ELEMENT_COUNT" => "1",
                        "PROPERTY_CODE" => array(
                            0 => "SHORT_NAME",
                            1 => "BIRTHDATE",
                            2 => "FIRST_NAME",
                            3 => "LAST_NAME",
                            4 => "",
                        ),
                        "SECTION_URL" => "",
                        "DETAIL_URL" => "",
                        "BASKET_URL" => "/personal/cart/step1a.php",
                        "ACTION_VARIABLE" => "action",
                        "PRODUCT_ID_VARIABLE" => "",
                        "SECTION_ID_VARIABLE" => "",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_SHADOW" => "Y",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "CACHE_TYPE" => "N",
                        "CACHE_TIME" => "3600",
                        "META_KEYWORDS" => "-",
                        "META_DESCRIPTION" => "-",
                        "DISPLAY_PANEL" => "N",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "DISPLAY_COMPARE" => "N",
                        "SET_TITLE" => "N",
                        "SET_STATUS_404" => "N",
                        "CACHE_FILTER" => "Y",
                        "PRICE_CODE" => array(
                            0 => "BASE",
                        ),
                        "USE_PRICE_COUNT" => "N",
                        "SHOW_PRICE_COUNT" => "1",
                        "PRICE_VAT_INCLUDE" => "N",
                        "DISPLAY_TOP_PAGER" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "PAGER_TITLE" => "Товары",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => "",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "Y",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "COMPONENT_TEMPLATE" => "category.recs",
                        "SECTION_USER_FIELDS" => array(
                            0 => "",
                            1 => "",
                        ),
                        "ELEMENT_SORT_FIELD2" => "id",
                        "ELEMENT_SORT_ORDER2" => "desc",
                        "HIDE_NOT_AVAILABLE" => "N",
                        "OFFERS_LIMIT" => "5",
                        "BACKGROUND_IMAGE" => "-",
                        "TEMPLATE_THEME" => "blue",
                        "ADD_PICT_PROP" => "-",
                        "LABEL_PROP" => "-",
                        "PRODUCT_SUBSCRIPTION" => "N",
                        "SHOW_DISCOUNT_PERCENT" => "N",
                        "SHOW_OLD_PRICE" => "N",
                        "SHOW_CLOSE_POPUP" => "N",
                        "MESS_BTN_BUY" => "Купить",
                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                        "MESS_BTN_SUBSCRIBE" => "Подписаться",
                        "MESS_BTN_COMPARE" => "Сравнить",
                        "MESS_BTN_DETAIL" => "Подробнее",
                        "MESS_NOT_AVAILABLE" => "Нет в наличии",
                        "SEF_MODE" => "N",
                        "CACHE_GROUPS" => "N",
                        "SET_BROWSER_TITLE" => "Y",
                        "BROWSER_TITLE" => "-",
                        "SET_META_KEYWORDS" => "Y",
                        "SET_META_DESCRIPTION" => "Y",
                        "SET_LAST_MODIFIED" => "N",
                        "USE_MAIN_ELEMENT_SECTION" => "N",
                        "CONVERT_CURRENCY" => "N",
                        "USE_PRODUCT_QUANTITY" => "N",
                        "PRODUCT_QUANTITY_VARIABLE" => "undefined",
                        "ADD_PROPERTIES_TO_BASKET" => "Y",
                        "PRODUCT_PROPS_VARIABLE" => "prop",
                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                        "PRODUCT_PROPERTIES" => array(
                        ),
                        "ADD_TO_BASKET_ACTION" => "ADD",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "SHOW_404" => "N",
                        "MESSAGE_404" => ""
                    ),
                    false
                )
                //}?>

         <?} else {  //проверка на вывод подборок на главной?>
            <p class="grayTitle"></p>
         <?}?>
         <?}?>
         <?  //блок с цитатой ?>
         <?if (is_array($arResult["QUOTE_ARRAY"])) {?>
             <div class="titleDiv">
                 <?if ($arResult["QUOTE_ARRAY"]["DETAIL_PICTURE"]){?>
                     <div class="photo">
                         <img src="<?= $arResult["QUOTE_IMAGE"]["src"]?>" alt="Автор <?=$arResult["QUOTE_ARRAY"]["PROPERTY_AUTHOR_NAME"]?>">
                     </div>
                 <?}?>
                 <p class="text">"<?= $arResult["QUOTE_ARRAY"]["DETAIL_TEXT"]?>"</p>
                 <p class="autor"><?= $arResult["QUOTE_ARRAY"]["PROPERTY_AUTHOR_NAME"]?></p>
             </div>
         <?}?>
         <?// блок с цитатой END ?>
         <ul class="filterParams">
             <li <?if ($_REQUEST['SORT'] == 'POPULARITY' || !($_REQUEST['SORT'])) { ?> class="active" <?}?>>
                 <p data-id="1">
                         <a href="/catalog/<?= $arParams["SECTION_CODE"]?>/?SORT=POPULARITY&DIRECTION=DESC" onclick="update_sect_page('popularity', 'desc', '<?= $arParams["SECTION_CODE"]?>'); return false;">По популярности</a>
                 </p>
             </li>
             <li <?if ($_REQUEST['SORT'] == 'DATE'){?>class="active"<?}?>>
                 <p data-id="2">
                     <?if ($_REQUEST['SORT'] == 'DATE' && $_REQUEST["DIRECTION"] == 'ASC') {?>
                         <a href="/catalog/<?= $arParams["SECTION_CODE"]?>/?SORT=DATE&DIRECTION=DESC" onclick="update_sect_page('date', 'asc', '<?= $arParams["SECTION_CODE"]?>'); return false;">По дате выхода</a>
                     <?} else {?>
                         <a href="/catalog/<?= $arParams["SECTION_CODE"]?>/?SORT=DATE&DIRECTION=ASC" onclick="update_sect_page('date', 'desc', '<?= $arParams["SECTION_CODE"]?>'); return false;">По дате выхода</a>
                     <?}?>
                 </p>
             </li>
             <li <?if ($_REQUEST['SORT'] == 'PRICE'){?>class="active"<?}?>>
                 <p data-id="3">
                     <?if ($_REQUEST['SORT'] == 'PRICE' && $_REQUEST["DIRECTION"] == 'ASC') {?>
                         <a href="/catalog/<?= $arParams["SECTION_CODE"]?>/?SORT=PRICE&DIRECTION=DESC" onclick="update_sect_page('price', 'desc', '<?= $arParams["SECTION_CODE"]?>'); return false;">По цене</a>
                     <?} else {?>
                         <a href="/catalog/<?= $arParams["SECTION_CODE"]?>/?SORT=PRICE&DIRECTION=ASC" onclick="update_sect_page('price', 'asc', '<?= $arParams["SECTION_CODE"]?>'); return false;">По цене</a>
                     <?}?>
                 </p>
             </li>
         </ul>
         <div class="otherBooks" id="block1">
             <ul>

                 <?$criteoCounter = 0;
                 $criteoItems = Array();
                 $gtmEcommerceImpressions = '';
                 $gdeslon = '';
                     foreach ($arResult["ITEMS"] as $cell => $arItem) {
                         foreach ($arItem["PRICES"] as $code => $arPrice) {
                         ?>
                         <li itemprop="itemListElement" itemscope itemtype="http://schema.org/Book">
                            <meta itemprop="description" content="<?=htmlspecialchars(strip_tags($arItem["PREVIEW_TEXT"]))?>" />
                             <div class="categoryBooks">
                                 <div class="sect_badge">
                                     <?if (($arItem["PROPERTIES"]["discount_ban"]["VALUE"] != "Y")
                                         && $arItem['PROPERTIES']['spec_price']['VALUE']
                                         && $arItem['PROPERTIES']['show_discount_icon']['VALUE'] == "Y") {
                                                if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/img/" . $arItem['PROPERTIES']['spec_price']['VALUE'] . "percent.png")) {
                                                    echo '<img class="discount_badge" src="/img/' . $arItem['PROPERTIES']['spec_price']['VALUE'] . 'percent.png">';
                                                }
                                     }?>
                                 </div>
                                <?if($arItem["PROPERTIES"]["TRANSPARENT_CORNER"]["VALUE_XML_ID"] == "Y"){?>
                                    <?$corner_1 = "Y";?>
                                <?} else if($arItem["PROPERTIES"]["TRANSPARENT_CORNER_1_2"]["VALUE_XML_ID"] == "Y"){?>
                                    <?$corner_2 = "Y";?>
                                <?} else {
                                    $corner_1 = '';
                                    $corner_2 = '';
                                }?>
                                <a href="<?= $arItem["DETAIL_PAGE_URL"]?>" onclick="productClickTracking(<?= $arItem["ID"];?>, '<?= $arItem["NAME"];?>', '<?= ceil($arPrice["DISCOUNT_VALUE_VAT"])?>','<?= $arResult["NAME"]?>', <?= ($cell+1)?>, 'Catalog Section');" itemprop="url">
                                     <div class="section_item_img">
                                         <?if ($arResult[$arItem["ID"]]["PICTURE"]["src"]) {?>
                                             <img src="<?= $arResult[$arItem["ID"]]["PICTURE"]["src"]?>" alt="<?= $arItem["NAME"];?>" itemprop="image" style="<?=($corner_1)?'border-radius: 15px 15px 15px 15px;':''?> <?=($corner_2)?'border-radius: 0px 15px 15px 0px;':''?>">
                                         <?} else {?>
                                             <img src="/images/no_photo.png" width="142" height="142">
                                         <?}?>
                                         <?if(!empty($arItem["PROPERTIES"]["number_volumes"]["VALUE"])) {?>
                                             <span class="volumes"><?= $arItem["PROPERTIES"]["number_volumes"]["VALUE"]?></span>
                                         <?}?>
                                     </div>
                                     <p class="nameBook" title="<?= $arItem["NAME"]?>" itemprop="name"><?= $arItem["NAME"]?></p>
                                     <?if ($USER->isAdmin()){?>
                                        <span class="crr-cnt" data-crr-url="<?=$arItem["ID"]?>" data-crr-chan="<?=$arItem["ID"]?>"></span>
                                     <?}?>
                                     <?if($arResult[$arItem["ID"]]["CURRENT_AUTHOR"]["NAME"]){?>
                                        <p class="bookAutor" itemprop="author"><?= $arResult[$arItem["ID"]]["CURRENT_AUTHOR"]["NAME"]?></p>
                                     <?}?>
                                     <?if($arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]){?>
                                        <p class="tapeOfPack"><?= $arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]?></p>
                                     <?}?>
                                     <?
                                     if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal")) {
                                            if ($arPrice["DISCOUNT_VALUE_VAT"] && $arResult['ID'] != CERTIFICATE_SECTION_ID) { ?>
                                                <p class="priceOfBook" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                <link itemprop="availability" href="http://schema.org/InStock"><link itemprop="itemCondition" href="http://schema.org/NewCondition"><span itemprop="price"><?= ceil($arPrice["DISCOUNT_VALUE_VAT"])?></span> <? if (!$is_bot_detected){?><span class="rub_symbol">i</span><?} else {?>руб.<?}?></p>
                                            <? } elseif ($arResult['ID'] == CERTIFICATE_SECTION_ID) { ?>
                                                <p class="priceOfBook" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                <link itemprop="availability" href="http://schema.org/InStock"<link itemprop="itemCondition" href="http://schema.org/NewCondition"><span itemprop="price"><?= ceil($arPrice["VALUE_VAT"])?></span> <? if (!$is_bot_detected){?><span class="rub_symbol">i</span><?} else {?>руб.<?}?></p>
                                            <? } else { ?>
                                                <p class="priceOfBook" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                <link itemprop="availability" href="http://schema.org/InStock"<link itemprop="itemCondition" href="http://schema.org/NewCondition"><span itemprop="price"><?= ceil($arPrice["ORIG_VALUE_VAT"])?></span> <? if (!$is_bot_detected){?><span class="rub_symbol">i</span><?} else {?>руб.<?}?></p>
                                            <? }
                                         ?>
                                         <?if ($arResult[$arItem["ID"]]["ITEM_IN_BASKET"]["QUANTITY"] == 0 && $arResult['ID'] != CERTIFICATE_SECTION_ID) {?>
                                            <a id="addToCartSection" class="product<?= $arItem["ID"];?>" onmousedown="try { rrApi.addToBasket(<?=$arItem["ID"]?>) } catch(e) {}" href="JavaScript::void(0);" onclick="<?// if ($arItem["CATALOG_QUANTITY"] >= 0) {?>addtocart(<?=$arItem["ID"];?>, '<?=$arItem["NAME"];?>'); addToCartTracking(<?= $arItem["ID"];?>, '<?= $arItem["NAME"];?>', '<?= ceil($arPrice["DISCOUNT_VALUE_VAT"])?>','<?= $arResult["NAME"]?>', '1'); <?//}?> return false;">
                                                <?if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode (CATALOG_IBLOCK_ID, "STATE", "soon")) {
                                                    /*if ($arItem["CATALOG_QUANTITY"] <= 0) {?>
                                                        <p class="basketBook basketBook_unavailable"><?=GetMessage("CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE")?></p>
                                                    <?} else {*/?>
                                                        <p class="basketBook"><?=GetMessage("CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET")?></p>
                                                    <?//}?>
                                                <?} else {?>
                                                    <p class="basketBook"><?=GetMessage("CT_BCS_TPL_MESS_BTN_ADD_TO_PREORDER")?></p>
                                                <?}?>
                                            </a>
                                         <?} elseif ($arResult['ID'] == CERTIFICATE_SECTION_ID) {?>
                                            <a class="product<?= $arItem["ID"];?>" href="<?echo $arItem["DETAIL_PAGE_URL"]?>">
                                                <p class="basketBook"><?=GetMessage("CT_BCS_TPL_MESS_BTN_BUY")?></p>
                                            </a>
                                         <?} else {?>
                                            <a class="product<?= $arItem["ID"];?>" href="/personal/cart/">
                                                <p class="basketBook" style="background-color: #A9A9A9; color: white;">Оформить</p>
                                            </a>
                                         <?}?>
                                 <?} elseif (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal")) {?>
                                    <p class="priceOfBook"><?= $arItem["PROPERTIES"]["STATE"]["VALUE"]?></p>
                                 <?} else {?>
                                    <p class="priceOfBook"><?= strtolower(FormatDate("j F", MakeTimeStamp($arItem['PROPERTIES']['SOON_DATE_TIME']['VALUE'], "DD.MM.YYYY HH:MI:SS")));?></p>
                                 <?}?>
                             </a>
                                 <? if ($USER -> IsAuthorized() && $arResult['ID'] != CERTIFICATE_SECTION_ID) { ?>
                                     <p class="basketLater" id="<?= $arItem["ID"]?>">Куплю позже</p>
                                 <? } ?>
                             </div>
                         </li>
                         <?      //}
                         }
                        if($criteoCounter<3){
                            array_push($criteoItems, $arItem['ID']);
                        }
                         $criteoCounter++;

                        $gdeslon .= $arItem['ID'].':'.ceil($arPrice["DISCOUNT_VALUE_VAT"]).',';

                         $gtmEcommerceImpressions .= "{";
                         $gtmEcommerceImpressions .= "'name': '" . $arItem["NAME"] . "',";
                         $gtmEcommerceImpressions .= "'id': '" . $arItem['ID'] . "',";
                         $gtmEcommerceImpressions .= "'price': '" . ceil($arPrice["DISCOUNT_VALUE_VAT"]) . "',";
                         $gtmEcommerceImpressions .= "'category': '" . $arResult["NAME"] . "',";
                         $gtmEcommerceImpressions .= "'list': 'category - " . $arResult["NAME"] . "',";
                         $gtmEcommerceImpressions .= "'position': '" . ($cell+1) . "'";
                         $gtmEcommerceImpressions .= "},";

                         }
                         ?>


                <script type="text/javascript">
                     <!-- //dataLayer GTM -->
                     dataLayer.push({
                         'categoryName' : '<?= $arResult["NAME"]?>',
                         'categoryId' : '<?= $arResult['ID'];?>',
                         'ecommerce': {
                             'impressions': [
                                 <?= $gtmEcommerceImpressions?>
                             ]
                         }

                     });
                     <!-- // dataLayer GTM -->
                 </script>
                <!-- gdeslon -->
                <script type="text/javascript" src="https://www.gdeslon.ru/landing.js?mode=list&amp;codes=<?=substr($gdeslon,0,-1)?>&amp;mid=79276&amp;cat_id=<?= $arResult['ID'];?>" async></script>

                 <!--Criteo counter-->
                 <script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
                 <script type="text/javascript">
                     window.criteo_q = window.criteo_q || [];
                     window.criteo_q.push(
                         { event: "setAccount", account: 18519 },
                         <?if ($USER->IsAuthorized()) {?>
                             { event: "setEmail", email: "<?= $USER->GetEmail()?>" },
                         <?}?>
                         { event: "setSiteType", type: "d" },
                         { event: "viewList", item: [<?foreach ($criteoItems as $criteoItem) {echo $criteoItem.', ';};?>]}
                     );
                 </script>
             </ul>

         </div>
            <div class="wishlist_info">
                <div class="CloseWishlist"><img src="/img/catalogLeftClose.png"></div>
                <span></span>
            </div>





            <?if (($arResult["NAV_RESULT"]->NavPageCount) > 1) {?>
                <p class="showMore">Показать ещё</p>
            <?}?>
            <?=$arResult["NAV_STRING"]?>
            </div>
        </div>



        <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "catalog_left_menu",
                array(
                    "ROOT_MENU_TYPE" => "top_books_left_menu",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "top",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "Y",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "COMPONENT_TEMPLATE" => "catalog_left_menu"
                ),
                false
            );?>

        <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "section.left.tree",
                array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "4",
                    "SECTION_ID" => "",
                    "SECTION_CODE" => "",
                    "COUNT_ELEMENTS" => "N",
                    "TOP_DEPTH" => "2",
                    "IBLOCK_HEADER_TITLE" => "Каталог книг",
                    "IBLOCK_HEADER_LINK" => "",
                    "SECTION_URL" => "#SITE_DIR#/catalog/#SECTION_CODE#/",
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "3600",
                    "DISPLAY_PANEL" => "N",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "COMPONENT_TEMPLATE" => "section.left.tree",
                    "SECTION_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "SECTION_USER_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "CACHE_GROUPS" => "N",
                    "VIEW_MODE" => "LIST",
                    "SHOW_PARENT_NAME" => "Y"
                ),
                false
            );?>


        <?if(!$for_chyldren){?>
            <div class="catalogDescription" itemprop="description">
                <?=$arResult["DESCRIPTION"]?>
            </div>
        <?}?>
    </div>
</div>

<?
    if (!isset($_SESSION[$APPLICATION -> GetCurDir()])) {
        $_SESSION[$APPLICATION -> GetCurDir()] = 1;
    }
?>
</div>
<script>
    // скрипт ajax-подгрузки товаров в блоке "Все книги"
    $(document).ready(function() {
        $(".leftMenu ul li").each(function(){
            if ($(this).children("a").attr("href") == "<?= $APPLICATION -> GetCurDir()?>") {
                $(this).children("a").find("p").css("font-weight", "bold");
                if ($(this).closest("ul").hasClass("secondLevel")) {
                    $(this).closest("ul").parent("li").find("a p").addClass("activeListName");
                    $(this).closest("ul").parent("li").find(".secondLevel").show();
                } else {
                    $(this).find("ul.secondLevel a p").addClass("activeListName");
                    $(this).find("ul.secondLevel").show();
                }
            }
        });
        <?$navnum = $arResult["NAV_RESULT"]->NavNum;
        if ($navnum == 1) {
            $navnum = 2;
        }
        switch ($arParams["ELEMENT_SORT_FIELD"]) {
            case "CATALOG_PRICE_1":
            $sort = "PRICE";
            break;

            case "PROPERTY_shows_a_day":
            $sort = "POPULARITY";
            break;

            case "PROPERTY_SOON_DATE_TIME":
            $sort = "DATE";
            break;
        }?>
        <?if (isset($_REQUEST["PAGEN_".$navnum])) {
           ?>
            var page = <?= $_REQUEST["PAGEN_".$navnum]?> + 1;
        <?} else {?>
            var page = 2;
        <?}?>
        var maxpage = <?= ($arResult["NAV_RESULT"]->NavPageCount)?>;
        if ($(".bx-pagination").size() > 0) {
            var WrappHeight = $(".wrapperCategor").height();
            var DescriptionHeight = $(".catalogDescription").height();
            var RecHeight = $(".grayTitle").height();
            if (RecHeight == 0) {
                RecHeight = 550;
            }
            var BooksLiLength = $(".otherBooks ul li").length;

            var startHeight = WrappHeight+RecHeight+100 + DescriptionHeight + Math.ceil((BooksLiLength - 15) / 5) * 455;
            //$(".wrapperCategor").css("height", startHeight+"px");
        }

        $('.showMore').click(function(){
           // var otherBooks = $(this).siblings(".otherBooks");
            <?
            if ($_REQUEST["SORT"]) {
            ?>
                $.get(window.location.href + '&PAGEN_<?= $navnum?>=' + page, function(data) {
                    var next_page = $('.otherBooks ul li', data);
                    $('.otherBooks ul').append(next_page);
                    $(".bx-pagination-container ul li").each(function(){
                        if ($(this).find("span").html() == page) {
                            $(".bx-pagination-container ul li").removeClass("bx-active");
                            $(this).addClass("bx-active");
                        }
                    });
                    page++;
                })
            <?
            } else {?>
                $.get('<?= $arResult["SECTION_PAGE_URL"]?>?SORT=<?= $sort?>&DIRECTION=<?= $arParams["ELEMENT_SORT_ORDER2"]?>&PAGEN_<?= $navnum?>='+page,
                    function(data) {
                    var next_page = $('.otherBooks ul li', data);
                    $('.otherBooks ul').append(next_page);
                    $(".bx-pagination-container ul li").each(function(){
                        if ($(this).find("span").html() == page) {
                            $(".bx-pagination-container ul li").removeClass("bx-active");
                            $(this).addClass("bx-active");
                        }
                    });
                    page++;
                })
            <?
            }
            ?>
            .done(function() {
                    $(".nameBook").each(function() {
                        if($(this).length > 0) {
                            $(this).html(truncate($(this).html(), 40));
                        }
                    });
                    var otherBooksHeight = 455 * Math.ceil($(".otherBooks ul li").length / 5);
                    console.log($(".otherBooks ul li").length);

                    var categorHeight = WrappHeight+RecHeight+200 + Math.ceil(($(".otherBooks ul li").length - 15) / 5) * 455;

                  //  $(".otherBooks").css("height", otherBooksHeight+"px");
                    //$(".wrapperCategor").css("height", categorHeight+"px");
                    //$(".contentWrapp").css("height", categorHeight-10+"px");
                    //$(".wrapperCategor").css("height", $(".contentWrapp").height()+"px");
            });
            if (page == maxpage) {
                $('.showMore').hide();
            }
            return false;

        });
        <?if (isset($_SESSION[$APPLICATION -> GetCurDir()])) {?>
            var upd_page = <?= $_SESSION[$APPLICATION -> GetCurDir()]?>;
            for (i = 2; i <= upd_page; i++) {
                 <?if ($_REQUEST["SORT"]) {?>
                    $.get(window.location.href + '&PAGEN_<?= $navnum?>=' + page, function(data) {
                        var next_page = $('.otherBooks ul li', data);
                        $('.otherBooks ul').append(next_page);
                        page++;
                    })
                 <?} else {?>
                     $.get('<?= $arResult["SECTION_PAGE_URL"]?>?SORT=<?= $sort?>&DIRECTION=<?= $arParams["ELEMENT_SORT_ORDER2"]?>&PAGEN_<?= $navnum?>='+page,
                        function(data) {
                            var next_page = $('.otherBooks ul li', data);
                            $('.otherBooks ul').append(next_page);
                            page++;
                        }
                     )
                 <?}?>
                .done(function() {
                        $(".nameBook").each(function() {
                                if($(this).length > 0) {
                                    $(this).html(truncate($(this).html(), 40));
                                }
                        });
                        var otherBooksHeight = 1350 * ($(".otherBooks ul li").length / 15);

                        var categorHeight = WrappHeight+RecHeight+200+ Math.ceil(($(".otherBooks ul li").length - BooksLiLength) / 5) * 455;

                       // $(".otherBooks").css("height", otherBooksHeight+"px");
                        //$(".wrapperCategor").css("height", categorHeight+"px");
                        //$(".contentWrapp").css("height", categorHeight-10+"px");
                        //$(".wrapperCategor").css("height", $(".wrapperCategor").height()+"px");

                });
                if (upd_page == maxpage) {
                    $('.showMore').hide();
                }
            }
        <?}?>
        <?if (!$USER -> IsAuthorized()) {?>
            $(".categoryWrapper .categoryBooks").hover(function() {
                $(this).css("height", "420px");
            });

        <?}?>
cackle_widget = window.cackle_widget || [];
            cackle_widget.push({widget: 'ReviewRating', id: 36574, html: '{{=it.stars}}{{?it.numr > 0}} {{=it.numr+it.numv}} {{=it.reviews}}{{?}}'});
            (function() {
                var mc = document.createElement('script');
                mc.type = 'text/javascript';
                mc.async = true;
                mc.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cackle.me/widget.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
            })();
    });
</script>
