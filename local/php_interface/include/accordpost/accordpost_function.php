<?
//Функция получение списка стран accordpost
function get_country_list() {
    $xmlCountryListRequest = '<request request_type="58" partner_id="'.ACCORDPOST_PARTNER_ID.'" password="'.ACCORDPOST_PASSWORD.'"/>';
    $curlCountryList = curl_init();

    curl_setopt($curlCountryList, CURLOPT_URL, CFG_REQUEST_FULLURL);
    curl_setopt($curlCountryList, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlCountryList, CURLOPT_POST, true);
    curl_setopt($curlCountryList, CURLOPT_POSTFIELDS, $xmlCountryListRequest);
    curl_setopt($curlCountryList, CURLOPT_SSL_VERIFYPEER, 0);

    //Запрос списка стран и обработка ответа
    if($out = curl_exec($curlCountryList)){
        $response = new SimpleXMLElement($out);
        if($response['state'] == 0) {
            //Успешный результат, сохраняем в массив
            foreach($response->country as $country) {
                $arCountry[strval($country['country_id'])]['country_id'] = strval($country['country_id']);
                $arCountry[strval($country['country_id'])]['country_id_name'] = strval($country['country_id_name']);
                $arCountry[strval($country['country_id'])]['country_id_name_en'] = strval($country['country_id_name_en']);
                $arCountry[strval($country['country_id'])]['country_id_name_fr'] = strval($country['country_id_name_fr']);
                $arCountry[strval($country['country_id'])]['country_id_trans_type_id'] = strval($country['country_id_trans_type_id']);
                $arCountry[strval($country['country_id'])]['country_id_trans_type_name'] = strval($country['country_id_trans_type_name']);
            }
         } else {
            foreach($response->error as $error) {
                echo $error['msg'].'<br>';
            }
            return false;
        }
    } else {
        echo 'Не удалось получить список стран';
        return false;
    }
    curl_close($curlCountryList);
    return $arCountry;
};

//Функция преобразования название страны
function transform_country_name($countryName) {
    $countryName = strtoupper(trim(strval($countryName)));
    //Возможно потребуются дополнительные проверки, дописывать сюда
    if ($countryName == 'ЧЕХИЯ') {
        $countryName = 'ЧЕШСКАЯ РЕСПУБЛИКА';
    }
    return $countryName;
}

//Функция проверки существования страны в списке
function get_country_id($arCountry, $countryName){
    foreach($arCountry as $countryID => $arCountryItem) {
        if ((transform_country_name($arCountryItem['country_id_name']) == transform_country_name($countryName)) ||
            (transform_country_name($arCountryItem['country_id_name_en']) == transform_country_name($countryName)) ||
            (transform_country_name($arCountryItem['country_id_name_fr']) == transform_country_name($countryName))) {
            return true;
        }
    }
    return false;
}

