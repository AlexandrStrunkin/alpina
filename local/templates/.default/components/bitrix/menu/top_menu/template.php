<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
foreach($arResult as $arItem) {
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<li><a class="topMenuLink" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
<?}?>

<?if (date("Y-m-d") == "2018-01-30") {?>
	<li class="timer"><a href="/actions/cybertuesday/" style="color:red!important" target="_blank">Кибервторник <span id="days"></span>:<span id="hours"></span>:<span id="minutes"></span>:<span id="seconds"></span></a></li>
	<script type="text/javascript" src="/js/countdown.js?2017112312"></script>
<?} else {?>
	<li><a class="topMenuLink" href="/actions/freedigitalbooks/" target="_blank">Бесплатные электронные книги</a></li>
<?}?>