<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

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
    <title><?$APPLICATION->ShowTitle()?></title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="/js/main.js?<?=filemtime($_SERVER["DOCUMENT_ROOT"].'/js/main.js')?>"></script>
    <?$APPLICATION->ShowHead();?>
    <link rel="stylesheet" href="/css/style.css?<?=filemtime($_SERVER["DOCUMENT_ROOT"].'/css/style.css')?>" type="text/css">
    <link rel="stylesheet" href="/css/landing_20.css" type="text/css">

</head>
<body itemscope itemtype="https://schema.org/WebPage">
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
    <header>
        <a href="https://<?=$_SERVER["HTTP_HOST"]?>" class="logo"><img src="/img/landing/logo_lp.png"></a>
        <P class="phone">+7 (495) 120-07-04 <br>
                        +7 (800) 550-53-22</p>
        <div class="menu_top">
            <ul class="menu">
                <li><a class="topMenuLink" href="/content/payment/">Оплата</a></li>
                <li><a class="topMenuLink" href="/content/delivery/">Доставка</a></li>
                <li><a class="topMenuLink" href="/content/discounts/">Скидки</a></li>
                <li><a class="topMenuLink" href="/about/contacts/">Контакты</a></li>
            </ul>
        </div>
    </header>
    
    <div class="ftoto_20">
        <h3>20 главных книг «Альпины» за 20 лет <br>
            со скидкой 20% <b>с 16 по 22 июля</b></h3>
            <p>Вместе с нашими партнерами мы подготовили для вас умные подарки. Уи-и-и! Но обо всем по порядку.</p>
    </div>

    <section>
        <div class="books_wrap">
            <?                
                $dbProductDiscounts = CCatalogDiscount::GetList(
                    array("SORT" => "ASC"),
                    array("ID" => 319),
                    false,
                    false,
                    array("ID", "PRODUCT_ID")
                    );
                while ($arProductDiscounts = $dbProductDiscounts->Fetch()) {
                    $massiv[] = $arProductDiscounts["PRODUCT_ID"];
                }
             $arSelect = Array("ID", "DETAIL_PICTURE", "DETAIL_PAGE_URL", "NAME", "PROPERTY_text_landing_20", "PROPERTY_appstore");
             $arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$massiv, "ACTIVE"=>"Y");
             $res = CIBlockElement::GetList(Array("SORT" => "asc"), $arFilter, false, false, $arSelect);

             while($arFields = $res->GetNext()) {
                // Простой товар, без торговых предложений (для количества равному 1)
               $price = CCatalogProduct::GetOptimalPrice($arFields["ID"], 1, $USER->GetUserGroupArray(), 'N');
               $picture = CFile::GetPath($arFields["DETAIL_PICTURE"]);
               $final_price = round($price['DISCOUNT_PRICE']);
               ?>
                <div class="bookWrap">
                    <a href="<?=$arFields["DETAIL_PAGE_URL"]?>" class="page" target="_blank">
                        <img src="<?=$picture?>" alt="<?=$arFields["NAME"]?>" title="<?=$arFields["NAME"]?>" /><br>
                    </a>
                    <b><?=$arFields["NAME"]?></b>     
                    <br>
                    <p><?=$arFields["PROPERTY_TEXT_LANDING_20_VALUE"]?></p>
                    <span> <strike><?=round($price['PRICE']["PRICE"])?> руб.</strike></span>

                    <a class="item product<?= $arFields["ID"]; ?>" href="javascript:void(0)" onclick="addtocart(<?= $arFields["ID"]; ?>, '<?= $arFields["NAME"]; ?>');return false;">
                        <p class="basketBook">Купить за <?=round($final_price)?> руб.</p>
                        <?if (!empty($arFields["PROPERTY_APPSTORE_VALUE"])) {?>
                        <div class="digitalBookMark">
                            <p><span class="test">+ Бесплатная эл. версия</span></p>
                        </div>
                        <?}?>
                    </a>                        

                </div>
            <?}?>   
        </div>
        <div class="gifts">
            <h3>А теперь <b>умные подарки</b> от партнеров!</h3>
            <p>Все покупатели, заказавшие* одну или несколько книг из юбилейного списка, участвуют
                в розыгрыше призов. Результаты будут объявлены 26 июля в соцсетях издательства.</p>
            <ul>
                <li>
                    <a href="https://puzzle-english.com/?tid=alpina_dr" target="_blank"><img src="/img/landing/PuzzleEnglish-logo_vertical_color.png"><p><b>Puzzle English</b> — онлайн-сервис для самостоятельного изучения английского языка с помощью видео, игр, упражнений, подкастов, песен и большого количества разного контента</p>
                    <span>2 доступа к заданиям</span>
                    <span>3 курса Puzzle Academy</span>
                    <span>5 доступов к подкастам</span>
                    </a>
                </li>
                <li>                  
                    <a href="http://cityclass.ru/" target="_blank"><img src="/img/landing/cityclass.png"><p><b>Сити Класс</b> предлагает интеллектуальный досуг. Это 100 идей, как с пользой провести время! Вас ждет прекрасная компания наших экспертов: Ирина Хакамада, Александр Васильев, Николай Сванидзе, Максим Поташев и другие</p>
                    <span>3 билета на лекции  и мастер-классы</span>
                    </a>
                </li>
                <li>
                    <a href="http://remote-moscow.ru/" target="_blank"><img src="/img/landing/pasted.png" style=" margin-top: 23px; "><p><b>Remote Moscow</b> — театральный проект нового формата</p>
                    <span>2 билета на спектакль - путешествие по Москве</span>
                    </a>
                </li>
                <li style=" height: 340px;">   
                    <a href="https://masterbrus.com/" target="_blank"><img src="/img/landing/share1.png" style=" margin-top: 15px; "><p >Молодой независимый театр, созданный на основе курса Школы-студии МХАТ под руководством Дмитрия Брусникина.</p>
                    <span>2 билета на любой спектакль</span>
                    </a>
                </li>
                <li style=" height: 340px;">
                    <a href="http://planetarium-moscow.ru/" target="_blank"><img src="/img/landing/dc6f8ad803f12dc564665195c0bdf357.png"><p style=" margin-top: 12px; ">Центр популяризации естественно-научных знаний</p>
                    <span>2 билета на посещение Большого Звездного зала и музея Урани</span>
                    </a>
                </li>
                <li style=" height: 340px;">
                    <a href="https://www.mosigra.ru/" target="_blank"><img src="/img/landing/timthumb.png"><p style=" margin-top: 12px; ">Мосигра - настольные игры для классных людей</p>
                    <span>5 наборов игры «Экивоки»</span>
                    </a>
                </li>
                <li>
                    <img src="/img/landing/foto_1.png" style=" margin-top: 4px; ">
                    <div>26 или 27 июля</div>
                    <p><b>Юлия Лапина</b>, клиническиий психолог, автор книги "Тело, секс, еда и тревога"</p>
                    <span>Ужин с Юлией Лапиной</span>
                </li>
                <li>
                    <img src="/img/landing/foto_2.png" style=" top: 3px; position: relative; ">
                    <div>28 июля</div>
                    <p><b>Александр Талал</b>, сценарист, куратор "Московской школы кино", автор книги "Миф и жизнь в кино"</p>
                    <span>Ужин с Александром Талалом</span>
                </li>
                <li>
                    <img src="/img/landing/foto_3.png">
                    <div>22 августа</div>
                    <p><b>Никита Непряхин</b>, бизнес-тренер, телерадио - ведущий, автор книги "Я манипулирую тобой"</p>
                    <span>Завтрак с Никитой Непряхиным</span>
                </li>
            </ul>
        </div>
    </section>
    <footer>
        <p>#альпина20</p>
        <ul>
            <li><a href="https://vk.com/ideabooks"><img src="/img/landing/seti_1.png" alt=""></a></li>
            <li><a href="https://www.facebook.com/alpinabook/"><img src="/img/landing/seti_2.png" alt=""></a></li>
        </ul>
        <span>* В розыгрыше участвуют заказы, оформленные и оплаченные в интернет-магазине alpina.ru с 16 по 22 июля. Для участия необходимо приобрести одну или более книг из юбилейного списка 20 главных книг "Альпины" за 20 лет.</span>     
        <hr> 
        <div class="footer">
             <p class="tag">© 2018 Альпина</p>
             <p class="phone">+7 (495) 120-07-04 <br>
                        +7 (800) 550-53-22</p>             
             <div class="bot_menu">
                <ul class="menu">
                    <li><a class="topMenuLink" href="/content/payment/">Оплата</a></li>
                    <li><a class="topMenuLink" href="/content/delivery/">Доставка</a></li>
                    <li><a class="topMenuLink" href="/content/discounts/">Скидки</a></li>
                    <li><a class="topMenuLink" href="/about/contacts/">Контакты</a></li>
                </ul>
             </div>
        </div>
    </footer>
</body>
</html>