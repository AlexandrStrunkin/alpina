<?
//include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');



require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
$APPLICATION->SetTitle("Страница не найдена");?>
<style type="text/css">
    body > table, body > br{
        display:none;
    }
</style>
	<div class="noResultBodyWrap">
		<div class="centerWrapper noResWrapp">
			<p class="noResultTitle">Неправильно набран адрес, <br>или такой страницы на сайте больше не существует.</p>
			<p class="noResText">Вернитесь на <a href="<?=SITE_DIR?>">главную</a> или посмотрите на наши <a href="/catalog/new/?SORT=NEW">новинки</a>.</p>
            <div data-retailrocket-markup-block="5b55e35d97a528425c3cea6b"></div>
		</div>
	</div>

	<?/*
    <div class="col-sm-offset-2 col-sm-4">
        <div class="bx-map-title"><i class="fa fa-leanpub"></i> Каталог</div>
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "tree",
            array(
                "COMPONENT_TEMPLATE" => "tree",
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "2",
                "SECTION_ID" => $_REQUEST["SECTION_ID"],
                "SECTION_CODE" => "",
                "COUNT_ELEMENTS" => "Y",
                "TOP_DEPTH" => "2",
                "SECTION_FIELDS" => array(
                    0 => "",
                    1 => "",
                ),
                "SECTION_USER_FIELDS" => array(
                    0 => "",
                    1 => "",
                ),
                "SECTION_URL" => "",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "Y",
                "ADD_SECTIONS_CHAIN" => "Y"
            ),
            false
        );
        ?>
    </div>

    <div class="col-sm-offset-1 col-sm-4">
        <div class="bx-map-title"><i class="fa fa-info-circle"></i> О магазине</div>
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:main.map",
            ".default",
            array(
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "SET_TITLE" => "N",
                "LEVEL" => "3",
                "COL_NUM" => "2",
                "SHOW_DESCRIPTION" => "Y",
                "COMPONENT_TEMPLATE" => ".default"
            ),
            false
        );?>
    </div>*/?>
            <div class="interestSlideWrap">
                <?
                if (isset($_COOKIE["rrpusid"])){
                    global $arrFilter;
                    $stringRecs = file_get_contents('http://api.retailrocket.ru/api/1.0/Recomendation/PersonalRecommendation/50b90f71b994b319dc5fd855/?rrUserId='.$_COOKIE["rrpusid"]);
                    $recsArray = json_decode($stringRecs);
                    $arrFilter = Array('ID' => (array_slice($recsArray, 0, 6)));
                }
                if ($arrFilter['ID'][0] > 0) {
                    $APPLICATION->IncludeComponent("bitrix:catalog.section", "interesting_items", Array(
                        "IBLOCK_TYPE_ID" => "catalog",
                        "IBLOCK_ID" => CATALOG_IBLOCK_ID,    // Инфоблок
                        "BASKET_URL" => "/personal/cart/",    // URL, ведущий на страницу с корзиной покупателя
                        "COMPONENT_TEMPLATE" => "template1",
                        "IBLOCK_TYPE" => "catalog",    // Тип инфоблока
                        "SECTION_ID" => "",    // ID раздела
                        "SECTION_CODE" => "",    // Код раздела
                        "SECTION_USER_FIELDS" => array(    // Свойства раздела
                            0 => "",
                            1 => "",
                        ),
                        "ELEMENT_SORT_FIELD" => "id",    // По какому полю сортируем элементы
                        "ELEMENT_SORT_ORDER" => "desc",    // Порядок сортировки элементов
                        "ELEMENT_SORT_FIELD2" => "id",    // Поле для второй сортировки элементов
                        "ELEMENT_SORT_ORDER2" => "desc",    // Порядок второй сортировки элементов
                        "FILTER_NAME" => "arrFilter",    // Имя массива со значениями фильтра для фильтрации элементов
                        "INCLUDE_SUBSECTIONS" => "Y",    // Показывать элементы подразделов раздела
                        "SHOW_ALL_WO_SECTION" => "Y",    // Показывать все элементы, если не указан раздел
                        "HIDE_NOT_AVAILABLE" => "N",    // Не отображать товары, которых нет на складах
                        "PAGE_ELEMENT_COUNT" => "12",    // Количество элементов на странице
                        "LINE_ELEMENT_COUNT" => "3",    // Количество элементов выводимых в одной строке таблицы
                        "PROPERTY_CODE" => array(    // Свойства
                            0 => "",
                            1 => "",
                        ),
                        "OFFERS_FIELD_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "OFFERS_PROPERTY_CODE" => array(
                            0 => "COLOR_REF",
                            1 => "SIZES_SHOES",
                            2 => "SIZES_CLOTHES",
                            3 => "",
                        ),
                        "OFFERS_SORT_FIELD" => "sort",
                        "OFFERS_SORT_ORDER" => "desc",
                        "OFFERS_SORT_FIELD2" => "id",
                        "OFFERS_SORT_ORDER2" => "desc",
                        "OFFERS_LIMIT" => "5",    // Максимальное количество предложений для показа (0 - все)
                        "TEMPLATE_THEME" => "site",    // Цветовая тема
                        "PRODUCT_DISPLAY_MODE" => "Y",
                        "ADD_PICT_PROP" => "BIG_PHOTO",    // Дополнительная картинка основного товара
                        "LABEL_PROP" => "-",    // Свойство меток товара
                        "OFFER_ADD_PICT_PROP" => "-",
                        "OFFER_TREE_PROPS" => array(
                            0 => "COLOR_REF",
                            1 => "SIZES_SHOES",
                            2 => "SIZES_CLOTHES",
                        ),
                        "PRODUCT_SUBSCRIPTION" => "N",    // Разрешить оповещения для отсутствующих товаров
                        "SHOW_DISCOUNT_PERCENT" => "N",    // Показывать процент скидки
                        "SHOW_OLD_PRICE" => "Y",    // Показывать старую цену
                        "SHOW_CLOSE_POPUP" => "N",    // Показывать кнопку продолжения покупок во всплывающих окнах
                        "MESS_BTN_BUY" => "Купить",    // Текст кнопки "Купить"
                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",    // Текст кнопки "Добавить в корзину"
                        "MESS_BTN_SUBSCRIBE" => "Подписаться",    // Текст кнопки "Уведомить о поступлении"
                        "MESS_BTN_DETAIL" => "Подробнее",    // Текст кнопки "Подробнее"
                        "MESS_NOT_AVAILABLE" => "Нет в наличии",    // Сообщение об отсутствии товара
                        "SECTION_URL" => "",    // URL, ведущий на страницу с содержимым раздела
                        "DETAIL_URL" => "",    // URL, ведущий на страницу с содержимым элемента раздела
                        "SECTION_ID_VARIABLE" => "SECTION_ID",    // Название переменной, в которой передается код группы
                        "SEF_MODE" => "N",    // Включить поддержку ЧПУ
                        "AJAX_MODE" => "N",    // Включить режим AJAX
                        "AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
                        "AJAX_OPTION_STYLE" => "Y",    // Включить подгрузку стилей
                        "AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
                        "AJAX_OPTION_ADDITIONAL" => "",    // Дополнительный идентификатор
                        "CACHE_TYPE" => "A",    // Тип кеширования
                        "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
                        "CACHE_GROUPS" => "Y",    // Учитывать права доступа
                        "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
                        "SET_BROWSER_TITLE" => "Y",    // Устанавливать заголовок окна браузера
                        "BROWSER_TITLE" => "-",    // Установить заголовок окна браузера из свойства
                        "SET_META_KEYWORDS" => "Y",    // Устанавливать ключевые слова страницы
                        "META_KEYWORDS" => "-",    // Установить ключевые слова страницы из свойства
                        "SET_META_DESCRIPTION" => "Y",    // Устанавливать описание страницы
                        "META_DESCRIPTION" => "-",    // Установить описание страницы из свойства
                        "SET_LAST_MODIFIED" => "N",    // Устанавливать в заголовках ответа время модификации страницы
                        "USE_MAIN_ELEMENT_SECTION" => "N",    // Использовать основной раздел для показа элемента
                        "ADD_SECTIONS_CHAIN" => "N",    // Включать раздел в цепочку навигации
                        "CACHE_FILTER" => "N",    // Кешировать при установленном фильтре
                        "ACTION_VARIABLE" => "action",    // Название переменной, в которой передается действие
                        "PRODUCT_ID_VARIABLE" => "id",    // Название переменной, в которой передается код товара для покупки
                        "PRICE_CODE" => array(    // Тип цены
                            0 => "BASE",
                        ),
                        "USE_PRICE_COUNT" => "N",    // Использовать вывод цен с диапазонами
                        "SHOW_PRICE_COUNT" => "1",    // Выводить цены для количества
                        "PRICE_VAT_INCLUDE" => "Y",    // Включать НДС в цену
                        "CONVERT_CURRENCY" => "N",    // Показывать цены в одной валюте
                        "USE_PRODUCT_QUANTITY" => "N",    // Разрешить указание количества товара
                        "PRODUCT_QUANTITY_VARIABLE" => "",    // Название переменной, в которой передается количество товара
                        "ADD_PROPERTIES_TO_BASKET" => "Y",    // Добавлять в корзину свойства товаров и предложений
                        "PRODUCT_PROPS_VARIABLE" => "prop",    // Название переменной, в которой передаются характеристики товара
                        "PARTIAL_PRODUCT_PROPERTIES" => "N",    // Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
                        "PRODUCT_PROPERTIES" => "",    // Характеристики товара
                        "OFFERS_CART_PROPERTIES" => array(
                            0 => "COLOR_REF",
                            1 => "SIZES_SHOES",
                            2 => "SIZES_CLOTHES",
                        ),
                        "ADD_TO_BASKET_ACTION" => "ADD",    // Показывать кнопку добавления в корзину или покупки
                        "PAGER_TEMPLATE" => "round",    // Шаблон постраничной навигации
                        "DISPLAY_TOP_PAGER" => "N",    // Выводить над списком
                        "DISPLAY_BOTTOM_PAGER" => "Y",    // Выводить под списком
                        "PAGER_TITLE" => "Товары",    // Название категорий
                        "PAGER_SHOW_ALWAYS" => "N",    // Выводить всегда
                        "PAGER_DESC_NUMBERING" => "N",    // Использовать обратную навигацию
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",    // Время кеширования страниц для обратной навигации
                        "PAGER_SHOW_ALL" => "N",    // Показывать ссылку "Все"
                        "PAGER_BASE_LINK_ENABLE" => "N",    // Включить обработку ссылок
                        "SET_STATUS_404" => "N",    // Устанавливать статус 404
                        "SHOW_404" => "N",    // Показ специальной страницы
                        "MESSAGE_404" => "",    // Сообщение для показа (по умолчанию из компонента)
                        "BACKGROUND_IMAGE" => "-",    // Установить фоновую картинку для шаблона из свойства
                        ),
                        false
                    );
                }?>
            </div>
	<script>
		$(document).ready(function(){
			dataLayer.push({'event' : 'otherEvents', 'action' : '404 error', 'label' : '<?=$_SERVER['REQUEST_URI']?>'});
		});
	</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
