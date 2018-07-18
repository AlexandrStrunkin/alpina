<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
    CJSCore::Init(array("fx"));
    $curPage = $APPLICATION->GetCurPage(true);
    $theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);

?>

<!doctype html>
<html lang="ru">
<head>
<!-- retailrocket трекер -->
<script type="text/javascript">
   var rrPartnerId = "50b90f71b994b319dc5fd855";
   var rrApi = {};
   var rrApiOnReady = rrApiOnReady || [];
   rrApi.addToBasket = rrApi.order = rrApi.categoryView = rrApi.view =
       rrApi.recomMouseDown = rrApi.recomAddToCart = function() {};
   (function(d) {
       var ref = d.getElementsByTagName('script')[0];
       var apiJs, apiJsId = 'rrApi-jssdk';
       if (d.getElementById(apiJsId)) return;
       apiJs = d.createElement('script');
       apiJs.id = apiJsId;
       apiJs.async = true;
       apiJs.src = "//cdn.retailrocket.ru/content/javascript/tracking.js";
       ref.parentNode.insertBefore(apiJs, ref);
   }(document));
</script>
<?if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/google_tag_manager.php")) {
    include_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/google_tag_manager.php");
}?>
<!--eski.mobi-->
<script class="eskimobi" data-type="mobile">!function(a,b,c,d,e){function g(a,c,d,e){var f=b.getElementsByTagName("script")[0];e.src?a.src=e.src:e.innerHTML&&(a.innerHTML=e.innerHTML),a.id=c,a.setAttribute("class",d),f.parentNode.insertBefore(a,f)}a.Mobify={points:[+new Date]};var f=/((; )|#|&|^)mobify=(\d)/.exec(location.hash+"; "+b.cookie);if(f&&f[3]){if(!+f[3])return}else if(!c())return;b.write('<div id="eski-overlay" style="font-family:Helvetica-Light,Helvetica,Arial,sans-serif;font-weight:light;font-size:300%;line-height:100%;position:absolute;top:42%;left:0;right:0;text-align:center;color: #999;">\u0417\u0430\u0433\u0440\u0443\u0437\u043A\u0430...</div><plaintext style="display:none">'),setTimeout(function(){var c=a.Mobify=a.Mobify||{};c.capturing=!0;var f=b.createElement("script"),h=function(){var c=new Date;c.setTime(c.getTime()+18e5),b.cookie="mobify=0; expires="+c.toGMTString()+"; path=/",a.location=a.location.href};f.onload=function(){if(e){var a=b.createElement("script");if(a.onerror=h,"string"==typeof e)g(a,"main-executable","mobify",{src:e});else{var c="var main = "+e.toString()+"; main();";g(a,"main-executable","mobify",{innerHTML:c})}}},f.onerror=h,g(f,"mobify-js","mobify",{src:d})})}(window,document,function(){var ua=navigator.userAgent||navigator.vendor||window.opera,m=false;if(/mobi|phone|ipod|nokia|android/i.test(ua))m=true;if(/msie|windows|media\scenter|opera\smini|ipad|android\s3|android\s2|iphone\sos\s(4|5|6)|ipad\sos\s(4|5|6)/i.test(ua)||screen.width>1024)m=false;return m;},"/eskimobi/eski.mobi.min.js?20170906","/eskimobi/mobi.js?201710182");</script><!--/eski.mobi-->
    <!--alpina_index-->
    <!--<meta http-equiv="Content-type" content="text/html; charset=utf-8"> -->
    <title><?$APPLICATION->ShowTitle()?></title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <link rel="stylesheet" href="/css/style.css?<?=filemtime($_SERVER["DOCUMENT_ROOT"].'/css/style.css')?>" type="text/css">
    <script src="/js/fxSlider.js"></script>

    <script src="/js/main.js?<?=filemtime($_SERVER["DOCUMENT_ROOT"].'/js/main.js')?>"></script>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png?v=WGG39kPBLm">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png?v=WGG39kPBLm">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png?v=WGG39kPBLm">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png?v=WGG39kPBLm">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png?v=WGG39kPBLm">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png?v=WGG39kPBLm">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png?v=WGG39kPBLm">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png?v=WGG39kPBLm">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png?v=WGG39kPBLm">
    <link rel="icon" type="image/png" href="/favicon-32x32.png?v=WGG39kPBLm" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-194x194.png?v=WGG39kPBLm" sizes="194x194">
    <link rel="icon" type="image/png" href="/favicon-96x96.png?v=WGG39kPBLm" sizes="96x96">
    <link rel="icon" type="image/png" href="/android-chrome-192x192.png?v=WGG39kPBLm" sizes="192x192">
    <link rel="icon" type="image/png" href="/favicon-16x16.png?v=WGG39kPBLm" sizes="16x16">
    <link rel="manifest" href="/manifest.json?v=WGG39kPBLm">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=WGG39kPBLm" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon.ico?v=WGG39kPBLm">
    <?if ($_SERVER["HTTP_HTTPS"]) {
        $protocol_name = "https://";
    } else {
        $protocol_name = "http://";
    }?>
    <link rel="amphtml" href="http://amp.alpinabook.ru/mobile/alpinabook-ru/amp/?p=<?= $protocol_name . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png?v=WGG39kPBLm">

    <meta name="theme-color" content="#ffffff">

    <meta name="google-site-verification" content="cUkEF3427PrBhej9QWdjG-Hd6IHnkt7tS_rr88-4B30" />
    <meta name="yandex-verification" content="7129a3dd68cb6589" />
    <meta name="google-site-verification" content="2anNV5c5mKCRA-xCKLOJU2A0UWEJxJ7CiSkjPBd1Ypw" />
    <link rel="stylesheet" type="text/css" href="/js/fancybox-2/jquery.fancybox.css" id="fancycss" media="screen" />
    <link rel="stylesheet" type="text/css" href="/js/fancybox-2/helpers/jquery.fancybox-thumbs.css" id="fancycss" media="screen" />
    <?$APPLICATION->ShowHead();?>


    <meta property="og:title" content="«Альпина Паблишер» — деловая литература" />
    <meta property="og:type" content="book" />
    <meta property="og:url" content="https://www.alpinabook.ru" />
    <meta property="og:image" content="https://www.alpinabook.ru/img/logo.png" />
    <meta property="og:site_name" content="www.alpinabook.ru" />
    <meta property="fb:admins" content="1425804193" />

    <meta property="fb:app_id" content="138738742872757" />

    <?include_once($_SERVER["DOCUMENT_ROOT"] . '/local/templates/.default/include/initial_scale_values.php');?>
    <? file_exists($_SERVER["DOCUMENT_ROOT"] . '/custom-scripts/ab_tests.php') ? include($_SERVER["DOCUMENT_ROOT"] . '/custom-scripts/ab_tests.php') : ""; //Хардовые AB-тесты?>
	<!-- header .index -->
	<!-- gdeslon -->
	<script type="text/javascript" src="https://www.gdeslon.ru/landing.js?mode=main&amp;mid=79276" async></script>
	<script>
		$(function(){
           fxSlider('smallBooksSliderConteiner', 'smallBooksleftArrow', 'smallBooksRightArrow', false, 650, 5);
		})
		$(function(){
           fxSlider('recomendedBooksSliderConteiner', 'recomendedBooksleftArrow', 'recomendedBooksRightArrow', false, 650, 5);
		})
		$(function(){
           fxSlider('bestcellersBooksSliderConteiner', 'bestcellersBooksleftArrow', 'bestcellersBooksRightArrow', false, 650, 5);
        })
	</script>
</head>
<body itemscope itemtype="https://schema.org/WebPage">
<?if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/google_tag_manager_no-script.php")) {
    include_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/google_tag_manager_no-script.php");
}?>
<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter1611177 = new Ya.Metrika({ id:1611177, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, ecommerce:"dataLayer" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/1611177" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<? global $USER;
if ($USER->IsAuthorized()) {
    $rsCurUser = CUser::GetByID($USER->GetID());
    $arCurUser = $rsCurUser->Fetch();
    $userGTMData = (!empty($arCurUser["NAME"]) ? "'user_name' : '" . $arCurUser["NAME"] . "'," : "");
    $userGTMData .= (!empty($arCurUser["EMAIL"]) ? "'user_email' : '" . $arCurUser["EMAIL"] . "'," : "");
    $userGTMData .= (!empty($arCurUser["UF_GENDER"]) ? "'user_gender' : '" . $arCurUser["UF_GENDER"] . "'" : "");
?>
    <script type="text/javascript">
        dataLayer = [{
            'userId' : <?= $USER->GetID() ?>,
            'event' : 'authentication',
            'userRegCategory' : 'UserRegistered',
            <?= $userGTMData?>
        }];
    </script>
    <?} else {?>
    <script type="text/javascript">
        dataLayer = [{
            'userRegCategory' : 'UserUnregistered'
        }];
    </script>
    <?}?>



<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<?include_once($_SERVER["DOCUMENT_ROOT"] . '/local/templates/.default/include/info_message_component.php');?>
<header itemscope="" id="WPHeader" itemtype="https://schema.org/WPHeader">
	<a href="/">
	<div class="logo">
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			".default",
			array(
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"AREA_FILE_RECURSIVE" => "Y",
				"EDIT_TEMPLATE" => "",
				"COMPONENT_TEMPLATE" => ".default",
				"PATH" => "/include/logo.php"
			),
			false
		);?>
		</div>
	</a>


	<div class="headerWrapper">
		<ul class="menu">
			<?$APPLICATION->IncludeComponent(
				"bitrix:menu",
				"top_menu",
				array(
					"ROOT_MENU_TYPE" => "top",
					"MAX_LEVEL" => "1",
					"CHILD_MENU_TYPE" => "top",
					"USE_EXT" => "N",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "N",
					"MENU_CACHE_TYPE" => "Y",
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_USE_GROUPS" => "N",
					"MENU_CACHE_GET_VARS" => array(),
					"COMPONENT_TEMPLATE" => "top_menu"
				),
				false
			);?>

		</ul>
	</div>

	<?$frame = new \Bitrix\Main\Page\FrameBuffered("header");
	$frame->begin();?>

	<script>
		function basketOpenFlag() {
			$('.hidingBasketRight, .layout, .windowClose').toggle();
			if ($('.hidingBasketRight, .layout, .windowClose').css('display') == 'block') {
				$('html').css('overflow', 'hidden');
			} else {
				$('html').css('overflow', 'auto');
			}
		}

		$(document).ready(function(){
			$("#authorisationPopup").click(function() {
				$('.layout').show();

				var winH = $(window).height();
				var winW = $(window).width();
				var blokT = winH / 2 - ($('.authorisationWrapper').height() / 2);
				var blokL = winW / 2 - ($('.authorisationWrapper').width() / 2);
				$('.authorisationWrapper').css({
					"top": blokT,
					"left": blokL
				});

				$('.authorisationWrapper').show();
				return false;
			});
            setTimeout(function() { $('.lkWrapp').show() }, 800);
		});
	</script>

	<div class="lkWrapp" style="display: none;">
		<a href="/personal/cart/" onclick="basketOpenFlag();return false;">
			<div class="headBasket">
				<div class="BasketQuant"></div>
			</div>
		</a>

		<?if(CUser::IsAuthorized()) {?>
			<a href="/personal/cart/?liked=yes">
				<div class="headLiked">
					<?
					$curr_user = CUser::GetByID($USER -> GetID()) -> Fetch();
					$user = $curr_user["NAME"]." ".$curr_user["LAST_NAME"];
					$wishItemList = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17, "NAME" => $user), false, false, array("NAME", "ID", "PROPERTY_PRODUCTS"));
					?>
					<div class="likedQuant"><?echo($wishItemList->SelectedRowsCount());?></div>
				</div>
			</a>
		<?}?>

		<a href="/personal/profile/" <?if (!$USER->IsAuthorized()){?>id="authorisationPopup"<?}?>>
			<div>
				<?echo !$USER->IsAuthorized() ? '<img src="/img/lkImg.png">' : '<img src="/img/lkImgBl.png">';?>
			</div>
		</a>

		<p class="telephone">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				".default",
				array(
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "inc",
					"AREA_FILE_RECURSIVE" => "Y",
					"EDIT_TEMPLATE" => "",
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => "/include/telephone.php"
				),
				false
			);?>
		</p>
	</div>

	<?$frame->beginStub();?>
     <?if(!CUser::IsAuthorized()) {?>
	    <div class="lkWrapp" style="display: none;">
		    <a href="/personal/cart/" onclick="basketOpenFlag();return false;">
			    <div class="headBasket">
				    <div class="BasketQuant" style="display: none;"></div>
			    </div>
		    </a>

		    <a href="/personal/profile/" id="authorisationPopup">
			    <div>
				    <img src="/img/lkImg.png">
			    </div>
		    </a>

		    <p class="telephone">
			    <?$APPLICATION->IncludeComponent(
				    "bitrix:main.include",
				    ".default",
				    array(
					    "AREA_FILE_SHOW" => "file",
					    "AREA_FILE_SUFFIX" => "inc",
					    "AREA_FILE_RECURSIVE" => "Y",
					    "EDIT_TEMPLATE" => "",
					    "COMPONENT_TEMPLATE" => ".default",
					    "PATH" => "/include/telephone.php"
				    ),
				    false
			    );?>
		    </p>
	    </div>
      <?}?>
	<?$frame->end();?>

