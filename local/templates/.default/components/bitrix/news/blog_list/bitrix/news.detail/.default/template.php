<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$pict = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], array('width'=>700, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL, true);

$section = CIBlockSection::GetByID($arResult["IBLOCK_SECTION_ID"]);
$section = $section->GetNext();

$arSelect = Array("ID", "NAME", "DETAIL_PICTURE", "PROPERTY_WHOIS", "DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID" => 72, "ACTIVE" => "Y", "ID"=>$arResult["PROPERTIES"]["AUTHOR"]["VALUE"]);
$author = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 1), $arSelect);

if ($author = $author->GetNextElement())
	$author = $author->GetFields();

$authpic = CFile::ResizeImageGet($author["DETAIL_PICTURE"], array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true);

$frame = $this->createFrame()->begin();
?>

<meta property="og:image" content="https://<?=$_SERVER["SERVER_NAME"].$pict["src"]?>"/>
<meta property="og:title" content='<?=$arResult["NAME"]?>' />
<meta property="og:description" content='<?=substr(strip_tags($arResult["DETAIL_TEXT"]),0,160)?>' />
<meta property="og:type" content="article" />
<meta property="og:url" content="https://<?=$_SERVER["SERVER_NAME"].$APPLICATION->GetCurPage()?>" />
<meta property="og:site_name" content="Блог издательства «Альпина Паблишер»" />
<meta property="og:locale" content="ru_RU" />
<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="//yastatic.net/share2/share.js"></script>

<div class="titleWrap">
	<div class="catalogWrapper postWrapper">
		<p class="breadCrump" itemprop="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
			<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a itemprop="url" href="/blog/"><span itemprop="name">Альпина.Медиа</span></a>
				<meta itemprop="position" content="1" />
			</span> / 
			<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a itemprop="url" href="/blog/category/<?=$section["ID"]?>/"><span itemprop="name"><?=$section['NAME']?></span></a>
				<meta itemprop="position" content="2" />
			</span> / 
			<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<span itemprop="name"><?=$arResult["NAME"]?></span>
				<meta itemprop="position" content="3" />
			</span>
		</p>
		<h1 class="mainTitle" itemprop="headline"><?=typonew($arResult["NAME"])?></h1>
		<h2 class="date"><?=FormatDate("d F Y", MakeTimeStamp($arResult["ACTIVE_FROM"]))?></h2>
		<meta itemprop="datePublished" content="<?=FormatDate("Y-m-d", MakeTimeStamp($arResult["ACTIVE_FROM"]))?>" />
		<meta itemprop="publisher" content="Издательство «Альпина Паблишер»" />
	</div>