//Создание нового элемента ИБ с отгрузкой Accord
function create_delivery_element($arIDs) {
    global $USER;
    global $DB;

    $logger_date = date('Y-m-d, H:i:s');
    $logger_file = $_SERVER['DOCUMENT_ROOT'].'/local/admin/accorpdost.log';

    //Логируем начало экспорта
    $order_log = $logger_date.' - Начало создания элемента в ИБ;';
    logger($order_log, $logger_file);


    //Создадим новую запись в ИБ, для идентификации отгрузок
    $el = new CIBlockElement;
    $arProperty = array();
    $arLoadProductArray = Array(
        "MODIFIED_BY"     => $USER->GetID(), // элемент изменен текущим пользователем
        "IBLOCK_ID"       => ACCORDPOST_IBLOCK_ID,
        "NAME"            => "Отгрузка ".date($DB->DateFormatToPHP(CSite::GetDateFormat("SHORT")), time()),
        "ACTIVE"          => "Y",            // активен
    );



    if($shipment_id = $el -> Add($arLoadProductArray)) {

        $order_log = $logger_date.' - Создан элемент в ИБ; Номер отгрузки - '.$shipment_id;
        logger($order_log, $logger_file);

        $zdoc_id = 'ALPINABOOK'.$shipment_id;

        $elUpdate = new CIBlockElement;

        //Обновим поле с zdoc_id
        $arPropertyUpdate = array();
        $arPropertyUpdate['SHIPMENT_ZDOC_ID'] = $zdoc_id;
        $arPropertyUpdate['SHIPMENT_ORDER_ROW'] = $arIDs;
        $arPropertyUpdate['HANDOVER_PROTOCOL'] = 'https://www.alpinabook.ru/tools/accordpost_handover_protocol.php?ZDOC_ID='.$shipment_id;

        $order_log = $logger_date.' - Номер отгрузки:'.$zdoc_id;
        logger($order_log, $logger_file);

        foreach($arPropertyUpdate['SHIPMENT_ORDER_ROW'] as $logger_id) {
            $order_log = $logger_date.' - ID заказа передаваемый в accord:'.$logger_id;
            logger($order_log, $logger_file);
        }

        $arLoadProductArrayUpdate = Array(
            "PROPERTY_VALUES"=> $arPropertyUpdate
        );

        $res = $elUpdate->Update($shipment_id, $arLoadProductArrayUpdate);
        return $shipment_id;
    } else {

        $order_log = $logger_date.' - Ошибка создания отгрузки на сайте';
        logger($order_log, $logger_file);

        echo 'Ошибка создания отгрузки на сайте';
        return false;
    }
}

//Проверка поля на существование
function exist_property($ORDER_ID, $ORDER_PROPS_ID) {
    $db_vals = '';
    $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $ORDER_ID, "ORDER_PROPS_ID" => $ORDER_PROPS_ID));
    if ($arVals = $db_vals -> Fetch()) {
        return $arVals['ID'];
    } else {
        return false;
    }
}

//Обновление поля
function update_property($prop_data) {
    $logger_date = date('Y-m-d, H:i:s');
    $logger_file = $_SERVER['DOCUMENT_ROOT'].'/local/admin/accorpdost.log';

    $order_log = $logger_date.' - Обновление свойства - $ORDER_ID: '.$prop_data['ORDER_ID'].' $ORDER_CODE: '.$prop_data['CODE'].' $ORDER_PROPS_ID:'.$prop_data['ORDER_PROPS_ID'].' NAME: '.$prop_data['NAME'].' VALUE: '.$prop_data['VALUE'];
    logger($order_log, $logger_file);

    $prop_id = exist_property($prop_data['ORDER_ID'], $prop_data['ORDER_PROPS_ID']);

    if($prop_id) {
        $order_log = $logger_date.' - Свойство существует $prop_id'.$prop_id.' ';
        logger($order_log, $logger_file);

        if (CSaleOrderPropsValue::Update($prop_id, $prop_data)) {
            $order_log = $logger_date.' - Свойство обновляется';
            logger($order_log, $logger_file);
            return true;
        } else {
            $order_log = $logger_date.' - Свойство не обновляется';
            logger($order_log, $logger_file);
            return false;
        };
    } else {
        $order_log = $logger_date.' - Свойство несуществует $ORDER_ID'.$prop_data['ORDER_ID'].' $ORDER_PROPS_ID'.$prop_data['ORDER_PROPS_ID'];
        logger($order_log, $logger_file);

        if (CSaleOrderPropsValue::Add($prop_data)) {
            $order_log = $logger_date.' - Свойство добавляется';
            logger($order_log, $logger_file);
            return true;
        } else {
            $order_log = $logger_date.' - Свойство не добавляется';
            logger($order_log, $logger_file);
            return false;
        };
    }
}