</header>

<div class="mainWrapp" itemprop="mainContentOfPage">
    <!--<div class="grayBack"></div>-->
    <h1 class="interShop">
        Доставляем интеллектуальное удовольствие
    </h1>
    <p class="ibooks">
        я<img src="/img/logoBig.png">книги
    </p>

    <?$APPLICATION->IncludeComponent(
	"bitrix:search.title",
	"search_form",
	array(
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_0_TITLE" => "Результаты",
		"CHECK_DATES" => "N",
		"COMPONENT_TEMPLATE" => "search_form",
		"CONTAINER_ID" => "title-search-top",
		"INPUT_ID" => "title-search-input-top",
		"NUM_CATEGORIES" => "1",
		"ORDER" => "rank",
		"PAGE" => "#SITE_DIR#search/index.php",
		"SHOW_INPUT" => "Y",
		"SHOW_OTHERS" => "N",
		"TOP_COUNT" => "5",
		"USE_LANGUAGE_GUESS" => "N",
		"CATEGORY_0_iblock_catalog" => array(
			0 => "4",
			1 => "29",
		),
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false

);?>
    <div class="books">

        <div class="catalogIcon">
            <span class="catalog_text"></span>
        </div>

        <div class="basketIcon">
        </div>

        <?
			$arrFilter = array('PROPERTY_STATE' => '21', ">DETAIL_PICTURE" => 0);

            $APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"template1",
			array(
				"IBLOCK_TYPE_ID" => "catalog",
				"IBLOCK_ID" => "4",
				"BASKET_URL" => "/personal/cart/",
				"COMPONENT_TEMPLATE" => "template1",
				"IBLOCK_TYPE" => "catalog",
				"SECTION_ID" => $_REQUEST["SECTION_ID"],
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				//"ELEMENT_SORT_FIELD" => "PROPERTY_big_index_image",
				"ELEMENT_SORT_FIELD" => "PROPERTY_DESIRABILITY",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "rand",
				"ELEMENT_SORT_ORDER2" => "desc",
				"FILTER_NAME" => "arrFilter",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"PAGE_ELEMENT_COUNT" => "20",
				"LINE_ELEMENT_COUNT" => "3",
				"PROPERTY_CODE" => array(
					0 => "AUTHORS",
					1 => "number_volumes",
					2 => "",
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
				"CACHE_TYPE" => "Y",
				"CACHE_TIME" => "3600",
				"CACHE_GROUPS" => "N",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "Y",
				"BROWSER_TITLE" => "-",
				"SET_META_KEYWORDS" => "Y",
				"META_KEYWORDS" => "-",
				"SET_META_DESCRIPTION" => "Y",
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
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"BACKGROUND_IMAGE" => "-",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"CUSTOM_FILTER" => "",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"COMPATIBLE_MODE" => "Y"
			),
			false
		);?>
			<?
            global $SellBlockFilter;
            if(!$USER->IsAdmin()){
                $SellBlockFilter = array('PROPERTY_best_seller' => 285, ">DETAIL_PICTURE" => 0, "!PROPERTY_FOR_ADMIN_VALUE" => "Y");
            } else {
                $SellBlockFilter = array('PROPERTY_best_seller' => 285, ">DETAIL_PICTURE" => 0);
            }
            $APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"template_bestsellers",
			array(
				"ACTION_VARIABLE" => "action",
				"ADD_PICT_PROP" => "BIG_PHOTO",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"ADD_SECTIONS_CHAIN" => "N",
				"ADD_TO_BASKET_ACTION" => "ADD",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"BACKGROUND_IMAGE" => "-",
				"BASKET_URL" => "/personal/cart/",
				"BROWSER_TITLE" => "-",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "N",
				"CACHE_TIME" => "3600",
				"CACHE_TYPE" => "Y",
				"COMPONENT_TEMPLATE" => "template_bestsellers",
				"CONVERT_CURRENCY" => "N",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_TOP_PAGER" => "N",
				"ELEMENT_SORT_FIELD" => "PROPERTY_DESIRABILITY",
				"ELEMENT_SORT_FIELD2" => "rand",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_ORDER2" => "desc",
				"FILTER_NAME" => "SellBlockFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"IBLOCK_ID" => "4",
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_TYPE_ID" => "catalog",
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
				"OFFER_ADD_PICT_PROP" => "-",
				"OFFER_TREE_PROPS" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
				),
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "round",
				"PAGER_TITLE" => "Товары",
				"PAGE_ELEMENT_COUNT" => "12",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRICE_CODE" => array(
					0 => "BASE",
				),
				"PRICE_VAT_INCLUDE" => "Y",
				"PRODUCT_DISPLAY_MODE" => "Y",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRODUCT_PROPERTIES" => array(
				),
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PRODUCT_QUANTITY_VARIABLE" => "",
				"PRODUCT_SUBSCRIPTION" => "N",
				"PROPERTY_CODE" => array(
					0 => "YEAR",
					1 => "AUTHORS",
					2 => "SALES_CNT",
					3 => "",
				),
				"SECTION_CODE" => "",
				"SECTION_ID" => $_REQUEST["SECTION_ID"],
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"SECTION_URL" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"SEF_MODE" => "N",
				"SET_BROWSER_TITLE" => "Y",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "Y",
				"SET_META_KEYWORDS" => "Y",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SHOW_404" => "N",
				"SHOW_ALL_WO_SECTION" => "Y",
				"SHOW_CLOSE_POPUP" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"SHOW_OLD_PRICE" => "Y",
				"SHOW_PRICE_COUNT" => "1",
				"TEMPLATE_THEME" => "site",
				"USE_MAIN_ELEMENT_SECTION" => "N",
				"USE_PRICE_COUNT" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"CUSTOM_FILTER" => "",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"COMPATIBLE_MODE" => "Y"
			),
			false

		);?>
        <?  global $arrFilter_soon;
            $arrFilter_soon = array('PROPERTY_STATE' => STATE_SOON, '>DETAIL_PICTURE' => 0, '!PROPERTY_reissue' => REISSUE_ID, '!PROPERTY_hide_soon' => HIDE_SOON_ID);

            $APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"template_soon",
			array(
				"IBLOCK_TYPE_ID" => "catalog",
				"IBLOCK_ID" => "4",
				"BASKET_URL" => "/personal/cart/",
				"COMPONENT_TEMPLATE" => "template_soon",
				"IBLOCK_TYPE" => "catalog",
				"SECTION_ID" => $_REQUEST["SECTION_ID"],
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"ELEMENT_SORT_FIELD" => "PROPERTY_page_views_ga",
				"ELEMENT_SORT_FIELD2" => "rand",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_ORDER2" => "desc",
				"FILTER_NAME" => "arrFilter_soon",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"PAGE_ELEMENT_COUNT" => "12",
				"LINE_ELEMENT_COUNT" => "3",
				"PROPERTY_CODE" => array(
					0 => "STATE",
					1 => "YEAR",
					2 => "AUTHORS",
					3 => "SALES_CNT",
					4 => "",
				),
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
				"CACHE_TYPE" => "Y",
				"CACHE_TIME" => "3600",
				"CACHE_GROUPS" => "N",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "Y",
				"BROWSER_TITLE" => "-",
				"SET_META_KEYWORDS" => "Y",
				"META_KEYWORDS" => "-",
				"SET_META_DESCRIPTION" => "Y",
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
				"ADD_TO_BASKET_ACTION" => "ADD",
				"PAGER_TEMPLATE" => "round",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"BACKGROUND_IMAGE" => "-",
				"OFFERS_LIMIT" => "5",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"CUSTOM_FILTER" => "",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"COMPATIBLE_MODE" => "Y"
			),
			false
		);?>
        <?
            $arrFilter_children = array('SECTION_ID' => array(132,133));

            $APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"template_children",
			array(
				"IBLOCK_TYPE_ID" => "catalog",
				"IBLOCK_ID" => "4",
				"BASKET_URL" => "/personal/cart/",
				"COMPONENT_TEMPLATE" => "template_children",
				"IBLOCK_TYPE" => "catalog",
				"SECTION_ID" => $_REQUEST["SECTION_ID"],
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"ELEMENT_SORT_FIELD" => "PROPERTY_DESIRABILITY",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "rand",
				"ELEMENT_SORT_ORDER2" => "desc",
				"FILTER_NAME" => "arrFilter_children",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"PAGE_ELEMENT_COUNT" => "12",
				"LINE_ELEMENT_COUNT" => "3",
				"PROPERTY_CODE" => array(
					0 => "YEAR",
					1 => "AUTHORS",
					2 => "SALES_CNT",
					3 => "",
				),
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
				"CACHE_TYPE" => "Y",
				"CACHE_TIME" => "36000",
				"CACHE_GROUPS" => "N",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "Y",
				"BROWSER_TITLE" => "-",
				"SET_META_KEYWORDS" => "Y",
				"META_KEYWORDS" => "-",
				"SET_META_DESCRIPTION" => "Y",
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
				"ADD_TO_BASKET_ACTION" => "ADD",
				"PAGER_TEMPLATE" => "round",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"BACKGROUND_IMAGE" => "-",
				"OFFERS_LIMIT" => "5",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"CUSTOM_FILTER" => "",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"COMPATIBLE_MODE" => "Y"
			),
			false
		);?>
        <?
            $arrFilter_mustread = array('PROPERTY_discount_on' => '276');

            $APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"template_mustread",
			array(
				"IBLOCK_TYPE_ID" => "catalog",
				"IBLOCK_ID" => "4",
				"BASKET_URL" => "/personal/cart/",
				"COMPONENT_TEMPLATE" => "template_mustread",
				"IBLOCK_TYPE" => "catalog",
				"SECTION_ID" => $_REQUEST["SECTION_ID"],
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"ELEMENT_SORT_FIELD" => "PROPERTY_page_views_ga",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "rand",
				"ELEMENT_SORT_ORDER2" => "desc",
				"FILTER_NAME" => "arrFilter_mustread",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"PAGE_ELEMENT_COUNT" => "12",
				"LINE_ELEMENT_COUNT" => "3",
				"PROPERTY_CODE" => array(
					0 => "YEAR",
					1 => "AUTHORS",
					2 => "SALES_CNT",
					3 => "",
				),
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
				"CACHE_TYPE" => "Y",
				"CACHE_TIME" => "36000",
				"CACHE_GROUPS" => "N",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "Y",
				"BROWSER_TITLE" => "-",
				"SET_META_KEYWORDS" => "Y",
				"META_KEYWORDS" => "-",
				"SET_META_DESCRIPTION" => "Y",
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
				"ADD_TO_BASKET_ACTION" => "ADD",
				"PAGER_TEMPLATE" => "round",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"BACKGROUND_IMAGE" => "-",
				"OFFERS_LIMIT" => "5",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"CUSTOM_FILTER" => "",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"COMPATIBLE_MODE" => "Y"
			),
			false
		);?>
        <ul>
            <li class="first"><span class="active" data-id="1"><a href="/catalog/new/?SORT=NEW" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'categoryClick', 'label' : 'newest'});">Новинки</a></span></li>
            <li><span data-id="2"><a href="/catalog/bestsellers/" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'categoryClick', 'label' : 'best'});">Бестселлеры</a></span></li>
            <li><span data-id="3"><a href="/catalog/coming-soon/" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'categoryClick', 'label' : 'soon'});">Скоро <br>в продаже</a></span></li>
			<li><span data-id="4"><a href="/catalog/BooksForParentsAndChildren/" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'categoryClick', 'label' : 'children'});">Для детей</a></span></li>
            <li><span data-id="5"><a href="/catalog/sale/" onclick="dataLayer.push({'event' : 'topBlockOnMain', 'action' : 'categoryClick', 'label' : 'sale'});">Скидки дня</span></li>
        </ul>
        <div class="socServ">
            <p class="text">
                ПРИСОЕДИНЯЙТЕСЬ В СОЦСЕТЯХ
            </p>
            <div class="icons">
                <a href="https://vk.com/ideabooks" target="_blank"><img src="/img/vk.png"></a>
                <a href="https://twitter.com/AlpinaBookRu" target="_blank"><img src="/img/twitter.png"></a>
                <a href="https://www.facebook.com/alpinabook/" target="_blank"><img src="/img/facebook.png"></a>
                <a href="https://instagram.com/alpinabook" target="_blank"><img src="/img/instagramm.png"></a>
                <a href="https://t.me/alpinaru " target="_blank" ><img src="/img/tele1.png"></a>
            </div>
        </div>
    </div>
