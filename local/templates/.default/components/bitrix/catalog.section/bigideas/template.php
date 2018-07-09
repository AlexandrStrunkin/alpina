<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$gdeSlon = '';
$is_bot_detected = false;
if (isset($_SERVER["HTTP_USER_AGENT"]) && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])) {    $is_bot_detected = true;}?>
    
<?if ($_REQUEST["DIRECTION"] == "DESC") {?>
    <style>
        .filterParams .active p:after {
            -moz-transform: scaleX(-1);
            -o-transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
            transform: scaleX(-1);
            position: absolute;}
        .wrapperCategor .filterParams li.active {
            width:128px;}
    </style>
<?}?>

<div class="otherBooks otherBooks_all" id="block1">
    <ul>
        <?foreach ($arResult["ITEMS"] as $arItem) {
            $pict = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>147, 'height'=>216), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            foreach ($arItem["PRICES"] as $code => $arPrice) {?>
                <li>
                    <div class="categoryBooks">
                        <div class="sect_badge">
                            <?if (arItem["PROPERTIES"]["discount_ban"]["VALUE"] != "Y" && $arItem['PROPERTIES']['spec_price']['VALUE'] ) {
                                switch ($arItem['PROPERTIES']['spec_price']['VALUE']) {
                                    case 10:
                                        echo '<img class="discount_badge" src="/img/10percent.png">';
                                        break;
                                    case 15:
                                        echo '<img class="discount_badge" src="/img/15percent.png">';
                                        break;
                                    case 20:
                                        echo '<img class="discount_badge" src="/img/20percent.png">';
                                        break;
                                    case 40:
                                        echo '<img class="discount_badge" src="/img/40percent_black.png">';
                                        break;
                                }
                            }?>
                        </div>
                        
                        <?
                        $dbBasketItems = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "PRODUCT_ID" => $arItem["ID"]), false, false, array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS"))->Fetch();
                        
                        $curr_author = CIBlockElement::GetByID($arItem["PROPERTIES"]["AUTHORS"]["VALUE"][0]) -> Fetch();?>
                        
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                            <div class="section_item_img">
                                <?if ($pict["src"]) {?>
                                    <img src="<?=$pict["src"]?>" alt="<?=$arItem["NAME"];?>">
                                <?} else {?>
                                    <img src="/images/no_photo.png" width="142" height="142">
                                <?}?>
                            </div>
                            <p class="nameBook"><?=$arItem["NAME"]?></p>
                        </a>
                        
                        <p class="bookAutor" title="<?=$curr_author["NAME"]?>"><?echo strlen($curr_author["NAME"]) > 18 ? substr($curr_author["NAME"],0,15).'...' : $curr_author["NAME"]?></p>
                        
                        <p class="tapeOfPack"><?=$arItem["PROPERTIES"]["COVER_TYPE"]["VALUE"]?></p>
                        
                        <?if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != 22 && intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) != 23) {?>
                        
                            <p class="priceOfBook">
                                <?=ceil($arPrice["DISCOUNT_VALUE_VAT"])?> <? if (!$is_bot_detected){?><span class="rub_symbol">i</span><?} else {?><span>руб.</span><?}?>
                            </p>
                            
                            <?if ($dbBasketItems["QUANTITY"] == 0) {?>
                                <a class="product<?=$arItem["ID"];?>" onmousedown="try { rrApi.addToBasket(<?=$arItem["ID"]?>) } catch(e) {}" href="<?echo $arItem["ADD_URL"]?>" onclick="addtocart(<?=$arItem["ID"];?>, '<?=$arItem["NAME"];?>');return false;"><p class="basketBook">В корзину</p></a>
                            <?} else {?>
                                <a class="product<?=$arItem["ID"];?>" href="/personal/cart/"><p class="basketBook" style="background-color: #A9A9A9;color: white;">Оформить</p></a>
                            <?}?>
                        <?} else if (intval($arItem["PROPERTIES"]["STATE"]["VALUE_ENUM_ID"]) == 23) {?>
                            <p class="priceOfBook"><?=$arItem["PROPERTIES"]["STATE"]["VALUE"]?></p>
                        <?} else {?>
                            <p class="priceOfBook"><?=strtolower(FormatDate("f Y", MakeTimeStamp($arItem['PROPERTIES']['SOON_DATE_TIME']['VALUE'], "DD.MM.YYYY HH:MI:SS")));?></p>
                            <a class="product<?=$arItem["ID"];?>" href="<?echo $arItem["ADD_URL"]?>" onclick="addtocart(<?=$arItem["ID"];?>, '<?=$arItem["NAME"];?>');return false;"><p class="basketBook">Предзаказ</p></a>
                        <?}?>
                        
                        <?$gdeSlon .= $arItem['ID'].':'.ceil($arPrice["DISCOUNT_VALUE_VAT"]).',';
                        
                        if ($USER -> IsAuthorized()) {?>
                            <p class="basketLater" id="<?=$arItem["ID"]?>">Куплю позже</p>
                        <?}?>
                    </div>
                </li>
            <?}
        }?>
    </ul>
</div>

<div class="wishlist_info">
    <div class="CloseWishlist"><img src="/img/catalogLeftClose.png"></div>
    <span></span>
</div>

<?if (($arResult["NAV_RESULT"]->NavPageCount) > 1) {?>
    <p class="showMore">Показать ещё</p>
<?}?>
<script type="">
       
    $(document).ready(function() {
        <?$navnum = $arResult["NAV_RESULT"]->NavNum;?>
        
        <?if (isset($_REQUEST["PAGEN_".$navnum])) {?>
            var page = <?=$_REQUEST["PAGEN_".$navnum]?> + 1;
        <?}else{?>
            var page = 2;
        <?}?>
        
        var maxpage = <?=(isset($arResult["NAV_RESULT"]->NavPageCount)) ? ($arResult["NAV_RESULT"]->NavPageCount) : 2?>;
        console.log(maxpage);
        $('.showMore').click(function(){
            var otherBooks = $(this).siblings(".otherBooks_all");

            <?if (isset($_REQUEST["SORT"])) {?>
                var section_url = '<?= $arResult["SECTION_PAGE_URL"] . "?" . $_SERVER["QUERY_STRING"] . "&PAGEN_" . $navnum . "=" ?>';
            <?} else {?>
                var section_url = '<?= $arResult["SECTION_PAGE_URL"] . "?PAGEN_" . $navnum . "=" ?>';
            <?}?>
            $.get(section_url + page, function(data) {
                var next_page = $('.otherBooks_all ul li', data);
                //$('.catalogBooks').append('<br /><h3>Страница '+ page +'</h3><br />');
                $('.otherBooks_all ul').append(next_page);
                page++;})
            .done(function() {
                $(".nameBook").each(function() {
                    if($(this).length > 0) {
                        $(this).html(truncate($(this).html(), 40));}});
                var otherBooksHeight = 1440 * Math.ceil(($(".otherBooks_all ul li").length / 15));
                var categorHeight = 1600 + Math.ceil($(".otherBooks_all ul li").length + $(".otherBooks_all").height() + $(".otherBooks_popular").height());
         //       otherBooks.css("height", otherBooksHeight +"px");
           //     $(".wrapperCategor").css("height", categorHeight+"px");
           //     $(".contentWrapp").css("height", categorHeight -10+"px");
            });
            if (page == maxpage) {
                $('.showMore').hide();
                //$('.phpages').hide();}
            return false;
        }
    }); 
});         
 
</script>