<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "скидки, накопительные скидки, программа лояльности");
$APPLICATION->SetPageProperty("description", "Программа лояльность, скидки за объем, накопительные скидки в интернет-магазине «Альпина Паблишер»");
$APPLICATION->SetTitle("Накопительные скидки, скидки за объем. Книги со скидкой в интернет-магазине «Альпина Паблишер»");
?><div class="searchWrap">
	<div class="catalogWrapper">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:search.title",
	"search_form",
	Array(
		"CATEGORY_0" => "",
		"CATEGORY_0_TITLE" => "",
		"CHECK_DATES" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"CONTAINER_ID" => "title-search",
		"INPUT_ID" => "title-search-input",
		"NUM_CATEGORIES" => "1",
		"ORDER" => "date",
		"PAGE" => "#SITE_DIR#search/index.php",
		"SHOW_INPUT" => "Y",
		"SHOW_OTHERS" => "N",
		"TOP_COUNT" => "5",
		"USE_LANGUAGE_GUESS" => "Y"
	)
);?>
	</div>
</div>
<div class="ContentcatalogIcon">
</div>
<div class="ContentbasketIcon">
</div>
<div class="deliveryPageTitleWrap">
	<div class="centerWrapper">
		<!-- <a href="/"><p>Главная</p></a> -->
		<h1>Накопительные скидки</h1>
	</div>
</div>
<style>
ul {
	list-style-type: none;
}
</style>
<div class="deliveryBodyWrap" style="padding: 50px 0;">
	<div class="centerWrapper">
		<div class="deliveryTypeWrap">
			Покупать книги в&nbsp;нашем интернет-магазине теперь еще приятнее. У&nbsp;нас работает, пожалуй, самая гуманная система накопительных скидок:
			<br /><br />
			<h6>Как получить скидку</h6><ul>
			<li>если вы&nbsp;потратите на&nbsp;нашем сайте всего 5 000&nbsp;рублей, то&nbsp;последующие заказы вы&nbsp;будете делать уже с&nbsp;постоянной скидкой 10%. Для этого не&nbsp;обязательно делать один заказ на&nbsp;5 000&nbsp;рублей, можно накопить эту сумму за&nbsp;несколько покупок;</li>
			<li>когда сумма ваших заказов достигнет 20&nbsp;000&nbsp;рублей, скидка на&nbsp;последующие покупки поднимется до&nbsp;20%.</li>
			</ul>
			<h6>Еще это удобно</h6><ul>
			<li>сумма заказа автоматически пересчитывается с&nbsp;учетом вашей скидки и&nbsp;указывается при оформлении покупки. Всю историю заказов вы&nbsp;можете увидеть в&nbsp;персональном разделе, во&nbsp;вкладке &laquo;Заказы&raquo;.</li>
			</ul>
			<h6>Важный момент</h6><ul>
				<li>Накопительная скидка действует только в&nbsp;том случае, если вы&nbsp;заказываете книги на&nbsp;сайте под одним и&nbsp;тем&nbsp;же логином (e-mail) и&nbsp;не&nbsp;распространяется на&nbsp;стоимость доставки.</li>
<li>В случае одновременного применения промо-кода и активации любой другой скидки применяется наибольшая из скидок.</li>
			</ul>
			<h6>Скидки не&nbsp;распространяются</h6><ul>
				<li>на&nbsp;подарочные сертификаты,</li>
				<li>на&nbsp;книги в&nbsp;коже и эко-коже,</li>
				<li>на&nbsp;книгу &laquo;Правила жизни том&nbsp;1&raquo;,</li>
				<li>на&nbsp;книгу &laquo;Правила жизни том&nbsp;2&raquo;,</li>
				<li>на&nbsp;книги по &laquo;МСФО&raquo;.</li>
			</ul>
		</div>
	</div>
</div>


<?/*
<div class="deliveryBodyWrap" style="padding: 50px 0;">
	<div class="centerWrapper">
		<div class="deliveryTypeWrap">
			Покупать книги в нашем интернет-магазине теперь еще приятнее. У нас работает, пожалуй, самая гуманная система накопительных скидок:
			<br /><br />
			Если вы потратите на нашем сайте всего 5 000 рублей, то последующие заказы вы будете делать уже с постоянной скидкой 10%. Для этого не обязательно делать один заказ на 5 000 рублей, можно накопить эту сумму за несколько покупок&nbsp;
			<br /><br />
			<b>Когда сумма ваших заказов достигнет 20 000 рублей, скидка на последующие покупки поднимется до 20%</b>
			<br /><br />
			Еще это <b>удобно</b>: сумма заказа автоматически пересчитывается с учетом вашей скидки и указывается при оформлении покупки. Всю историю заказов вы можете увидеть в персональном разделе, во вкладке &quot;Заказы&quot;
			<br /><br />
			Важный момент: накопительная скидка действует только в том случае, если вы заказываете книги на сайте под одним и тем же логином (e-mail) и не распространяется на стоимость доставки.
			<br /><br />
			В случае одновременного применения промо-кода и активации любой другой скидки применяется наибольшая из скидок.
			<br /><br />
			Скидки не распространяются на подарочные сертификаты, а также книги: "Правила жизни том 1", "Правила жизни том 2", "Атлант расправил плечи (в коже)", "Добыча (в коже)", "МСФО: Точка зрения КМПГ"
		</div>
	</div>
</div>*/?>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>