</div>
<div class="hintWrapp">
    <div class="catalogWrapper saleWrapp">
		<?/* Получаем персональные рекомендации RetailRocket */
		if (isset($_COOKIE["rcuid"])){
			$opts = array('http' =>
				array(
					'method'  => 'GET',
					'timeout' => 3
				)
			);

			$context  = stream_context_create($opts);
			$stringRecs = file_get_contents('https://api.retailrocket.ru/api/2.0/recommendation/personal/50b90f71b994b319dc5fd855/?partnerUserSessionId='.$_COOKIE["rcuid"], false, $context);
			$recsArray = array_slice(json_decode($stringRecs, true), 0, 10);
			$arrFilter = array();
			foreach($recsArray as $val) {
				$arrFilter[ID][] = $val[ItemId];
			}

        }

		?>

	<div class="bestonmain">

	<?//Слайдер "Рекомендованно лично вам"
	if($recsArray != ""){
		$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"slider_on_main_recommended",
	array(
		"IBLOCK_TYPE_ID" => "catalog",
		"IBLOCK_ID" => "4",
		"BASKET_URL" => "/personal/cart/",
		"COMPONENT_TEMPLATE" => "slider_on_main_recommended",
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
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"PAGE_ELEMENT_COUNT" => "6",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "AUTHORS",
			1 => "PROPERTY_AUTHORS.NAME",
			2 => "",
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
		"SET_BROWSER_TITLE" => "Y",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "Y",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "Y",
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
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"BACKGROUND_IMAGE" => "-",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"CUSTOM_FILTER" => "",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"DISPLAY_COMPARE" => "N",
		"COMPATIBLE_MODE" => "Y"
	),
	false
);
	}
		?>

            <?
			global $BestsOnMain;
            if(!$USER->IsAdmin()){
                $BestsOnMain = array('PROPERTY_best_seller' => 285, ">DETAIL_PICTURE" => 0, "!PROPERTY_FOR_ADMIN_VALUE" => "Y");
            } else {
                $BestsOnMain = array('PROPERTY_best_seller' => 285, ">DETAIL_PICTURE" => 0);
            }
            ?>

            <?//Слайдер "Бестселлеры"
			$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"slider_on_main_bestsellers",
	array(
		"IBLOCK_TYPE_ID" => "catalog",
		"IBLOCK_ID" => "4",
		"BASKET_URL" => "/personal/cart/",
		"COMPONENT_TEMPLATE" => "slider_on_main_bestsellers",
		"IBLOCK_TYPE" => "catalog",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => "PROPERTY_DESIRABILITY",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "rand",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "BestsOnMain",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"PAGE_ELEMENT_COUNT" => "12",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "AUTHORS",
			1 => "PROPERTY_AUTHORS.NAME",
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
		"CACHE_TYPE" => "Y",
		"CACHE_TIME" => "43200",
		"CACHE_GROUPS" => "N",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "Y",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "Y",
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
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"BACKGROUND_IMAGE" => "-",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"CUSTOM_FILTER" => "",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"COMPATIBLE_MODE" => "Y",
		"DISPLAY_COMPARE" => "N"
	),
	false
);?>

		<?
		global $blogPostsFilter;
		$blogPostsFilter = array("!ID" => false);
		$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"this_book_in_blog",
	array(
		"IBLOCK_TYPE_ID" => "catalog",
		"IBLOCK_ID" => "71",
		"BASKET_URL" => "/personal/cart/",
		"COMPONENT_TEMPLATE" => "this_book_in_blog",
		"IBLOCK_TYPE" => "catalog",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => "ACTIVE_FROM",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "asc",
		"FILTER_NAME" => "blogPostsFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"PAGE_ELEMENT_COUNT" => "9",
		"LINE_ELEMENT_COUNT" => "1",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"TEMPLATE_THEME" => "site",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_BTN_DETAIL" => "Последние посты в блоге",
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
		"CACHE_TIME" => "36000",
		"CACHE_GROUPS" => "Y",
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
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"BACKGROUND_IMAGE" => "-",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"CUSTOM_FILTER" => "",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DISPLAY_COMPARE" => "N",
		"COMPATIBLE_MODE" => "Y",
		"OFFERS_LIMIT" => "5",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"MESS_BTN_COMPARE" => "Сравнить"
	),
	false
);
		?>
            <?

            global $smallBooks;
            if(!$USER->IsAdmin()){
                $smallBooks = array("=PROPERTY_SERIES" => array(435902, 429853), "!PROPERTY_FOR_ADMIN_VALUE" => "Y");
            } else {
                $smallBooks = array("=PROPERTY_SERIES" => array(435902, 429853));
            }
            ?>
            <?//Слайдер "Маленькие книги - большие..."
