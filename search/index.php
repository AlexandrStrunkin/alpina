<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Результаты поиска — Альпина Паблишер");
$APPLICATION->SetTitle("Поиск");
?>
<div class="search-page" itemprop="mainEntity" itemscope itemtype="http://schema.org/ItemList">
    <?if(!empty($_REQUEST["query"])) {?>
        <div data-retailrocket-markup-block="5b55e2e397a528425c3ce9e8" data-search-phrase="<?=$_REQUEST["query"]?>"></div>
    <?}?>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
