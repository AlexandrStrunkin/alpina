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
<div class="cat_block">
<style>
.wrapperCategor, .categoryWrapper .contentWrapp {height:auto;}
.catalogIcon span, .basketIcon span {color: #99ABB1;}
</style>
<?
$navnum = $arResult["NAV_RESULT"]->NavNum;
if ($_REQUEST["PAGEN_" . $navnum]) {
    //$_SESSION[$APPLICATION -> GetCurDir()] = $_REQUEST["PAGEN_" . $navnum];
}
?>
<div class="wrapperCategor">
    <div class="categoryWrapper">
        <div class="catalogIcon">
        </div>
        <div class="basketIcon">
        </div>
        <div class="contentWrapp">
            <p class="breadCrump no-mobile" itemprop="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                    <a href="/" title="Главная страница" itemprop="item">
                        <span itemprop="name">Главная страница</span>
                    </a>
                    <meta itemprop="position" content="1">
                </span>
				<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                    <span class="gap"></span>
					<span itemprop="name"><?=$GLOBALS["NAME"]?></span>
					<meta itemprop="position" content="2">
                </span>
            </p>
            <div itemprop="mainEntity" itemscope itemtype="http://schema.org/OfferCatalog">
            <link itemprop="url" href="<?=$_SERVER['REQUEST_URI']?>" />

            <h1 itemprop="name"><?=$GLOBALS["NAME"]?></h1>

			<?
			$arData = array();
			$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL");
			$arFilter = Array("IBLOCK_ID" => 80, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_THIS_SECTION" => $arResult["ID"]);
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
			while($ob = $res->GetNextElement()) {
				$arData[] = $ob->GetFields();
			}

			if(count($arData) > 0):
			?>
			<div class="doner_tags">
				<span>Популярные категории</span>
				<?foreach($arData as $data):?>
				<a href="<?=$data["DETAIL_PAGE_URL"]?>"><?=$data["NAME"]?></a>
				<?endforeach;?>
			</div>

			<?endif;?>

         <div class="otherBooks" id="block1" style="margin-top:50px">
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

                                 <a href="<?= $arItem["DETAIL_PAGE_URL"]?>" onclick="productClickTracking(<?= $arItem["ID"];?>, '<?= $arItem["NAME"];?>', '<?= ceil($arPrice["DISCOUNT_VALUE_VAT"])?>','<?= $arResult["NAME"]?>', <?= ($cell+1)?>, 'Catalog Section');" itemprop="url">
                                     <div class="section_item_img">
                                         <?if ($arResult[$arItem["ID"]]["PICTURE"]["src"]) {?>
                                             <img src="<?= $arResult[$arItem["ID"]]["PICTURE"]["src"]?>" alt="<?= $arItem["NAME"];?>" itemprop="image">
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
                                     <p class="bookAutor" itemprop="author"><?= $arResult[$arItem["ID"]]["CURRENT_AUTHOR"]["NAME"]?></p>
                                     <p class="tapeOfPack"><?= $arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]?></p>
                                     <?
                                     if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal")) {
                                            if ($arPrice["DISCOUNT_VALUE_VAT"] && $arResult['ID'] != CERTIFICATE_SECTION_ID) { ?>
                                                <p class="priceOfBook" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                <link itemprop="availability" href="http://schema.org/InStock"><link itemprop="itemCondition" href="http://schema.org/NewCondition"><span itemprop="price"><?= ceil($arPrice["DISCOUNT_VALUE_VAT"])?></span> <span>руб.</span></p>
                                            <? } elseif ($arResult['ID'] == CERTIFICATE_SECTION_ID) { ?>
                                                <p class="priceOfBook" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                <link itemprop="availability" href="http://schema.org/InStock"<link itemprop="itemCondition" href="http://schema.org/NewCondition"><span itemprop="price"><?= ceil($arPrice["VALUE_VAT"])?></span> <span>руб.</span></p>
                                            <? } else { ?>
                                                <p class="priceOfBook" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                <link itemprop="availability" href="http://schema.org/InStock"<link itemprop="itemCondition" href="http://schema.org/NewCondition"><span itemprop="price"><?= ceil($arPrice["ORIG_VALUE_VAT"])?></span> <span>руб.</span></p>
                                            <? }
                                         ?>
                                         <?if ($arResult[$arItem["ID"]]["ITEM_IN_BASKET"]["QUANTITY"] == 0 && $arResult['ID'] != CERTIFICATE_SECTION_ID) {?>
                                            <a class="product<?= $arItem["ID"];?>" href="<?echo $arItem["ADD_URL"]?>" onclick="<?// if ($arItem["CATALOG_QUANTITY"] >= 0) {?>addtocart(<?=$arItem["ID"];?>, '<?=$arItem["NAME"];?>', '<?=$arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]?>'); addToCartTracking(<?= $arItem["ID"];?>, '<?= $arItem["NAME"];?>', '<?= ceil($arPrice["DISCOUNT_VALUE_VAT"])?>','<?= $arResult["NAME"]?>', '1'); <?//}?> return false;">
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
                         <?   //   }
                         }
                        if($criteoCounter<3){
                            array_push($criteoItems, $arItem['ID']);
                        }
                         $criteoCounter++;

                        $gdeslon .= $arItem['ID'].':'.ceil($arPrice["DISCOUNT_VALUE_VAT"]).',';

                        if(!empty($arResult["ORIGINAL_PARAMETERS"]["TAG_CODE"])) {
                            $tagCode = $arResult["ORIGINAL_PARAMETERS"]["TAG_CODE"];
                            $arSelectTag = Array("ID", "NAME");
                            $arFilterTag = Array("IBLOCK_ID" => IBLOCK_ID_TAGGED_PAGES, "ACTIVE"=>"Y", "CODE" => $tagCode);
                            $resTag = CIBlockElement::GetList(Array(), $arFilterTag, false, Array(), $arSelectTag);
                            $arTag = $resTag->fetch();
                        }

                        $gtmEcommerceImpressions .= "{";
                        $gtmEcommerceImpressions .= "'name': '" . $arItem["NAME"] . "',";
                        $gtmEcommerceImpressions .= "'id': '" . $arItem['ID'] . "',";
                        $gtmEcommerceImpressions .= "'price': '" . ceil($arPrice["DISCOUNT_VALUE_VAT"]) . "',";
                        $gtmEcommerceImpressions .= "'category': '" . $arTag["NAME"] . "',";
                        $gtmEcommerceImpressions .= "'list': 'category - " . $arTag["NAME"] . "',";
                        $gtmEcommerceImpressions .= "'position': '" . ($cell+1) . "'";
                        $gtmEcommerceImpressions .= "},";

                     }
                     ?>
                <?if(!empty($arTag)) {?>
                    <script type="text/javascript">
                         <!-- //dataLayer GTM -->
                         dataLayer.push({
                             'categoryName' : '<?= $arTag["NAME"]?>',
                             'categoryId' : '0<?= $arTag['ID'];?>',
                             'ecommerce': {
                                 'impressions': [
                                     <?= $gtmEcommerceImpressions?>
                                 ]
                             }

                         });
                     </script>
                <?}?>
                <!-- gdeslon -->
                <script type="text/javascript" src="https://www.gdeslon.ru/landing.js?mode=list&amp;codes=<?=substr($gdeslon,0,-1)?>&amp;mid=79276&amp;cat_id=<?= $arResult['ID'];?>"></script>

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
			<div itemprop="description" style="padding: 10px 0px;">
				<?=$GLOBALS["DETAIL_TEXT"]?>
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



        <div class="catalogDescription" itemprop="description">
            <?=$arResult["DESCRIPTION"]?>
        </div>
    </div>
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
        })
        <?$navnum = $arResult["NAV_RESULT"]->NavNum;
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
                    page++;
                })
            <?
            } else {?>
                $.get('<?= $arResult["SECTION_PAGE_URL"]?>?SORT=<?= $sort?>&DIRECTION=<?= $arParams["ELEMENT_SORT_ORDER2"]?>&PAGEN_<?= $navnum?>='+page,
                    function(data) {
                    var next_page = $('.otherBooks ul li', data);
                    $('.otherBooks ul').append(next_page);
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

                    $(".otherBooks").css("height", otherBooksHeight+"px");
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

                        $(".otherBooks").css("height", otherBooksHeight+"px");
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