$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"slider_on_main_small_books",
	array(
		"IBLOCK_TYPE_ID" => "catalog",
		"IBLOCK_ID" => "4",
		"BASKET_URL" => "/personal/cart/",
		"COMPONENT_TEMPLATE" => "slider_on_main_small_books",
		"IBLOCK_TYPE" => "catalog",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => "RAND",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "",
		"ELEMENT_SORT_ORDER2" => "",
		"FILTER_NAME" => "smallBooks",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"PAGE_ELEMENT_COUNT" => "7",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "AUTHORS",
			1 => "PROPERTY_AUTHORS.NAME",
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
		"CACHE_TIME" => "43200",
		"CACHE_GROUPS" => "N",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "Y",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "Y",
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
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"BACKGROUND_IMAGE" => "-",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"CUSTOM_FILTER" => "",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"COMPATIBLE_MODE" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DISPLAY_COMPARE" => "N"
	),
	false
);?>

			<?/*$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				".default",
				array(
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "inc",
					"AREA_FILE_RECURSIVE" => "Y",
					"EDIT_TEMPLATE" => "",
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => "/include/overview.php"
				),
				false
			);*/?>
        </div>

		<?  // instagramm
		/*$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			".default",
			array(
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"AREA_FILE_RECURSIVE" => "Y",
				"EDIT_TEMPLATE" => "",
				"COMPONENT_TEMPLATE" => ".default",
				"PATH" => "/include/instagram/instagram_feed.php"
			),
			false
		);  */
		?>
        <div class="no-mobile bestbookmain">
            <?
			global $bestWeekBook;
			//$bestWeekBook = array('>PROPERTY_STATEDATE' => date('Y-m-d', strtotime("-14 days")));
			//$bestWeekBook = array('ID' =>90639);
            if(!$USER->IsAdmin()){
                $bestWeekBook = array('PROPERTY_book_of_the_week' => 917, "!PROPERTY_FOR_ADMIN_VALUE" => "Y");
            } else {
                $bestWeekBook = array('PROPERTY_book_of_the_week' => 917);
            }
            ?>
            <?
			$APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"bestbook",
			array(
				"IBLOCK_TYPE_ID" => "catalog",
				"IBLOCK_ID" => "4",
				"BASKET_URL" => "/personal/cart/",
				"COMPONENT_TEMPLATE" => "bestbook",
				"IBLOCK_TYPE" => "catalog",
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"ELEMENT_SORT_FIELD" => "PROPERTY_shows_a_day",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "rand",
				"ELEMENT_SORT_ORDER2" => "desc",
				"FILTER_NAME" => "bestWeekBook",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"PAGE_ELEMENT_COUNT" => "1",
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
				"CACHE_TYPE" => "Y",
				"CACHE_TIME" => "43200",
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
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"BACKGROUND_IMAGE" => "-",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"CUSTOM_FILTER" => "",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"COMPATIBLE_MODE" => "Y"
			),
			false
		);?>
        </div>

		<div class="hintWrapp EditorChoiceWrapp">
			<div class="catalogWrapper">
				<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section.list",
				"editor_choice",
				array(
					"VIEW_MODE" => "LIST",
					"SHOW_PARENT_NAME" => "Y",
					"IBLOCK_TYPE" => "catalog",
					"IBLOCK_ID" => "4",
					"SECTION_ID" => $_REQUEST["SECTION_ID"],
					"SECTION_CODE" => "",
					"SECTION_URL" => "",
					"COUNT_ELEMENTS" => "Y",
					"TOP_DEPTH" => "2",
					"SECTION_FIELDS" => array(
						0 => "",
						1 => "",
					),
					"SECTION_USER_FIELDS" => array(
						0 => "UF_SHOW_ALWAYS",
						1 => "",
					),
					"ADD_SECTIONS_CHAIN" => "Y",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "60",
					"CACHE_NOTES" => "",
					"CACHE_GROUPS" => "N",
					"COMPONENT_TEMPLATE" => "editor_choice"
				),
				false
				);?>
			</div>
		</div>

        <div class="saleWrapp saleDiscount">
            <div class="catalogWrapper">
                <div>
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						".default",
						array(
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "inc",
							"AREA_FILE_RECURSIVE" => "Y",
							"EDIT_TEMPLATE" => "",
							"COMPONENT_TEMPLATE" => ".default",
							"PATH" => "/include/discount_items_title.php"
							),
						false
					);?>

					<?
                    if(!$USER->IsAdmin()){
                        $disc_items = array ('PROPERTY_discount_on' => '276', "!PROPERTY_FOR_ADMIN_VALUE" => "Y");
                    } else {
                        $disc_items = array ('PROPERTY_discount_on' => '276');
                    }
					$APPLICATION->IncludeComponent(
						"bitrix:catalog.section",
						"discount_books",
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
							"CACHE_TIME" => "3600",
							"CACHE_TYPE" => "Y",
							"COMPONENT_TEMPLATE" => "discount_books",
							"CONVERT_CURRENCY" => "N",
							"DETAIL_URL" => "",
							"DISPLAY_BOTTOM_PAGER" => "Y",
							"DISPLAY_TOP_PAGER" => "N",
							"ELEMENT_SORT_FIELD" => "rand",
							"ELEMENT_SORT_FIELD2" => "id",
							"ELEMENT_SORT_ORDER" => "asc",
							"ELEMENT_SORT_ORDER2" => "desc",
							"FILTER_NAME" => "disc_items",
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
							"PAGE_ELEMENT_COUNT" => "30",
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
								0 => "discount_on",
								1 => "spec_price",
								2 => "AUTHORS",
							),
							"SECTION_CODE" => "",
							"SECTION_ID" => $_REQUEST["SECTION_ID"],
							"SECTION_ID_VARIABLE" => "SECTION_ID",
							"SECTION_URL" => "",
							"SECTION_USER_FIELDS" => array(
								0 => "",
								1 => "",
							),
							"SEF_MODE" => "N",
							"SET_BROWSER_TITLE" => "Y",
							"SET_LAST_MODIFIED" => "N",
							"SET_META_DESCRIPTION" => "Y",
							"SET_META_KEYWORDS" => "Y",
							"SET_STATUS_404" => "N",
							"SET_TITLE" => "N",
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
							"DISABLE_INIT_JS_IN_COMPONENT" => "N",
							"CUSTOM_FILTER" => "",
							"HIDE_NOT_AVAILABLE_OFFERS" => "N",
							"COMPATIBLE_MODE" => "Y"
							),
						false
					);?>
				</div>
				<!--noindex-->

                <div class="giftWrapBlock">
                    <div class="giftWrap">
                        <form action="/" method="post">
                            <input type="text" placeholder="Ваш e-mail" name="email" onkeypress="if (event.keyCode == 13) {return SubmitRequest(event);}">
                            <input type="button" value="">
                        </form>
                        <div class="some_info">
                            Заявка на подписку принята, ждите информацию на почту
                        </div>
                        <p class="title">
                            Книга в подарок
                        </p>
                        <p>
                            Подпишитесь на рассылку и получите книгу<br />в формате PDF бесплатно
                        </p>
						<div class="pii no-mobile">* подписываясь на рассылку, вы соглашаетесь на обработку персональных данных в соответствии <a href="/content/pii/" target="_blank">с условиями</a></div>
                    </div>
                </div>
				<!--/noindex-->
            </div>
        </div>
    </div>
