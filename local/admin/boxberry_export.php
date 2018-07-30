<?
    /** @global CMain $APPLICATION */
    /** @global CUser $USER */
    /** @global string $DBType */
    /** @global CDatabase $DB */
    use Bitrix\Main\Loader;
    use Bitrix\Main\Localization\Loc;
    use Bitrix\Main\Config\Option;
    use Bitrix\Sale\Internals\StatusTable;
    use Bitrix\Sale;



    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
    Loader::includeModule('sale');
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/prolog.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/general/admin_tool.php");

    Loc::loadMessages(__FILE__);

    $sTableID = "tbl_sale_order";

    $by = "ID";
    $order = "DESC";

    $filter = array(
        "LOGIC" => "OR",
        array("BOXBERRY.ORDER_PROPS_ID" => EXPORTED_TO_BOXBERRY_PROPERTY_ID_NATURAL, "BOXBERRY.VALUE" => "N", "DELIVERY_ID" => BOXBERRY_PICKUP_DELIVERY_ID, "PAYED" => "Y", "!STATUS_ID" => array("PR", "A", "W", "OS")),
        array("BOXBERRY.ORDER_PROPS_ID" => EXPORTED_TO_BOXBERRY_PROPERTY_ID_LEGAL, "BOXBERRY.VALUE" => "N", "DELIVERY_ID" => BOXBERRY_PICKUP_DELIVERY_ID, "PAYED" => "Y", "!STATUS_ID" => array("PR", "A", "W", "OS"))
    );

    $getListParams = array(
        'order' => array($by => $order),
        'filter' => $filter,
        'select' => array("*", "BOXBERRY"),
        'limit' => 250,
        'runtime' => array(
            new \Bitrix\Main\Entity\ReferenceField(
                'BOXBERRY',
                '\Bitrix\Sale\Internals\OrderPropsValueTable',
                array('ref.ORDER_ID' => 'this.ID')
            )
        )
    );

    //собираем заказы с доставкой boxberry
    $order_list = array(); //список заказов со всеми данными
    $user_id_list = array(); //список пользователей
    $order_id_array = array(); //список ID заказов
    $dbOrderList = new CAdminResult(\Bitrix\Sale\Internals\OrderTable::getList($getListParams), $sTableID);
    while ($arOrder = $dbOrderList->Fetch()) {
        $order_id_array[] = $arOrder["ID"];
        $order_list[$arOrder["ID"]] = $arOrder;
        $user_id_list[] = $arOrder["USER_ID"];
    }

    $order_id_array = array_unique($order_id_array);

    $user_id_list = array_unique($user_id_list);
    if (!empty($user_id_list)) {
        //собираем данные пользователей
        $user_list = array();
        $user_info = CUser::GetList($by = "ID", $sort = "ASC", array("ID" => implode(" | ", $user_id_list)));
        while ($ar_user = $user_info->Fetch()) {
            $user_list[$ar_user["ID"]] = $ar_user["EMAIL"];
        }
    }

    //собираем статусы заказа
    $status_list = array();
    $status = CSaleStatus::GetList(array(), array("LID" => "ru"), false, false, array());
    while ($ar_status = $status->Fetch()) {
        $status_list[$ar_status["ID"]] = $ar_status["NAME"];
    }

    $APPLICATION->SetTitle(GetMessage("DOSTAVKA_BOXBERRY_EXPORT"));
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

    $APPLICATION->AddHeadScript("//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js");

    //ajax-экспорт заказов. Запрос отправляется из скрипта, который описан ниже
    if (!empty($_REQUEST["ID"]) && $_REQUEST["export_order"] == "yes") {
        $current_order_id = intval($_REQUEST["ID"]);

        //убираем хедер, чтобы в ответе не было лишнего кода
        $APPLICATION->RestartBuffer();

        //фильтр для выборки заказа
        $order_filter = array("ID" => $current_order_id);

        $getListParams = array(
            'filter' => $order_filter,
        );

        $ar_order = CSaleOrder::GetById($current_order_id);

        //собираем свйоства заказа
        $order_props = array();

        $rs_order_props = CSaleOrderPropsValue::GetList(array(), array("ORDER_ID" => $current_order_id), false, false, array());
        while($ar_order_prop = $rs_order_props->Fetch()) {
            $order_props[$ar_order_prop["CODE"]] = $ar_order_prop;
        }

        //массив с информацией о заказе
        $SDATA=array();
        //выбираем нужные поля
        if($ar_order['PERSON_TYPE_ID'] == LEGAL_ENTITY_PERSON_TYPE_ID) {
            //имя получателя
            $cont_name = (!empty($order_props["F_CONTACT_PERSON"]["VALUE"]) ? $order_props["F_CONTACT_PERSON"]["VALUE"] : $order_props["F_NAME"]["VALUE"]);
            $cont_name = preg_replace("/[^\w\s]+/u", "", $cont_name);
            //телефон
            $cont_tel = (!empty($order_props["PHONE"]["VALUE"]) ? $order_props["PHONE"]["VALUE"] : $order_props["F_PHONE"]["VALUE"]);
            $cont_tel = str_replace("+7", "8", $cont_tel);
            $cont_tel = preg_replace("/[^0-9]/", "" , $cont_tel);
            //email
            $cont_email = (!empty($order_props["EMAIL"]["VALUE"]) ? $order_props["EMAIL"]["VALUE"] : $order_props["F_EMAIL"]["VALUE"]);
            //адрес
            $address_full = (!empty($order_props["ADDRESS_FULL"]["VALUE"]) ? $order_props["ADDRESS_FULL"]["VALUE"] : $order_props["F_ADDRESS_FULL"]["VALUE"]);
            //название компании
            $company_name = (!empty($order_props["COMPANY_NAME"]["VALUE"]) ? $order_props["COMPANY_NAME"]["VALUE"] : $order_props["F_COMPANY_NAME"]["VALUE"]);
            //ИНН
            $inn = (!empty($order_props["INN"]["VALUE"]) ? $order_props["INN"]["VALUE"] : $order_props["F_INN"]["VALUE"]);
            //КПП
            $kpp = (!empty($order_props["KPP"]["VALUE"]) ? $order_props["KPP"]["VALUE"] : $order_props["F_KPP"]["VALUE"]);
            //БИК
            $bik = (!empty($order_props["BIK"]["VALUE"]) ? $order_props["BIK"]["VALUE"] : $order_props["F_BIK"]["VALUE"]);
            //расчетный счет
            $rs_property = (!empty($order_props["RS"]["VALUE"]) ? $order_props["RS"]["VALUE"] : $order_props["F_RS"]["VALUE"]);
            //наименование банка
            $bank = (!empty($order_props["BANK"]["VALUE"]) ? $order_props["BANK"]["VALUE"] : $order_props["F_BANK"]["VALUE"]);
            //корр. счет
            $korr_bill = (!empty($order_props["KORR_BILL"]["VALUE"]) ? $order_props["KORR_BILL"]["VALUE"] : $order_props["F_KORR_BILL"]["VALUE"]);

            $SDATA['customer'] = array(
                'fio' => $cont_name,
                'phone' => $cont_tel,
                'email' => $cont_email,
                'name' => $company_name,
                'address' => $address_full,
                'inn' => $inn,
                'kpp' => $kpp,
                'r_s' => $rs_property,
                'bank' => $bank,
                'kor_s' => $korr_bill,
                'bik' => $bik
            );
        } else {
            //имя получателя
            $cont_name = (!empty($order_props["F_CONTACT_PERSON"]["VALUE"]) ? $order_props["F_CONTACT_PERSON"]["VALUE"] : $order_props["F_NAME"]["VALUE"]);
            $cont_name = preg_replace("/[^\w\s]+/u", "", $cont_name);
            //телефон
            $cont_tel = (!empty($order_props["PHONE"]["VALUE"]) ? $order_props["PHONE"]["VALUE"] : $order_props["F_PHONE"]["VALUE"]);
            $cont_tel = str_replace("+7", "8", $cont_tel);
            $cont_tel = preg_replace("/[^0-9]/", "" , $cont_tel);
            //email
            $cont_email = (!empty($order_props["EMAIL"]["VALUE"]) ? $order_props["EMAIL"]["VALUE"] : $order_props["F_EMAIL"]["VALUE"]);

            $SDATA['customer'] = array(
                'fio' => $cont_name,
                'phone' => $cont_tel,
                'email' => $cont_email,
            );
        }
        //код пункта самовывоза
        $pvz_id = (!empty($order_props["ADDRESS"]["VALUE"]) ? $order_props["ADDRESS"]["VALUE"] : $order_props["F_ADDRESS"]["VALUE"]);

        //собираем корзину
        $basket_items = array();
        $order_basket = CSaleBasket::GetList(array(), array("ORDER_ID" => $current_order_id));
        while($ar_basket_item = $order_basket->Fetch()) {
            $basket_items[] = $ar_basket_item;
        }

        //считаем вес
        $weight = 0;
        foreach ($basket_items as $item_id => $item) {
            $SDATA['items'][$item_id]['id'] = $item['ID'];
            $SDATA['items'][$item_id]['name'] = $item['NAME'];
            $SDATA['items'][$item_id]['price'] = $item['PRICE'];
            $SDATA['items'][$item_id]['quantity'] = $item['QUANTITY'];
            $price = $price + $item['PRICE'] * $item["QUANTITY"];
            if ($item["WEIGHT"] > 0 && $item["QUANTITY"] > 0) {
                $weight += $item["QUANTITY"] * $item["WEIGHT"];
            }
        }

        $SDATA['order_id']= $current_order_id;
        $SDATA['price']= $price;
        $SDATA['payment_sum'] = 0;
        $SDATA['delivery_sum'] = $ar_order['PRICE_DELIVERY'];
        $SDATA['vid'] = 1;
        $SDATA['shop'] = array(
            'name' => $pvz_id,
            'name1' => '010'
        );

        $SDATA['weights'] = array(
            'weight' => $weight
        );

        // Отправляем массив на сервер boxberry используя CURL.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.boxberry.de/json.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'token'=> BOXBERRY_TOKEN,
            'method'=> 'ParselCreate',
            'sdata'=> json_encode($SDATA)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch),1);
        if($data['err'] or count($data)<=0) {
            // если произошла ошибка и ответ не был получен.
            echo $data['err'];
        }
        else
        {
            //иначе выполняем необходимые действия с заказом
            //проверяем данные, которые пришли в ответе. Если они корректные - обновляем заказ: устанавлфваем флаг "экспортирован в boxberry"
            $prop_data = array("ORDER_ID" => $current_order_id , "VALUE" => "Y");
            if (CSaleOrderPropsValue::Update($order_props["EXPORTED_TO_B"]["ID"], $prop_data) && CSaleOrder::Update($current_order_id, array("TRACKING_NUMBER" => $data['track']))) {

                if($arOrder = CSaleOrder::GetByID($ID)) {
                   if($arOrder["STATUS_ID"] == "D") {
                       CSaleOrder::StatusOrder($ID, "AC");
                   } else {
                       CSaleOrder::StatusOrder($ID, "I");
                   }
                }
                echo "OK";
            } else {
                echo GetMessage("ORDER_UPDATE_ERROR");
            }
        }
        die(); //прерываем дальнейшее выполнение страницы при аякс-запросе
    }

