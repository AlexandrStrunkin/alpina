<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Результаты поиска — Альпина Паблишер");
$APPLICATION->SetTitle("Поиск");
global $SearchFilter;
$SearchFilter = array(">CATALOG_PRICE_1" => 0);

?> 
<?/*$APPLICATION->IncludeComponent(
    "bitrix:catalog.search",
    "search_page",
    array(
        "AJAX_MODE" => "Y",
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "4",
        "ELEMENT_SORT_FIELD" => "rank",
        "ELEMENT_SORT_ORDER" => "asc",
        "ELEMENT_SORT_FIELD2" => "sort",
        "ELEMENT_SORT_ORDER2" => "desc",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "BASKET_URL" => "/personal/cart/",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "DISPLAY_COMPARE" => "Y",
        "PAGE_ELEMENT_COUNT" => "80",
        "LINE_ELEMENT_COUNT" => "2",
        "PROPERTY_CODE" => array(
            0 => "STATE",
            1 => "",
        ),
        "OFFERS_FIELD_CODE" => "",
        "OFFERS_PROPERTY_CODE" => "",
        "OFFERS_SORT_FIELD" => "",
        "OFFERS_SORT_ORDER" => "",
        "OFFERS_SORT_FIELD2" => "",
        "OFFERS_SORT_ORDER2" => "",
        "OFFERS_LIMIT" => "5",
        "PRICE_CODE" => array(
            0 => "BASE",
        ),
        "USE_PRICE_COUNT" => "Y",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "USE_PRODUCT_QUANTITY" => "Y",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "RESTART" => "Y",
        "NO_WORD_LOGIC" => "Y",
        "USE_LANGUAGE_GUESS" => "Y",
        "CHECK_DATES" => "Y",
        "DISPLAY_TOP_PAGER" => "Y",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "РўРѕРІР°СЂС‹",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "Y",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "HIDE_NOT_AVAILABLE" => "N",
        "CONVERT_CURRENCY" => "Y",
        "CURRENCY_ID" => "RUB",
        "OFFERS_CART_PROPERTIES" => "",
        "AJAX_OPTION_JUMP" => "Y",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "Y",
        "COMPONENT_TEMPLATE" => "search_page",
        "AJAX_OPTION_ADDITIONAL" => "",
        "PRODUCT_PROPERTIES" => array(
        )
    ),
    false
);*/

if(!$USER->IsAdmin()){
    $SearchFilter["!PROPERTY_FOR_ADMIN_VALUE"] = "Y";
}
  
$APPLICATION->IncludeComponent(
    "bitrix:search.page",
    "search_common_page",
    array(
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DEFAULT_SORT" => "rank",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_TOP_PAGER" => "Y",
        "FILTER_NAME" => "SearchFilter",
        "NO_WORD_LOGIC" => "Y",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_TEMPLATE" => "",
        "PAGER_TITLE" => "Результаты поиска",
        "PAGE_RESULT_COUNT" => "70",
        "PATH_TO_USER_PROFILE" => "",
        "RATING_TYPE" => "",
        "RESTART" => "Y",
        "SHOW_RATING" => "",
        "SHOW_WHEN" => "N",
        "SHOW_WHERE" => "Y",
        "USE_LANGUAGE_GUESS" => "N",
        "USE_SUGGEST" => "N",
        "USE_TITLE_RANK" => "Y",
        "arrFILTER" => array(
            0 => "iblock_catalog",
        ),
        "arrFILTER_iblock_catalog" => array(
            0 => "4",
            1 => "23",
            2 => "29",
            3 => "45",
        ),
        "arrFILTER_iblock_sebekon_presents" => array(
            0 => "all",
        ),
        "arrFILTER_socialnetwork" => array(
            0 => "all",
        ),
        "arrWHERE" => array(
        ),
        "COMPONENT_TEMPLATE" => "search_common_page"
    ),
    false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>