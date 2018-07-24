<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$pict = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], array('width'=>300, 'height'=>300), BX_RESIZE_IMAGE_PROPORTIONAL, true);

$frame = $this->createFrame()->begin();

$blocks = array();

$arSelect = Array('ID', 'NAME', 'DETAIL_PICTURE', 'DETAIL_TEXT', 'DETAIL_PAGE_URL');
$arFilter = Array("IBLOCK_ID" => 71, "ACTIVE" => "Y", "ACTIVE_DATE"=>"Y", "PROPERTY_AUTHOR"=>$arResult["ID"]);
$posts = CIBlockElement::GetList(Array("ID" => "DESC"), $arFilter, false, Array("nPageSize" => 999), $arSelect);
$i = 0;
while ($post = $posts->GetNextElement()) {
    $postFields = $post->GetFields();

    if (($i + 1) % 3 == 1)
        $blocks[0][] = $postFields;
    elseif (($i + 1) % 3 == 2)
        $blocks[1][] = $postFields;
    else
        $blocks[2][] = $postFields;

    $i++;
}
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
    <div class="catalogWrapper">
        <p class="breadCrump" itemprop="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="url" href="/blog"><span itemprop="name">Блог</span></a>
                <meta itemprop="position" content="1" />
            </span> /
            <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="url" href="/blog/authors/"><span itemprop="name">Авторы блога</span></a>
                <meta itemprop="position" content="2" />
            </span> /
            <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name"><?=$arResult["NAME"]?></span>
                <meta itemprop="position" content="3" />
            </span>
        </p>
        <h1 class="mainTitle" itemprop="headline"><?=typonew($arResult["NAME"])?></h1>
        <h2 itemprop="headline"><?=typonew($arResult["PROPERTIES"]["WHOIS"]["VALUE"])?></h2>
    </div>
</div>
<div class="content">
    <meta itemprop="name" content="<?=$arResult["NAME"]?>" />
    <div class="catalogWrapper">
        <?if ($pict["src"]) {?>
            <center itemprop="image"><img src="<?=$pict["src"]?>" alt="Автор блога <?=$arResult["NAME"]?>" /></center>
        <?}?>
        <br /><br />
    <?foreach ($blocks as $block) {?>
        <ul class="block">
            <?foreach($block as $arItem) {
            $pict = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array('width'=>360, 'height'=>360), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
                <li class="blogPostPreview">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img title="<?=$arItem['NAME']?>" alt="Фотография <?=$arItem['NAME']?>" src="<?=$pict["src"]?>"></a>
                    <?if (!empty($arItem["IBLOCK_SECTION_ID"])) {
                        $section = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"]);
                        $section = $section->GetNext();
                        echo '<div class="cat">'.$section["NAME"].'</div>';
                    }?>
                    <div class="previewContent">
                        <a class="title" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem['NAME']?></a>
                        <div class="previewText"><?=substr(strip_tags($arItem['DETAIL_TEXT']),0,250).'...'?></div>
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="fullText">Читать</a>
                    </div>
                </li>
            <?}?>
        </ul>
    <?}?>
        <div class="clearer"></div>
        <div id="cackleReviews"></div>
        <center><div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,collections,whatsapp,viber,telegram" data-counter=""></div></center>
    </div>
</div>
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


</script>