?>

<script>
    $(function() {
        //задаем начальные параметры
        order_id_array = [];
        interval = false;

        //обработка чекбокса "выбрать все"
        $(".js-order-box-all").on("click", function() {
            $(".js-order-box").each(function() {
                var checkBoxes = $(this);
                if (!checkBoxes.prop("disabled")) {
                    checkBoxes.prop("checked", !checkBoxes.prop("checked"));
                }
            })
        })
    })

    //функция-обертка для экспорта заказов с интервалом в 1 секунду
    function export_orders_data() {

        $(".js-order-box").each(function(){
            if ($(this).prop("checked")) {
                order_id_array.push($(this).data("order-id"));
            }
        })

        if (order_id_array.length == 0) {
            alert("<?=GetMessage("NO_ORDERS_SELECT")?>");
            return false;
        }


        $(".js-export-processing").show();
        $(".js-export-status").show();
        $('.js-orders-exported').html("0");
        $(".js-orders-count").html(order_id_array.length);
        interval = setInterval(function(){
            export_order()
            }, 1000);
    }

    //функция экспорта заказов
    function export_order() {
        //проверяем текущую длину массива с заказами
        var len = order_id_array.length;
        if (len <= 0) {
            //если массив пуст, то прерываем импорт
            clearInterval(interval);
            $(".js-export-processing").hide();
            return false
        } else {
            //получаем первый элемент массива
            var current_order_id = order_id_array[0];
            //удаляем полученный элемент из массива
            order_id_array.splice(0, 1);

            if (parseInt(current_order_id) > 0) {
                //отправляем аяксом запрос на текущий файл. обработка таких запросов написаны выше
                $.post("<?=$APPLICATION->GetCurPage()?>", {ID: current_order_id, export_order: "yes"}, function(data){
                    var exported_orders_count = parseInt($('.js-orders-exported').html());
                    $('.js-orders-exported').html(exported_orders_count + 1);
                    $(".js-export-" + current_order_id).html(data);
                    if (data == "OK") {
                        $(".js-order-box[data-order-id=" + current_order_id + "]").attr("disabled", "disabled");
                        $(".js-order-box[data-order-id=" + current_order_id + "]").removeAttr("checked");
                    }
                });
            }
        }
    }