</div>
<div class="content">
	<meta itemprop="name" content="<?=$arResult["NAME"]?>" />
	<div class="catalogWrapper postWrapper">
		<?if ($pict["src"]) {?>
			<div itemprop="image" class="mainImage"><img src="<?=$pict["src"]?>" alt="Изображение к посту «<?=$arResult["NAME"]?>»" /></div>
		<?}?>
		<div class="textWrap">
			<?$arResult["DETAIL_TEXT"] = str_replace("ifr ame", "iframe", $arResult["DETAIL_TEXT"]);?>
			<?=typonew($arResult["DETAIL_TEXT"])?>
		</div>
		<div class="author authorName">
			<h2>Автор</h2>
			<a href="<?=$author["DETAIL_PAGE_URL"]?>" class="authorLink">
				<img src=<?=$authpic["src"]?> alt="<?=$author["NAME"]?>" style="border-radius: 90px;"/>
				<span itemprop="author"><?=$author["NAME"]?><?echo !empty($author["PROPERTY_WHOIS_VALUE"]) ? ',<br />'.$author["PROPERTY_WHOIS_VALUE"] : '';?></span>
			</a>
		</div>
		<div class="author authorName bottomWrap">
		<?
		if (!empty($arResult["PROPERTIES"]["BOOKS"]["VALUE"])) {
			global $articleBooks;
			$articleBooks = array("ID" => $arResult["PROPERTIES"]["BOOKS"]["VALUE"]);?>     
			<div class="weRecomWrap">
					<p class="tile">Книги на эту тему</p>
					<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.section",
					"all_recommended_books",
					array(
					"IBLOCK_TYPE_ID" => "catalog",
					"IBLOCK_ID" => "4",
					"BASKET_URL" => "/personal/cart/",
					"COMPONENT_TEMPLATE" => "all_recommended_books",
					"IBLOCK_TYPE" => "catalog",
					"SECTION_ID" => $_REQUEST["SECTION_ID"],
					"SECTION_CODE" => "",
					"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
					),
					"ELEMENT_SORT_FIELD" => "id",
					"ELEMENT_SORT_ORDER" => "desc",
					"ELEMENT_SORT_FIELD2" => "id",
					"ELEMENT_SORT_ORDER2" => "desc",
					"FILTER_NAME" => "articleBooks",
					"INCLUDE_SUBSECTIONS" => "Y",
					"SHOW_ALL_WO_SECTION" => "Y",
					"HIDE_NOT_AVAILABLE" => "N",
					"PAGE_ELEMENT_COUNT" => "12",
					"LINE_ELEMENT_COUNT" => "3",
					"PROPERTY_CODE" => array(
					0 => "",
					1 => "",
					),
					"OFFERS_FIELD_CODE" => array(
					0 => "",
					1 => "",
					),
					"OFFERS_PROPERTY_CODE" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
					3 => "",
					),
					"OFFERS_SORT_FIELD" => "sort",
					"OFFERS_SORT_ORDER" => "desc",
					"OFFERS_SORT_FIELD2" => "id",
					"OFFERS_SORT_ORDER2" => "desc",
					"OFFERS_LIMIT" => "5",
					"TEMPLATE_THEME" => "site",
					"PRODUCT_DISPLAY_MODE" => "Y",
					"ADD_PICT_PROP" => "BIG_PHOTO",
					"LABEL_PROP" => "-",
					"OFFER_ADD_PICT_PROP" => "-",
					"OFFER_TREE_PROPS" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
					),
					"PRODUCT_SUBSCRIPTION" => "N",
					"SHOW_DISCOUNT_PERCENT" => "N",
					"SHOW_OLD_PRICE" => "Y",
					"SHOW_CLOSE_POPUP" => "N",
					"MESS_BTN_BUY" => "Купить",
					"MESS_BTN_ADD_TO_BASKET" => "В корзину",
					"MESS_BTN_SUBSCRIBE" => "Подписаться",
					"MESS_BTN_DETAIL" => "Подробнее",
					"MESS_NOT_AVAILABLE" => "Нет в наличии",
					"SECTION_URL" => "",
					"DETAIL_URL" => "",
					"SECTION_ID_VARIABLE" => "SECTION_ID",
					"SEF_MODE" => "N",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_GROUPS" => "N",
					"SET_TITLE" => "N",
					"SET_BROWSER_TITLE" => "N",
					"BROWSER_TITLE" => "-",
					"SET_META_KEYWORDS" => "N",
					"META_KEYWORDS" => "-",
					"SET_META_DESCRIPTION" => "N",
					"META_DESCRIPTION" => "-",
					"SET_LAST_MODIFIED" => "N",
					"USE_MAIN_ELEMENT_SECTION" => "N",
					"ADD_SECTIONS_CHAIN" => "N",
					"CACHE_FILTER" => "N",
					"ACTION_VARIABLE" => "action",
					"PRODUCT_ID_VARIABLE" => "id",
					"PRICE_CODE" => array(
					0 => "BASE",
					),
					"USE_PRICE_COUNT" => "N",
					"SHOW_PRICE_COUNT" => "1",
					"PRICE_VAT_INCLUDE" => "Y",
					"CONVERT_CURRENCY" => "N",
					"USE_PRODUCT_QUANTITY" => "N",
					"PRODUCT_QUANTITY_VARIABLE" => "",
					"ADD_PROPERTIES_TO_BASKET" => "Y",
					"PRODUCT_PROPS_VARIABLE" => "prop",
					"PARTIAL_PRODUCT_PROPERTIES" => "N",
					"PRODUCT_PROPERTIES" => array(
					),
					"OFFERS_CART_PROPERTIES" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
					),
					"ADD_TO_BASKET_ACTION" => "ADD",
					"PAGER_TEMPLATE" => "round",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"PAGER_TITLE" => "Товары",
					"PAGER_SHOW_ALWAYS" => "Y",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"SET_STATUS_404" => "N",
					"SHOW_404" => "N",
					"MESSAGE_404" => "",
					"BACKGROUND_IMAGE" => "-"
					),
					false
					);?>
					
		<h2>Читайте также</h2>
		<?
		global $arFilter;
		$arFilter = array("!ID" => $arResult["ID"], "SECTION_ID" => $section["ID"]);
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"blog_main_recs",
			array(
				"IBLOCK_TYPE_ID" => "catalog",
				"IBLOCK_ID" => "71",
				"BASKET_URL" => "/personal/cart/",
				"COMPONENT_TEMPLATE" => "blog_main_recs",
				"IBLOCK_TYPE" => "catalog",
				"SECTION_ID" => $_REQUEST["SECTION_ID"],
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"ELEMENT_SORT_FIELD" => "id",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"FILTER_NAME" => "arFilter",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"PAGE_ELEMENT_COUNT" => "5",
				"LINE_ELEMENT_COUNT" => "3",
				"PROPERTY_CODE" => array(
					0 => "",
					1 => "",
				),
				"OFFERS_FIELD_CODE" => array(
					0 => "",
					1 => "",
				),
				"OFFERS_PROPERTY_CODE" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
					3 => "",
				),
				"OFFERS_SORT_FIELD" => "sort",
				"OFFERS_SORT_ORDER" => "desc",
				"OFFERS_SORT_FIELD2" => "id",
				"OFFERS_SORT_ORDER2" => "desc",
				"OFFERS_LIMIT" => "5",
				"TEMPLATE_THEME" => "site",
				"PRODUCT_DISPLAY_MODE" => "Y",
				"ADD_PICT_PROP" => "BIG_PHOTO",
				"LABEL_PROP" => "-",
				"OFFER_ADD_PICT_PROP" => "-",
				"OFFER_TREE_PROPS" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
				),
				"PRODUCT_SUBSCRIPTION" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"SHOW_OLD_PRICE" => "Y",
				"SHOW_CLOSE_POPUP" => "N",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_SUBSCRIBE" => "Подписаться",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"SECTION_URL" => "",
				"DETAIL_URL" => "",
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"SEF_MODE" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_GROUPS" => "N",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"BROWSER_TITLE" => "-",
				"SET_META_KEYWORDS" => "N",
				"META_KEYWORDS" => "-",
				"SET_META_DESCRIPTION" => "N",
				"META_DESCRIPTION" => "-",
				"SET_LAST_MODIFIED" => "N",
				"USE_MAIN_ELEMENT_SECTION" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"CACHE_FILTER" => "N",
				"ACTION_VARIABLE" => "action",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRICE_CODE" => array(
					0 => "BASE",
				),
				"USE_PRICE_COUNT" => "N",
				"SHOW_PRICE_COUNT" => "1",
				"PRICE_VAT_INCLUDE" => "Y",
				"CONVERT_CURRENCY" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"PRODUCT_QUANTITY_VARIABLE" => "",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRODUCT_PROPERTIES" => array(
				),
				"OFFERS_CART_PROPERTIES" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
				),
				"ADD_TO_BASKET_ACTION" => "ADD",
				"PAGER_TEMPLATE" => "round",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "Y",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"BACKGROUND_IMAGE" => "-"
			),
			false
		);?>
			</div>
		<?}?>
		</div>

		<div class="author" style="clear:both">
			<center><div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,collections,whatsapp,viber,telegram" data-counter=""></div></center>
			<?if (!empty($arResult["TAGS"])) {
			$tags = explode(', ',$arResult["TAGS"]);
				echo '<div class="keywords">';
				foreach($tags as $tag) {
					echo '<a href="/blog/search/?q='.$tag.'&s=blog" style="border-bottom:none"><span>'.$tag.'</span></a>';
				}
				echo '</div>';
			}?>
		</div>
		
		<div id="cackleReviews"></div>
	</div>
