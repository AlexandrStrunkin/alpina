<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="mainRecs">
	<ul>
		<?foreach ($arResult["ITEMS"] as $arItem) {
			$pict = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], array('width'=>200, 'height'=>216), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
			<li class="rec">
				<a class="title" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$pict["src"]?>" title="<?=$arItem["NAME"]?>" />
				<?echo mb_strlen($arItem["NAME"]) > 50 ? mb_substr($arItem["NAME"],0,50).'...' : $arItem["NAME"];?></a>

			</li>
		<?}?>
	</ul>
</div>