</script>


<?if (empty($order_list)) {?>

    <p><b><?=GetMessage("NO_ORDERS")?></b></p>

    <?} else {?>

    <a class="adm-btn adm-btn-save" href="javascript:void(0)" onclick="export_orders_data()"><?=GetMessage("DO_EXPORT")?></a>

    <p class="js-export-processing" style="display: none"><b><?=GetMessage("EXPORT_PROCESSING")?></b></p>

    <p class="js-export-status" style="display: none">
        <b><?=GetMessage("EXPORT_ORDERS_COUNT")?>:</b>
        <span class="js-orders-exported"></span>
        <?=GetMessage("FROM")?>
        <span class="js-orders-count"></span>
    </p>

    <p><b><?=GetMessage("ORDERS_TO_EXPORT")?></b></p>

    <table class="adm-list-table">
        <thead>
            <tr class="adm-list-table-header">

                <td class="adm-list-table-cell">
                    <div class="adm-list-table-cell-inner">
                        #
                    </div>
                </td>

                <td class="adm-list-table-cell">
                    <div class="adm-list-table-cell-inner">
                        <input type="checkbox" value="" class="js-order-box-all" >
                    </div>
                </td>

                <td class="adm-list-table-cell">
                    <div class="adm-list-table-cell-inner">
                        <?=GetMessage("ORDER_ID")?>
                    </div>
                </td>

                <td class="adm-list-table-cell">
                    <div class="adm-list-table-cell-inner">
                        <?=GetMessage("ORDER_DATE_CREATE")?>
                    </div>
                </td>

                <td class="adm-list-table-cell">
                    <div class="adm-list-table-cell-inner">
                        <?=GetMessage("ORDER_STATUS")?>
                    </div>
                </td>

                <td class="adm-list-table-cell">
                    <div class="adm-list-table-cell-inner">
                        <?=GetMessage("ORDER_USER")?>
                    </div>
                </td>

                <td class="adm-list-table-cell">
                    <div class="adm-list-table-cell-inner">
                        <?=GetMessage("ORDER_SUMM")?>
                    </div>
                </td>

                <td class="adm-list-table-cell">
                    <div class="adm-list-table-cell-inner">
                        <?=GetMessage("EXPORT_STATUS")?>
                    </div>
                </td>

            </tr>
        </thead>
        <tbody>
            <?  $i = 1;
                foreach ($order_list as $arOrder) {?>
                <tr>
                    <td class="adm-list-table-cell"><?=$i?></td>
                    <td class="adm-list-table-cell"><input type="checkbox" value="" class="js-order-box" data-order-id="<?=$arOrder["ID"]?>"></td>
                    <td class="adm-list-table-cell"><a href="sale_order_detail.php?ID=<?=$arOrder["ID"]?>" target="_blank"><?=$arOrder["ID"]?></a></td>
                    <td class="adm-list-table-cell"><?=$arOrder["DATE_INSERT"]?></td>
                    <td class="adm-list-table-cell"><?=$status_list[$arOrder["STATUS_ID"]]?></td>
                    <td class="adm-list-table-cell"><?=$user_list[$arOrder["USER_ID"]]?></td>
                    <td class="adm-list-table-cell"><?=round($arOrder["PRICE"], 2)?></td>
                    <td class="adm-list-table-cell js-export-<?=$arOrder["ID"]?>"></td>
                </tr>
                <?
                    $i++;
                }
            ?>
        </tbody>
    </table>

    <?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>