<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
    CJSCore::Init(array("fx"));
    $curPage = $APPLICATION->GetCurPage(true);
    $theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);
?>
<!doctype html>
<html class="finishOrder" lang="ru">

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
<?
//Отправка данных о заказе в GTM
$order_id = intval($_REQUEST["ORDER_ID"]);
if($order_id > 0) {
    $arBasketItems = array();
    $arOrder = array();

    $arFilterOrder = Array(
        "ID" => $order_id
    );

    $dbOrder = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilterOrder);
    if($arOrder = $dbOrder->Fetch()) {
        $dbBasketItems = CSaleBasket::GetList(
            array(),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "ORDER_ID" => $arOrder["ID"]
            ),
            false,
            false,
            array("ID", "PRICE", "NAME", "QUANTITY")
        );
        while ($arItems = $dbBasketItems->Fetch()) {
            $arBasketItems[] = $arItems;
        }
    }

    if(count($arBasketItems) > 0 && !empty($arOrder)) {
        foreach ($arBasketItems as $basketItem) {
            $toJSON[] = array(
                'sku'      => intval($basketItem["PRODUCT_ID"]),
                'name'     => strval($basketItem["NAME"]),
                'price'    => floatval($basketItem["PRICE"]),
                'quantity' => intval($basketItem["QUANTITY"])
            );
        }
        $jsonBasket = json_encode($toJSON);
        ?>
        <script>
        window.dataLayer = window.dataLayer || []
        dataLayer.push({
           'transactionId': <?=$order_id;?>,
           'transactionAffiliation': 'alpinabook.ru',
           'transactionTotal': <?=$arOrder["PRICE"];?>,
           'transactionTax': <?=$arOrder["TAX_VALUE"];?>,
           'transactionProducts': <?=$jsonBasket;?>
       });
        </script>
    <?}?>
<?}?>

