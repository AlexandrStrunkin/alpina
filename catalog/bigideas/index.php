<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Маленькие книги — большие идеи");
$APPLICATION->SetTitle("Серия «Маленькие книги — большие идеи»");

if ($_REQUEST["DIRECTION"])
{
    $order = $_REQUEST["DIRECTION"];
}
else
{
    $order = "desc";
}
switch ($_REQUEST["SORT"])
{
    case "DATE":
    $sort = "PROPERTY_YEAR";
    break;

    case "PRICE":
    $sort = "CATALOG_PRICE_1";
    break;

    case "POPULARITY":
    $sort = "PROPERTY_DESIRABILITY";
    $order = "asc";
    break;

    default:
    $sort = "PROPERTY_DESIRABILITY";
    $order = "desc";
}

?>

<div class="wrapperCategor ComingSoonCategor">
    <div class="categoryWrapper">
    
        <div class="catalogIcon"></div>
        <div class="basketIcon"></div>

        <div class="contentWrapp">
            <h1 class="titleMain">Маленькие книги — большие идеи</h1>
            <div class='serieDescr'>Перед вами две серии книг: «Альпина. Психология и философия» и «Альпина. Popular Science».<br />Мы выбрали лучшие книги по психологии, философии и популярной науке, и переиздали их в новом  формате.<br /><br /><p style='font-family:Walshein_black;font-size:18px'>В чем особенность этих книг?</p>• Удобный карманный формат: берите с собой куда угодно<br />• Оригинальный дизайн: вам захочется собрать коллекцию<br />• Доступная цена: ни в чем себе не отказывайте<br />• Занимают мало места и почти ничего не весят</div>


<?global $arrFilter_1;
if(!$USER->IsAdmin()){
    $arrFilter_1 = array('PROPERTY_SERIES' => array(429853), ">DETAIL_PICTURE" => 0, "!PROPERTY_FOR_ADMIN_VALUE" => "Y");
} else {
    $arrFilter_1 = array('PROPERTY_SERIES' => array(429853), ">DETAIL_PICTURE" => 0);
}?>

<h2>Альпина. Психология и философия</h2>

<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "bigideas", Array(
        "ACTION_VARIABLE" => "action",
        "ADD_PICT_PROP" => "-",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "ADD_TO_BASKET_ACTION" => "ADD",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BACKGROUND_IMAGE" => "-",
        "BASKET_URL" => "/personal/basket.php",
        "BROWSER_TITLE" => "-",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "N",
        "COMPONENT_TEMPLATE" => "bestsellers",
        "CONVERT_CURRENCY" => "N",
        "DETAIL_URL" => "",
        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_SORT_FIELD" => $sort,
        "ELEMENT_SORT_FIELD2" => "name",
        "ELEMENT_SORT_ORDER" => $order,
        "ELEMENT_SORT_ORDER2" => "asc",
        "FILTER_NAME" => "arrFilter_1",
        "HIDE_NOT_AVAILABLE" => "N",
        "IBLOCK_ID" => "4",
        "IBLOCK_TYPE" => "catalog",
        "INCLUDE_SUBSECTIONS" => "Y",
        "LABEL_PROP" => "-",
        "LINE_ELEMENT_COUNT" => "3",
        "MESSAGE_404" => "",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "OFFERS_LIMIT" => "5",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Товары",
        "PAGE_ELEMENT_COUNT" => "15",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRICE_CODE" => array(
            0 => "BASE",
        ),
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPERTIES" => array(
        ),
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "",
        "PRODUCT_SUBSCRIPTION" => "N",
        "PROPERTY_CODE" => array(
            0 => "AUTHORS",
            1 => "",
        ),
        "SECTION_CODE" => "",
        "SECTION_CODE_PATH" => "",
        "SECTION_ID" => $_REQUEST["SECTION_ID"],
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SECTION_URL" => "",
        "SECTION_USER_FIELDS" => array(
            0 => "",
            1 => "",
        ),
        "SEF_MODE" => "Y",
        "SEF_RULE" => "",
        "SET_BROWSER_TITLE" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "Y",
        "SHOW_404" => "N",
        "SHOW_ALL_WO_SECTION" => "Y",
        "SHOW_CLOSE_POPUP" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "TEMPLATE_THEME" => "blue",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "USE_PRICE_COUNT" => "N",
        "USE_PRODUCT_QUANTITY" => "N",
        "CUSTOM_FILTER" => "",
        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
        "COMPATIBLE_MODE" => "Y"
    ),
    false
);?>