</div>
<div class="reviewsWrapp">
    <div class="catalogWrapper">
        <div class="arrows">
            <img src="/img/arrowRoundLeft.png" id="left"> <img src="/img/arrowRoundRight.png" id="right">
        </div>
        <p class="revTitle">
            Отзывы
        </p>
        <?
            if(!$USER->IsAdmin()){
                $RevFilter = array("!SECTION_ID" => true, "!PROPERTY_FOR_ADMIN_VALUE" => "Y");
            } else {
                $RevFilter = array("!SECTION_ID" => true);
            }
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "latest_reviews",
                array(
                    "IBLOCK_TYPE_ID" => "catalog",
                    "IBLOCK_ID" => "31",
                    "BASKET_URL" => "/personal/cart/",
                    "COMPONENT_TEMPLATE" => "latest_reviews",
                    "IBLOCK_TYPE" => "catalog",
                    "SECTION_ID" => $_REQUEST["SECTION_ID"],
                    "SECTION_CODE" => "",
                    "SECTION_USER_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "ELEMENT_SORT_FIELD" => "rand",
                    "ELEMENT_SORT_ORDER" => "desc",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "FILTER_NAME" => "RevFilter",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "PAGE_ELEMENT_COUNT" => "8",
                    "LINE_ELEMENT_COUNT" => "3",
                    "PROPERTY_CODE" => array(
                        0 => "BOOK",
                        1 => "expert",
                        2 => "review",
                        3 => "name",
                        4 => "comment",
                        5 => "stars",
                        6 => "",
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
                    "ADD_PICT_PROP" => "-",
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
                    "CACHE_GROUPS" => "Y",
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "Y",
                    "BROWSER_TITLE" => "-",
                    "SET_META_KEYWORDS" => "Y",
                    "META_KEYWORDS" => "-",
                    "SET_META_DESCRIPTION" => "Y",
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
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "SET_STATUS_404" => "N",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    "BACKGROUND_IMAGE" => "-",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N"
                ),
                false
            );?>
        <div class="dopSaleWrap">
            <div class="dopSale">
                Накопительные скидки
            </div>

            <div class="percentBlock">
                <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => "/include/main_discount_left.php"
                        ),
                        false
                    );?>
            </div>

            <div class="TwentypercentBlock">
                <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "AREA_FILE_RECURSIVE" => "Y",
                            "EDIT_TEMPLATE" => "",
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH" => "/include/main_discount_right.php"
                        ),
                        false
                    );?>
            </div>
        </div>
    </div>
