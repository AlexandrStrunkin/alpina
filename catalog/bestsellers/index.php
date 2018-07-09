<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "📕 Предлагаем  бестеллеры. Дарим &#127873; электронные книги в подарок; &#128666; доставляем по всему миру; &#37; предоставляем накопительные скидки. Подробности заказа по телефону &#128242; +7 (495) 120 07 04.");
$APPLICATION->SetTitle("Купить книги бестселлеры месяца - доставка по Москве и России");

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
    $sort = "PROPERTY_DESIRABILITY";          //PROPERTY_page_views_ga
    $order = "asc";
    break;

    default:
    //$sort = "PROPERTY_SALES_CNT";
    $sort = "PROPERTY_DESIRABILITY";
    $order = "desc";
}
global $arrFilter;
if(!$USER->IsAdmin()){
    $arrFilter = array('PROPERTY_best_seller' => 285, ">DETAIL_PICTURE" => 0, "!PROPERTY_FOR_ADMIN_VALUE" => "Y");
} else {
    $arrFilter = array('PROPERTY_best_seller' => 285, ">DETAIL_PICTURE" => 0);
}

if (!empty($_REQUEST["FILTER"])) {
    if($_REQUEST["FILTER"] == "for_kids_and_parents") {
        $arrFilter["SECTION_CODE"] = "BooksForParentsAndChildren";
        $arrFilter["INCLUDE_SUBSECTIONS"] = "Y";
    }
}
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "bestsellers",
    array(
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
        "FILTER_NAME" => "arrFilter",
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
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>