<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if ($USER->isAdmin()) {?>
	<a target="_blank" href="misc/book_subs.php">Подписка на выход книг и предзаказы</a><br /><br />
	<a target="_blank" href="catalog/bestsellers.php">Посмотреть бестселлеры за определенные даты</a><br /><br />
	<a target="_blank" href="misc/pickups.php">Список самовывозов на сбор</a><br /><br />
	<a target="_blank" href="alpinadigital/singleorder.php">Отправить бесплатные электронные книги</a><br /><br />
	<a target="_blank" href="misc/addtocartmultiple.php">Добавить в корзину сразу несколько позиций</a><br /><br />
	<a target="_blank" href="misc/change_status.php">Поменять статус заказа на "Отправлен на почту РФ"</a><br /><br />
	<a target="_blank" href="misc/compose_pricelist.php">Получить свежий прайс-лист</a><br /><br />
	<a target="_blank" href="misc/count_delivery.php">Количество заказов на доставку по Москве</a><br /><br />
	<a target="_blank" href="misc/ruspost.php">Таблица для отправки в РусПост</a><br /><br />
	<a target="_blank" href="checkdelivery/waiting_delivery.php">Изменить дату доставки заказа и отправить письмо клиенту</a><br /><br />
	<a target="_blank" href="checkdelivery/couroutes.php">Маршрутные листы для курьеров</a><br /><br />
	<a target="_blank" href="checkdelivery/dimax.php">Таблица для Dimax</a><br /><br />
	<a target="_blank" href="orders/check_book_status.php">Статус книг в заказе</a><br /><br />
	<a target="_blank" href="checkdelivery/lost.php">Проверка упущенных заказов</a><br /><br />
	<a target="_blank" href="checkdelivery/couroutes/">Архив маршрутных листов</a><br /><br />
    <a target="_blank" href="orders/check_preorders.php">Проверить предзаказы</a><br /><br />
    <a target="_blank" href="basket_rules/coupon.php">Создание промо-кодов</a><br /><br />
    <a target="_blank" href="test2.php">Проставить треки</a><br /><br />
    <a target="_blank" href="sale/sale_add.php">Добавление товаров в правило скидки</a><br /><br />
    <a target="_blank" href="delivery_date/delivery_cahnge.php">Смена даты доставки Москва</a><br /><br />
    <a target="_blank" href="delivery_date/pickup_delivery.php">Смена даты самовывоза</a><br /><br />
    <a target="_blank" href="catalog/export_user_csv.php">Скрипт выгрузки покупателей</a><br /><br />
	<a target="_blank" href="checkdelivery/courier_checked.php">Скрипт привязки курьеров</a><br /><br />
    
	
<?} else {
	echo 'error';
}?>