</div>

<div class="socialServises no-mobile" style="text-align: center;padding:40px 0">
	<style>
	.b-share-btn__wrap {margin:0 20px!important}
	</style>
	<?require($_SERVER["DOCUMENT_ROOT"].'/local/templates/.default/components/bitrix/catalog/catalog_template/bitrix/catalog.element/.default/include/socialbuttons.php'); ?>
</div>

<div class="paymentWrapp">
    <div class="catalogWrapper">
        <div class="comfortPayment">
            <p class="title">
                Комфортная оплата
            </p>
            <div class="image_visa"></div>
            <div class="image_mastercard"></div>
            <div class="image_yandexmoney"></div>
            <div class="image_webmoney"></div>
            <div class="variants">
                <div>
                    <a href="/content/payment/#cash">
                        <p>
                            Оплата наличными
                        </p>
                    </a>
                    <a href="/content/payment/#bankcard">
                        <p>
                            Оплата банковской картой
                        </p>
                    </a>
                    <a href="/content/payment/#epayments">
                        <p>
                            Электронные платежи
                        </p>
                    </a>
                </div>
                <div>
                    <a href="/content/payment/#cashless">
                        <p>
                            Безналичный перевод для юр. лиц
                        </p>
                    </a>
                    <a href="/content/payment/#banktransf">
                        <p>
                            Банковский перевод
                        </p>
                    </a>
                </div>
            </div>
        </div>
        <div class="shiping">
            <p class="title">
                Удобная доставка
            </p>
            <div class="image_boxberry"></div>
            <div class="image_russianpost"></div>
            <div class="variants">
                <div>
                    <a href="/content/delivery/#moscow_courier">
                        <p>
                            Курьерская доставка по Москве и Подмосковью
                        </p>
                    </a>
                    <a href="/content/delivery/#russianpost">
                        <p>
                            Доставка почтой по всей России
                        </p>
                    </a>
                </div>
                <div>
                    <a href="/content/delivery/#iml_delivery">
                        <p>
                            Международная доставка
                        </p>
                    </a>
                    <a href="/content/delivery/#pickup">
                        <p>
                            Самовывоз м.Полежаевская
                        </p>
                    </a>
					<a href="/content/delivery/#postamat">
                        <p>
                            Пункты выдачи по России
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".some_info").click(function(){
        $(".some_info").hide();
        $(".layout").hide();
    });


    /*$(".layout").click(function(){
    alert(123);
    $(".some_info").hide();
    $(".layout").hide();
    })*/



    if ($(".saleSlider ul li").size() < 6)
    {
        $(".saleSlider .left").hide();
        $(".saleSlider .right").hide();
    }
</script>

<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
    window.criteo_q = window.criteo_q || [];
    window.criteo_q.push(
        { event: "setAccount", account: 18519 },
        <?if($USER->IsAuthorized()){?>
            { event: "setEmail", email: "<?=$USER->GetEmail()?>" },
            <?}?>
        { event: "setSiteType", type: "d" },
        { event: "viewHome" }
    );
</script>