</div>
?>
<?$frame->end();?>
<script type="text/javascript">
cackle_widget = window.cackle_widget || [];
cackle_widget.push({
	widget: 'Comment',
	id: 43786,
	msg: {
		yRecom: 'Я рекомендую эту книгу',
		recom: 'Рекомендую книгу',
		anonym2: 'Представьтесь, пожалуйста',
		formhead: 'Отзыв о книге',
		vbtitle: 'Этот пользователь купил книгу',
		pros: 'Понравилось'
	},
	container: 'cackleReviews',
	channel: <?=!empty($arResult["PROPERTIES"]["OLDID"]["VALUE"]) ? $arResult["PROPERTIES"]["OLDID"]["VALUE"] : $arResult["ID"]?>,
	providers: 'vkontakte;facebook;twitter;yandex;odnoklassniki;other;'
});
(function() {
    var mc = document.createElement('script');
    mc.type = 'text/javascript';
    mc.async = true;
    mc.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cackle.me/widget.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
})();

$(document).ready(function() {
	if (($(".textWrap").height() + 150) < $(".bottomWrap").height()) {
		$(".bottomWrap").css("width", "100%");
	}

    $('body').on('click', '.mc-subscr-toggle', function(){
        var email = $('#cackleReviews .mc-subscr-input-wrap input').val();
        (window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() { rrApi.setEmail(email);    });
    })
});

</script>
<input type="hidden" id="postid" name="postid" value="<?=$arResult["ID"]?>" />