<?global $arrFilter_2;
if(!$USER->IsAdmin()){
    $arrFilter_2 = array('PROPERTY_SERIES' => array(435902), ">DETAIL_PICTURE" => 0, "!PROPERTY_FOR_ADMIN_VALUE" => "Y");
} else {
    $arrFilter_2 = array('PROPERTY_SERIES' => array(435902), ">DETAIL_PICTURE" => 0);
}?>

<h2>Alpina. Popular science</h2>
<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "bigideas_popular", Array(
        "ACTION_VARIABLE" => "action",
        "ADD_PICT_PROP" => "-",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "ADD_TO_BASKET_ACTION" => "ADD",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BACKGROUND_IMAGE" => "-",
        "BASKET_URL" => "/personal/basket.php",
        "BROWSER_TITLE" => "-",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "N",
        "COMPONENT_TEMPLATE" => "bestsellers",
        "CONVERT_CURRENCY" => "N",
        "DETAIL_URL" => "",
        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_SORT_FIELD" => $sort,
        "ELEMENT_SORT_FIELD2" => "name",
        "ELEMENT_SORT_ORDER" => $order,
        "ELEMENT_SORT_ORDER2" => "asc",
        "FILTER_NAME" => "arrFilter_2",
        "HIDE_NOT_AVAILABLE" => "N",
        "IBLOCK_ID" => "4",
        "IBLOCK_TYPE" => "catalog",
        "INCLUDE_SUBSECTIONS" => "Y",
        "LABEL_PROP" => "-",
        "LINE_ELEMENT_COUNT" => "3",
        "MESSAGE_404" => "",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "OFFERS_LIMIT" => "5",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Товары",
        "PAGE_ELEMENT_COUNT" => "15",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRICE_CODE" => array(
            0 => "BASE",
        ),
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPERTIES" => array(
        ),
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "",
        "PRODUCT_SUBSCRIPTION" => "N",
        "PROPERTY_CODE" => array(
            0 => "AUTHORS",
            1 => "",
        ),
        "SECTION_CODE" => "",
        "SECTION_CODE_PATH" => "",
        "SECTION_ID" => $_REQUEST["SECTION_ID"],
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SECTION_URL" => "",
        "SECTION_USER_FIELDS" => array(
            0 => "",
            1 => "",
        ),
        "SEF_MODE" => "Y",
        "SEF_RULE" => "",
        "SET_BROWSER_TITLE" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "Y",
        "SHOW_404" => "N",
        "SHOW_ALL_WO_SECTION" => "Y",
        "SHOW_CLOSE_POPUP" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "TEMPLATE_THEME" => "blue",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "USE_PRICE_COUNT" => "N",
        "USE_PRODUCT_QUANTITY" => "N",
        "CUSTOM_FILTER" => "",
        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
        "COMPATIBLE_MODE" => "Y"
    ),
    false
);?>
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
    </div>
</div>
<!-- GdeSlon -->   
<script type="text/javascript" src="//www.gdeslon.ru/landing.js?mode=list&amp;codes=<?=substr($gdeSlon,0,-1)?>&amp;mid=79276"></script>
<script>
    // скрипт ajax-подгрузки товаров в блоке "Все книги"
    $(document).ready(function() {
    
        <?if (!$USER -> IsAuthorized()){?>
            $(".categoryWrapper .categoryBooks").hover(function(){
                $(this).css("height", "390px");});
        <?}?>
    });
</script>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>