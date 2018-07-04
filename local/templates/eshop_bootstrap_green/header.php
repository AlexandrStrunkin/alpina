<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
    CJSCore::Init(array("fx"));
    $curPage = $APPLICATION->GetCurPage(true);
    $theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);
    global $USER;
?>
<!doctype html>
<html lang="ru">
<head>

<?if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/google_tag_manager.php")) {
    include_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/google_tag_manager.php");
}?>
<!--eski.mobi--><script class="eskimobi" data-type="mobile">!function(a,b,c,d,e){function g(a,c,d,e){var f=b.getElementsByTagName("script")[0];e.src?a.src=e.src:e.innerHTML&&(a.innerHTML=e.innerHTML),a.id=c,a.setAttribute("class",d),f.parentNode.insertBefore(a,f)}a.Mobify={points:[+new Date]};var f=/((; )|#|&|^)mobify=(\d)/.exec(location.hash+"; "+b.cookie);if(f&&f[3]){if(!+f[3])return}else if(!c())return;b.write('<div id="eski-overlay" style="font-family:Helvetica-Light,Helvetica,Arial,sans-serif;font-weight:light;font-size:300%;line-height:100%;position:absolute;top:42%;left:0;right:0;text-align:center;color: #999;">\u0417\u0430\u0433\u0440\u0443\u0437\u043A\u0430...</div><plaintext style="display:none">'),setTimeout(function(){var c=a.Mobify=a.Mobify||{};c.capturing=!0;var f=b.createElement("script"),h=function(){var c=new Date;c.setTime(c.getTime()+18e5),b.cookie="mobify=0; expires="+c.toGMTString()+"; path=/",a.location=a.location.href};f.onload=function(){if(e){var a=b.createElement("script");if(a.onerror=h,"string"==typeof e)g(a,"main-executable","mobify",{src:e});else{var c="var main = "+e.toString()+"; main();";g(a,"main-executable","mobify",{innerHTML:c})}}},f.onerror=h,g(f,"mobify-js","mobify",{src:d})})}(window,document,function(){var ua=navigator.userAgent||navigator.vendor||window.opera,m=false;if(/mobi|phone|ipod|nokia|android/i.test(ua))m=true;if(/msie|windows|media\scenter|opera\smini|ipad|android\s3|android\s2|iphone\sos\s(4|5|6)|ipad\sos\s(4|5|6)/i.test(ua)||screen.width>1024)m=false;return m;},"/eskimobi/eski.mobi.min.js?20170906","/eskimobi/mobi.js?201710182");</script><!--/eski.mobi-->
    <title><?if(isset($_GET['PAGEN_2'])): $APPLICATION->ShowTitle(); echo ' - страница № ' . $_GET['PAGEN_2'] . ' – Альпина'; else: $APPLICATION->ShowTitle(); endif;?></title>
    
    <!-- retailrocket ������ -->
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
    
    <script>
      (function(d, w, c, e, l) {
        w[c] = w[c] || 'HfuU7jy2swMfqZncmph09QrD6JoYXRrh';
        w[e] = w[e] || 'antisov.ru';
        w[l] = w[l] || 1;
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.src = 'https://cdn.' + w[e] + '/advisor.js';
        s.async = true;
        try {
            d.getElementsByTagName('head')[0].appendChild(s);
        } catch (e) {}
      })(document, window, 'AdvisorApiToken', 'AdvisorHost', 'AdvisorSecure');
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <link rel="stylesheet" href="/css/style.css?<?=filemtime($_SERVER["DOCUMENT_ROOT"].'/css/style.css')?>" type="text/css">

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
    <meta name="yandex-verification" content="9b63e2cc68c18dd9" />

    <link rel="stylesheet" type="text/css" href="/js/fancybox-2/jquery.fancybox.css" id="fancycss" media="screen" />
    <link rel="stylesheet" type="text/css" href="/js/fancybox-2/helpers/jquery.fancybox-thumbs.css" id="fancycss" media="screen" />
    <link href="https://cdn.jsdelivr.net/jquery.suggestions/17.2/css/suggestions.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/17.2/js/jquery.suggestions.min.js"></script>

    <link href="/local/css/slider_box.css?<?=md5(rand());?>" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="/js/slider_box.js?<?=md5(rand());?>"></script>

    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
       function onSubmit(token) {
         checkRegisterFields();
       }
    </script>
    <?if(!isset($_GET['PAGEN_2'])): $APPLICATION->ShowMeta("description"); endif;?>
    <?$APPLICATION->ShowCSS();?>
    <?$APPLICATION->ShowHeadStrings()?>
    <?$APPLICATION->ShowHeadScripts()?>

<?/*    <meta property="og:title" content="<?=htmlspecialchars($APPLICATION->ShowTitle())?>" />
    <meta property="og:description" content="<?=htmlspecialchars($APPLICATION->ShowProperty("description"))?>" />*/?>
    <?$APPLICATION->ShowProperty('FACEBOOK_META');?>
    <?include_once($_SERVER["DOCUMENT_ROOT"] . '/local/templates/.default/include/initial_scale_values.php');?>
    <? file_exists($_SERVER["DOCUMENT_ROOT"] . '/custom-scripts/ab_tests.php') ? include($_SERVER["DOCUMENT_ROOT"] . '/custom-scripts/ab_tests.php') : ""; //Хардовые AB-тесты?>
    <!-- header .eshop_bootstrap_green -->
    <?if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/google_tag_manager_no-script.php")) {
        include_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/google_tag_manager_no-script.php");
    }?>

</head>
<body itemscope itemtype="
    <?if (preg_match("/(.*)\/catalog\/([a-z]+)\/([0-9]+)\/(.*)/i", $_SERVER['REQUEST_URI'])) {
        echo 'https://schema.org/ItemPage';
    } elseif (preg_match("/(.*)\/search\/index.php\?q=(.*)/i", $_SERVER['REQUEST_URI'])) {
        echo 'https://schema.org/SearchResultsPage';
    } elseif (preg_match("/(.*)\/catalog\/([a-z]+)\/(.*)/i", $_SERVER['REQUEST_URI'])) {
        echo 'https://schema.org/CollectionPage';
    } else {
        echo 'https://schema.org/WebPage';
    }?>">
<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter1611177 = new Ya.Metrika({ id:1611177, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, ecommerce:"dataLayer" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/1611177" style="position:absolute; left:-9999px;" alt="" /></div></noscript> 

<!-- /Yandex.Metrika counter -->
<?if ($USER->IsAuthorized()) {
    $rsCurUser = CUser::GetByID($USER->GetID());
    $arCurUser = $rsCurUser->Fetch();
    $userGTMData = (!empty($arCurUser["NAME"]) ? "'user_name' : '" . $arCurUser["NAME"] . "'," : "");
    $userGTMData .= (!empty($arCurUser["EMAIL"]) ? "'user_email' : '" . $arCurUser["EMAIL"] . "'," : "");
    $userGTMData .= (!empty($arCurUser["UF_GENDER"]) ? "'user_gender' : '" . $arCurUser["UF_GENDER"] . "'" : "");
?>

  <!--  <script src="https://api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
    <script src="/js/geolocation_ip.js" type="text/javascript"></script> -->

    <script type="text/javascript">
    dataLayer = [{
        'userId' : <?= $USER->GetID() ?>,
        'event' : 'authentication',
        'userRegCategory' : 'UserRegistered',
        <?= $userGTMData ?>
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
<header>
    <a href="/">
        <div class="logo catalogLogo">
            <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "AREA_FILE_RECURSIVE" => "Y",
                        "EDIT_TEMPLATE" => "",
                        "COMPONENT_TEMPLATE" => ".default",
                        "PATH" => "/include/logoMini.php"
                    ),
                    false
                );?>
        </div>
    </a>
    <div class="catalogHead headCatalog">
        <p>Каталог</p>
    </div>
    <div class="headerWrapper">
        <ul class="menu">
            <?$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "top_menu",
    array(
        "ROOT_MENU_TYPE" => "top",
        "MAX_LEVEL" => "1",
        "CHILD_MENU_TYPE" => "top",
        "USE_EXT" => "Y",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "Y",
        "MENU_CACHE_TYPE" => "Y",
        "MENU_CACHE_TIME" => "36000",
        "MENU_CACHE_USE_GROUPS" => "N",
        "MENU_CACHE_GET_VARS" => array(
        ),
        "COMPONENT_TEMPLATE" => "top_menu",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO"
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

<div class="searchWrap">
    <div class="catalogWrapper">
        <!-- форма поиска -->
        <?$APPLICATION->IncludeComponent(
    "bitrix:search.title",
    "search_form",
    array(
        "CATEGORY_0" => array(
            0 => "iblock_catalog",
        ),
        "CATEGORY_0_TITLE" => "Результат",
        "CHECK_DATES" => "N",
        "COMPONENT_TEMPLATE" => "search_form",
        "CONTAINER_ID" => "title-search",
        "INPUT_ID" => "title-search-input",
        "NUM_CATEGORIES" => "1",
        "ORDER" => "rank",
        "PAGE" => "#SITE_DIR#search/index.php",
        "SHOW_INPUT" => "Y",
        "SHOW_OTHERS" => "N",
        "TOP_COUNT" => "5",
        "USE_LANGUAGE_GUESS" => "Y",
        "CATEGORY_0_iblock_catalog" => array(
            0 => "4",
            1 => "29",
            2 => "45",
        ),
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO"
    ),
    false
);?>
    </div>
</div>