//Обновление элемента после выгрузки
function update_order_accordpost($zdoc_id, $arIDs, $order_props) {
    global $DB;

    $logger_date = date('Y-m-d, H:i:s');
    $logger_file = $_SERVER['DOCUMENT_ROOT'].'/local/admin/accorpdost.log';

    //Логируем начало экспорта
    $order_log = $logger_date.' - Начало обновления заказов;';
    logger($order_log, $logger_file);

    $export_date = date($DB->DateFormatToPHP(CSite::GetDateFormat("SHORT")), time());

    $error_result = false;
    $update_result = false;
    foreach($arIDs as $ID) {
        $order_log = $logger_date.' - Обновляем заказ:'.$ID.' Лицо: '.$order_props[$ID]['PERSON_TYPE_ID'];
        logger($order_log, $logger_file);
        $legal = false;
        if($order_props[$ID]['PERSON_TYPE_ID'] == LEGAL_ENTITY_PERSON_TYPE_ID) {
            $order_log = $logger_date.' - Юр.лицо';
            logger($order_log, $logger_file);

            $prop_data = array(
               "ORDER_ID" => $ID,
               "ORDER_PROPS_ID" => EXPORTED_TO_ACCORDPOST_PROPERTY_ID_LEGAL,
               "CODE" => "EXPORTED_TO_ACCORDPOST",
               "NAME" => EXPORTED_TO_ACCORDPOST_PROPERTY_NAME_LEGAL,
               "VALUE" => $export_date
            );
            $prop_data_zdoc = array(
               "ORDER_ID" => $ID,
               "ORDER_PROPS_ID" => ZDOC_ID_ACCORDPOST_PROPERTY_ID_LEGAL,
               "CODE" => "ZDOC_ID",
               "NAME" => ZDOC_ID_ACCORDPOST_PROPERTY_NAME_LEGAL,
               "VALUE" => $zdoc_id
            );
            $legal = true;
        } else {
            $order_log = $logger_date.' - Физ.лицо';
            logger($order_log, $logger_file);

            $prop_data = array(
               "ORDER_ID" => $ID,
               "ORDER_PROPS_ID" => EXPORTED_TO_ACCORDPOST_PROPERTY_ID_NATURAL,
               "CODE" => "EXPORTED_TO_ACCORDPOST",
               "NAME" => EXPORTED_TO_ACCORDPOST_PROPERTY_NAME_NATURAL,
               "VALUE" => $export_date
            );
            $prop_data_zdoc = array(
               "ORDER_ID" => $ID,
               "ORDER_PROPS_ID" => ZDOC_ID_ACCORDPOST_PROPERTY_ID_NATURAL,
               "CODE" => "ZDOC_ID",
               "NAME" => ZDOC_ID_ACCORDPOST_PROPERTY_NAME_NATURAL,
               "VALUE" => $zdoc_id
            );
        }

        $order_log = $logger_date.' - Перед самим обновлением заказа:'.$ID.'Поля $prop_data: $prop_data["ORDER_ID"]'.$prop_data["ORDER_ID"].' $prop_data["ORDER_PROPS_ID"]'.$prop_data["ORDER_PROPS_ID"].' $prop_data["NAME"]'.$prop_data["NAME"].' $prop_data["VALUE"]'.$prop_data["VALUE"].' ';
        logger($order_log, $logger_file);
        $order_log = $logger_date.' - Перед самим обновлением заказа:'.$ID.'Поля $prop_data_zdoc: $prop_data_zdoc["ORDER_ID"]'.$prop_data_zdoc["ORDER_ID"].' $prop_data_zdoc["ORDER_PROPS_ID"]'.$prop_data_zdoc["ORDER_PROPS_ID"].' $prop_data_zdoc["NAME"]'.$prop_data_zdoc["NAME"].' $prop_data_zdoc["VALUE"]'.$prop_data_zdoc["VALUE"].' ';
        logger($order_log, $logger_file);

        //Обновим свойства у выгруженных элементов
        if ($legal) {
            if (update_property($prop_data) && update_property($prop_data_zdoc)) {
                $order_log = $logger_date.' - Успешно обновил';
                logger($order_log, $logger_file);

                //Если статус оплачен то ставим комплектуется
                if($arOrder = CSaleOrder::GetByID($ID)) {
                  /* if($arOrder["STATUS_ID"] == "D") {
                       CSaleOrder::StatusOrder($ID, "AC");
                   } else {*/
                       CSaleOrder::StatusOrder($ID, "K");
                   //}
                }

                $error_result = true;
            } else {
                $order_log = $logger_date.' - Не обновил';
                logger($order_log, $logger_file);
            };
        } else {
            if (update_property($prop_data) && update_property($prop_data_zdoc)) {
                $order_log = $logger_date.' - Успешно обновил';
                logger($order_log, $logger_file);

                if($arOrder = CSaleOrder::GetByID($ID)) {
                   /*if($arOrder["STATUS_ID"] == "D") {
                       CSaleOrder::StatusOrder($ID, "AC");
                   } else {*/
                       CSaleOrder::StatusOrder($ID, "K");
                   //}
                }

                $error_result = true;
            } else {
                $order_log = $logger_date.' - Не обновил';
                logger($order_log, $logger_file);
            }
        }
    }
    return $error_result;
}