<?if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/google_tag_manager.php")) {
    include_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/google_tag_manager.php");
}?>
<!--eski.mobi--><script class="eskimobi" data-type="mobile">!function(a,b,c,d,e){function g(a,c,d,e){var f=b.getElementsByTagName("script")[0];e.src?a.src=e.src:e.innerHTML&&(a.innerHTML=e.innerHTML),a.id=c,a.setAttribute("class",d),f.parentNode.insertBefore(a,f)}a.Mobify={points:[+new Date]};var f=/((; )|#|&|^)mobify=(\d)/.exec(location.hash+"; "+b.cookie);if(f&&f[3]){if(!+f[3])return}else if(!c())return;b.write('<div id="eski-overlay" style="font-family:Helvetica-Light,Helvetica,Arial,sans-serif;font-weight:light;font-size:300%;line-height:100%;position:absolute;top:42%;left:0;right:0;text-align:center;color: #999;">\u0417\u0430\u0433\u0440\u0443\u0437\u043A\u0430...</div><plaintext style="display:none">'),setTimeout(function(){var c=a.Mobify=a.Mobify||{};c.capturing=!0;var f=b.createElement("script"),h=function(){var c=new Date;c.setTime(c.getTime()+18e5),b.cookie="mobify=0; expires="+c.toGMTString()+"; path=/",a.location=a.location.href};f.onload=function(){if(e){var a=b.createElement("script");if(a.onerror=h,"string"==typeof e)g(a,"main-executable","mobify",{src:e});else{var c="var main = "+e.toString()+"; main();";g(a,"main-executable","mobify",{innerHTML:c})}}},f.onerror=h,g(f,"mobify-js","mobify",{src:d})})}(window,document,function(){var ua=navigator.userAgent||navigator.vendor||window.opera,m=false;if(/mobi|phone|ipod|nokia|android/i.test(ua))m=true;if(/msie|windows|media\scenter|opera\smini|ipad|android\s3|android\s2|iphone\sos\s(4|5|6)|ipad\sos\s(4|5|6)/i.test(ua)||screen.width>1024)m=false;return m;},"/eskimobi/eski.mobi.min.js?20170906","/eskimobi/mobi.js?201710182");</script><!--/eski.mobi-->
    <!--alpina_basket-->
    <!--<meta http-equiv="Content-type" content="text/html; charset=utf-8"> -->
    <title><?$APPLICATION->ShowTitle()?></title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://payment.platbox.com/widget.js"></script>

    <link rel="stylesheet" href="/css/style.css?<?=filemtime($_SERVER["DOCUMENT_ROOT"].'/css/style.css')?>" type="text/css">
    <link rel="stylesheet" href="/css/selectric.css" type="text/css">

    <script type="text/javascript" src="/js/fancybox-2/jquery.fancybox.js"></script>
    <script type="text/javascript" src="/js/fancybox-2/helpers/jquery.fancybox-thumbs.js"></script>
    <script type="text/javascript" src="/js/fxSlider.js"></script>

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

    <!--<script src="/js/inputmask.date.extension.js"></script>   -->
    <script src="/js/jquery.selectric.min.js"></script>

    <script src="/js/main.js?<?=filemtime($_SERVER["DOCUMENT_ROOT"].'/js/main.js')?>"></script>

    <link rel="stylesheet" type="text/css" href="/js/fancybox-2/jquery.fancybox.css" id="fancycss" media="screen" />
    <link rel="stylesheet" type="text/css" href="/js/fancybox-2/helpers/jquery.fancybox-thumbs.css" id="fancycss" media="screen" />

    <link rel="stylesheet" type="text/css" href="/js/jquery-ui.css" id="fancycss" media="screen" />
    <script type="text/javascript" src="/js/jquery-ui-plugin.js"></script>
    <script type="text/javascript" src="/js/datepicker-ru.js"></script>

    <?$APPLICATION->ShowHead();?>

    <?$APPLICATION->ShowProperty('FACEBOOK_META');?>

        <script type="text/javascript">
//                alert(screen.width) ;
        if (screen.width<=360) {
            $('head').append('<meta name="viewport" content="user-scalable=yes, initial-scale=0.3, maximum-scale=0.8, width=device-width">');
        } else if(screen.width<=415){
            $('head').append('<meta name="viewport" content="user-scalable=yes, initial-scale=0.5, maximum-scale=0.8, width=device-width">');
        } else if(screen.width<=960){
            $('head').append('<meta name="viewport" content="user-scalable=yes, initial-scale=0.8, maximum-scale=0.8, width=device-width">');
        } else if (screen.width<1024) {
            $('head').append('<meta name="viewport" content="user-scalable=yes, initial-scale=0.5, maximum-scale=0.8, width=device-width">');
        }
    </script>
    <? file_exists($_SERVER["DOCUMENT_ROOT"] . '/custom-scripts/ab_tests.php') ? include($_SERVER["DOCUMENT_ROOT"] . '/custom-scripts/ab_tests.php') : ""; //Хардовые AB-тесты?>
    <!-- header .alpina_basket -->
    <script src="https://api-maps.yandex.ru/1.1/index.xml?modules=metro" type="text/javascript"></script>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
        //ymaps.ready(init);
        function map_metro(adress_input) {

            var myMap = new ymaps.Map('map_station', {
                center: [55.753994, 37.622093],
                zoom: 9
            });
            var latitude = '';
            var longitude = '';
            ymaps.geocode(adress_input, {
                /**
                 * Опции запроса
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
                 */
                results: 1
            }).then(function (res) {
                    // Выбираем первый результат геокодирования.
                    var firstGeoObject = res.geoObjects.get(0),
                        // Координаты геообъекта.
                        coords = firstGeoObject.geometry.getCoordinates(),
                        // Область видимости геообъекта.
                        bounds = firstGeoObject.properties.get('boundedBy');

                    firstGeoObject.options.set('preset', 'islands#darkBlueDotIconWithCaption');
                    // Получаем строку с адресом и выводим в иконке геообъекта.
                    firstGeoObject.properties.set('iconCaption', firstGeoObject.getAddressLine());

                    // Добавляем первый найденный геообъект на карту.
                    myMap.geoObjects.add(firstGeoObject);
                    // Масштабируем карту на область видимости геообъекта.
                    myMap.setBounds(bounds, {
                        // Проверяем наличие тайлов на данном масштабе.
                        checkZoomRange: true
                    });

                    var latitude = firstGeoObject.properties.get('boundedBy')[0][0]; // получаем долготу
                    var longitude = firstGeoObject.properties.get('boundedBy')[0][1];  // получаем широту

                    if(latitude > 0 && longitude > 0){
                        geoMetro(latitude,longitude);
                    }
            });
                    // Найдем ближайшую к точке (37.588162, 55.733797) станцию метро

        }
        function geoMetro(latitude, longitude){
            var metro = new YMaps.Metro.Closest(new YMaps.GeoPoint(longitude,latitude), { results : 1 } )// по геоданным получаем 1 станцию метро
            YMaps.Events.observe(metro, metro.Events.Load, function (metro) {

              if (metro.length()) {
                  var firstStation = metro.get(0);
                  var tubest = (firstStation.text).split("метро ");
                    $("#<?=METRO_2?> option[data-value='"+tubest[1]+"']").attr('selected', 'selected'); // выбираем станцию из списка станций
              }
            });
        }
        // $(function(){
        //    fxSlider('saleSlider.recsOnMain', 'left', 'right', false, 200, 5);
        // })
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
<?if ($USER->IsAuthorized()) {
    $rsCurUser = CUser::GetByID($USER->GetID());
    $arCurUser = $rsCurUser->Fetch();
    $userGTMData = "";
    $userGTMData = (!empty($arCurUser["NAME"]) ? "'user_name' : '".$arCurUser["NAME"]."'," : "");
    $userGTMData .= (!empty($arCurUser["EMAIL"]) ? "'user_email' : '".$arCurUser["EMAIL"]."'," : "");
    $userGTMData .= (!empty($arCurUser["UF_GENDER"]) ? "'user_gender' : '".$arCurUser["UF_GENDER"]."'" : "");

    ?>

    <script type="text/javascript">
    dataLayer = [{
        'userId' : <?=$USER->GetID()?>,
        'event' : 'authentication',
        'userRegCategory' : 'UserRegistered',
        <?=$userGTMData?>
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

<div class="basketHeader">
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
    <div class="baskHeadMenu">
        <ul>
            <?$APPLICATION->IncludeComponent("bitrix:menu", "top_menu_cart", Array(
                    "ROOT_MENU_TYPE" => "top_cart",    // РўРёРї РјРµРЅСЋ РґР»СЏ РїРµСЂРІРѕРіРѕ СѓСЂРѕРІРЅСЏ
                    "MAX_LEVEL" => "1",    // РЈСЂРѕРІРµРЅСЊ РІР»РѕР¶РµРЅРЅРѕСЃС‚Рё РјРµРЅСЋ
                    "CHILD_MENU_TYPE" => "top",    // РўРёРї РјРµРЅСЋ РґР»СЏ РѕСЃС‚Р°Р»СЊРЅС‹С… СѓСЂРѕРІРЅРµР№
                    "USE_EXT" => "Y",    // РџРѕРґРєР»СЋС‡Р°С‚СЊ С„Р°Р№Р»С‹ СЃ РёРјРµРЅР°РјРё РІРёРґР° .С‚РёРї_РјРµРЅСЋ.menu_ext.php
                    "DELAY" => "N",    // РћС‚РєР»Р°РґС‹РІР°С‚СЊ РІС‹РїРѕР»РЅРµРЅРёРµ С€Р°Р±Р»РѕРЅР° РјРµРЅСЋ
                    "ALLOW_MULTI_SELECT" => "Y",    // Р Р°Р·СЂРµС€РёС‚СЊ РЅРµСЃРєРѕР»СЊРєРѕ Р°РєС‚РёРІРЅС‹С… РїСѓРЅРєС‚РѕРІ РѕРґРЅРѕРІСЂРµРјРµРЅРЅРѕ
                    "MENU_CACHE_TYPE" => "N",    // РўРёРї РєРµС€РёСЂРѕРІР°РЅРёСЏ
                    "MENU_CACHE_TIME" => "3600",    // Р’СЂРµРјСЏ РєРµС€РёСЂРѕРІР°РЅРёСЏ (СЃРµРє.)
                    "MENU_CACHE_USE_GROUPS" => "Y",    // РЈС‡РёС‚С‹РІР°С‚СЊ РїСЂР°РІР° РґРѕСЃС‚СѓРїР°
                    "MENU_CACHE_GET_VARS" => "",    // Р—РЅР°С‡РёРјС‹Рµ РїРµСЂРµРјРµРЅРЅС‹Рµ Р·Р°РїСЂРѕСЃР°
                    ),
                    false
                );?>
        </ul>
    </div>
    <div class="headPhone">
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
    </div>
</div>