//Функция экспорта в accordpost
function export_to_accordpost($xmlBody, $zdoc_id, $shipment_id, $arIDs, $order_props){

    $logger_date = date('Y-m-d, H:i:s');
    $logger_file = $_SERVER['DOCUMENT_ROOT'].'/local/admin/accorpdost.log';

    //Логируем начало экспорта
    $order_log = $logger_date.' - Начало экспорта в аккорд;';
    logger($order_log, $logger_file);

    //Константы для curl запроса
    define('CFG_NL', "\n");
    define('CFG_REQUEST_POST', 1);
    define('CFG_REQUEST_TIMEOUT', 1);
    define('CFG_CONTENT_TYPE', 'text/xml; charset=utf-8');

    //Экспорт заказов
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, CFG_REQUEST_FULLURL);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlBody);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    //Запрос и обработка ответа
    if ($out = curl_exec($curl)) {

        //Логируем начало экспорта
        $order_log = $logger_date.' - Ответ от аккорд:'.$out;
        logger($order_log, $logger_file);

        $response = new SimpleXMLElement($out);

        if($response['state'] == 0) {
            //Обновим элементы
            if (update_order_accordpost($zdoc_id, $arIDs, $order_props)) {

                //Логируем начало экспорта
                $order_log = $logger_date.' - Выгрузка прошла успешно, номер документа: '.$zdoc_id;
                logger($order_log, $logger_file);

                echo 'Выгрузка прошла успешно, номер документа: '.$zdoc_id.'<br>';
            } else {
                //Логируем начало экспорта
                $order_log = $logger_date.' - Выгрузка прошла успешно, не удалось обновить элемент в системе: '.$zdoc_id;
                logger($order_log, $logger_file);

                //Удалим ошибочную выгрузку
                $xmlBodyDelete = '<request request_type="102" partner_id="'.ACCORDPOST_PARTNER_ID.'" password="'.ACCORDPOST_PASSWORD.'"><doc zdoc_id="'.$zdoc_id.'"/></request>';

                $curlDelete = curl_init();
                curl_setopt($curlDelete, CURLOPT_URL, CFG_REQUEST_FULLURL);
                curl_setopt($curlDelete, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlDelete, CURLOPT_POST, true);
                curl_setopt($curlDelete, CURLOPT_POSTFIELDS, $xmlBodyDelete);
                curl_setopt($curlDelete, CURLOPT_SSL_VERIFYPEER, 0);

                //Запрос и обработка ответа
                $outDelete = curl_exec($curlDelete);

                echo 'Выгрузка прошла успешно, не удалось обновить элемент в системе';
            }
        } else {

            foreach($response->error as $error) {
                echo $error['msg'].'<br>';
            }

            $parent = CIBlockElement::Delete($shipment_id);

            curl_close($curl);
            die();
        }
    } else {
        echo 'Ошибка подключения к серверу Accordpost';
        CIBlockElement::Delete($shipment_id);
        curl_close($curl);
        die();
    }
    curl_close($curl);
}
?>
