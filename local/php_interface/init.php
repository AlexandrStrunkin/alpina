<?
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/.config.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/sailplay.php");

    //Подключим хендлеры для работы с остатками
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/exchange_1c_sync.php");
    //require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/iblock_element_edit_before_save.php");

//    file_exists('/home/bitrix/vendor/autoload.php') ? require '/home/bitrix/vendor/autoload.php' : "";
    file_exists('/var/www/alpinabook.ru/vendor/autoload.php') ? require '/var/www/alpinabook.ru/vendor/autoload.php' : "";
    use Mailgun\Mailgun;

    CModule::IncludeModule("blog");
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("sale");
    CModule::IncludeModule("catalog");
    CModule::IncludeModule("main");
    CModule::IncludeModule('highloadblock');
    use Bitrix\Sale;
    use Bitrix\Main;
    use Bitrix\Main\Loader;
    use Bitrix\Main\Localization\Loc;
    use Bitrix\Sale\Internals;
    use Bitrix\Highloadblock as HL;
    use Bitrix\Main\Entity;

    // ID раздела подборок на главной - из каталога книг
    define ("MAIN_PAGE_SELECTIONS_SECTION_ID", 209);
    define ("CATALOG_IBLOCK_ID", 4);
    define ("IBLOCK_ID_COURIER", 52);
    define ("AUTHORS_IBLOCK_ID", 29);
    define ("REVIEWS_IBLOCK_ID", 24);
    define ("SERIES_IBLOCK_ID", 45);
    define ("SPONSORS_IBLOCK_ID", 47);
    define ("PROPERTY_STATE_ID", 56); // свойство состояния статуса товара
    define ("WISHLIST_IBLOCK_ID", 17);
    define ("WISHLIST_LOGGER_IBLOCK_ID", 81);
    define ("EXPERTS_IBLOCK_ID", 23);
    define ("CATALOG_IBLOCK_ID_REMAINDER", 77);
    define ("LECTIONS_ANNOUNCES_IBLOCK_ID", 60);
    define ("EXPERTS_REVIEWS_IBLOCK_ID", 31);
    define ("SERIES_BANNERS_IBLOCK_ID", 54); // 53 - для тестовой копии
    define ("INFO_MESSAGES_IBLOCK_ID", 53); // 52 - для тестовой копии
    define ("SUSPENDED_BOOKS_BUYERS_IBLOCK", 55); // 54 - для тестовой копии
    define ("NEW_BOOK_STATE_XML_ID", 21);
    define ("STATUS_ORDER_SP", 438);
    define ("BESTSELLER_BOOK_XML_ID", 285);
    define ("COVER_TYPE_SOFTCOVER_XML_ID", 168);
    define ("COVER_TYPE_HARDCOVER_XML_ID", 169);
    define ("RFI_PAYSYSTEM_ID", 13);
    define ("PLATBOX_PAYSISTEM_ID", 24);
    define ("CASH_PAY_SISTEM_ID", 1);
    define ("PAYPAL_PAYSYSTEM_ID", 16);
    define ("SBERBANK_PAYSYSTEM_ID", 14);
    define ("CASHLESS_PAYSYSTEM_ID", 12);
    define ("EXPORTED_TO_GURU_PROPERTY_ID_NATURAL", 90); // физ. лицо
    define ("EXPORTED_TO_GURU_PROPERTY_ID_LEGAL", 91); // юр. лицо
    define ("PICKPOINT_DELIVERY_ID", 18);
    define ("CITY_INDIVIDUAL_ORDER_PROP_ID", 2);
    define ("CITY_ENTITY_ORDER_PROP_ID", 3);
    define ("ADDRESS_INDIVIDUAL_ORDER_PROP_ID", 5);
    define ("ADDRESS_ENTITY_ORDER_PROP_ID", 14);
    define ("SUSPENDED_BOOKS_PRICE_ID", 12);
    define ("PICKUP_DELIVERY_ID", 2);
    define ("GIFT_BOOK_PROPERTY_ID", 427); // 419 - для тестовой копии
    define ("GIFT_BOOK_QUANTITY_PROPERTY_ID", 428); // 420 - для тестовой копии
    define ("GIFT_BOOK_BUYER_EMAIL_PROPERTY_ID", 429);
    define ("GIFT_COUNPON_IBLOCK_ID", 51); //инфоблок, в котором хранится информация о подарочных сертификатах
    define ("RECURRENT_URL", "https://www.alpinabook.ru");
    define ("NATURAL_ENTITY_PERSON_TYPE_ID", 1);
    define ("LEGAL_ENTITY_PERSON_TYPE_ID", 2);
    define ("BIK_FOR_EXPENSE_OFFER", "044525716");
    define ("PROPERTY_SHOWING_DISCOUNT_ICON_VARIANT_ID", 350); // 354 - для тестовой копии
    define ("GURU_LEGAL_ENTITY_MAX_WEIGHT", 10000); // максимальный допустимый вес для юр. лиц у доставки гуру
    define ("TRADING_FINANCE_SECTION_ID", 111);
    define ("LOCATION_IMTERNATIONAL", 21279);
    define ("SECTION_ID_FOR_CHILDREN", 131);  // id раздела для детей и родителей
    define ("BOOK_COLOR_BLACK", 434300);
    define ("EVENT_SALE_STATUS_CHANGED_AR", 400);

    define ("GROUP_COURIER", 9);
    define ("DELIVERY_COURIER_1", 9);
    define ("DELIVERY_COURIER_2", 15);
    define ("DELIVERY_COURIER_MKAD", 12);
    define ("DELIVERY_PICKUP", 2);
    define ("DELIVERY_M", 21279);
    define ("DELIVERY_MAIL", 10);
    define ("DELIVERY_MAIL_2", 11);
    define ("DELIVERY_MAIL_3", 16);
    define ("DELIVERY_MAIL_4", 24);
    define ("DELIVERY_PICK_POINT", 18);
    define ("DELIVERY_FLIPOST", 30);
    define ("DELIVERY_BOXBERRY_PICKUP", 49);
    define ("DELIVERY_PICK_POINT2", 17);
    define ("GURU_DELIVERY_ID", 43);
    define ("FLIPPOST_ID", 30);
    define ("BOXBERY_ID", 50);

    define("WIDGET_PREVIEW_WIDTH", 70);
    define("WIDGET_PREVIEW_HEIGHT", 90);
    define("FREE_SHIPING", 2000); //стоимость заказа для бесплатной доставки
    define("BOXBERRY_DELIVERY_SUCCES", 'Выдано'); //Название статуса выдачи посылки в ответе API boxberry
    define("BOXBERRY_DELIVERED", 'Поступило в пункт выдачи'); //Название статуса поступления в ПВЗ в ответе API boxberry
    define("CERTIFICATE_SECTION_ID", 143); //Инфоблок с подарочными сертификатами
    define("MAIL_FROM_DEFAULT", 'shop@alpinabook.ru'); //Инфоблок с подарочными сертификатами

    define("CERTIFICATE_IBLOCK_ID", 68); //Инфоблок с заказами сертификатов/ для копии 67
    define("NEW_LEGAL_PERSON_CERTIFICATE_ORDER_EVENT", "LEGAL_NEW_CERTIFICATE"); // тип почтового события при покупке нового серификата юр лицом

    define("CERTIFICATE_NATURAL_PERSON_PROPERTY_ID", 910); //Тип покупателя физ.лицо для флага "Тип покупателя" в инфоблоке сертификатов, на копии 906
    define("CERTIFICATE_LEGAL_PERSON_PROPERTY_ID", 911); //Тип покупателя юр.лицо для флага "Тип покупателя" в инфоблоке сертификатов, на копии 907

    define("CERTIFICATE_ORDERS_COUPONS_ID_FIELD", 783); // Поле с идентификаторами купонов, на копии 766
    define("CERTIFICATE_ORDERS_COUPONS_CODE_FIELD", 784); // Поле с кодами купонов, на копии 767

    define("SEND_CERTIFICATE_TO_USER_EVENT", 'SEND_CERTIFICATE_TO_USER'); // Шаблон письма с отправкой сертификата пользователям

    define("SEARCH_INDEX_HL_ID", 3); //ID HL блока для поиска
    define("PREORDER_BASKET_HL_ID", 4); //ID HL блока хранения корзины до предзаказа
    define("CERTIFICATE_SECTION_ID", 143); //Инфоблок с подарочными сертификатами

    define ("DELIVERY_DATE_LEGAL_ORDER_PROP_ID", 45);
    define ("DELIVERY_DATE_NATURAL_ORDER_PROP_ID", 44);

    define ("PREORDER_STATUS_ID", 'PR');
    define ("ROUTE_STATUS_ID", 'I');  // в пути
    define ("ASSEMBLED_STATUS_ID", 'C');  // собран
    define ("STATUS_UNDER_ORDER", 'PZ');  // под заказ
    define ("STATUS_SERTIFICATE", 'OS');  // оплата сертификатом
    define ("DELIVERY_TIME", '12:00');  // Время

    define ("REISSUE_ID", 218); //ID свойства "Переиздание"
    define ("HIDE_SOON_ID", 357); //ID свойства "Не показывать в скоро в продаже"
    define ("STATE_SOON", 22); //ID состояния книги "Скоро в продаже"
    define ("UNDER_ORDER", 5844); //ID состояния книги "предзаказ"
    define ("PROP_NOVINKA_ID", 5971); //ID свойства книги "Новинка"
    define ("STATE_NULL", 23); //ID состояния книги "Нет в наличии"
    define ("STATE_NEWS", 21); //ID состояния книги "Новинка"
    define ("EXPERTS_IBLOCK_ID", 23); //ID инфоблока Эксперты
    define ("PAY_SYSTEM_RFI", 13); //ID платежный системы РФИ
	define ("PAY_SYSTEM_IN_OFFICE", 11); //ID платежный системы "При получении"

    define ("ADMIN_GROUP_ID", 1);
    define ("ECOM_ADMIN_GROUP_ID", 6);
    define ("GIFT_BAG_EXHIBITION", 331); // правило корзины Подарок: сумка с выставки ММКВЯ 2017
    define ("SALE_POPULAR_ELEMENT", 958); // свойство для обновления популярной книги
    define ("SHOW_ALWAYS_PROP_VALUE_ID", 15); // ID значения "Да" пользовательского поля "Показывать постоянно" для подборок на главной
    define ("MAIN_PAGE_SELECTIONS_SECTION_ID", 209); // ID раздела "Подборки книг на главной" инфоблока книг

    /**
    * Изменить на define() при апе до 7 версии PHP
    **/
    $orderListTemplates = array(16,178,344,380, STATUS_ORDER_SP); //Письма с составом заказа
    $paymentButtonTemplates = array(16,178); //Письма с кнопкой "оплатить"
    $latestBooksTemplates = array(16,160,168); //Письма с новинками
    /**
    * конец
    **/

    function arshow($array, $adminCheck = true, $dieAfterArshow = false) {
        global $USER;
        $USER = new Cuser;
        if ($adminCheck) {
            if (!$USER->IsAdmin()) {
                return false;
            }
        }
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        if ($dieAfterArshow) {
            die();
        }
    }
    function object_in_array($data) {
        if (is_array($data) || is_object($data))
        {
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = object_in_array($value);
            }
            return $result;
        }
        return $data;
    }

    /**
    *
    * @param mixed $data
    * @param string $file
    * @return void
    *
    * */

    function logger($data, $file) {
        file_put_contents(
            $file,
            var_export($data, 1)."\n",
            FILE_APPEND
        );
    }

    AddEventHandler('main', 'OnBeforeEventSend', 'addingTagParameterForTemplate');
    function addingTagParameterForTemplate ($arFields, $arTemplate) {
        if ($arTemplate["EVENT_NAME"] == "SUBSCRIBE_CONFIRM") {
            $arFields["TAG_MACROS"] = '$%my_tag%$';
        }
    }
    /**
    *
    * Отдельная функция для писем с вложениями, т.к. разобрать то, что шлет битрикс нереально
    * @param array $arFields,
    * @param array $arTemplate
    * @return bool
    *
    * */


    /**
    *
    * Кастомная функция отправки почты через Mailgun
    * @link https://documentation.mailgun.com/user_manual.html#sending-via-api
    *
    * @param string $to
    * @param string $subject
    * @param string $message
    * @param string $additional_headers
    * @param string $additional_parameters
    *
    **/
    /*  сторонний сервис отправки почты
    function custom_mail($to, $subject, $message, $additional_headers = "", $additional_parameters = '') {

       //logger($message, $_SERVER["DOCUMENT_ROOT"].'/logs/log_event.txt');
        if(strlen($message) > 1000) {
            $htmlStart = strripos($message, "8bit");
            $message = substr($message, $htmlStart);
            $htmlEnd = strripos($message, "---------");
            $message = substr($message, 5, -(strlen($message) - $htmlEnd ));
        }

        GLOBAL $arParams;
        // т.к. доп заголовки битрикс передает строкой, то придется их вырезать
        $from_pattern = "/(?<=From:)(.*)(?=)/";
        $bcc_pattern = "/(?<=BCC:)(.*)(?=)/";
        $cc_pattern = "/(?<=CC:)(.*)(?=)/";
        $from_matches = array();
        $bcc_matches = array();
        $macros_matches = array();
        preg_match($from_pattern, $additional_headers, $from_matches);
        preg_match($bcc_pattern, $additional_headers, $bcc_matches);
        preg_match($cc_pattern, $additional_headers, $cc_matches);

        preg_match('/\$\%(.*)\%\$/', $message, $macros_matches);
        if (!empty($macros_matches)) {
            $macros_value = $macros_matches[1];
        }
        $mailgun = new Mailgun(MAILGUN_KEY);

        $params = array(
            'from'	=> ($from_matches[0])?$from_matches[0]:MAIL_FROM_DEFAULT,
            'to'		=> $to,
            'subject' => $subject,
            'html'	=> $message
        );

		if ($macros_value)
            $params['o:tag'] = $macros_value;

        if (trim($bcc_matches[0])) {
            $params['bcc'] = $bcc_matches[0];
        }
        if (trim($bcc_matches[0])) {
            $params['cc'] = $cc_matches[0];
        }
        //$attachments = 'https://www.alpinabook.ru/img/twi.png';
        $domain = MAILGUN_DOMAIN;
        # Make the call to the client.
        $result = $mailgun->sendMessage($domain, $params, array('attachment' => $additional_headers));
    }
        */
    //Отрубаем отправку письма о "новом заказе" при офорлмении предзаказа
    function cancelMail(&$arFields, $arTemplate) {
        if ($arTemplate["ID"] == 16) {
            $order = CSaleOrder::GetByID($arFields["ORDER_ID"]);
            $rsBasket = CSaleBasket::GetList(array(), array("ORDER_ID" => $order["ID"]));
            while ($arBasket = $rsBasket->Fetch()) {
                $arBasketItems[] = $arBasket;
            }
            if (count($arBasketItems) == 1) {
                $basketItem = $arBasketItems;
                $basketItem = array_pop($basketItem);
                $itemID = $basketItem["PRODUCT_ID"];
                $res = CIBlockElement::GetList(Array(), Array("ID" => IntVal($itemID)), false, Array(), Array("ID", "PROPERTY_SOON_DATE_TIME", "PROPERTY_STATE", "PROPERTY_DELIVERY_TIME"));
                if ($arItem = $res->Fetch()) {
                     $arBasketItems[] = $arItem;
                }
            }
            if (count($arBasketItems) >= 1) {
                foreach($arBasketItems as $items){
                    if(intval($items["PROPERTY_STATE_ENUM_ID"]) == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "soon") || intval($items["PROPERTY_STATE_ENUM_ID"]) == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "under_order")){
                        $basketItem = $items;
                    }
                }
                if (intval($basketItem["PROPERTY_STATE_ENUM_ID"]) == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "soon")) {
                   // CEvent::Send("SALE_NEW_ORDER", 's1', $arTemplate, 423);
                    $arFields["DELIVERY_PREORDER"] = "<br>После поступления книги в продажу";
                    return true;
                } else if(intval($basketItem["PROPERTY_STATE_ENUM_ID"]) == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "under_order")) {
                    CSaleOrder::StatusOrder($arFields["ORDER_ID"], STATUS_UNDER_ORDER);
                    $template_event = array("ORDER_D" => $arFields["ORDER_ID"]);
                    CEvent::Send("UNDER_ORDER", 's1', $template_event);
                    $arFields["DELIVERY_PREORDER"] = '<br>Срок поставки '.$basketItem["PROPERTY_DELIVERY_TIME_VALUE"].' дней после оплаты';
                    return true;
                }
            };
        }
        return false;
    }



    /**
    * Дефолтные значения для флиппост на случай, если что-то пошло не так и цена доставки 0
    *
    * @return array
    * */
    function getDefaultFlippostValues() {
        return $flippost_default_values = array(
            array(
                "PRICE" => 1500.00,
                "WEIGHT" => array(0, 5000)
            ),
            array(
                "PRICE" => 3000.00,
                "WEIGHT" => 5000
            ),
        );
    }

    /**
    * Дефолтные значения для доставки гуру на случай, если что-то пошло не так и цена доставки 0
    *
    * @return array
    * */
    function getDefaultGuruValues() {
        return $guru_default_values = array(
            "PRICE" => 269,
            "TIME" => 0
        );
    }


    /**
    * Создаем ссылку для авторизации пользователя
    * */
    function createAuthLink($login,$page) {
        global $USER;
        $filter = Array(
            "ACTIVE"				=> "Y",
            "LOGIN"				=> $login
        );

        $rsUsers = CUser::GetList($by = 'ID', $order = 'ASC', $filter);

        if ($user = $rsUsers->Fetch()) {
            if (empty($page))
                $page = '/';

            $userID = $user[ID];

            return $_SERVER["SERVER_NAME"].$page.'?bx_hit_hash='.$USER->AddHitAuthHash($page, $userID);
        }
    }

    /**
    * Аналог функции isAdmin() для группы Администраторы интернет-магазина
    * */
    function isEcomAdmin() {
        global $USER;
        $userGroup = CUser::GetUserGroup($USER->GetID());
        if (in_array(ADMIN_GROUP_ID, $userGroup, true) || in_array(ECOM_ADMIN_GROUP_ID, $userGroup, true))
            return true;
    }



    /***************
    *
    * получение ID значения свойства "Состояние" из символьного кода этого значения
    *
    * @param int $iblockId - инфоблок, содержащий свойство
    * @param string $propCode - символьный код свойства
    * @param string $propXmlId - символьный код значения свойства
    *
    ***************/

    function getXMLIDByCode ($iblockId, $propCode, $propXmlId) {
        $iblockProps = CIBlockPropertyEnum::GetList (array(), array("IBLOCK_ID" => $iblockId, "CODE" => $propCode, "XML_ID" => $propXmlId));
        while ($iblockStateProp = $iblockProps -> Fetch()) {
            return $iblockStateProp["ID"];
        }
    }


    function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }
    /**
    * Проверка на мобильное устройство
    * */
    function checkMobile() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
            return true;
        else
            return false;
    }

    // -----> создаем свой формат выводимой даты доставки
    function date_day($day) {
        $date_prev = date("N", (time()+(3600*24)*$day)); // считаем через какое количество дней
        $date_N_today = date("N"); // определим какой сегодня день недели

        $day = $day + 2;
        if ($date_N_today == 7) {
            $day = $day;
        } else if ($date_N_today == 4) {
            $day = $day + 1;
        } else if ($date_N_today == 5) {
            $day = $day + 1;
        } else if ($date_N_today == 3) {
            $day = $day + 2;
        }

        if(strtotime($_SESSION["DATE_DELIVERY_STATE"])){
            $delivery_pre_order = strtotime($_SESSION["DATE_DELIVERY_STATE"]) + (3600*24)*2;
        } else {
            $delivery_pre_order = (time()+(3600*24)*$day);
        }

        $date_N = date("N", $delivery_pre_order); // считаем через какое количество дней
        $date_d = date("j", $delivery_pre_order);
        $date_n = date("n", $delivery_pre_order);
        $date_Y = date("Y", $delivery_pre_order);
        $month = array("","январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь");
        $days = array("","понедельник","вторник","среда","четверг","пятница","суббота","воскресенье");


        // формат вывода
        $date = $days[$date_N].', '.$date_d.' '.$month[$date_n].', '.$date_Y;
        return $date;
    } // -----> создаем свой формат выводимой даты доставки
    function date_day_courier($day) {
        $date_prev = date("N", (time()+(3600*24)*$day)); // считаем через какое количество дней
        $date_N_today = date("N"); // определим какой сегодня день недели

        /* if ($date_N_today == 5 || $date_N_today == 6) {
        $day = $day + 2;
        } else if ($date_N_today == 7) {
        $day = $day + 1;
        } else {
        $day = $day;
        }   */
        $object_date_close = CIBlockElement::GetList (
           Array("RAND" => "ASC"),
           Array("IBLOCK_ID" => IBLOCK_ID_DATE_DELIVERY_MOSCOW),
           false,
           false,
           array("NAME", "CODE")
        );
        global $close_date;
        global $open_date;
        while ($date_close = $object_date_close->Fetch()) {
            if($date_close["CODE"] == "close"){
                $close_date = explode(', ', $date_close["NAME"]);     // вытаскивает закрытые даты доставки
            } else {
                $open_date = explode(', ', $date_close["NAME"]);   // вытаскивает открытые даты доставки
            }
        }

        if (($date_N_today + $day == 6 || $date_N_today + $day == 7) && !in_array(date('j.n.Y'), $open_date)) {
            $day = $day + 2;
        }
        if(strtotime($_SESSION["DATE_DELIVERY_STATE"])){
            $delivery_pre_order = strtotime($_SESSION["DATE_DELIVERY_STATE"]) + (3600*24)*2;
        } else {
            $delivery_pre_order = (time()+(3600*24)*$day);
        }

        $date_N = date("N", $delivery_pre_order); // считаем через какое количество дней
        $date_d = date("j", $delivery_pre_order);
        $date_n = date("n", $delivery_pre_order);
        $date_Y = date("Y", $delivery_pre_order);
        $date_promt = date("d.m.Y", $delivery_pre_order);
        $date_deactive = array('29.04.2018', '30.04.2018', '01.05.2018', '02.05.2018', '09.05.2018');


        $month = array("","январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь");
        $days = array("","понедельник","вторник","среда","четверг","пятница","суббота","воскресенье");


        // формат вывода
        $date = $days[$date_N].', '.$date_d.' '.$month[$date_n].', '.$date_Y;
        return $date;
    }
    function date_day_today($day) {
        $date_prev = date("N"); // считаем через какое количество дней
        $date_H = date("H"); // текущее время

        if ($date_prev == 5 && $date_H > 17) {
            $day = $day + 2;
        } else if ($date_prev == 6) {
            $day = $day + 1;
        } else if ($date_prev == 7) {
            $day = $day;
        } else if ($date_H > 17) {
            $day = $day + 1;
        }

        if(strtotime($_SESSION["DATE_DELIVERY_STATE"])){
            $delivery_pre_order = strtotime($_SESSION["DATE_DELIVERY_STATE"]) + (3600*24)*2;
        } else {
            $delivery_pre_order = (time()+(3600*24)*$day);
        }
        $date_N = date("N", $delivery_pre_order); // считаем через какое количество дней
        $date_d = date("j", $delivery_pre_order);
        $date_n = date("n", $delivery_pre_order);
        $date_Y = date("Y", $delivery_pre_order);
        $month = array("","январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь");
        $days = array("","понедельник","вторник","среда","четверг","пятница","суббота","воскресенье");


        // формат вывода
        $date = $days[$date_N].', '.$date_d.' '.$month[$date_n].', '.$date_Y;
        return $date;
    }
    // <------ создаем свой формат выводимой даты доставки

    function searchNum2Str($num) {
        $nul='ноль';
        $ten=array(
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять')
        );
        $a20=array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens=array(2=>'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred=array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit=array( // Units
            //array('копейка', 'копейки', 'копеек',		1),
            //array('рубль', 'рубля', 'рублей'	,0),
            array('тысяча', 'тысячи', 'тысяч'		,-1),
            array('миллион', 'миллиона', 'миллионов',0),
            array('миллиард', 'милиарда', 'миллиардов',0),
        );
        //
        $number = sprintf("%012u", floatval($num));
        $out = array();
        if (intval($number)>0) {
            foreach(str_split($number,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender+1][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender+1][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>-2) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }

    //Дублируем email заказа в пользовательские поля
    AddEventHandler("sale", "OnOrderSave", "duplicateEmail");
    function duplicateEmail($orderId, $arFields) {
        if($orderId > 0) {
            $order = Bitrix\Sale\Order::load($orderId);
            $userType = $order->getPersonTypeId();
            $propertyCollection = $order->getPropertyCollection();
            $emailPropValue = $propertyCollection->getUserEmail();
            $email = $emailPropValue->getValue();
            if(!empty($email)) {
                if ($userType == LEGAL_ENTITY_PERSON_TYPE_ID) {
                    $cashEmailPropertyInstance = $propertyCollection->getItemByOrderPropertyId(ORDER_PROPS_CASH_EMAIL_ID_ENTITY);
                } else {
                    $cashEmailPropertyInstance = $propertyCollection->getItemByOrderPropertyId(ORDER_PROPS_CASH_EMAIL_ID_INDIVIDUAL);
                }
                $cashEmailPropertyInstance->setValue($email);
                $order->save();
            }
        }
    }

    AddEventHandler("sale", "OnOrderSave", "flippostHandler"); // меняем цену для flippost
    AddEventHandler("sale", "OnOrderSave", "flippostHandlerAfter"); // меняем адрес для flippost

    /**
    * Handler для доставки flippost. Плюсуем стоимость доставки
    *
    * @param array $arFields
    * @return void
    *
    * */
    function flippostHandler($orderId, $arFields) {
        if ($arFields['DELIVERY_ID'] == FLIPPOST_ID) {
            $delivery_price = 0;

            $flippost_default_values = getDefaultFlippostValues();
            if ($_REQUEST['flippost_cost']) {
                $delivery_price = $_REQUEST['flippost_cost'];
            } else {
                foreach ($flippost_default_values as $default_variant) {
                    if (is_array($default_variant['WEIGHT'])) {
                        if ((int)$arFields['ORDER_WEIGHT'] > $default_variant['WEIGHT'][0] && (int)$arFields['ORDER_WEIGHT'] <= $default_variant['WEIGHT'][1]) {
                            $delivery_price = $default_variant['PRICE'];
                            break;
                        }
                    } else {
                        if ($arFields['ORDER_WEIGHT'] > $default_variant['WEIGHT']) {
                            $delivery_price = $default_variant['PRICE'];
                            break;
                        }
                    }
                }
            }

            if($_REQUEST['flippost_cost']){
                // записываем стоимость доставки в отгрузку
                $order = Sale\Order::loadByAccountNumber($orderId);
                //и получаем Коллекцию Отгрузок текущего Заказа
                $shipmentCollection = $order->getShipmentCollection();

                foreach($shipmentCollection as $shipment) {
                     $shipment_id = $shipment->getId();

                     //пропускаем системные
                     if ($shipment->isSystem())
                      continue;

                     $arShipments[$orderId] = array(
                      'ID' => $shipment_id,
                      'ORDER_ID' => $shipment->getField('ORDER_ID'),
                      'DELIVERY_ID' => $shipment->getField('DELIVERY_ID'),
                      'PRICE_DELIVERY' => (float)$shipment->getField('PRICE_DELIVERY'),
                     );
                          $shipment->setField('BASE_PRICE_DELIVERY', $delivery_price);
                          $shipment->setField('CUSTOM_PRICE_DELIVERY', 'Y');
                          $order->save();
                 }
            }

        }

    }
    // изменяем статус для заказов с предзаказом
    AddEventHandler("sale", "OnBeforeOrderAdd", "statusUpdate");

    function statusUpdate(&$arFields){
        CModule::IncludeModule('iblock');
        CModule::IncludeModule('sale');
        $VALUES = 0;
        logger($arFields, $_SERVER["DOCUMENT_ROOT"].'/logs/status.txt');
        foreach($arFields["BASKET_ITEMS"] as $basket_item){

            $res = CIBlockElement::GetProperty(CATALOG_IBLOCK_ID, $basket_item["PRODUCT_ID"], array(), array("CODE" => "STATE"));
            if ($ob = $res->GetNext()) {
                if($ob["VALUE"] == STATE_SOON){
                    $VALUES += 1;
                }
            }
        }

        if($VALUES > 0){
            $arFields["STATUS_ID"] = "PR";
        }

    }


	function updateCumulativeDiscount($ID) {
		$arFilter = Array(
			"ID" => $ID
		);

		$rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);

		while ($arOrder = $rsSales->Fetch()) {

			$userGroup = CUser::GetUserGroup($arOrder["USER_ID"]);

			$domain = strstr(Message::getClientEmail($ID), '@');

			if (in_array(ADMIN_GROUP_ID, $userGroup) || in_array(ECOM_ADMIN_GROUP_ID, $userGroup) || $domain == "@alpina.ru" || $domain == "@alpinabook.ru") {
				continue;
			}

			$order = \Bitrix\Sale\Order::loadByAccountNumber($arOrder["ID"]);
			$discountList = $order->getDiscount()->getApplyResult();

			$rubcoupon = '';
			foreach($discountList["DISCOUNT_LIST"] as $oneDiscount) {
				if ($oneDiscount["REAL_DISCOUNT_ID"] == 129)
					unset($discountList["DISCOUNT_LIST"][$oneDiscount["ID"]]);

				if ($oneDiscount["ACTIONS_DESCR_DATA"]["BASKET"][0]["VALUE_TYPE"] == "S") {
					$rubcoupon = $oneDiscount["ID"];
					foreach ($discountList["COUPON_LIST"] as $oneCoupon) {
						if ($oneCoupon["ORDER_DISCOUNT_ID"] == $rubcoupon)
							$rubcoupon = $oneCoupon["COUPON"];
					}
					unset($discountList["DISCOUNT_LIST"][$oneDiscount["ID"]]);
				}
			}


			if (empty($discountList["DISCOUNT_LIST"])) {
				//$userDiscount = CCatalogDiscountSave::GetDiscount(array('USER_ID' => $arOrder["USER_ID"]));
				$userDiscount = CSaleUser::GetBuyersList(array(),array("USER_ID"=>$arOrder["USER_ID"]))->Fetch();

				if ($userDiscount["ORDER_SUM"] >= 5000) {
					if (!($basket = $order->getBasket())) {
					   throw new \Bitrix\Main\ObjectNotFoundException('Entity "Basket" not found');
					}

					$discount = $order->getDiscount();

					\Bitrix\Sale\DiscountCouponsManager::clearApply(true);
					\Bitrix\Sale\DiscountCouponsManager::clear(true);
					if ($rubcoupon != '') {
						\Bitrix\Sale\DiscountCouponsManager::add($rubcoupon);
					}

					if ($userDiscount["ORDER_SUM"] < 20000) {
						\Bitrix\Sale\DiscountCouponsManager::add("cumulativeDiscount10");
					} else {
						\Bitrix\Sale\DiscountCouponsManager::add("cumulativeDiscount20");
					}

					\Bitrix\Sale\DiscountCouponsManager::useSavedCouponsForApply(true);
					\Bitrix\Sale\DiscountCouponsManager::saveApplied(true);

					$discount->setOrderRefresh(true);
					$discount->setApplyResult(array());

					$basket->refreshData(array('PRICE', 'COUPONS'));
					$discount->calculate();
					$order->save();
				}
			}
		}
	}

    AddEventHandler("sale", "OnBeforeOrderAdd", "boxberyHandlerBefore"); // меняем цену для boxbery
    AddEventHandler("sale", "OnOrderSave", "boxberyHandlerAfter"); // меняем адрес для boxbery


    /**
    * Handler для доставки boxbery. Плюсуем стоимость доставки
    *
    * @param array $arFields
    * @return void
    *
    * */
    function boxberyHandlerBefore(&$arFields) {
        if ($arFields['DELIVERY_ID'] == BOXBERY_ID) {
            $delivery_price = 0;

            $boxbery_default_values = getDefaultFlippostValues();

            if ($_REQUEST['boxbery_cost']) {
                $delivery_price = $_REQUEST['boxbery_cost'];
            } else {
                foreach ($boxbery_default_values as $default_variant) {
                    if (is_array($default_variant['WEIGHT'])) {
                        if ((int)$arFields['ORDER_WEIGHT'] > $default_variant['WEIGHT'][0] && (int)$arFields['ORDER_WEIGHT'] <= $default_variant['WEIGHT'][1]) {
                            $delivery_price = $default_variant['PRICE'];
                            break;
                        }
                    } else {
                        if ($arFields['ORDER_WEIGHT'] > $default_variant['WEIGHT']) {
                            $delivery_price = $default_variant['PRICE'];
                            break;
                        }
                    }
                }
            }
            $arFields['PRICE_DELIVERY'] = floatval($delivery_price);
            if(floatval($delivery_price) <= 0 && $arFields["PRICE"] < 2000){
                //$arFields['PRICE_DELIVERY'] = 235;
                $arFields["PRICE_DELIVERY"] = 0;
                $arFields['PRICE'] += $arFields['PRICE_DELIVERY'];
            } else {
                $arFields['PRICE'] += floatval($delivery_price);
            }

        }
    }

    /**
    * Handler для доставки boxbery. Изменяем адрес
    *
    * @param array $arFields
    * @return void
    *
    * */
    function boxberyHandlerAfter($ID, $arFields) {
        GLOBAL $arParams;
        if ($arFields['DELIVERY_ID'] == BOXBERY_ID) {

            $arPropFields = array(
                "ORDER_ID" => $ID,
                "NAME" => $arParams["PICKPOINT"]["ADDRESS_TITLE_PROP"],
                "VALUE" => $_REQUEST['boxbery_address']
            );

            $arPropFields["ORDER_PROPS_ID"] = $arParams["PICKPOINT"]["NATURAL_ADDRESS_ID"];
            $arPropFields["CODE"] = $arParams["PICKPOINT"]["NATURAL_ADDRESS_CODE"];

            CSaleOrderPropsValue::Add($arPropFields);

        }
    }

    /**
    * Handler для доставки flippost. Изменяем адрес
    *
    * @param array $arFields
    * @return void
    *
    * */
    function flippostHandlerAfter($ID, $arFields) {
        GLOBAL $arParams;
        if ($arFields['DELIVERY_ID'] == FLIPPOST_ID) {
            $arPropFields = array(
                "ORDER_ID" => $ID,
                "NAME" => $arParams["PICKPOINT"]["ADDRESS_TITLE_PROP"],
                "VALUE" => $_REQUEST['flippost_address']
            );

            $arPropFields["ORDER_PROPS_ID"] = $arParams["PICKPOINT"]["NATURAL_ADDRESS_ID"];
            $arPropFields["CODE"] = $arParams["PICKPOINT"]["NATURAL_ADDRESS_CODE"];

            CSaleOrderPropsValue::Add($arPropFields);

        }
    }

    AddEventHandler("sale", "OnBeforeOrderAdd", "guruHandlerBefore"); // меняем цену для guru
    AddEventHandler("sale", "OnOrderSave", "guruHandlerAfter"); // меняем адрес для guru

    /**
    * Handler для доставки guru. Плюсуем стоимость доставки
    *
    * @param array $arFields
    * @return void
    *
    * */
    function guruHandlerBefore(&$arFields) {
        if ($arFields['DELIVERY_ID'] == GURU_DELIVERY_ID) {
            $delivery_price = $_REQUEST['guru_cost'];
            $arFields['PRICE'] += floatval($delivery_price);
            $arFields['PRICE_DELIVERY'] = floatval($delivery_price);
        }
    }

    /**
    * Handler для доставки guru. Изменяем адрес
    *
    * @param array $arFields
    * @return void
    *
    * */
    function guruHandlerAfter($ID, $arFields) {
        GLOBAL $arParams;
        if ($arFields['DELIVERY_ID'] == GURU_DELIVERY_ID) {
            $order_instance = Bitrix\Sale\Order::load($ID);
            // записываем тех данные в поле адреса id пункта самовывоза|дата доставки
            $property_collection = $order_instance->getPropertyCollection();
            if ($arFields['PERSON_TYPE_ID'] == LEGAL_ENTITY_PERSON_TYPE_ID) {
                $address_property_instance = $property_collection->getItemByOrderPropertyId(ADDRESS_ENTITY_ORDER_PROP_ID);
                $exported_to_dg_property_instance = $property_collection->getItemByOrderPropertyId(EXPORTED_TO_GURU_PROPERTY_ID_LEGAL);
            } else {
                $address_property_instance = $property_collection->getItemByOrderPropertyId(ADDRESS_INDIVIDUAL_ORDER_PROP_ID);
                $exported_to_dg_property_instance = $property_collection->getItemByOrderPropertyId(EXPORTED_TO_GURU_PROPERTY_ID_NATURAL);
            }
            $address_property_instance->setValue($_REQUEST['guru_delivery_data']);
            $exported_to_dg_property_instance->setValue("N");

            $order_instance->save();
        }
    }

    AddEventHandler("sale", "OnOrderSave", "boxberryDeliveryHandlerBefore"); // меняем цену для boxbery

    /**
    * Handler для доставки boxbery. Плюсуем стоимость доставки
    *
    * @param array $arFields
    * @return void
    *
    * */
    function boxberryDeliveryHandlerBefore($orderId, $arFields) {
        if ($arFields['DELIVERY_ID'] == BOXBERY_ID) {
            $delivery_price = $_REQUEST['boxbery_price'];
            if(floatval($delivery_price) <= 0 && $arFields['PRICE'] < 2000){
                $delivery_price = 235;
            }
            if($_REQUEST['boxbery_price']){
                // записываем стоимость доставки в отгрузку
                $order = Sale\Order::loadByAccountNumber($orderId);
                //и получаем Коллекцию Отгрузок текущего Заказа
                $shipmentCollection = $order->getShipmentCollection();

                foreach($shipmentCollection as $shipment) {
                     $shipment_id = $shipment->getId();

                     //пропускаем системные
                     if ($shipment->isSystem())
                      continue;

                     $arShipments[$orderId] = array(
                      'ID' => $shipment_id,
                      'ORDER_ID' => $shipment->getField('ORDER_ID'),
                      'DELIVERY_ID' => $shipment->getField('DELIVERY_ID'),
                      'PRICE_DELIVERY' => (float)$shipment->getField('PRICE_DELIVERY'),
                     );
                          $shipment->setField('BASE_PRICE_DELIVERY', $delivery_price);
                          $shipment->setField('CUSTOM_PRICE_DELIVERY', 'Y');
                          $order->save();
                 }
            }

        }
    }

    //Обновление заказа для доставки Boxberry
    AddEventHandler("sale", "OnOrderSave", "boxberryHandlerAfter"); // меняем адрес для boxberry


    /**
    * Handler для доставки boxberry. Изменяем адрес
    *
    * @param array $arFields
    * @return void
    *
    * */
    function boxberryHandlerAfter($orderId, $arFields) {
        GLOBAL $arParams;
        if ($arFields['DELIVERY_ID'] == BOXBERRY_PICKUP_DELIVERY_ID) {

            $delivery_price = $_REQUEST['boxberry_cost'];
            if(floatval($delivery_price) <= 0 && $arFields['PRICE'] < 2000){
                $delivery_price = 235;
            }

            if($_REQUEST['boxberry_cost']){
                // записываем стоимость доставки в отгрузку
                $order = Sale\Order::loadByAccountNumber($orderId);
                //и получаем Коллекцию Отгрузок текущего Заказа
                $shipmentCollection = $order->getShipmentCollection();

                foreach($shipmentCollection as $shipment) {
                     $shipment_id = $shipment->getId();

                     //пропускаем системные
                     if ($shipment->isSystem())
                      continue;

                     $arShipments[$orderId] = array(
                      'ID' => $shipment_id,
                      'ORDER_ID' => $shipment->getField('ORDER_ID'),
                      'DELIVERY_ID' => $shipment->getField('DELIVERY_ID'),
                      'PRICE_DELIVERY' => (float)$shipment->getField('PRICE_DELIVERY'),
                     );
                          $shipment->setField('BASE_PRICE_DELIVERY', $delivery_price);
                          $shipment->setField('CUSTOM_PRICE_DELIVERY', 'Y');
                          $order->save();
                 }
            }

            $order_instance = Bitrix\Sale\Order::load($orderId);
            // записываем тех данные в поле адреса id пункта самовывоза
            $property_collection = $order_instance->getPropertyCollection();
            if ($arFields['PERSON_TYPE_ID'] == LEGAL_ENTITY_PERSON_TYPE_ID) {
                $exported_to_dg_property_instance = $property_collection->getItemByOrderPropertyId(EXPORTED_TO_BOXBERRY_PROPERTY_ID_LEGAL);
            } else {
                $exported_to_dg_property_instance = $property_collection->getItemByOrderPropertyId(EXPORTED_TO_BOXBERRY_PROPERTY_ID_NATURAL);
            }
            $exported_to_dg_property_instance_value = $exported_to_dg_property_instance->GetValue();
            if (empty($exported_to_dg_property_instance_value)) {
                $exported_to_dg_property_instance->setValue("N");
            }
            $order_instance->save();
        }
    }

    //Create gift coupon after buy certificate
    AddEventHandler("sale", "OnOrderAdd", Array("Certificate", "GenerateGiftCoupon"));
    class Certificate {
        function GenerateGiftCoupon($ID, $arFields) {
            GLOBAL $APPLICATION;
            //Get gift certificate
            $db_res = CIBlockElement::GetList(Array("ID" => "ASC"), Array("SECTION_ID" => 143), false);
            while ($ar_res = $db_res->Fetch()) {
                $arDiscounts[$ar_res["ID"]]=$ar_res;
            }
            //Get items from order
            $dbItemsInOrder = CSaleBasket::GetList(array("ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(),"DELAY"=>'N', 'CAN_BUY'=>'Y', "ORDER_ID" => NULL));

            while ($arItemsInOrder = $dbItemsInOrder->Fetch()) {
                $arItems[$arItemsInOrder["PRODUCT_ID"]] = $arItemsInOrder;
                for ($x=0; $x<$arItemsInOrder["QUANTITY"]; $x++) {
                    if (in_array($arItemsInOrder["PRODUCT_ID"], array_keys($arDiscounts))) {
                        $dID=preg_replace("/[^0-9]/", '', $arDiscounts[$arItemsInOrder["PRODUCT_ID"]]["EXTERNAL_ID"]);
                        //Create coupon
                        Loader::includeModule('sale');
                        $couponTypeList = Internals\DiscountCouponTable::getCouponTypes(true);
                        $fields['DISCOUNT_ID'] = $dID;
                        $fields['COUPON'] = CatalogGenerateCoupon();
                        $fields['ACTIVE'] = "Y";
                        $fields['TYPE'] = 2;
                        $fields['MAX_USE'] = 1;
                        $result = Internals\DiscountCouponTable::add($fields);
                        $array = (array) $result;

                        //Write in infoblock
                        $arFields = array(
                            "ACTIVE" => "Y",
                            "IBLOCK_ID" => GIFT_COUNPON_IBLOCK_ID,
                            "NAME" => $arDiscounts[$arItemsInOrder["PRODUCT_ID"]]["NAME"],
                            "PROPERTY_VALUES" => array(
                                "ORDER" => $ID,
                                "COUPON" => current($array),
                                "CODE" => $fields['COUPON'],
                                "SEND" => "N"
                            )
                        );
                        $oElement = new CIBlockElement();
                        $idElement = $oElement->Add($arFields, false, false, true);
                    }
                }
            }
        }
    }

    //обработка статусов заказа при получении оплаты
    AddEventHandler('sale', 'OnSalePayOrder', "UpdOrderStatus");
    function UpdOrderStatus ($ID, $val) {

        $arStatus = array("D", "K", "F"); //статусы заказа "оплачен", "отправлен на почту" РФ и "выполнен"
        //при получении оплаты
        if ($val == "Y") {
            $order = CSaleOrder::GetById($ID);
            //если текущий статус закана - не один из трех вышеперечисленных, ставим статус "оплачен"
            if (!in_array($order["STATUS_ID"],$arStatus)) {
                $order_list = CSaleOrder::GetByID($ID);
                $allBooksUrl = '';
                $bookId = '';
                $recId = '';
                $sendinfo = '';

                $orderUser = CUser::GetByID($order_list['USER_ID'])->Fetch();
                if (!empty($orderUser["UF_TEST"])) {
                    $allUrlsArray = unserialize($orderUser["UF_TEST"]);
                } else {
                    $allUrlsArray = array();
                }
                $dbBasketItems = CSaleBasket::GetList(array(), array("ORDER_ID" => $ID), false, false, array());

                $ids = '';
                while ($arItems = $dbBasketItems->Fetch()) {
                    if ($arItems["PRODUCT_ID"] != '186046' && $arItems["PRODUCT_ID"] != '372526') {
						$mainID = CIBlockElement::GetList(Array(), array("ID" => $arItems["PRODUCT_ID"]), false, false, array("ID", "PROPERTY_MAIN_APP_ID"))->Fetch();

                        $ids .= $mainID["PROPERTY_MAIN_APP_ID_VALUE"] ? $mainID["PROPERTY_MAIN_APP_ID_VALUE"].',' : $arItems["PRODUCT_ID"].',';
                    }
                }
                $products = getUrlForFreeDigitalBook(substr($ids,0,-1));

                if ($products['url'] != 'error') {
                    $allUrlsArray[] = array("orderid" => $ID, "products" => $products);

                    $sendinfo .= '<ol>';

                    foreach($products['products'] as $product) {
                        if ($product['status'] == 'ok') {
                            $sendinfo .= '<li style="padding-top:5px;">'.$product['name'].'</li>';
                        } else {
                            $sendinfo .= '<li style="padding-top:5px;">Вместо книги «'.$product['name'].'», которой нет в наличии, мы дарим вам книгу «'.$product['recname'].'»</li>';
                        }
                    }

                    $sendinfo .= '</ol>';

                    $links = serialize($allUrlsArray);

                    $fieldsGend = Array(
                        "UF_TEST"						=> $links
                    );
                    $userGend = new CUser;
                    $userGend->Update($order_list['USER_ID'], $fieldsGend);

                    $freeurl = $products['url'];
                    $useremail = Message::getClientEmail($ID);
                } else {
                    $freeurl = 'К сожалению, произошла ошибка. В ближайшее время специалист свяжется с вами и поможет получить бесплатные книги.';
                    $useremail = 'shop@alpinabook.ru';
                }
                $mailFields = array(
                    //"EMAIL" => "a-marchenkov@yandex.ru, a.limansky@alpina.ru, t.razumovskaya@alpinabook.ru, karenshain@gmail.com, sarmat2012@yandex.ru",
                    "EMAIL"=> $useremail,
                    "TEXT" => $sendinfo,
                    "URL" => $freeurl,
                    "ORDER_ID" => $ID,
                    "ORDER_USER"=> Message::getClientName($ID)
                );

				CEvent::Send("FREE_DIGITAL_BOOKS", "s1", $mailFields, "N");

                if($order_list["PAY_SYSTEM_ID"] == RFI_PAYSYSTEM_ID &&
                    ($order_list["DELIVERY_ID"] == DELIVERY_COURIER_1 ||
                     $order_list["DELIVERY_ID"] == DELIVERY_COURIER_2 ||
                     $order_list["DELIVERY_ID"] == DELIVERY_COURIER_MKAD) &&
                     $order_list["STATUS_ID"] == ROUTE_STATUS_ID){

                        $arFields = array(
                            "ID"=> $ID,
                        );
                        CEvent::Send("NOTICE_OF_PAYMENT", "s1", $arFields, "N");
                } else if($order_list["STATUS_ID"] == ASSEMBLED_STATUS_ID){
                    CSaleOrder::StatusOrder($ID, ASSEMBLED_STATUS_ID);
                } else if($order_list["STATUS_ID"] == "PZ"){
                    CSaleOrder::StatusOrder($ID, "PZ");
                } else {
                    CSaleOrder::StatusOrder($ID, "D");
                    CSaleOrder::PayOrder($ID, "Y", false, false, 0);
                }
                    logger(date().' '.$order_list, $_SERVER["DOCUMENT_ROOT"].'/logs/UpdOrderStatus_log_3.txt');

            }
        }


        //Create gift coupon after buy certificate
        $IBLOCK_ID = GIFT_COUNPON_IBLOCK_ID;
        if ($val=='Y') {
            GLOBAL $APPLICATION;
            //Get gift certificate
            $db_res = CIBlockElement::GetList(Array("ID" => "ASC"), Array("SECTION_ID" => "143", "ACTIVE" => 'Y'), false);
            while ($ar_res = $db_res->Fetch()) {
                $arDiscounts[$ar_res["ID"]]=$ar_res;
            }

            //Get items from order
            $dbItemsInOrder = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $ID));
            while ($arItemsInOrder = $dbItemsInOrder->Fetch()) {
                $arItems[$arItemsInOrder["PRODUCT_ID"]]=$arItemsInOrder;
                if (in_array($arItemsInOrder["PRODUCT_ID"], array_keys($arDiscounts))) {
                    $dbDis = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => $IBLOCK_ID, "ORDER" => $ID), false);
                    while ($arDis = $dbDis->Fetch()) {
                        $db_props = CIBlockElement::GetProperty($IBLOCK_ID, $arDis["ID"], array("sort" => "asc"), Array("CODE" => "ORDER"));
                        if ($ar_props = $db_props->Fetch()) {
                            if ($ar_props["VALUE"]==$ID) {
                                $db_prop = CIBlockElement::GetProperty($IBLOCK_ID, $arDis["ID"], array("sort" => "asc"), Array("CODE" => "SEND"));
                                if ($ar_prop = $db_prop->Fetch()) {
                                    if ($ar_prop["VALUE"]=='N') {
                                        $dbprop = CIBlockElement::GetProperty($IBLOCK_ID, $arDis["ID"], array("sort" => "asc"), Array("CODE" => "COUPON"));
                                        if ($arprop = $dbprop->Fetch()) {

                                            $filter=array('=ID' => $arprop["VALUE"]);

                                            $discountIterator = Internals\DiscountCouponTable::getList(array(
                                                'select' => array('ID', 'COUPON'),
                                                'filter' => $filter
                                            ));
                                            $arCoupon = $discountIterator->fetch();
                                            $dbpr = CSaleOrderPropsValue::GetOrderProps($ID);

                                            $EMAIL = "";
                                            while ($arProps = $dbpr->Fetch()) {
                                                if ($arProps["CODE"] == "EMAIL" || $arProps["CODE"] == "F_EMAIL") {
                                                    $EMAIL = $arProps["VALUE"];
                                                }
                                            }
                                            //form date of activity certificate
                                            $couponTypeList = Internals\DiscountCouponTable::getCouponTypes(true);
                                            $active_from= date('d.m.Y G:i:s');
                                            $active_to=date('d.m.Y G:i:s', strtotime(date('d.m.Y G:i:s').'+6 month'));

                                            $arEventFields = array(
                                                "EMAIL_TO" => $EMAIL,
                                                "CODE_CERTIFICATE" => $arCoupon["COUPON"],
                                                "ACTIVE_FROM" => $active_from,
                                                "ACTIVE_TO" => $active_to
                                            );
                                            $arrSITE = CAdvContract::GetSiteArray($CONTRACT_ID);
                                            CEvent::Send("SEND_GIFT_CERTIFICATE", "s1", $arEventFields, 'Y', "164");

                                            //when send mail coupon active six months
                                            $fields['ACTIVE_FROM'] = \Bitrix\Main\Type\DateTime::createFromUserTime($active_from);
                                            $fields['ACTIVE_TO'] = \Bitrix\Main\Type\DateTime::createFromUserTime($active_to);
                                            $result = Internals\DiscountCouponTable::update($arCoupon["ID"], $fields);

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    //обработка флага оплаты, при изменении статусов заказа
    AddEventHandler('sale', 'OnSaleStatusOrder', "triggerLogic");

    function triggerLogic ($ID, $val) {
        $arStatus = array("D", "K", "F"); //статусы заказа "оплачен", "отправлен на почту" РФ и "выполнен"
        //если установлен один из вышеуказанных статусов
        if (in_array($val, $arStatus)) {
            $order = CSaleOrder::GetById($ID);
            //если флаг оплаты не стоит - ставим
            if ($order["PAYED"] != "Y") {
                $order_list = CSaleOrder::GetByID($ID);
                $allBooksUrl = '';
                $bookId = '';
                $recId = '';
                $sendinfo = '';

                $orderUser = CUser::GetByID($order_list['USER_ID'])->Fetch();
                if (!empty($orderUser["UF_TEST"])) {
                    $allUrlsArray = unserialize($orderUser["UF_TEST"]);
                } else {
                    $allUrlsArray = array();
                }
                $dbBasketItems = CSaleBasket::GetList(array(), array("ORDER_ID" => $ID), false, false, array());

                $ids = '';
                while ($arItems = $dbBasketItems->Fetch()) {
					$mainID = CIBlockElement::GetList(Array(), array("ID" => $arItems["PRODUCT_ID"]), false, false, array("ID", "PROPERTY_MAIN_APP_ID"))->Fetch();

					$ids .= $mainID["PROPERTY_MAIN_APP_ID_VALUE"] ? $mainID["PROPERTY_MAIN_APP_ID_VALUE"].',' : $arItems["PRODUCT_ID"].',';
                }

                $products = getUrlForFreeDigitalBook(substr($ids,0,-1));

                if ($products['url'] != 'error') {
                    $allUrlsArray[] = array("orderid" => $ID, "products" => $products);

                    $sendinfo .= '<ol>';

                    foreach($products['products'] as $product) {
                        if ($product['status'] == 'ok') {
                            $sendinfo .= '<li style="padding-top:5px;">'.$product['name'].'</li>';
                        } else {
                            $sendinfo .= '<li style="padding-top:5px;">Вместо книги «'.$product['name'].'», которой нет в наличии, мы дарим вам книгу «'.$product['recname'].'»</li>';
                        }
                    }

                    $sendinfo .= '</ol>';

                    $links = serialize($allUrlsArray);

                    $fieldsGend = Array(
                        "UF_TEST"						=> $links
                    );
                    $userGend = new CUser;
                    $userGend->Update($order_list['USER_ID'], $fieldsGend);

                    $freeurl = $products['url'];

                    $useremail = Message::getClientEmail($ID);
                } else {
                    $freeurl = 'К сожалению, произошла ошибка. В ближайшее время специалист свяжется с вами и поможет получить бесплатные книги.';
                    $useremail = 'shop@alpinabook.ru';
                }
                $mailFields = array(
                    //"EMAIL" => "a-marchenkov@yandex.ru, a.limansky@alpina.ru, t.razumovskaya@alpinabook.ru, karenshain@gmail.com, sarmat2012@yandex.ru",
                    "EMAIL"=> $useremail,
                    "TEXT" => $sendinfo,
                    "URL" => $freeurl,
                    "ORDER_ID" => $ID,
                    "ORDER_USER"=> Message::getClientName($ID)
                );

				CEvent::Send("FREE_DIGITAL_BOOKS", "s1", $mailFields, "N");


                // при смене статуса и последующего автоматического CSaleOrder::PayOrder
                // не срабатывает хендлер OnSalePayOrder, поэтому применяем выполнение функции здесь после оплаты

                if (CSaleOrder::PayOrder($ID, "Y", false, false, 0)) {
                    UpdOrderStatus($ID, "Y");
                }
            }

        }


        //----- Отправка смс при изменении статуса заказа
        if (array_key_exists($val,Message::$messages)) {
            if ($val=="C") { // ---- статус собран может быть только для заказов с самовывозом
                if (Message::getOrderDeliveryType($ID)==2) {
                    $message = new Message();
                    $order = CSaleOrder::GetById($ID);
                    if($_SESSION["MESSAGE_STATE"] != $val || $_SESSION["MESSAGE_ORDER"] != $ID || $_SESSION["MESSAGE_PRICE"] != $order['PRICE']){
                        $result = $message->sendMessage($ID,$val,'',$order['PRICE']);
                    }


                }
            } else if($val=="N"){
                $message = new Message();
                if($_SESSION["MESSAGE_STATE"] != $val || $_SESSION["MESSAGE_ORDER"] != $ID){
                    $result = $message->sendMessage($ID,$val);
                }
            } else if($val=="SP"){
                $message = new Message();
                if($_SESSION["MESSAGE_STATE"] != $val || $_SESSION["MESSAGE_ORDER"] != $ID){
                    $result = $message->sendMessage($ID,$val);
                }
            } elseif (($val=="A")) {
				$message = new Message();
                if($_SESSION["MESSAGE_STATE"] != $val || $_SESSION["MESSAGE_ORDER"] != $ID){
                    $result = $message->sendMessage($ID,$val);
                }
			} else if($val == "I"){
                $order = CSaleOrder::GetById($ID);
                $message = new Message();
                $ar_courier = array();
                if($_SESSION["MESSAGE_STATE"] != $val || $_SESSION["MESSAGE_ORDER"] != $ID){
                    $arSelect_courier = Array("ID", "PROPERTY_COURIRER");
                    $arFilter_courier = Array("IBLOCK_ID"=>IBLOCK_ID_COURIER, "ACTIVE"=>"Y", "NAME" => $ID);
                    $res_courier = CIBlockElement::GetList(Array(), $arFilter_courier, false, false, $arSelect_courier);
                    if ( $courier = $res_courier->Fetch() ) {
                        $user_ar = CUser::GetByID($courier["PROPERTY_COURIRER_VALUE"])->Fetch();
                        $ar_courier["CUR"]["NAME"] = $user_ar["NAME"];
                        $ar_courier["CUR"]["PHONE"] = $user_ar["LAST_NAME"];
                    }

                    if(!empty($ar_courier)){
                        logger($ar_courier["CUR"]["NAME"],$_SERVER["DOCUMENT_ROOT"].'/logs/log_courier.txt' );
                        $result = $message->sendMessage($ID,$val,$ar_courier,'');
                    } else if($order["TRACKING_NUMBER"]){
                        $result = $message->sendMessage($ID,$val,'','',$order["TRACKING_NUMBER"]);
                    }
                }
            } else if($val == "AR"){
                $message = new Message();
                if($_SESSION["MESSAGE_STATE"] != $val || $_SESSION["MESSAGE_ORDER"] != $ID){
                    $result = $message->sendMessage($ID,$val);
                }
            }
            $_SESSION["MESSAGE_STATE"] = $val;
            $_SESSION["MESSAGE_PRICE"] = $order['PRICE'];
            $_SESSION["MESSAGE_ORDER"] = $ID;

            logger(date('d.m.Y H:i:s').': '.$result,$_SERVER["DOCUMENT_ROOT"].'/logs/log1_sms.txt' );
        }

        //----- Триггерные письма при изменении статуса заказа
        if ($val=="C") { // Статус собран
            if (Message::getOrderDeliveryType($ID)==2) { //2 - ID службы доставки "самовывоз"
                $arEventFields = array(
                    "EMAIL"=> Message::getClientEmail($ID),
                    "ORDER_USER"=> Message::getClientName($ID),
                    "ORDER_ID"=> $ID

                );
                CEvent::Send("SALE_STATUS_CHANGED_C_NEW", "s1", $arEventFields,"N");
            }
        } elseif ($val=="D") { // Статус оплачен
            if (Message::getOrderDeliveryType($ID) == 2) { // самовывоз
                $orderPayInfo = 'По вашему заказу поступила оплата. Он будет собран в течение двух рабочих часов.';
            } elseif (Message::getOrderDeliveryType($ID) == 17) { // PickPoint
                $orderPayInfo = 'По вашему заказу поступила оплата. Он будет собран и передан в службу доставки <a href="http://pickpoint.ru/" target="_blank">PickPoint</a>.';
            } elseif (in_array(Message::getOrderDeliveryType($ID), array(12,13,14,15))) { // Курьерская доставка
                $orderPayInfo = 'По вашему заказу поступила оплата. Он будет собран и передан курьеру. Ожидайте звонок представителя курьерской службы в день доставки.';
            } elseif (in_array(Message::getOrderDeliveryType($ID), array(49))) { // Boxberry
                $orderPayInfo = 'По вашему заказу поступила оплата. Он будет собран и передан в службу доставки <a href="http://boxberry.ru/" target="_blank">Boxberry</a>.';
            } else {
                $orderPayInfo = 'По вашему заказу поступила оплата. Он будет собран и передан в службу доставки.';
            }

            $arEventFields = array(
                "EMAIL" => Message::getClientEmail($ID),
                "ORDER_USER" => Message::getClientName($ID),
                "ORDER_ID" => $ID,
                "ORDER_PAY_INFO" => $orderPayInfo

            );
            CEvent::Send("ORDER_PAYED_MANUAL", "s1", $arEventFields,"N");
        } elseif ($val=="RT") {
            UpdOrderStatus($ID, "F");
        }
    }

    //Получаем ссылку на бесплатную книгу в приложении Бизнес книги
    function getUrlForFreeDigitalBook($productID) {
        $ids = explode(',', $productID);
        $forurl = array();
        $products = array();

        foreach ($ids as $checkbook) {

            $name = CIBlockElement::GetByID($checkbook)->Fetch();
            $name = $name['NAME'];
            $existinstore = CIBlockElement::GetProperty(4, $checkbook, array("sort" => "asc"), Array("CODE" => "appstore"))->Fetch();

            if ($existinstore[VALUE] == 231) {
                $products[] = array('id' => $checkbook, 'status' => 'ok', 'name' => $name, 'rec' => '', 'recname' => '');
                $forurl[] = $checkbook;
            }/* else {
            $recid = CIBlockElement::GetProperty(4, $checkbook, array("sort" => "asc"), Array("CODE" => "rec_for_ad"))->Fetch();
            if ($recid[VALUE]) {
            $recname = CIBlockElement::GetByID($recid[VALUE])->Fetch();
            $recname = $recname['NAME'];
            $products[] = array('id' => $checkbook, 'status' => 'rec', 'name' => $name, 'rec' => $recid[VALUE], 'recname' => $recname);
            $forurl[] = $recid[VALUE];
            }
            }*/
        }

        $prepareurl = '';
        foreach ($forurl as $m => $urlid) {
            if ($m == 0) {
                $prepareurl .= '?emag_id[]='.$urlid;
            } else {
                $prepareurl .= '&emag_id[]='.$urlid;
            }
        }
        $freeBookUrl = array();

        $url = "https://api5.alpinadigital.ru/api/v1/gift/emag/".$prepareurl;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                "Content-type: application/json",
                "X-AD-Offer: 1",
                "X-AD-Token: a893c81321e1693e0caad8a6a1a6077c"
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $outputRes = json_decode(preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
            }, $output));
        $output = get_object_vars($outputRes[0]);

        if (isset($output["url"])) {
            $freeBookUrl = array('url' => $output["url"], 'products' => $products);
        } else {
            $freeBookUrl = array('url' => 'error', 'products' => $products);
        }

        return $freeBookUrl;
    }

    //Work of custom coupon
    AddEventHandler("sale", "OnBeforeOrderAdd", Array("changeOrderPrice", "changingOrderPriceOnCustomCoupon"));

    AddEventHandler("sale", "OnOrderAdd", Array("changeOrderPrice", "OnOrderCustomCouponHandler"));

    class changeOrderPrice {
        function changingOrderPriceOnCustomCoupon(&$arFields) {
            if ($_SESSION["CUSTOM_COUPON"]["DEFAULT_COUPON"] == "N") {
                $newPrice = $arFields["PRICE"] - $arFields["DISCOUNT_VALUE"] - (float)$_SESSION["CUSTOM_COUPON"]["COUPON_VALUE"];

                if ($newPrice < 0) {
                    $newPrice = 0;
                    $newPrice = $newPrice + $arFields["PRICE_DELIVERY"];
                }
                $arFields["PRICE"] = $newPrice;
            }
        }

        function OnOrderCustomCouponHandler($ID, $arFields) {
            if ($_SESSION["CUSTOM_COUPON"]["DEFAULT_COUPON"] == "N") {
                //Update coupon
                Loader::includeModule('sale');
                $couponTypeList = Internals\DiscountCouponTable::getCouponTypes(true);
                $fields['ACTIVE'] = "N";
                $result = Internals\DiscountCouponTable::update($_SESSION["CUSTOM_COUPON"]["COUPON_ID"], $fields);
                unset ($_SESSION["CUSTOM_COUPON"]);
            }
        }
    }

    // склонение существительных после чисел (например - товар, товара, товаров)

    function format_by_count($count, $form1, $form2, $form3) {
        $count = abs($count) % 100;
        $lcount = $count % 10;
        if ($count >= 11 && $count <= 19) return($form3);
        if ($lcount >= 2 && $lcount <= 4) return($form2);
        if ($lcount == 1) return($form1);
        return $form3;
    }

    /*AddEventHandler('iblock', 'OnAfterIBlockElementAdd', "my_OnAfterIBlockElementAdd");

    function my_OnAfterIBlockElementAdd(&$arFields) {
        if ($arFields["IBLOCK_ID"] == 12) {
            $elem = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arFields["IBLOCK_ID"], "ID" => $arFields["ID"]), false, false, array("ID", "NAME", "PROPERTY_email", "PROPERTY_phone", "PROPERTY_message"));
            while ($elem_info = $elem -> Fetch()) {
                $mailFields = array(
                    "EMAIL_TO" => "shop@alpina.ru",
                    "AUTHOR" => $elem_info["NAME"],
                    "AUTHOR_EMAIL" => $elem_info["PROPERTY_EMAIL_VALUE"],
                    "AUTHOR_PHONE" => $elem_info["PROPERTY_PHONE_VALUE"],
                    "TEXT" => $elem_info["PROPERTY_MESSAGE_VALUE"],
                    "REQUEST_ID" => $elem_info["ID"]
                );
            }
            CEvent::Send("FEEDBACK_FORM", "s1", $mailFields, "N");
        }
        //РїРѕР»СѓС‡РёРј СЃРѕРѕР±С‰РµРЅРёРµ

    }*/


    //подмена логина на EMAIL
    AddEventHandler("main", "OnBeforeUserRegister", Array("OnBeforeUserRegisterHandler", "OnBeforeUserRegister"));
    class OnBeforeUserRegisterHandler {
        function OnBeforeUserRegister(&$arFields) {
           // $arFields['LOGIN'] = $arFields['EMAIL'];
            logger(date('d.m.Y H:i').' '.implode(', ', $arFields), $_SERVER["DOCUMENT_ROOT"].'/logs/user_mail.txt');
           // return $arFields;
        }
    }

    //Handler switch on iml delivery service for cities
    AddEventHandler('ipol.iml', 'onCompabilityBefore', 'onCompabilityBeforeIML');

    //Switch on iml delivery service for cities
    function onCompabilityBeforeIML($order, $conf, $keys) {
        //Check is current location switched-on for IML delivery
        $obImlCity = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => "37", "ACTIVE" => 'Y', "PROPERTY_ID_CITY"=>$order["LOCATION_TO"]), false, false, array("ID", "IBLOCK_ID", "NAME", "PROPERTY_ID_CITY", "PROPERTY_SWITCH_PICKUP", "PROPERTY_SWITCH_COURIER"));
        $arImlCity = $obImlCity->Fetch();
        if (!empty($arImlCity["ID"])) {
            //Forming switched-on delivery type's
            if (!empty($arImlCity["PROPERTY_SWITCH_COURIER_VALUE"])) {
                $profilesName[]="courier";
            }
            if (!empty($arImlCity["PROPERTY_SWITCH_PICKUP_VALUE"])) {
                $profilesName[]="pickup";
            }
            //Check is delivery type is enable
            foreach ($profilesName as $profile) {
                if (in_array($profile,$keys)) {
                    $profileResult[]=$profile;
                }
            }
            //Return result
            if (!empty($profileResult)) {
                return $profileResult;
            } else {
                return false;
            }
        }
        return false;
    }

    AddEventHandler("main", "OnAfterUserRegister", Array("AlpinaBK", "sendUserToBK"));
    AddEventHandler("main", "OnAfterUserUpdate", Array("AlpinaBK", "updateUserPassword"));
    AddEventHandler("main", "OnBeforeUserLogin", Array("AlpinaBK", "checkUserBeforeLogin"));

    // общий класс для методов, связанных с бизнес книгами
    class AlpinaBK {

        /**
        *
        * Регистрируем нового пользователя в БК после регистрации на сайте
        *
        * */
        public static function sendUserToBK($arFields) {
            $postdata = http_build_query(
                array(
                    'method' => 'sendUserToBK',
                    'token' => BK_TOKEN,
                    'email' => $arFields['EMAIL'],
                    'password' => $arFields['PASSWORD'],
                    'name' => $arFields['NAME'] . " " . $arFields['LAST_NAME']
                )
            );

            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );

            $context = stream_context_create($opts);
            $result = file_get_contents('https://www.alpinabook.ru/api/user/', false, $context);
        }

        /**
        *
        * При сбросе пароля ищем пользователя в БК, если он там есть, то меняем ему пароль на такой же,
        * если нет, то регистрируем нового пользователя в БК
        *
        * @param array $fields
        *
        * */
        public static function updateUserPassword(&$fields) {
            // проверяем, что сбрасывают именно пароль
            if ($fields['PASSWORD'] && $fields['CONFIRM_PASSWORD'] && $fields['RESULT']) {
                // получение данных пользователя
                $user = CUser::GetByID($fields['ID']);
                $user = $user->Fetch();
                // --- запрос на существование пользователя в БК ---
                $data = array(
                    'email' => $user['EMAIL']
                );
                ksort($data);

                $string_to_hash = http_build_query($data);
                $sig = md5($string_to_hash . BK_API_SECRET_KEY);

                $data['sig'] = $sig;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, BK_REQUESTS_URL . 'b2b/users?' . http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'X-Auth-Token: ' . BK_API_TOKEN,
                ));
                $data = curl_exec($ch);
                curl_close($ch);
                // --- запрос на существование пользователя в БК ---
                $user = json_decode($data, true);
                if ($user[0]['id']) {
                    // если пользователь есть, то сбросим пароль
                    $data = array(
                        'password' => $fields['CONFIRM_PASSWORD']
                    );
                    ksort($data);

                    $string_to_hash = http_build_query($data);
                    $sig = md5($string_to_hash . BK_API_SECRET_KEY);

                    $data['sig'] = $sig;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, BK_REQUESTS_URL . 'b2b/users/' . $user[0]['id']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'X-Auth-Token: ' . BK_API_TOKEN,
                    ));
                    $data = curl_exec($ch);
                    curl_close($ch);
                    // --- запрос сброс пароля в БК ---
                } else {
                    // если нет, то создадим
                    self::sendUserToBK(array(
                        "EMAIL"		=> $user['EMAIL'],
                        "PASSWORD" => $fields['CONFIRM_PASSWORD'],
                        "NAME"		=> $user['NAME'],
                        "LAST_NAME" => $user['LAST_NAME']
                    ));
                }
            }
        }

        /**
        *
        * Реализация единого алгоритма авторизации
        *
        * @param array $fields
        *
        * */
        public static function checkUserBeforeLogin(&$fields) {
            // пробуем найти юзера в битрикс
            $users = CUser::GetList(
                ($by = "id"),
                ($order = "asc"),
                array(
                    "=EMAIL" => $fields['LOGIN'] // stristr($fields['LOGIN'], '@', true)
                ),
                array(
                    "FIELDS" => array("ID", "EMAIL", "PASSWORD")
                )
            );
            // если пользователь найден, то дальше работает с ним
            if ($user = $users->Fetch()) {
                $current_hash = $user['PASSWORD'];
                $password = $fields['PASSWORD'];
                $salt = substr($current_hash, 0, (strlen($current_hash) - 32));

                $current_password = substr($current_hash, -32);
                $password = md5($salt . $password);
                // если пароли совпадают, то все ок, просто авторизуем, если нет, то проверим его на БК
                if ($current_password != $password) {
                    $data = array(
                        'email'	=> $fields['LOGIN'],
                        'password' => $fields['PASSWORD']
                    );

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, BK_REQUESTS_URL . 'users/login');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'X-AD-Offer: 1'
                    ));
                    $data = curl_exec($ch);
                    curl_close($ch);
                    $bk_response = json_decode($data, true);
                    // если пользователь смог авторизоваться, то меняем его пароль в битриксе на этот
                    if ($bk_response[0]["id"]) {
                        $user_update = new CUser;
                        $user_update->Update(
                            $user["ID"],
                            array(
                                "PASSWORD"			=> $fields['PASSWORD'],
                                "CONFIRM_PASSWORD" => $fields['PASSWORD']
                            )
                        );
                        global $USER;
                        if (!is_object($USER)) $USER = new CUser;
                        $auth_result = $USER->Login($fields['LOGIN'], $fields['PASSWORD'], "Y", "Y");
                    }
                }
            } else {
                // если нет, то проверяем, есть ли он в БК
                $data = array(
                    'email'	=> $fields['LOGIN'],
                    'password' => $fields['PASSWORD']
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, BK_REQUESTS_URL . 'users/login');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'X-AD-Offer: 1'
                ));
                $data = curl_exec($ch);
                curl_close($ch);
                $bk_response = json_decode($data, true);
                // если пользователь смог авторизоваться, то регистрируем его в альпине
                if ($bk_response[0]["id"]) {
                    $user = new CUser;
                    $user_fields = Array(
                        "EMAIL"				=> $fields['LOGIN'],
                        "LOGIN"				=> $fields['LOGIN'],
                        "ACTIVE"			=> "Y",
                        "GROUP_ID"			=> array(3, 4, 5),
                        "PASSWORD"			=> $fields['PASSWORD'],
                        "CONFIRM_PASSWORD" => $fields['PASSWORD']
                    );

                    $ID = $user->Add($user_fields);
                    global $USER;
                    if (!is_object($USER)) $USER = new CUser;
                    $auth_result = $USER->Login($fields['LOGIN'], $fields['PASSWORD'], "Y", "Y");
                }
            }
        }
    }

    AddEventHandler("main", "OnAfterUserRegister", Array("OnAfterUserRegisterHandler", "OnAfterUserRegister"));
    class OnAfterUserRegisterHandler {
        function OnAfterUserRegister(&$arFields, &$arTemplate) {
            if ($arTemplate["ID"] == 2) {
                $arFields["PASS"] = $arFields["PASSWORD"];
                $arFields["C_PASS"] = $arFields["CONFIRM_PASSWORD"];
            }

            CModule::IncludeModule('subscribe');

            if ($_POST['USER_SUBSCRIBE'] == 'on') {
                $SubscriberList = CSubscription::GetList(Array(), Array('EMAIL' => $arFields["EMAIL"]), false);
                if (!($Subscriber = $SubscriberList->Fetch())) {
                    $NewSubscriber = new CSubscription;
                    $subFields = array(
                        "EMAIL" => $arFields["EMAIL"],
                        "USER_ID" => $arFields["USER_ID"],
                        "ACTIVE" => "Y",
                        "RUB_ID" => array("1")
                    );
                    $NewSubscriber->Add($subFields);
                }
            }
            //		$arFields['LOGIN'] = $arFields['EMAIL'];
            return $arFields;
        }
    }

    AddEventHandler("main", "OnAfterUserAuthorize", "checkSailplayUserExistance");

    /**
    *
    * Проверяем, существует ли пользователь в системе Sailplay,
    * если нет, то добавляем его.
    *
    * @param array
    * @return void
    * */
    function checkSailplayUserExistance($user) {
        if ($token = SailplayHelper::getAuth() && $user['user_fields']['EMAIL']) {
            $result = SailplayHelper::isUserExist($token, $user['user_fields']['EMAIL']);
            if ($result['status'] == 'fail') {
                // если такого пользователя нет, то добавим его
                SailplayHelper::addNewUser($token, $user['user_fields']['EMAIL'], $user['user_fields']['NAME'], $user['user_fields']['LAST_NAME']);
            }
        }
    }

    AddEventHandler("catalog", "OnDiscountUpdate", "updatingSpecPriceProperty");

    /******
    *
    *
    * обновление значение свойства "Спеццена" в зависимости от скидки на товар
    *
    * @param int $ID - ID скидки на товар
    * @var int $discount_value - значение скидки на товар
    * @var int $prop_value_ID - ID товара в инфоблоке товаров
    *
    *
    ******/
    function updatingSpecPriceProperty($ID, $arFields) {
        if ($arFields["ACTIVE"] == "Y") {
            $discount = CCatalogDiscount::GetByID($ID);
            $discount_value = round($discount["VALUE"]);
            $product = CIBlockProperty::GetPropertyEnum("spec_price", array(), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "VALUE" => $discount_value));
            while ($product_info = $product -> Fetch()) {
                $prop_value_ID = $product_info["ID"];
            }
            $discount_prods = CCatalogDiscount::GetDiscountProductsList (array(), array("DISCOUNT_ID" => $ID), false, false, array());
            while ($discount = $discount_prods -> Fetch()) {
                CIBlockElement::SetPropertyValues($discount["PRODUCT_ID"], CATALOG_IBLOCK_ID, array("VALUE"=>$prop_value_ID), "spec_price");
            }
        }
    }


    function getCourierByID($cID) {
        $return = Array();
        $filter = Array("GROUPS_ID" => Array(9),"ID"=>$cID,"ACTIVE" => "Y");
        $rsUsers = CUser::GetList(($by=""), ($order=""), $filter,array("FIELDS"=>array("ID","NAME","LAST_NAME","PERSONAL_MOBILE"))); // выбираем пользователей
        while($test_cur = $rsUsers->NavNext(true, "f_")) {
            if (!preg_match('/[0-9]/',$test_cur['LAST_NAME'])) {
                $return["CUR"] = Array("NAME"=>$test_cur['NAME']." ".$test_cur['LAST_NAME'],"PHONE"=>$test_cur['PERSONAL_MOBILE']);
            } else {
                $return["CUR"] = Array("NAME"=>$test_cur['NAME'],"PHONE"=>$test_cur['LAST_NAME']);
            }
        }
        return $return;
    }



    // --- класс для отправки смс при изменении статусов заказа
    class Message {

        /***************
        *
        * Статусы заказа,при которых отправляется сообщение
        *
        * @var array $messages
        *
        *************/
        public static $messages = Array(
            "N" => "Заказ №order принят. Мы рады ответить на ваши вопросы: +7(495)1200704",
            "A" => "Заказ №order отменен. Если это ошибка, звоните +7(495)1200704",
            "K" => "Заказ №order отправлен почтой РФ. Трек-номер будет выслан в течение 5 рабочих дней. Возник вопрос? Звоните +7(495)1200704",
            "C" => "Заказ №order на сумму ordsum руб собран и ждет вас по адресу 4-ая Магистральная ул., д.5, под. 2, этаж 2 по будням с 8 до 18 часов",
            "CA" => "Ваш заказ №order в пути. Трек-номер tracking",
            "AR" => "Ваш заказ №order прибыл в место вручения.",
            "D10" => "Истекает срок хранения заказа №order. Возник вопрос? Звоните +7(495)1200704",
            "D12" => "Осталось 2 дня до отмены заказа №order. Возник вопрос? Звоните +7(495)1200704",
            "I" => "Заказ №order уже в пути. Курьер cur_name cur_phone",
            "PS" => "Заказ №order принят Почтой России к отправке. В течение 1-2 недель посылка прибудет в почтовое отделение. Будем держать в курсе",
            "PD" => "Заказ №order доставлен почтовое отделение. Пожалуйста, получите посылку на почте. Трекинг-код tracking. С собой необходимо иметь паспорт",
            "P10" => "Срок хранения заказа №order истекает. Пожалуйста, заберите заказ в почтовом отделении. Трекинг-код tracking",
            "PA" => "Срок хранения заказа №order истекает. Пожалуйста, заберите заказ в почтовом отделении. Трекинг-код tracking",
            "P" => "К сожалению, курьер не смог до вас дозвониться. Доставка перенесена на следующий рабочий день. Возник вопрос? Звоните +7(495)1200704",
            "SP" => "Срок хранения вашего заказа №order истек! Хотите его продлить? Звоните: +7 (495) 120-07-04 "
        );

        /***************
        *
        * Получаем способ доставки для заказа
        *
        * @param int $id
        * @return string $order['DELIVERY_ID']
        *
        *************/

        public static function getOrderDeliveryType($id) {
            $order = CSaleOrder::GetByID($id);
            return $order['DELIVERY_ID'];
        }

        /***************
        *
        * Логин/пароль для доступа к смс сервису
        *
        *************/

        function __construct() {
            global $arParams;
            $this->user = $arParams["SMS"]["LOGIN"];
            $this->password = $arParams["SMS"]["PASSWORD"];
        }

        /***************
        *
        * Получаем телефон из заказа
        *
        * @param int $id
        * @return string $clearedPhone
        *
        *************/

        function getPhone($id) {
            $db_props = CSaleOrderPropsValue::GetOrderProps($id);
            while ($arProps = $db_props->Fetch()) {
                if ($arProps['CODE']=='PHONE') {
                    $clearedPhone = preg_replace('/[^0-9+]/', '',$arProps['VALUE']);
                    return $clearedPhone;
                }
            }
        }

        /***************
        *
        * Получаем имя клиента из заказа
        *
        * @param int $id
        * @return string $arProps['VALUE']
        *
        *************/

        function getClientName($id) {
            $db_props = CSaleOrderPropsValue::GetOrderProps($id);
            while ($arProps = $db_props->Fetch()) {
                if ($arProps['CODE']=='CONTACT_PERSON' || $arProps['CODE']=='F_CONTACT_PERSON') {
                    return $arProps['VALUE'];
                }
            }
        }

        /***************
        *
        * Получаем email клиента из заказа
        *
        * @param int $id
        * @return string $arProps['VALUE']
        *
        *************/

        function getClientEmail($id) {
            $db_props = CSaleOrderPropsValue::GetOrderProps($id);
            while ($arProps = $db_props->Fetch()) {
                if ($arProps['CODE']=='EMAIL') {
                    return $arProps["VALUE"];
                }
            }
        }

        /***************
        *
        * Отправляем сообщение
        *
        * @param int $id
        * @param string $val
        * @param array $curArr - optional
        * @return string $result
        *
        *************/
        private $login = 't.razumovskaya@alpina.ru'; //логин в системе терасмс
        private $token = '8lUOOC9tDKKsqvn1hOYh'; //токен в системе МТС терасмс
        private $password_sms = 'TL5MBRT6FE'; //токен в системе МТС терасмс
        private $sender = 'alpina.ru'; //подпись отправителя
        private $url = "https://auth.terasms.ru/outbox/send/"; //url для api запросов

        public function sendMessage($ID,$val,$curArr,$ordsum,$tracking) {
            $phone = $this->getPhone($ID);
            $name = $this->getClientName($ID);
            logger($curArr, $_SERVER["DOCUMENT_ROOT"].'/logs/status.txt');
            if (empty($curArr) && $val == "I") {  // проверяем заказы с трек номером
                $message = preg_replace('/order/',$ID,self::$messages["CA"]); // ---- вставляем номер заказа
            } else {
                $message = preg_replace('/order/',$ID,self::$messages[$val]); // ---- вставляем номер заказа
            }
            $message = preg_replace('/ordsum/',$ordsum,$message); // ---- вставляем сумму заказа
            if ($tracking) {
                $message = preg_replace('/tracking/',$tracking,$message); // ---- вставляем трек-номер
            }
            $message = preg_replace('/clientName/',$name,$message); // ---- вставляем имя клиента
            if (!empty($curArr)) {
                $message = preg_replace('/cur_name/',$curArr['CUR']['NAME'],$message); // ---- вставляем имя курьера
                $message = preg_replace('/cur_phone/',$curArr['CUR']['PHONE'],$message); // ---- вставляем телефон курьера
            }
            if (empty($phone) || empty($message)) {
                return false;
            }

            //форматируем номер телефона - убираем лишние символы
            $phone = preg_replace('/[^0-9]/', '', $phone);

            $path = $this->url;

            //альтернативный варинт авторизации
           // $sign = md5("login=" . $this->login . "&message= " . $message . "&sender= " . $this->sender . "&target=" . $phone . $this->token);

            $postdata = http_build_query(
               array(
                "login" => $this->login,
                "password" => $this->password_sms,
                "message" => $message,
                "sender" => $this->sender,
                "target" => $phone,
            ));

            $opts = array('http' =>
                 array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                    )
            );

            logger($curArr,$_SERVER["DOCUMENT_ROOT"].'/logs/log_courier.txt' );

            $context  = stream_context_create($opts);
            $result = file_get_contents($path, false, $context);

            return $result;
        }

    }

    /*//----- Отправка смс при новом заказе
    AddEventHandler("sale", "OnOrderNewSendEmail", "sendSMSOnNewOrder");


    function sendSMSOnNewOrder($orderID, &$eventName, &$arFields) {
    $message = new Message();
    $result = $message->sendMessage($orderID,"N");
    }*/


    //подмена логина на EMAIL
    AddEventHandler("main", "OnBeforeUserAdd", Array("OnBeforeUserAddHandler", "OnBeforeUserAdd"));
    class OnBeforeUserAddHandler{
        function OnBeforeUserAdd(&$arFields) {
            if($arFields["EXTERNAL_AUTH_ID"] != 'socservices'){
                $arFields['LOGIN'] = $fields['EMAIL'];

                return $arFields;
            }
            if (strlen($arFields['EMAIL']) && !strlen($arFields['LOGIN'])) {
                $arFields['LOGIN'] = $arFields['EMAIL'];

                return $arFields;
            }
        }
    }
    //подмена логина на EMAIL
    AddEventHandler("main", "OnBeforeUserUpdate", Array("UserUpdateClass", "OnBeforeUserUpdateHandler"));
    class UserUpdateClass {
        // создаем обработчик события "OnBeforeUserUpdate"
        function OnBeforeUserUpdateHandler(&$arFields) {
            if (strlen($arFields['EMAIL']) && !strlen($arFields['LOGIN'])) {
                $arFields['LOGIN'] = $arFields['EMAIL'];
            }
            return $arFields;
        }
    }



    AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "UpdateStatusNew");

    // создаем обработчик события "OnAfterIBlockElementUpdate"
    function UpdateStatusNew(&$arFields) {
        if($arFields["IBLOCK_ID"] == CATALOG_IBLOCK_ID){
            $db_props = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], array("sort" => "asc"), Array("CODE"=>"STATE"));
            if($ar_props = $db_props->Fetch()){
                $str_to_state = $ar_props["VALUE"]; // получаем значение статуса
            }
            $proprs_date = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], array("sort" => "asc"), Array("CODE"=>"STATEDATE"));
            if($ar_props_date = $proprs_date->Fetch()){
                $state_date = $ar_props_date["VALUE"]; // получаем дату проставления новинки
            }

            $date = date_create($state_date);
            date_modify($date, '+2 month');  // прибавляем 2 месяца
            $new_date = date_format($date, 'd.m.Y');

            if($str_to_state == STATE_NEWS && strtotime($new_date) >= strtotime(date('d.m.Y'))){ // добавляем свойство новинки
                CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arFields["IBLOCK_ID"], array("NOVINKA" => PROP_NOVINKA_ID));
            } else { // удалем свойство через 2 месяца после установленной даты
                CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arFields["IBLOCK_ID"], array("NOVINKA" => false));
            }
        }
    }

    // --- books subscribe
    AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "sendMailToBookSubs");

    function sendMailToBookSubs(&$arParams) {
        if ($arParams['IBLOCK_ID']==4) {
            $arSelect = Array("NAME","DETAIL_PAGE_URL","DETAIL_PICTURE","PROPERTY_STATE");
            $arFilter = Array("IBLOCK_ID"=>4,"ID"=>$arParams['ID'], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
            while($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                $oldElStatus = $arFields['PROPERTY_STATE_ENUM_ID'];
                $bookName = $arFields['NAME'];
                $bookHref = "https://www.alpinabook.ru".$arFields['DETAIL_PAGE_URL'];
                $bookImg = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array("width" => 200, "height" => 270), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            }

            $newElStatus = $arParams['PROPERTY_VALUES'][56][0]["VALUE"];

            if ($newElStatus!=$oldElStatus && !empty($arParams['PROPERTY_VALUES'][56][0]) && ($oldElStatus==22 || $oldElStatus==23)) {

                $el = new CIBlockElement;
                $arLoadProductArray = Array("ACTIVE" => "N");
                // --- status changed from "coming soon" to "new" or "available"
                if ($oldElStatus==22 && $newElStatus!=23) {

                    $arSelect = Array("ID","PROPERTY_SUB_EMAIL");
                    $arFilter = Array("IBLOCK_ID"=>41,"PROPERTY_SUB_TYPE_ID"=>array(1,2),"PROPERTY_BOOK_ID"=>$arParams['ID'],"ACTIVE" => "Y");
                    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>9999), $arSelect);
                    while($ob = $res->GetNextElement()) {
                        $arFields = $ob->GetFields();
                        // --- email sending here
                        $arEventFields = array(
                            "EMAIL"=> $arFields['PROPERTY_SUB_EMAIL_VALUE'],
                            "BOOK_HREF" => $bookHref,
                            "BOOK_NAME" => $bookName,
                            "BOOK_IMG" => $bookImg['src']
                        );
                        CEvent::Send("BOOK_SUB_MAILING", "s1", $arEventFields,"N");
                        // --- email sending here
                        $el->Update($arFields['ID'], $arLoadProductArray);

                    }
                }
            }
        }
    }



    //Функция перевода числа в текстовую форму
    function num2str($num) {
        $nul='ноль';
        $ten=array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
        );
        $a20=array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens=array(2=>'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred=array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit=array( // Units
            array('копейка', 'копейки', 'копеек',		1),
            array('рубль', 'рубля', 'рублей'	,0),
            array('тысяча', 'тысячи', 'тысяч'		,1),
            array('миллион', 'миллиона', 'миллионов',0),
            array('миллиард', 'милиарда', 'миллиардов',0),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        //arshow(str_split($rub, 3));
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }

    function typo($str) {
        $pattern = '/\s+(в|без|до|из|к|на|по|о|от|перед|при|через|с|у|и|нет|за|над|для|об|под|про|но|что|не|или)\s+/i';
        return preg_replace($pattern, ' \1&nbsp;', $str);
    }

    /**
    * Склоняем словоформу
    */

    //----- Fix for flippost cost
    AddEventHandler("sale", "OnOrderNewSendEmail", "customizeNewOrderMail");

    function customizeNewOrderMail($orderID, &$eventName, &$arFields) {
		updateCumulativeDiscount($orderID);
        $orderArr = CSaleOrder::GetByID($orderID);
        $arFields['EMAIL_DISCOUNT_PERCENT_TOTAL'] = $_SESSION['EMAIL_DISCOUNT_PERCENT_TOTAL'];
        $arFields['EMAIL_DISCOUNT_SUM_TOTAL'] = $_SESSION['EMAIL_DISCOUNT_SUM_TOTAL'];
		$arFields['PRICE'] = $orderArr["PRICE"];
        $arFields['EMAIL_CURRENT_DISCOUNT_SAVE_PERCENT'] = $_SESSION['EMAIL_CURRENT_DISCOUNT_SAVE_PERCENT'];
        $arFields['EMAIL_NEXT_DISCOUNT_SAVE_SUM'] = $_SESSION['EMAIL_NEXT_DISCOUNT_SAVE_SUM'];
        $arFields['EMAIL_ORDER_WEIGHT'] = $_SESSION['EMAIL_ORDER_WEIGHT'];
        $arFields['EMAIL_ORDER_ITEMS'] = getOrderItemsForMail($orderID);
		$authHash = get_hash_for_authorization($arFields['EMAIL']);
        $phone_prop = CSaleOrderPropsValue::GetList (array("SORT" => "ASC"), array("ORDER_ID" => $orderID, "CODE" => "PHONE"));
        while ($phone = $phone_prop -> Fetch()) {
            $arFields["CUSTOMER_PHONE"] = $phone["VALUE"];
        }
        $arFields['PROMO_PARTNER'] = '';
        if ($orderArr['PAY_SYSTEM_ID'] == CASHLESS_PAYSYSTEM_ID) { //если оплата по безналу юриком
            $arFields['EMAIL_PAY_SYSTEM'] = getOrderPaySystemName($orderArr['PAY_SYSTEM_ID']);
            $arFields['PAYMENT_LINK'] = "Менеджер отправит счет на оплату в рабочее время.";
        } else {
            $arFields['EMAIL_PAY_SYSTEM'] = getOrderPaySystemName($orderArr['PAY_SYSTEM_ID']);
        }

        if ($orderArr["PAY_SYSTEM_ID"] == RFI_PAYSYSTEM_ID || $orderArr["PAY_SYSTEM_ID"] == SBERBANK_PAYSYSTEM_ID || $orderArr["PAY_SYSTEM_ID"] == PLATBOX_PAYSISTEM_ID) {
            //получаем путь до обработчика
            $arFields["PAYMENT_LINK"] = "Для оплаты заказа перейдите по <a href='https://www.alpinabook.ru/personal/order/payment/?ORDER_ID=".$orderArr["ID"]."&hash=".$authHash."'>ссылке</a>.";
        }

        $arFields['DELIVERY_NAME'] = getOrderDeliverySystemName($orderArr['DELIVERY_ID']);

        if (in_array(trim($orderArr['DELIVERY_ID']), array(DELIVERY_PICK_POINT, DELIVERY_PICK_POINT2, DELIVERY_BOXBERRY_PICKUP, "pickpoint:postamat"))) {

            $arFields['EMAIL_DELIVERY_TERM'] = "<br />Сроки доставки (дней): <b>".$_SESSION['EMAIL_DELIVERY_TERM']."</b><br>";
            $arFields['EMAIL_DELIVERY_ADDR'] = "Адрес доставки: <b>".getDeliveryAddress(trim($orderArr['DELIVERY_ID']),$orderID)."</b><br>";

        } elseif (in_array($orderArr['DELIVERY_ID'], array(DELIVERY_COURIER_1, DELIVERY_COURIER_2))) {

            $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $orderID, "CODE" => array("DELIVERY_DATE","ADDRESS")));
            while ($arVals = $db_vals -> Fetch()) {
                $arVals['CODE'] == "ADDRESS" ? $arFields['EMAIL_DELIVERY_ADDR'] = "Адрес доставки: <b>".$arVals['VALUE']."</b><br>" : $arFields['EMAIL_DELIVERY_TERM'] = "<br />".$arVals['NAME']." : <b>".$arVals['VALUE']."</b><br>";
            }
            $arFields['EMAIL_ADDITIONAL_INFO'] = "<tr><td align=\"left\" style=\"border-collapse: collapse;color:#393939;font-family: 'Open Sans', 'Segoe UI',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 160%;font-style: normal;letter-spacing: normal;padding-top:10px;\" valign=\"top\" colspan=\"2\">";
            $arFields['EMAIL_ADDITIONAL_INFO'] .= "Курьер свяжется с вами в выбранный день доставки, чтобы согласовать удобное время и другие детали.";
            $arFields['EMAIL_ADDITIONAL_INFO'] .= "</td></tr>";

        } elseif ($orderArr['DELIVERY_ID'] == DELIVERY_PICKUP) {

            $arFields['EMAIL_ADDITIONAL_INFO'] = "<tr><td align=\"left\" style=\"border-collapse: collapse;color:#393939;font-family: 'Open Sans', 'Segoe UI',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 160%;font-style: normal;letter-spacing: normal;padding-top:10px;\" valign=\"top\" colspan=\"2\">";
            $arFields['EMAIL_ADDITIONAL_INFO'] .= "Заказ будет собран в&nbsp;течение двух рабочих часов. Забрать заказ можно по&nbsp;адресу <em>м.Полежаевская, ул.4-ая&nbsp;Магистральная, д.5, 2&nbsp;подъезд, 2&nbsp;этаж.</em> <br />Офис работает по&nbsp;будням с&nbsp;8&nbsp;до&nbsp;18&nbsp;часов.";
            $arFields['EMAIL_ADDITIONAL_INFO'] .= "<br /><br /><b>Как к нам пройти</b><br /><br />Метро «Полежаевская» (или «Хорошёвская»), последний вагон из центра, из вестибюля направо, выход на улицу налево. После выхода на улицу переходите на противоположную сторону к ТЦ «Хорошо», поворачиваете направо и двигаетесь по 4-ой Магистральной улице. Проходите магазин «Ларес» и доходите до дома 5 строения 1. Вам нужен «БЦ на Магистральной», второй подъезд, второй этаж.";
            $arFields['EMAIL_ADDITIONAL_INFO'] .= "</td></tr>";

            $arFields['YANDEX_MAP'] = "<tr><td style=\"border-collapse: collapse;padding-bottom:20px;\"><table align=\"left\" width=\"100%\"><tbody><tr><td align=\"left\" style=\"border-collapse: collapse;color:#393939;font-family: 'Open Sans', 'Segoe UI',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 100%;font-style: normal;letter-spacing: normal;padding-top:10px;\" colspan=\"2\" valign=\"top\"><img src=\"https://www.alpinabook.ru/img/ymap.png\" /></td></tr></tbody></table></td></tr>";

        } else if($orderArr['DELIVERY_ID'] == DELIVERY_MAIL || $orderArr['DELIVERY_ID'] == DELIVERY_MAIL_2 || $orderArr['DELIVERY_ID'] == DELIVERY_MAIL_3 || $orderArr['DELIVERY_ID'] == DELIVERY_MAIL_4){
            $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $orderID, "CODE" => array("INDEX", "CITY_DELIVERY")));
            while ($arVals = $db_vals -> Fetch()) {
                if(!empty($arVals["VALUE"])){
                    $arFields['EMAIL_DELIVERY_ADDR'] .=  " ".$arVals['NAME'].": ".$arVals["VALUE"]."<br>";
                }
            }
            $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $orderID, "CODE" => array("COUNTRY_DELIVERY", "COUNTRY", "CITY", "STREET", "HOUSE")));
            $arFields['EMAIL_DELIVERY_ADDR'] = "Адрес доставки:<br>";
            while ($arVals = $db_vals -> Fetch()) {
                if(!empty($arVals["VALUE"])){
                    $arFields['EMAIL_DELIVERY_ADDR'] .=  " ".$arVals['NAME'].": ".$arVals["VALUE"]."<br>";
                }
            }
        }

        $arFields['USER_DESCRIPTION'] = $orderArr['USER_DESCRIPTION'];
    }


    function getOrderItemsForMail($orderID) {
        $bookDescString = "";
        $dbItemsInOrder = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $orderID));
        while ($arItems = $dbItemsInOrder->Fetch()) {
            $bookDescString .= "<tr>";
            $bookDescString .= "<td align=\"left\" style=\"border-collapse: collapse;color:#393939;font-family: 'Open Sans', 'Segoe UI',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 100%;font-style: normal;letter-spacing: normal;padding-top:10px;\" valign=\"top\">";
            $bookDescString .= "<a href='https://www.alpinabook.ru".$arItems["DETAIL_PAGE_URL"]."?utm_source=autotrigger&amp;rr_setemail=#EMAIL#&utm_medium=email&utm_term=bookordered&utm_campaign=newordermail' target='_blank'>".$arItems['NAME']."</a>";
            $bookDescString .= "</td><td align=\"center\" style=\"border-collapse: collapse;color:#393939;font-family: 'Open Sans', 'Segoe UI',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 100%;font-style: normal;letter-spacing: normal;padding-top:10px;\" width=\"80\">";
            $bookDescString .= $arItems['QUANTITY'];
            $bookDescString .= "</td><td align=\"center\" style=\"border-collapse: collapse;color:#393939;font-family: 'Open Sans', 'Segoe UI',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 100%;font-style: normal;letter-spacing: normal;padding-top:10px;\" width=\"100\">";
            $bookDescString .= $arItems['PRICE']*$arItems['QUANTITY'];
            $bookDescString .= "</td>";

            //$bookDescString .= $arItems['NAME']." - ".$arItems['QUANTITY']." шт. ".$arItems['PRICE']*$arItems['QUANTITY']." руб. ";
            $arSelect = Array('ID',"IBLOCK_ID","PROPERTY_TYPE","PROPERTY_COVER_TYPE");
            $arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$arItems['PRODUCT_ID']);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
            while($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                $bookDescString .= "<tr><td colspan=\"3\" align=\"left\" style=\"border-collapse: collapse;color:#393939;font-family: 'Open Sans', 'Segoe UI',Roboto,Tahoma,sans-serif;font-size: 12px; font-weight: 400;line-height: 100%;font-style: normal;letter-spacing: normal;padding-top:10px;padding-bottom: 10px;\">".$arFields['PROPERTY_TYPE_VALUE'].". ".$arFields['PROPERTY_COVER_TYPE_VALUE']."</td></tr>";
            }
        }
        return $bookDescString;
    }


    function getOrderPaySystemName($psi) {
        $psn = "";
        $psArr = CSalePaySystem::GetByID($psi);
        $psn = $psArr['NAME'];
        return $psn;
    }

    function getOrderDeliverySystemName($psi) {
        $psn = "";
        $psArr = CSaleDelivery::GetByID($psi);
        $psn = $psArr['NAME'];
        return $psn;
    }

    function getDeliveryAddress($deliveryServ,$orderId) {
        $address = "";
        switch($deliveryServ) {
            case 18:
                $ordArr = CSaleOrder::GetByID($orderId);
                $address = $ordArr['USER_DESCRIPTION'];
                break;
            case 15:
                $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $orderId, "CODE" => "ADDRESS"));
                if ($arVals = $db_vals -> Fetch()) {
                    $address = $arVals["VALUE"];
                }
                break;
            case 21:
                $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $orderId, "CODE" => "IML_ADDRESS"));
                if ($arVals = $db_vals -> Fetch()) {
                    $address = $arVals["VALUE"];
                }
                break;
            case 20:
                $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $orderId, "CODE" => "ADDRESS"));
                if ($arVals = $db_vals -> Fetch()) {
                    $address = $arVals["VALUE"];
                }
                break;
        }
        return $address;
    }

    function getDiffToNextDiscountSave($ui,$np) {
        $diff = 0.0;
        // --- сумма всех оплаченных заказов = сумме накопительной скидки
        $totalPayedSum = 0.0;

        $arFilter = Array(
            "USER_ID" => $ui,
            "PAYED" => "Y"
        );

        $db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
        while ($ar_sales = $db_sales->Fetch()) {
            $totalPayedSum +=$ar_sales['PRICE'];
        }

        // ---- сколько осталось до следующей скидки
        $res = CCatalogDiscountSave::GetRangeByDiscount(array(),array("VALUE"=>$np),false);
        if ($ob = $res->fetch()) {
            $diff = (float)$ob['RANGE_FROM'] - $totalPayedSum;
        }

        return $diff;

    }


    AddEventHandler('sale', 'OnOrderStatusSendEmail', Array("mail_change", "change_data"));


    class mail_change {
        function change_data($ID, &$eventName, &$arFields, $val) {
            if ($eventName=="SALE_STATUS_CHANGED_P") {
                $salelist=CSaleOrderPropsValue::GetList(array(),array("ORDER_ID"=>$ID, "ORDER_PROPS_ID"=>24),false,false,array("VALUE"));
                if ($sale_prop=$salelist->Fetch())
                    $arFields["PERSONAL_PHONE"]=$sale_prop["VALUE"];
                $userslist=CSaleOrderPropsValue::GetList(array(),array("ORDER_ID"=>$ID, "ORDER_PROPS_ID"=>7),false,false,array("VALUE"));
                if ($usersarray=$userslist->Fetch())
                    $arFields["ORDER_USER"]=$usersarray["VALUE"];
            }

        }
    }

    //Функции для работы с хешем для мгновенной авторизации
    //Генерация хэша авторизации по ссылке, для пользователя
    function generate_hash_for_authorization($user_email) {

        $order_log = '<--------------- generate_hash_for_authorization: '.$user_email.' ----------------->';
        $file = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/mail_certificate.log';
        logger($order_log, $file);

        $arSelect = Array("ID", "NAME");
        $arFilter = Array("IBLOCK_ID" => IntVal(RFM_IBLOCK_ID), "NAME" => $user_email, "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);

        if ($ob = $res->GetNextElement()) {

            $arFields = $ob->GetFields();
            $arFilter = array(
                "ACTIVE"		=> "Y",
                "EMAIL"		=> $arFields['NAME']
            );

            $rsUsers = CUser::GetList(($by="id"), ($order="desc"), $arFilter);

            if ($arUser = $rsUsers->Fetch()) {
                if (!empty($arUser)) {
                    $arGroups = CUser::GetUserGroup($arUser['ID']);
                    if (!in_array(ADMIN_GROUP_ID, $arGroups)) {
                        $hash = md5(uniqid(rand(), true));
                        $arProperty = array (
                            'HASH_FOR_AUTHORIZE' => $hash,
                            'HASH_UPDATE_DATE' => time()
                        );
                        CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, $arProperty);
                        return $hash;
                    }
                }
            }
        }
        return false;
    }

    //Увеличение времени жизни хеша
    function extend_hash_lifetime($user_email) {
        $arSelect = Array("ID", "NAME", "PROPERTY_HASH_UPDATE_DATE");
        $arFilter = Array("IBLOCK_ID" => RFM_IBLOCK_ID, "NAME" => $user_email, "ACTIVE" => "Y");

        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        if ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();

            if (!empty($arFields['PROPERTY_HASH_UPDATE_DATE_VALUE'])) {
                $arProperty = array (
                    'HASH_UPDATE_DATE' => time()
                );

                CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, $arProperty);
            }
        }
    }

    function get_hash_for_authorization($user_email) {

        $order_log = '<--------------- get_hash_for_authorization: '.$user_email.' ----------------->';
        $file = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/mail_certificate.log';
        logger($order_log, $file);

        $arSelect = Array("ID", "NAME", "PROPERTY_HASH_FOR_AUTHORIZE", "PROPERTY_HASH_UPDATE_DATE");
        $arFilter = Array("IBLOCK_ID" => RFM_IBLOCK_ID, "NAME" => $user_email, "ACTIVE" => "Y");

        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        if ($ob = $res->GetNextElement()) {

            $order_log = '<--------------- ob exist: '.$user_email.' ----------------->';
            $file = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/mail_certificate.log';
            logger($order_log, $file);

            $arFields = $ob->GetFields();

            if (!empty($arFields['PROPERTY_HASH_UPDATE_DATE_VALUE']) && !empty($arFields['PROPERTY_HASH_FOR_AUTHORIZE_VALUE'])) {

                $order_log = '<--------------- hash exist: '.$arFields['PROPERTY_HASH_FOR_AUTHORIZE_VALUE'].' ----------------->';
                $file = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/mail_certificate.log';
                logger($order_log, $file);

                if (!empty($arFields['PROPERTY_HASH_UPDATE_DATE_VALUE'])) {
                    $arProperty = array (
                        'HASH_UPDATE_DATE' => time()
                    );

                    CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, $arProperty);
                }
                return $arFields['PROPERTY_HASH_FOR_AUTHORIZE_VALUE'];
            } else {

                $order_log = '<--------------- hash empty: '.$user_email.' ----------------->';
                $file = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/mail_certificate.log';
                logger($order_log, $file);

                if ($hash = generate_hash_for_authorization($user_email)) {

                    $order_log = '<--------------- hash: '.$hash.' ----------------->';
                    $file = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/mail_certificate.log';
                    logger($order_log, $file);

                    return $hash;
                };
            }
        } else {
            $order_log = '<--------------- no RFM: '.$user_email.' ----------------->';
            $file = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/mail_certificate.log';
            logger($order_log, $file);

            return false;
        }
    }

    //Добавим хеши в почтовый шаблон
    \Bitrix\Main\EventManager::getInstance()->addEventHandler(
        'main',
        'OnBeforeEventSend',
        'add_hash_to_template'
    );

    function add_hash_to_template(&$arFields, &$arTemplate) {

        $file = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/mail_certificate.log';
        $order_log = '<--------------- '.$arFields['EMAIL'].' ----------------->';
        logger($order_log, $file);

        if ($hash = get_hash_for_authorization($arFields['EMAIL'])) {
            $arFields['HASH'] = $hash;
        }
    }

    AddEventHandler('main', 'OnBeforeEventSend', 'RegisterNoneEmail'); // вызывается перед отправкой шаблона письма

    function RegisterNoneEmail (&$arFields, &$arTemplate) {		// при создании пользователя с одинаковым генерируемым email не отправляет письмо
        if (stristr($arFields["LOGIN"], 'newuser_') == true && in_array($arTemplate["EVENT_NAME"], array('NEW_USER', 'USER_INFO'))) {
            return false;
        }
        /*
        $arFields["LOGIN"] = логин нового пользователя
        $arTemplate["EVENT_NAME"] = событие при котором происходит отправка письма
        */
    }

    //Добавляем кнопку "Оплатить" в шаблон
    AddEventHandler('main', 'OnBeforeEventSend', 'PayButtonForOnlinePayment');
    function PayButtonForOnlinePayment (&$arFields, &$arTemplate) {
        if (in_array($arTemplate["ID"],array(16,178))) {
            $order = CSaleOrder::GetByID($arFields["ORDER_ID"]);
            if ($order["PAY_SYSTEM_ID"] == PAY_SYSTEM_RFI && $order["STATUS_ID"] != "PR") {
				$authHash = get_hash_for_authorization($arFields['EMAIL']);
                $pay_button = '<div class="payment_button" style="white-space: normal; font-size: 18px; text-align: center; vertical-align: middle; background-color: #00abb8; height: 50px; width: 146px; margin-left: 60%; border-radius: 35px; margin-top: 15px;">
                <a href="https://www.alpinabook.ru/personal/order/payment/?ORDER_ID='.$arFields["ORDER_ID"].'&hash='.$authHash.'" style="color: #fff; text-decoration: none;"><span style="line-height: 45px">Оплатить</span></a>
                </div>';
            } else {
                $pay_button = "";
            }
            $arFields["PAYMENT_BUTTON"] = $pay_button;
        }
    }

    // редактируем письмо статуса "истек срок хранения"
    AddEventHandler('main', 'OnBeforeEventSend', "eventSPStatus");

    function eventSPStatus (&$arFields, &$arTemplate) {
        Cmodule::IncludeModule('sale');

        if($arTemplate["ID"] == STATUS_ORDER_SP) {
            $orderArr = CSaleOrder::GetByID($arFields["ORDER_ID"]);
            $arFields['EMAIL_DISCOUNT_PERCENT_TOTAL'] = $orderArr['EMAIL_DISCOUNT_PERCENT_TOTAL'];
            $arFields['EMAIL_DISCOUNT_SUM_TOTAL'] = $orderArr['EMAIL_DISCOUNT_SUM_TOTAL'];
            $arFields['PRICE'] = $orderArr["PRICE"];
            $arFields['EMAIL_CURRENT_DISCOUNT_SAVE_PERCENT'] = $orderArr['EMAIL_CURRENT_DISCOUNT_SAVE_PERCENT'];
            $arFields['EMAIL_NEXT_DISCOUNT_SAVE_SUM'] = $orderArr['EMAIL_NEXT_DISCOUNT_SAVE_SUM'];
            $arFields['EMAIL_ORDER_WEIGHT'] = $orderArr['EMAIL_ORDER_WEIGHT'];
            $arFields['EMAIL_ORDER_ITEMS'] = getOrderItemsForMail($orderArr["ID"]);
            $authHash = get_hash_for_authorization($arFields['EMAIL']);
            $phone_prop = CSaleOrderPropsValue::GetList (array("SORT" => "ASC"), array("ORDER_ID" => $orderArr["ID"], "CODE" => "PHONE"));
            while ($phone = $phone_prop -> Fetch()) {
                $arFields["CUSTOMER_PHONE"] = $phone["VALUE"];
            }
            $arFields['PROMO_PARTNER'] = '';
            if ($orderArr['PAY_SYSTEM_ID'] == CASHLESS_PAYSYSTEM_ID) { //если оплата по безналу юриком
                $arFields['EMAIL_PAY_SYSTEM'] = getOrderPaySystemName($orderArr['PAY_SYSTEM_ID']);
                $arFields['PAYMENT_LINK'] = "Менеджер отправит счет на оплату в рабочее время.";
            } else {
                $arFields['EMAIL_PAY_SYSTEM'] = getOrderPaySystemName($orderArr['PAY_SYSTEM_ID']);
            }

            if ($orderArr["PAY_SYSTEM_ID"] == RFI_PAYSYSTEM_ID || $orderArr["PAY_SYSTEM_ID"] == SBERBANK_PAYSYSTEM_ID || $orderArr["PAY_SYSTEM_ID"] == PLATBOX_PAYSISTEM_ID) {
                //получаем путь до обработчика
                $arFields["PAYMENT_LINK"] = "Для оплаты заказа перейдите по <a href='https://www.alpinabook.ru/personal/order/payment/?ORDER_ID=".$orderArr["ID"]."&hash=".$authHash."'>ссылке</a>.";
            }

            $arFields['DELIVERY_NAME'] = getOrderDeliverySystemName($orderArr['DELIVERY_ID']);

            if (in_array(trim($orderArr['DELIVERY_ID']), array(DELIVERY_PICK_POINT, DELIVERY_PICK_POINT2, DELIVERY_BOXBERRY_PICKUP, "pickpoint:postamat"))) {

                $arFields['EMAIL_DELIVERY_TERM'] = "<br />Сроки доставки (дней): <b>".$_SESSION['EMAIL_DELIVERY_TERM']."</b><br>";
                $arFields['EMAIL_DELIVERY_ADDR'] = "Адрес доставки: <b>".getDeliveryAddress(trim($orderArr['DELIVERY_ID']),$orderArr["ID"])."</b><br>";

            } elseif (in_array($orderArr['DELIVERY_ID'], array(DELIVERY_COURIER_1, DELIVERY_COURIER_2))) {

                $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $orderArr["ID"], "CODE" => array("DELIVERY_DATE","ADDRESS")));
                while ($arVals = $db_vals -> Fetch()) {
                    $arVals['CODE'] == "ADDRESS" ? $arFields['EMAIL_DELIVERY_ADDR'] = "Адрес доставки: <b>".$arVals['VALUE']."</b><br>" : $arFields['EMAIL_DELIVERY_TERM'] = "<br />".$arVals['NAME']." : <b>".$arVals['VALUE']."</b><br>";
                }
                $arFields['EMAIL_ADDITIONAL_INFO'] = "<tr><td align=\"left\" style=\"border-collapse: collapse;color:#393939;font-family: 'Open Sans', 'Segoe UI',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 160%;font-style: normal;letter-spacing: normal;padding-top:10px;\" valign=\"top\" colspan=\"2\">";
                $arFields['EMAIL_ADDITIONAL_INFO'] .= "Курьер свяжется с вами в выбранный день доставки, чтобы согласовать удобное время и другие детали.";
                $arFields['EMAIL_ADDITIONAL_INFO'] .= "</td></tr>";

            } elseif ($orderArr['DELIVERY_ID'] == DELIVERY_PICKUP) {

                $arFields['EMAIL_ADDITIONAL_INFO'] = "<tr><td align=\"left\" style=\"border-collapse: collapse;color:#393939;font-family: 'Open Sans', 'Segoe UI',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 160%;font-style: normal;letter-spacing: normal;padding-top:10px;\" valign=\"top\" colspan=\"2\">";
                $arFields['EMAIL_ADDITIONAL_INFO'] .= "Заказ будет собран в&nbsp;течение двух рабочих часов. Забрать заказ можно по&nbsp;адресу <em>м.Полежаевская, ул.4-ая&nbsp;Магистральная, д.5, 2&nbsp;подъезд, 2&nbsp;этаж.</em> <br />Офис работает по&nbsp;будням с&nbsp;8&nbsp;до&nbsp;18&nbsp;часов.";
                $arFields['EMAIL_ADDITIONAL_INFO'] .= "<br /><br /><b>Как к нам пройти</b><br /><br />Метро «Полежаевская» (или «Хорошёвская»), последний вагон из центра, из вестибюля направо, выход на улицу налево. После выхода на улицу переходите на противоположную сторону к ТЦ «Хорошо», поворачиваете направо и двигаетесь по 4-ой Магистральной улице. Проходите магазин «Ларес» и доходите до дома 5 строения 1. Вам нужен «БЦ на Магистральной», второй подъезд, второй этаж.";
                $arFields['EMAIL_ADDITIONAL_INFO'] .= "</td></tr>";

                $arFields['YANDEX_MAP'] = "<tr><td style=\"border-collapse: collapse;padding-bottom:20px;\"><table align=\"left\" width=\"100%\"><tbody><tr><td align=\"left\" style=\"border-collapse: collapse;color:#393939;font-family: 'Open Sans', 'Segoe UI',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 100%;font-style: normal;letter-spacing: normal;padding-top:10px;\" colspan=\"2\" valign=\"top\"><img src=\"https://www.alpinabook.ru/img/ymap.png\" /></td></tr></tbody></table></td></tr>";

            } else if($orderArr['DELIVERY_ID'] == DELIVERY_MAIL || $orderArr['DELIVERY_ID'] == DELIVERY_MAIL_2 || $orderArr['DELIVERY_ID'] == DELIVERY_MAIL_3 || $orderArr['DELIVERY_ID'] == DELIVERY_MAIL_4){
                $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $orderArr["ID"], "CODE" => array("INDEX", "CITY_DELIVERY")));
                while ($arVals = $db_vals -> Fetch()) {
                    if(!empty($arVals["VALUE"])){
                        $arFields['EMAIL_DELIVERY_ADDR'] .=  " ".$arVals['NAME'].": ".$arVals["VALUE"]."<br>";
                    }
                }
                $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array("ORDER_ID" => $orderArr["ID"], "CODE" => array("COUNTRY_DELIVERY", "COUNTRY", "CITY", "STREET", "HOUSE")));
                $arFields['EMAIL_DELIVERY_ADDR'] = "Адрес доставки:<br>";
                while ($arVals = $db_vals -> Fetch()) {
                    if(!empty($arVals["VALUE"])){
                        $arFields['EMAIL_DELIVERY_ADDR'] .=  " ".$arVals['NAME'].": ".$arVals["VALUE"]."<br>";
                    }
                }
            }
            logger($arFields, $_SERVER["DOCUMENT_ROOT"].'/logs/SP.txt');
            $arFields['USER_DESCRIPTION'] = $orderArr['USER_DESCRIPTION'];
        }
    }


    //Добавляем состав заказа в шаблон
    AddEventHandler('main', 'OnBeforeEventSend', 'GetOrderList');
    function GetOrderList(&$arFields, &$arTemplate) {
        if (in_array($arTemplate["ID"],array(16,178,344,380, STATUS_ORDER_SP))) {
            $orderItems = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $arFields["ORDER_ID"]));
            $orderItemsResult = '<br /><center><h3 style="color:#393939;font-family: Segoe UI,Roboto,Tahoma,sans-serif;font-size: 20px;font-weight: 400;">Книги в заказе</h3></center><br />';
            while($orderItem = $orderItems->GetNext()) {
                $orderItemsResult .= '<a href="'.$orderItem['DETAIL_PAGE_URL'].'" target="_blank" style="color:#393939;font-family: Segoe UI,Roboto,Tahoma,sans-serif;font-size: 16px;line-height:150%;font-weight: 400;">'.$orderItem['NAME'].'</a><br />';
            }
            $arFields["ORDERED_BOOKS"] = $orderItemsResult;
        }
    }

    //Добавляем данные о пользователе в шаблон
    AddEventHandler('main', 'OnBeforeEventSend', 'AddCustomInfo');
    function AddCustomInfo (&$arFields, &$arTemplate) {
        $arFields["ORDER_USER"] = Message::getClientName($arFields["ORDER_ID"]);
    }

    AddEventHandler('main', 'OnBeforeEventSend', "AddLatestBooks");

    function AddLatestBooks (&$arFields, &$arTemplate) {
        if (in_array($arTemplate["ID"],array(16,160,168, STATUS_ORDER_SP))) {
            $latestBooks = "";
            $NewItems = CIBlockElement::GetList(array("PROPERTY_shows_a_day" => "DESC"), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "PROPERTY_STATE" => NEW_BOOK_STATE_XML_ID, "ACTIVE" => "Y", ">DETAIL_PICTURE" => 0), false, Array("nPageSize"=>3), array());
            while ($NewItemsList = $NewItems -> Fetch()){
                $pict = CFile::ResizeImageGet($NewItemsList["DETAIL_PICTURE"], array("width" => 140, "height" => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                $curr_sect = CIBlockSection::GetByID($NewItemsList["IBLOCK_SECTION_ID"]) -> Fetch();
                $latestBooks .= '
                <table align="left" border="0" cellpadding="8" cellspacing="0" class="tile" width="32%">
                <tbody>
                <tr>
                <td height="200" style="border-collapse: collapse;text-align:center;" valign="top" width="100%">
                <a href="https://www.alpinabook.ru/catalog/'.$curr_sect["CODE"].'/'.$NewItemsList["ID"].'/?utm_source=autotrigger&amp;rr_setemail=#EMAIL#&amp;utm_medium=email&amp;utm_term=newbooks&amp;utm_campaign=newordermail" target="_blank">
                <img alt="'.$NewItemsList["NAME"].'" src="'.$pict["src"].'" style="width: 140px; height: auto;" />
                </a>
                </td>
                </tr>
                <tr>
                <td align="center" height="18" style="color: #336699;font-weight: normal; border-collapse: collapse;font-family: Roboto,Tahoma,sans-serif;font-size: 16px;line-height: 150%;" valign="top" width="126">
                <a href="https://www.alpinabook.ru/catalog/'.$curr_sect["CODE"].'/'.$NewItemsList["ID"].'/?utm_source=autotrigger&amp;rr_setemail=#EMAIL#&amp;utm_medium=email&amp;utm_term=newbooks&amp;utm_campaign=newordermail" target="_blank">Подробнее о книге</a>
                </td>
                </tr>
                <tr>
                <td align="center" height="18" style="color: #336699;font-weight: normal; border-collapse: collapse;font-family: Roboto,Tahoma,sans-serif;font-size: 16px;line-height: 150%;padding-top:0;" valign="top" width="126">
                <a href="https://www.alpinabook.ru/catalog/'.$curr_sect["CODE"].'/'.$NewItemsList["ID"].'/?utm_source=autotrigger&amp;rr_setemail=#EMAIL#&amp;utm_medium=email&amp;utm_term=newbooks&amp;utm_campaign=newordermail" target="_blank">Купить</a>
                </td>
                </tr>
                </tbody>
                </table>';
                $i++;
            }
            $arFields["NEW_ITEMS_BLOCK"] = $latestBooks;
            $arFields["PROMO_PARTNER"] = "";
        }
    }

    AddEventHandler('main', 'OnBeforeEventSend', "DeliveryServiceName");

    function DeliveryServiceName (&$arFields, &$arTemplate) {
        if ($arTemplate["ID"] == 131 || $arTemplate["ID"] == EVENT_SALE_STATUS_CHANGED_AR) {
            $order_list=CSaleOrder::GetByID($arFields['ORDER_ID']);
            $arFields['HREF']='<a href="https://pochta.ru/tracking#'.$order_list['TRACKING_NUMBER'].'" target="_blank">на сайте Почты России</a>.';
            $arFields["DELIVERY_DOC_NUM"] = $order_list['TRACKING_NUMBER'];
            if ($order_list['DELIVERY_ID']==17) {
                $arFields['HREF']='<a href="https://pickpoint.ru/monitoring/?shop=alpinabook.ru&number='.$arFields['ORDER_ID'].'" target="_blank">на сайте PickPoint</a>.';
            } elseif ($order_list['DELIVERY_ID']==30) {
                $arFields['HREF']='<a href="http://flippost.com/instruments/online/" target="_blank">Flipost</a>.';
            } elseif ($order_list['DELIVERY_ID']==49) {
                $arFields['HREF']='<a href="http://boxberry.ru/tracking/?id='.$order_list['TRACKING_NUMBER'].'" target="_blank">на сайте Boxberry</a>.';
            }
        }
    }


    function RussianPostTrackingAgent() {
        if(CModule::IncludeModule("sale") && CModule::IncludeModule("iblock") && CModule::IncludeModule("main")) {
            $arFilterOrders = Array (
                //Временно чтобы не трогать все заказы
               ">=DATE_INSERT" => "01.09.2017",
               "STATUS_ID" => array("I", "AR"),
               "DELIVERY_ID" => array(
                    RUSSIAN_POST_DELIVERY_ID_1,
                    RUSSIAN_POST_DELIVERY_ID_2,
                    INTERNATIONAL_RUSSIAN_POST_ID_1,
                    INTERNATIONAL_RUSSIAN_POST_ID_2,
                    INTERNATIONAL_RUSSIAN_POST_ID_3,
                    INTERNATIONAL_RUSSIAN_POST_ID_4,
                    INTERNATIONAL_RUSSIAN_POST_ID_5
                ),
               "!TRACKING_NUMBER" => false
            );

            $dbOrders = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilterOrders, false, false, array("TRACKING_NUMBER", "ID", "DATE_INSERT", "STATUS"));
            while ($arOrder = $dbOrders->Fetch()) {
                $trackingNumber = trim(strval($arOrder["TRACKING_NUMBER"]));
                if(strlen($trackingNumber) > 0) {
                    $arOrdersList[$trackingNumber] = array(
                        "ID"      => $arOrder["ID"],
                        "ARRIVED" => ($arOrder["STATUS"] == "AR") ? true : false
                    );
                }
            };

            $get_ticket_xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pos="http://fclient.russianpost.org/postserver" xmlns:fcl="http://fclient.russianpost.org">
               <soapenv:Header/>
               <soapenv:Body>
                  <pos:ticketRequest>
                     <request>';
            foreach($arOrdersList as $trackingNumber => $order) {
                $get_ticket_xml .= '<fcl:Item Barcode="'.$trackingNumber.'"></fcl:Item>';
            }
            $get_ticket_xml .= '</request>
                     <login>'.RUSSIAN_POST_TRACKING_LOGIN.'</login>
                     <password>'.RUSSIAN_POST_TRACKING_PASSWORD.'</password>
                     <language>RUS</language>
                  </pos:ticketRequest>
               </soapenv:Body>
            </soapenv:Envelope>';


            $headers = array("Content-Type:	text/xml; charset=utf-8");
            $url = "https://tracking.russianpost.ru/fc/";

            $ch_get_ticket = curl_init();
            curl_setopt($ch_get_ticket, CURLOPT_URL, $url);
            curl_setopt($ch_get_ticket, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch_get_ticket, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch_get_ticket, CURLOPT_POST, true);
            curl_setopt($ch_get_ticket, CURLOPT_POSTFIELDS, $get_ticket_xml);
            curl_setopt($ch_get_ticket, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch_get_ticket, CURLOPT_ENCODING, "UTF-8");

            $soap_result_get_ticket = curl_exec($ch_get_ticket);

            if (!curl_errno($soap_result_get_ticket)) {
                $response_ticket_xml = simplexml_load_string($soap_result_get_ticket);

                $response_ticket_xml->registerXPathNamespace('S',   'http://schemas.xmlsoap.org/soap/envelope/');
                $response_ticket_xml->registerXPathNamespace('ns2', 'http://fclient.russianpost.org/postserver');
                $response_ticket_xml->registerXPathNamespace('ns3', 'http://fclient.russianpost.org');

                foreach ($response_ticket_xml->xpath('//ns2:ticketResponse') as $ticketResponse) {
                    $ticket = strval($ticketResponse->value);
                }
            }

            curl_close($ch_get_ticket);

            if(strlen($ticket) > 0) {

                //Почта России сначала генерирует тикет, на составление которого требуется время, после этого мы обращаемся к содержимому по этому тикету. Без интервала будет ошибка что тикет еще не готов
                sleep(20);

                $get_response_xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pos="http://fclient.russianpost.org/postserver">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <pos:answerByTicketRequest>
                            <ticket>'.$ticket.'</ticket>
                            <login>'.RUSSIAN_POST_TRACKING_LOGIN.'</login>
                            <password>'.RUSSIAN_POST_TRACKING_PASSWORD.'</password>
                        </pos:answerByTicketRequest>
                    </soapenv:Body>
                </soapenv:Envelope>';

                $ch_get_response = curl_init();
                curl_setopt($ch_get_response, CURLOPT_URL, $url);
                curl_setopt($ch_get_response, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch_get_response, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch_get_response, CURLOPT_POST, true);
                curl_setopt($ch_get_response, CURLOPT_POSTFIELDS, $get_response_xml);
                curl_setopt($ch_get_response, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch_get_response, CURLOPT_ENCODING, "UTF-8");

                $soap_result_get_response = curl_exec($ch_get_response);

                if (!curl_errno($ch_get_response)) {
                    $response_xml = simplexml_load_string($soap_result_get_response);

                    $response_xml->registerXPathNamespace('S',   'http://schemas.xmlsoap.org/soap/envelope/');
                    $response_xml->registerXPathNamespace('ns2', 'http://fclient.russianpost.org/postserver');
                    $response_xml->registerXPathNamespace('ns3', 'http://fclient.russianpost.org');

                    foreach ($response_xml->xpath('//ns3:Item') as $Item) {

                        $operTypeID = 0;
                        $operCtgID  = 0;
                        $barcode    = "";
                        $DateOper   = "";

                        if(isset($Item['Barcode'])) {

                            $barcode    = (string) $Item['Barcode'];
                            $orderID    = intval($arOrdersList[$barcode]["ID"]);

                            $operTypeID = (int) $Item->xpath('ns3:Operation')[count($Item->xpath('ns3:Operation')) - 1]["OperTypeID"];
                            $operCtgID  = (int) $Item->xpath('ns3:Operation')[count($Item->xpath('ns3:Operation')) - 1]["OperCtgID"];
                            $DateOper   = (string) $Item->xpath('ns3:Operation')[count($Item->xpath('ns3:Operation')) - 1]["DateOper"];

                            if($operTypeID == 8 && $operCtgID == 2 && strlen($DateOper) > 0 && !$arOrdersList[$barcode]["ARRIVED"]) {

                                //Проверим заполнено ли свойство с датой доставки, если да выход
                                $dbPropArrivedValue = CSaleOrderPropsValue::GetList(
                                    array("SORT" => "ASC"),
                                    array(
                                        "ORDER_ID" => $orderID,
                                        "CODE"     => "RUSPOST_ARRIVED"
                                    )
                                );

                                //Добавим время и отправим письмо
                                if ($arPropArrived = CSaleOrderProps::GetList(array(), array('CODE' => "RUSPOST_ARRIVED"))->Fetch()) {
                                    $arArrivedFields = array(
                                        "NAME"           => $arPropArrived['NAME'],
                                        "CODE"           => $arPropArrived['CODE'],
                                        "ORDER_PROPS_ID" => $arPropArrived['ID'],
                                        'ORDER_ID'       => $orderID,
                                        "VALUE"          => $DateOper
                                    );
                                }

                                if ($arPropArrivedValue = $dbPropArrivedValue->Fetch()) {
                                    if(CSaleOrderPropsValue::Update($arPropArrivedValue["ID"], $arArrivedFields)) {
                                        CSaleOrder::StatusOrder($orderID, "AR");
                                    };
                                } else {
                                    if(CSaleOrderPropsValue::Add($arArrivedFields)) {
                                        CSaleOrder::StatusOrder($orderID, "AR");
                                    };
                                }

                            } elseif($operTypeID == 2 && strlen($DateOper) > 0) {
                            //Посылка принята
                                //Проверим заполнено ли свойство с датой доставки, если да выход
                                $dbPropReceivedValue = CSaleOrderPropsValue::GetList(
                                    array("SORT" => "ASC"),
                                    array(
                                        "ORDER_ID" => $orderID,
                                        "CODE"     => "RUSPOST_RECEIVED"
                                    )
                                );

                                //Добавим время и отправим письмо
                                if ($arPropReceived = CSaleOrderProps::GetList(array(), array('CODE' => "RUSPOST_RECEIVED"))->Fetch()) {
                                    $arReceivedFields = array(
                                        "NAME"           => $arPropReceived['NAME'],
                                        "CODE"           => $arPropReceived['CODE'],
                                        "ORDER_PROPS_ID" => $arPropReceived['ID'],
                                        'ORDER_ID'       => $orderID,
                                        "VALUE"          => $DateOper
                                    );
                                }

                                if ($arPropReceivedValue = $dbPropReceivedValue->Fetch()) {
                                    if(CSaleOrderPropsValue::Update($arPropReceivedValue["ID"], $arReceivedFields)) {
                                        CSaleOrder::StatusOrder($orderID, "F");
                                    };
                                } else {
                                    if(CSaleOrderPropsValue::Add($arReceivedFields)) {
                                        CSaleOrder::StatusOrder($orderID, "F");
                                    };
                                }
                            }
                        }
                    }
                }
            }
        }
        return "RussianPostTrackingAgent();";
    }

    // --- couriers popup in admin
    AddEventHandler("main", "OnAdminListDisplay", "curInit");

    function curInit() {
        if ($GLOBALS["APPLICATION"] -> GetCurPage() == "/bitrix/admin/sale_order_detail.php" || $GLOBALS["APPLICATION"] -> GetCurPage() == "/bitrix/admin/sale_order.php") {
            $GLOBALS['APPLICATION'] -> AddHeadScript("/admin_modules/couriers/js/couriersListeners.js");
            $GLOBALS['APPLICATION'] -> AddHeadScript("/admin_modules/couriers/js/orderAdmin.class.js");
            $GLOBALS['APPLICATION'] -> AddHeadScript("/admin_modules/couriers/js/popup.class.js");
            $GLOBALS['APPLICATION'] -> AddHeadScript("/admin_modules/couriers/js/index.js");
            $GLOBALS['APPLICATION'] -> SetAdditionalCSS("/admin_modules/couriers/css/style.css");
        }
    }

    //Смена адреса пунтка самовывоза боксберри в админке
    \Bitrix\Main\EventManager::getInstance()->addEventHandler(
        'main',
        'OnAdminListDisplay',
        'BoxberryChangeAdress'
    );
    function BoxberryChangeAdress() {
        global $APPLICATION;
        $url = $APPLICATION->GetCurPage();
        if (preg_match("/bitrix\/admin\/sale_order_view.php/i", $url)) {
            $APPLICATION->AddHeadString('<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>');
            $APPLICATION->AddHeadString('<script type="text/javascript" src="https://points.boxberry.de/js/boxberry.js"></script>');
            $APPLICATION->AddHeadString('<script type="text/javascript" src="/js/change-boxberry-address.js?'.date('U').'"></script>');
        }
    }
    //Получение этикетки для бланков заказов, сделанных через PickPoint

    function MakeLabelPickPoint($orderId) {
        global $arParams;
        //Авторизация на сервере PickPoint для получения ключа сессии (Необходим для дальнейшей работы с API)
        $dataLogin = array('Login' => $arParams["PICKPOINT"]["DATA_ACCESS"]["Login"], 'Password' => $arParams["PICKPOINT"]["DATA_ACCESS"]["Password"]); //Необходимо указать доступы к API выданные клиенту
        $ikn = $arParams["PICKPOINT"]["IKN"]; //Номер контракта клиента
        $urlLogin = "http://e-solution.pickpoint.ru/api/login";
        $content = json_encode($dataLogin);
        $curl = curl_init($urlLogin);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($json_response, true); //Получили ключ сессии(Далее работа будет производится на основе его)
        //Получаем номер отправления в PickPoint по Id заказа
        $obItem = CPickpoint::SelectOrderPostamat($orderId);
        $item = $obItem->Fetch();
        //Отправляем запрос для получения этикетки в формате pdf
        $dataSend = array('SessionId' => $response["SessionId"], 'Invoices' => array($item["PP_INVOICE_ID"]));
        $urlLabel = "http://e-solution.pickpoint.ru/api/makelabel";
        $content = json_encode($dataSend);
        //		arshow($content);
        $order_info = CSaleOrder::GetByID($orderId);
        $curl = curl_init($urlLabel);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($json_response, true); //Получили ключ сессии(Далее работа будет производится на основе его)
        //Преобразуем массив байтов в изображение
        if (!empty($json_response)) {
            $imagick = new Imagick();
            $imagick->setResolution(200, 200);
            $imagick->readImageBlob($json_response);
            $imagick->cropImage(500, 450, 250, 80);
            $imagick->writeImages($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/pickpoint/label/'.$orderId.'.jpg', false);
        }
    }

    // Получение этикетки для boxbery
    function SetLabellCheckBoxbery($track) {
        $url='http://api.boxberry.de/json.php?token='.BOXBERRY_TOKEN.'&method=ParselCheck&ImId='.$track;

        // $arOrder["TRACKING_NUMBER"] - Код для отслеживания.
        $handle = fopen($url, "rb");
        $contents = stream_get_contents($handle);
        fclose($handle);
        $data=json_decode($contents,true);
        if ($data["label"]) {
            // если произошла ошибка и ответ не был получен.
            //		arshow($content);
            //Преобразуем массив байтов в изображение
            $imagick = new Imagick();
            $imagick->setResolution(200, 200);
            $imagick->readImage($data["label"]);
          //  $imagick->cropImage(500, 450, 250, 80);
            $imagick->writeImages($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/boxbery/'.$track.'.jpg', false);
        }
    }




    AddEventHandler("main", "OnBeforeProlog", "checkUser");
    function checkUser() {
        global $USER, $APPLICATION;
        if (!$USER->IsAdmin())
            $APPLICATION->SetAdditionalCSS("/css/temp.css");
    }

    //Add coupon list item in admin menu
    AddEventHandler("main", "OnBuildGlobalMenu", "extraMenu");
    function extraMenu(&$adminMenu, &$moduleMenu) {
        //страница со списком купонов в админке
        $moduleMenu[] = array(
            "parent_menu" => "global_menu_marketing",
            "section"		=> "webgk.coupons",
            "sort"		=> 500,
            "url"			=> "coupon-list.php?lang=".LANG,
            "text"		=> 'Список купонов правил работы с корзиной',
            "title"		=> 'Фильтруемый список купонов правил работы с корзиной',
            "icon"		=> "form_menu_icon",
            "page_icon" => "form_page_icon",
            "items_id"	=> "menu_webgk.coupons",
            "items"		=> array()
        );

        //страница экспорта заказов в "boxberry"
        $moduleMenu[] = array(
            "parent_menu" => "global_menu_store",
            "section"		=> "webgk.boxberry_export",
            "sort"		=> 150,
            "url"			=> "boxberry_export.php?lang=".LANG,
            "text"		=> 'Boxberry экспорт',
            "title"		=> 'Экспорт заказов Boxberry',
            "icon"		=> "form_menu_icon",
            "page_icon" => "form_page_icon",
            "items_id"	=> "menu_webgk.boxberry_export",
            "items"		=> array()
        );

        //страница экспорта заказов в "accordpost"
        $moduleMenu[] = array(
            "parent_menu" => "global_menu_store",
            "section"		=> "webgk.accordpost_export",
            "sort"		=> 150,
            "url"			=> "accordpost_export.php?lang=".LANG,
            "text"		=> 'Accordpost экспорт',
            "title"		=> 'Экспорт заказов Accordpost',
            "icon"		=> "form_menu_icon",
            "page_icon" => "form_page_icon",
            "items_id"	=> "menu_webgk.accordpost_export",
            "items"		=> array()
        );

        $moduleMenu[] = array(
            "parent_menu" => "global_menu_store",
            "section"	  => "webgk.accordpost_export",
            "sort"		  => 110,
            "url"		  => "sale_order_filter.php?lang=".LANG,
            "text"		  => 'Фильтр заказов по разделам книг',
            "title"		  => 'Фильтр заказов по разделам книг',
            "icon"		  => "form_menu_icon",
            "page_icon"   => "form_page_icon",
            "items_id"	  => "menu_webgk.accordpost_export",
            "items"		  => array()
        );
    }

    AddEventHandler("sale", "OnSaleCancelOrder", "changingOrderStatusAfterCancelling");
    function changingOrderStatusAfterCancelling($ID, $val) {
        if ($val == "Y") {
            CSaleOrder::StatusOrder($ID, "A");
        }
    }

    //Handlers for PickPoint improvements
    AddEventHandler("sale", "OnOrderSave", Array("CustomPickPoint", "RewriteOrderDescription"));

    //Class for PickPoint improvements
    class CustomPickPoint {

        //Rewriting user description in ordres with PickPoint delivery
        function RewriteOrderDescription($id, $arFields) {
            GLOBAL $arParams;
            if ($arFields["DELIVERY_ID"] == $arParams["PICKPOINT"]["DELIVERY_ID"]) {
                if (COption::GetOptionString($arParams["PICKPOINT"]["MODULE_ID"], $arParams["PICKPOINT"]["ADD_INFO_NAME"], "")) {
                    $arPropFields = array("ORDER_ID" => $id, "NAME" => $arParams["PICKPOINT"]["ADDRESS_TITLE_PROP"], "VALUE" => $_SESSION["PICKPOINT_ADDRESS"]);
                    if ($arFields["PERSON_TYPE_ID"] == $arParams["PICKPOINT"]["LEGAL_PERSON_ID"]) {
                        $arPropFields["ORDER_PROPS_ID"] = $arParams["PICKPOINT"]["LEGAL_ADDRESS_ID"];
                        $arPropFields["CODE"] = $arParams["PICKPOINT"]["LEGAL_ADDRESS_CODE"];
                    } else if ($arFields["PERSON_TYPE_ID"] == $arParams["PICKPOINT"]["NATURAL_PERSON_ID"]) {
                        $arPropFields["ORDER_PROPS_ID"] = $arParams["PICKPOINT"]["NATURAL_ADDRESS_ID"];
                        $arPropFields["CODE"] = $arParams["PICKPOINT"]["NATURAL_ADDRESS_CODE"];
                    }
                    CSaleOrderPropsValue::Add($arPropFields);
                    unset($_SESSION["PICKPOINT_ADDRESS"]);
                }
            }
        }

        function getDeliveryDate($orderID) {
            GLOBAL $arParams;
            //Авторизация на сервере PickPoint для получения ключая сессии (Необходим для дальнейшей работы с API)
            $dataLogin = array('Login' => $arParams["PICKPOINT"]["DATA_ACCESS"]["Login"], 'Password' => $arParams["PICKPOINT"]["DATA_ACCESS"]["Password"]); //Необходимо указать доступы к API выданные клиенту
            $urlLogin = "http://e-solution.pickpoint.ru/api/login";
            $content = json_encode($dataLogin);
            $curl = curl_init($urlLogin);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array("Content-type: application/json"));
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            $json_response = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $response = json_decode($json_response, true); //Получили ключ сессии(Далее работа будет производится на основе его)
            //Значения переменный для получения ID постамата данного заказа
            $fromCity = "Москва";
            $obData = CPickpoint::SelectOrderPostamat($orderID);
            while ($postamatData = $obData -> Fetch()) {
                $PTnumber = $postamatData["POSTAMAT_ID"];
            }

            //Данные для получения ориентировочных сроков доставки
            $dataTarifCalc = array('SessionId'=>$response["SessionId"], 'FromCity' => $fromCity, 'ToPT' => $PTnumber);


            $content = json_encode($dataTarifCalc);
            $urlTarif = "http://e-solution.pickpoint.ru/api/getzone";
            $curlTarif = curl_init($urlTarif);
            curl_setopt($curlTarif, CURLOPT_HEADER, false);
            curl_setopt($curlTarif, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlTarif, CURLOPT_HTTPHEADER,
                array("Content-type: application/json"));
            curl_setopt($curlTarif, CURLOPT_POST, true);
            curl_setopt($curlTarif, CURLOPT_POSTFIELDS, $content);
            $json_response = curl_exec($curlTarif);
            $status = curl_getinfo($curlTarif, CURLINFO_HTTP_CODE);
            curl_close($curlTarif);
            $responseCalcTarif = json_decode($json_response, true);
            $order_info = CSaleOrder::GetByID($orderID);
            $delivery_min_time = strtotime ($order_info["DATE_INSERT"]) + $responseCalcTarif["Zones"][0]["DeliveryMin"] * 86400 + 2 * 86400;
            $delivery_min_date = strtolower(FormatDate("j F", MakeTimeStamp(date("d.m.Y", $delivery_min_time), "DD.MM.YYYY HH:MI:SS")));
            $delivery_max_time = $delivery_min_time + 5 * 86400;
            $delivery_max_date = strtolower(FormatDate("j F", MakeTimeStamp(date("d.m.Y", $delivery_max_time), "DD.MM.YYYY HH:MI:SS")));
            $date = $delivery_min_date. " - " . $delivery_max_date;
            return $date;
        }
    }

    /*AddEventHandler('main', 'OnEpilog', '_Check404Error', 1);
    function _Check404Error() {
    if (defined('ERROR_404') && ERROR_404=='Y' || CHTTP::GetLastStatus() == "404 Not Found") {
    GLOBAL $APPLICATION;
    $APPLICATION->RestartBuffer();
    require $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/header.php';
    require $_SERVER['DOCUMENT_ROOT'].'/404.php';
    require $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/footer.php';
    }
    } */

    AddEventHandler('sale', 'OnSalePayOrder', 'ChangeStatusForCertificate');

    function ChangeStatusForCertificate($ID, $val) {
        if ($val == "Y") {
            $dbOrderProps = CSaleOrderPropsValue::GetList(
                 array("SORT" => "ASC"),
                 array("ORDER_ID" => $ID, "CODE"=>array("CODE_COUPON"))
             );
             while ($arOrderProps = $dbOrderProps->GetNext()){
                 if(!empty($arOrderProps["VALUE"])){
                     $certificate_ob = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CERTIFICATE_IBLOCK_ID, "PROPERTY_COUPON_CODE" => $arOrderProps["VALUE"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_COUPON_CODE"));
                     if($ar_certificate = $certificate_ob->fetch()) {
                         CSaleOrder::StatusOrder($ID, STATUS_SERTIFICATE);
                     }
                 }
             }
        }
    }

    AddEventHandler('sale', 'OnSalePayOrder', 'AddNewGiftIBlockElement');

    /***************
    *
    * добавление нового элемент в инфоблок книг в дар после оплаты соответствующего заказа с подвешенной книги
    *
    * @param int $ID - ID заказа, к которому применена оплата
    * @var array $arProps - массив свойств для создаваемого элемента инфоблока
    * @var array $basket_items - информация о подвешенном товаре, содержащемся в данном заказе
    *
    ***************/

    function AddNewGiftIBlockElement ($ID, $val) {
        if ($val == "Y") {
            $curr_order = CSaleOrder::GetByID ($ID);
            if (!empty($curr_order["USER_DESCRIPTION"]) && $curr_order["DELIVERY_ID"] == PICKUP_DELIVERY_ID) {
                $new_gift_book = new CIBlockElement;
                $ar_props = array();
                $basket_items = CSaleBasket::GetList(
                    array(),
                    array(
                        "ORDER_ID" => $ID
                    ),
                    false,
                    false,
                    array()
                ) -> Fetch();
                $dash_pos = intval(strpos($curr_order["USER_DESCRIPTION"], " "));
                $ar_props[GIFT_BOOK_PROPERTY_ID] = $basket_items["PRODUCT_ID"];
                $ar_props[GIFT_BOOK_QUANTITY_PROPERTY_ID] = intval($basket_items["QUANTITY"]);
                $ar_props[GIFT_BOOK_BUYER_EMAIL_PROPERTY_ID] = substr($curr_order["USER_DESCRIPTION"], $dash_pos + 1);
                $ar_fields = array(
                    "IBLOCK_ID" => SUSPENDED_BOOKS_BUYERS_IBLOCK,
                    "NAME" => substr($curr_order["USER_DESCRIPTION"], 0, $dash_pos),
                    "PROPERTY_VALUES" => $ar_props
                );

                $new_gift_book -> Add ($ar_fields);
                $mail_fields = array("EMAIL" => $ar_props[GIFT_BOOK_BUYER_EMAIL_PROPERTY_ID]);
                CEvent::Send ("BOUGHT_SUSPENDED_BOOK", "s1", $mail_fields, "N");
            }
        }
    }

    function UserOrdersCount($user_id) {
        CModule::IncludeModule("sale");
        $order_list = CSaleOrder::GetList(array(), array("USER_ID" => $user_id), false, false, array());
        $count = $order_list -> SelectedRowsCount();
        return $count;
    }


    /**
    *
    * Проверяет, есть ли у пользователя рекуррентные карты
    *
    * @param $user_id int
    * @return string|bool
    *
    * */
    function isUserHaveRecurrentCard($user_id) {
        $users = CUser::GetList(
            ($by = ""),
            ($order = ""),
            Array(
                "ID" => $user_id
            ),
            Array(
                "SELECT" => Array("UF_RECURRENT_CARD_ID")
            )
        );
        if ($user = $users->NavNext(true, "f_")) {
            return $user["UF_RECURRENT_CARD_ID"];
        } else {
            return false;
        }
    }


    /**
    *
    * Выполнить запрос
    *
    * @param array $data
    * @param string $method
    * @param string $request
    * @param string $headers
    * @return mixed $result
    *
    * */

    function performQuery($data, $method = "GET", $request, $headers) {
        $postdata = http_build_query(
            $data
        );

        $opts = array(
            'http' => array(
                'method' => $method,
                'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL . $headers,
                'content' => $postdata
            ),
            'ssl' => array(
                'verify_peer' => false
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($request, false, $context);

        return $result;
    }

    /***********
    *
    * при добавлении/изменении скидки на товар проставлять свойство "Показывать иконку скидки" у данного товара
    * если активность скидки "Да"
    *
    * @var array $products_ids - ID привязанных к скидке товаров
    *
    */
    AddEventHandler("catalog", "OnDiscountUpdate", "activateShowingDiscountIcon");
    AddEventHandler("catalog", "OnDiscountAdd", "activateShowingDiscountIcon");

    function activateShowingDiscountIcon ($ID, $arFields) {
        $products_ids = array();
        foreach ($arFields["PRODUCT_IDS"] as $product_id) {
            $products_ids[] = $product_id;
        }

        if (!empty($products_ids)) {
            if ($arFields["ACTIVE"] == "Y") {
                foreach ($products_ids as $product_id) {
                    CIBlockElement::SetPropertyValuesEx($product_id, false, array("show_discount_icon" => PROPERTY_SHOWING_DISCOUNT_ICON_VARIANT_ID));
                }
            } else {
                foreach ($products_ids as $product_id) {
                    CIBlockElement::SetPropertyValuesEx($product_id, false, array("show_discount_icon" => "N"));
                }
            }
        } else {
            $discount_info = CCatalogDiscount::GetList (array(), array("ID" => $ID), false, false, array("PRODUCT_ID"));
            while ($discount = $discount_info -> Fetch()) {
                if (!in_array($discount["PRODUCT_ID"], $products_ids)) {
                    $products_ids[] = $discount["PRODUCT_ID"];
                }
            }
            if (!empty($products_ids[0])) {
                if ($arFields["ACTIVE"] == "Y") {
                    foreach ($products_ids as $product_id) {
                        CIBlockElement::SetPropertyValuesEx($product_id, false, array("show_discount_icon" => PROPERTY_SHOWING_DISCOUNT_ICON_VARIANT_ID));
                    }
                } else {
                    foreach ($products_ids as $product_id) {
                        CIBlockElement::SetPropertyValuesEx($product_id, false, array("show_discount_icon" => "N"));
                    }
                }
            }

        }
    }

    //агент для выгрузки статусов заказов из личного кабинета Boxberry
    function BoxberryListStatuses() {

        $bTmpUser = False;
        if (!isset($GLOBALS["USER"]) || !is_object($GLOBALS["USER"])) {
            $bTmpUser = True;
            $GLOBALS["USER"] = new CUser;
        }

        $arFilter = Array(
            "!TRACKING_NUMBER" => null,
            "DELIVERY_ID" => BOXBERRY_PICKUP_DELIVERY_ID,
            "!STATUS_ID" => 'F'
        );
        if ($db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter)) {
            while ($ar_sales = $db_sales->Fetch()) {
                $orders_tracking_number[$ar_sales['ID']] = $ar_sales['TRACKING_NUMBER'];
            }
        };
        foreach($orders_tracking_number as $order_id => $order_tracking_number) {
            $url='http://api.boxberry.de/json.php?token='.BOXBERRY_TOKEN.'&method=ListStatusesFull&ImId='.$order_tracking_number;
            // XXXXXX - код отслеживания заказа
            $handle = fopen($url, "rb");
            $contents = stream_get_contents($handle);
            fclose($handle);
            $data=json_decode($contents,true);
            if ($data['err']) {
                // если произошла ошибка и ответ не был получен:
                echo $data['err'];
            } else {
                foreach($data[statuses] as $status) {
                    $last_status = $status;
                }
                if ($last_status['Name'] == BOXBERRY_DELIVERY_SUCCES) {
                    $order = Bitrix\Sale\Order::load($order_id);
                    $order->setField('STATUS_ID', 'F');
                    $order->save();
                }
            }
        }
        if ($bTmpUser) {
            unset($GLOBALS["USER"]);
        }
        return 'BoxberryListStatuses();';
    }

    //агент для выгрузки статусов заказов из личного кабинета accordpost
    function AccordListStatuses() {
        //Константы для curl запроса
        define('CFG_NL', "\n");
        define('CFG_REQUEST_POST', 1);
        define('CFG_REQUEST_FULLURL', 'https://api.accordpost.ru/ff/v1/wsrv/');
        define('CFG_REQUEST_TIMEOUT', 1);
        define('CFG_CONTENT_TYPE', 'text/xml; charset=utf-8');
        //Шапка с доступами и типом запроса
        $xmlBody = '<request request_type="104" partner_id="'.ACCORDPOST_PARTNER_ID.'" password="'.ACCORDPOST_PASSWORD.'" doc_type = "6"/>';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, CFG_REQUEST_FULLURL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlBody);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        if ($out = curl_exec($curl)) {
            $ar_idoc_id = array();
            $xmlBody = '';
            $ar_barcode_list = array();
            $response = new SimpleXMLElement($out);
            foreach ($response->doc as $doc) {
                $ar_idoc_id[] = $doc['idoc_id'];
                $xmlBody_second_request = '<request request_type="105" partner_id="'.ACCORDPOST_PARTNER_ID.'" password="'.ACCORDPOST_PASSWORD.'" idoc_id="'.$doc['idoc_id'].'"/>';
                $curl_second_request = curl_init();
                curl_setopt($curl_second_request, CURLOPT_URL, CFG_REQUEST_FULLURL);
                curl_setopt($curl_second_request, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_second_request, CURLOPT_POST, true);
                curl_setopt($curl_second_request, CURLOPT_POSTFIELDS, $xmlBody_second_request);
                curl_setopt($curl_second_request, CURLOPT_SSL_VERIFYPEER, 0);
                if ($out_second_request = curl_exec($curl_second_request)) {
                    $response_second_request = new SimpleXMLElement($out_second_request);
                    foreach ($response_second_request->doc->parcel as $parcel) {
                        logger($parcel, $_SERVER["DOCUMENT_ROOT"].'/logs/accord_post.txt');
                        //поменять на barcode
                        $ar_barcode_list[strval($parcel['order_id'])] = strval($parcel['Barcode']);
                        $arFilter = Array(
                            "TRACKING_NUMBER" => null,
                            "ID" => intval($parcel['order_id']),
                            "!STATUS_ID" => 'F'
                        );

                        $db_sales = CSaleOrder::GetList(array(), $arFilter) -> Fetch();
                        if($db_sales['ID']) {
                            CSaleOrder::Update(intval($parcel['order_id']), array("TRACKING_NUMBER" => strval($parcel['Barcode'])));
                            $order = Bitrix\Sale\Order::load(intval($parcel['order_id']));
                            $order->setField('STATUS_ID', 'I');
                            $order->save();
                        }
                    }
                } ;
                curl_close($curl_second_request);
            }
        }
        curl_close($curl);
        return 'AccordListStatuses();';
    }

    //Логирование изменение статусов заказа, нужно удалить когда проблема исчезнет
    Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleOrderBeforeSaved', 'OnBeforeOrderUpdateLogger');
    function OnBeforeOrderUpdateLogger(Main\Event $event) {
        $order = $event->getParameter("ENTITY");
        $status_id = $order->GetField("STATUS_ID");
        $order_id = $order->GetField("ID");
        $date = date('Y-m-d, H:i:s');
        global $APPLICATION, $USER;
        $userID = $USER->GetID();
        $curPage = $APPLICATION->GetCurPage();
        $order_log = 'Date: '.$date.'; CurPage: '.$curPage.'; IP: '.$_SERVER['REMOTE_ADDR'].'; UserID: '.$userID.'; OrderStatus: '.$status_id.'; OrderID: '.$order_id.';';
        $file = $_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/order_log.log';
       // logger($order_log, $file);
    }

    /**
    *
    * Создаем купоны для заказа сертификатов
    *
    * @param int $order_id - номер заказа, хотя это просто номер элемента инфоблока
    * @param int $quantity
    * @param int $basket_rule_id
    *
    * */

    function generateCouponsForOrder($order_id, $quantity, $basket_rule_id) {

        $coupon_active_date = new \Bitrix\Main\Type\DateTime();
        $coupon_active_from = clone $coupon_active_date;
        $coupon_active_to = $coupon_active_date -> add('+6 months');

        for ($i = 1; $i <= $quantity; $i++) {

            //Битриксовая недокументированная функция, генерирует просто ключ в виде строки
            $arFields['COUPON'] = CatalogGenerateCoupon();
            $arFields['DISCOUNT_ID'] = $basket_rule_id;
            $arFields['ACTIVE'] = 'Y';
            $arFields['TYPE'] = 2;
            $arFields['MAX_USE'] = 1;
            $arFields['ACTIVE_FROM'] = $coupon_active_from;
            $arFields['ACTIVE_TO'] = $coupon_active_to;

            //Фукнкция из ядра, создаем новый купон в правилах корзины
            $obCoupon = \Bitrix\Sale\Internals\DiscountCouponTable::add($arFields);

            //Получаем ID сгенерированного купона
            $discountIterator = \Bitrix\Sale\Internals\DiscountCouponTable::getList(array(
                'select' => array('ID'),
                'filter' => array('COUPON' => $arFields['COUPON'])
            ));

            //Собираем массив с ID купонов
            if ($arDiscountIterator = $discountIterator -> fetch()) {
                $arCertificateID[] = $arDiscountIterator['ID'];
            }
            //Собираем массив с кодами купонов
            $arCouponCode[] = $arFields['COUPON'];
        }

        $props = array(
            'COUPON_ID' => $arCertificateID,
            'COUPON_CODE' => $arCouponCode
        );


        $props_update = array (
            'DATE_ACTIVE_FROM' => $coupon_active_from -> toString(),
            'DATE_ACTIVE_TO' => $coupon_active_to -> toString()
        );
        // Установим новое значение для данного свойства данного элемента

        CIBlockElement::SetPropertyValuesEx($order_id, false, $props);

        $el = new CIBlockElement;
        $res = $el->Update($order_id, $props_update);
        //Возвращаем новые купоны
        return $arCouponCode;
    }

    AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "certificatePayed");
    AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "certificateUpdate");

    /**
    *
    * Проверяем, оплачен ли заказ сертификата
    * За свойство оплачен выдается свойство активность
    *
    * */
    function certificatePayed(&$arParamsCertificate) {
        GLOBAL $arParams;

        if ($arParamsCertificate['IBLOCK_ID'] == CERTIFICATE_IBLOCK_ID) {
            $current_object = CIBlockElement::GetList(
                Array(),
                Array("ID" => $arParamsCertificate['ID']),
                false,
                Array("nPageSize" => 1),
                Array("ID", "NAME", "ACTIVE", "XML_ID", "PROPERTY_CERT_QUANTITY", "PROPERTY_NATURAL_EMAIL", "PROPERTY_NATURAL_NAME", "PROPERTY_LEGAL_EMAIL", "PROPERTY_LEGAL_NAME", "PROPERTY_CERT_PRICE", "ACTIVE_FROM", "ACTIVE_TO")
            );
            if ($current_values = $current_object->Fetch()) {
                $order_id = $current_values['ID'];
                $quantity = $current_values['PROPERTY_CERT_QUANTITY_VALUE'];
                $basket_rule_id = $current_values['XML_ID'];
                $cert_name = $current_values['NAME'];
                $cert_price = $current_values['PROPERTY_CERT_PRICE_VALUE'];
                $user_email = '';
                $user_name = '';
                if (!empty($current_values['PROPERTY_NATURAL_EMAIL_VALUE']) && !empty($current_values['PROPERTY_NATURAL_NAME_VALUE'])) {
                    $user_name = $current_values['PROPERTY_NATURAL_NAME_VALUE'];
                    $user_email = $current_values['PROPERTY_NATURAL_EMAIL_VALUE'];
                } elseif (!empty($current_values['PROPERTY_LEGAL_EMAIL_VALUE']) && !empty($current_values['PROPERTY_LEGAL_NAME_VALUE'])) {
                    $user_name = $current_values['PROPERTY_LEGAL_NAME_VALUE'];
                    $user_email = $current_values['PROPERTY_LEGAL_EMAIL_VALUE'];
                }
            }
            $first_coupon_array_key = key($arParamsCertificate['PROPERTY_VALUES'][CERTIFICATE_ORDERS_COUPONS_CODE_FIELD]);
            //Сохраним все купоны после генерации
            $arCoupons = array();

            if (!$arParamsCertificate['PROPERTY_VALUES'][CERTIFICATE_ORDERS_COUPONS_CODE_FIELD][$first_coupon_array_key]['VALUE'] && $arParamsCertificate['ACTIVE'] == "Y" && !empty($quantity)) {

                $arCoupons = generateCouponsForOrder($order_id, $quantity, $basket_rule_id);
            }
            if (!empty($arCoupons)) {
                $couponListHTML = '';
                foreach($arCoupons as $couponItem) {
                    if (!empty($couponItem)) {
                        $couponListHTML .= '<tr><td align="right" style="border-collapse: collapse;color:#393939;font-family: "Open Sans","Segoe UI",Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 100%;font-style: normal;letter-spacing: normal;padding-top:10px;" valign="top">';
                        $couponListHTML .= $couponItem;
                        $couponListHTML .= '</td></tr>';
                    }
                }
                $arMailFields = array(
                    "COUPON_LIST" => $couponListHTML,
                    "ORDER_ID"		=> 'CERT_'.$order_id,
                    "EMAIL"			=> trim($user_email),
                    "NAME"			=> $user_name,
                    "CERT_NAME"		=> $cert_name,
                    "CERT_QUANTITY" => $quantity,
                    "CERT_PRICE"	=> $cert_price,
                    "TOTAL_SUM"		=> $quantity * $cert_price
                );
                if (!empty($arCoupons) && !empty($user_email)) {
                    CEvent::Send(SEND_CERTIFICATE_TO_USER_EVENT, "s1", $arMailFields, "N");
                }
            }
        }
    }


    /*
    *
    * Перед обновлением элемента проверим не менялась ли дата, если дата менялась обновим сертификаты в базе
    */
    function certificateUpdate(&$arParamsCertificate) {
        if ($arParamsCertificate['IBLOCK_ID'] == CERTIFICATE_IBLOCK_ID && (!empty($arParamsCertificate['ACTIVE_FROM']) || !empty($arParamsCertificate['ACTIVE_TO']))) {
            $current_object = CIBlockElement::GetList(Array(), Array("ID" => $arParamsCertificate['ID']), false, Array(), Array("ID", "PROPERTY_COUPON_ID", "ACTIVE_FROM", "ACTIVE_TO"));
            while($current_values = $current_object->Fetch()) {
                if (($arParamsCertificate['ACTIVE_FROM'] != $current_values['ACTIVE_FROM'] || $arParamsCertificate['ACTIVE_TO'] != $current_values['ACTIVE_TO']) && (!empty($current_values['ACTIVE_FROM']) || !empty($current_values['ACTIVE_TO']))) {
                    $ar_coupon_id[] = $current_values['PROPERTY_COUPON_ID_VALUE'];
                }
            }
            if (!empty($ar_coupon_id)) {
                $date_from = new \Bitrix\Main\Type\DateTime($arParamsCertificate['ACTIVE_FROM']);
                $date_to = new \Bitrix\Main\Type\DateTime($arParamsCertificate['ACTIVE_TO']);
                $fields = array(
                    'ACTIVE_FROM' => $date_from,
                    'ACTIVE_TO' => $date_to
                );
                foreach ($ar_coupon_id as $coupon_id) {
                    \Bitrix\Sale\Internals\DiscountCouponTable::update($coupon_id, $fields);
                }
            }
        }
    }

    // класс для отправки сообщений о новых заказах сертификатов
    class CertificateMail {
        public static function newLegalPersonOrder($order_id) {
            $view_link = sprintf("https://www.alpinabook.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=%d&type=service&ID=%d", CERTIFICATE_IBLOCK_ID, $order_id);
            CEvent::Send(NEW_LEGAL_PERSON_CERTIFICATE_ORDER_EVENT, "s1", array("VIEW_LINK" => $view_link),"N");
        }
    }


    //Обновление HL блока с поисковыми индексами
    \Bitrix\Main\EventManager::getInstance()->addEventHandler(
        'iblock',
        'OnAfterIBlockElementUpdate',
        'HLBlockElementUpdate'
    );
    \Bitrix\Main\EventManager::getInstance()->addEventHandler(
        'iblock',
        'OnAfterIBlockElementAdd',
        'HLBlockElementUpdate'
    );
    function HLBlockElementUpdate($arElement){

        if($arElement['IBLOCK_ID'] == CATALOG_IBLOCK_ID || $arElement['IBLOCK_ID'] == AUTHORS_IBLOCK_ID) {
            if(!empty($arElement['WF_PARENT_ELEMENT_ID'])){
                $arSelect = Array("ID", "NAME", "IBLOCK_ID", "DATE_ACTIVE_FROM", "PROPERTY_SEARCH_WORDS", "PROPERTY_AUTHORS", "PROPERTY_COVER_TYPE", "DETAIL_PAGE_URL", "PROPERTY_page_views_ga", "PROPERTY_FOR_ADMIN", "PROPERTY_IGNORE_SEARCH_INDEX");
                $arFilter = Array("ID" => $arElement['WF_PARENT_ELEMENT_ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                while($arFields = $res->GetNext())
                {
                    $dbIgnoreSearchIndexProp = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], array(), Array("CODE" => "IGNORE_SEARCH_INDEX"));
                    if($arIgnoreSearchIndexProp = $dbIgnoreSearchIndexProp->Fetch()) {
                        $ignoreSearchIndexPropID = intval($arIgnoreSearchIndexProp["ID"]);
                    }

                    $to_delete = false;
                    if(isset($arElement["PROPERTY_VALUES"][$arIgnoreSearchIndexProp["ID"]])) {
                        if(!empty($arElement["PROPERTY_VALUES"][$arIgnoreSearchIndexProp["ID"]])) {
                            $to_delete = true;
                        }
                    } else {
                        if(!empty($arFields[PROPERTY_IGNORE_SEARCH_INDEX_VALUE])) {
                            $to_delete = true;
                        }
                    }

                    if (!empty($arFields['NAME'])) {
                        $arHLData['UF_TITLE'] = preg_replace("/([^a-zA-Z\sа-яёА-ЯЁ0-9])/u","",$arFields['NAME']);
                    }
                    if (!empty($arFields['NAME'])) {
                        $arHLData['UF_TITLE_REAL'] = $arFields['NAME'];
                    }
                    if (!empty($arFields['DETAIL_PAGE_URL'])) {
                        $arHLData['UF_DETAIL_PAGE_URL'] = $arFields['DETAIL_PAGE_URL'];
                    }
                    if (!empty($arFields['PROPERTY_SEARCH_WORDS_VALUE'])) {
                        $arHLData['UF_SEARCH_WORDS'] = implode(' ', array($arFields['PROPERTY_SEARCH_WORDS_VALUE'], $arHLData['UF_SEARCH_WORDS']));
                    }
                    $arHLData['UF_PAGE_VIEWS_GA'] = $arFields['PROPERTY_PAGE_VIEWS_GA_VALUE'];
                    $arHLData['UF_FOR_ADMIN'] = $arFields['PROPERTY_FOR_ADMIN_VALUE'];

                    if(!empty($arFields['PROPERTY_AUTHORS_VALUE'])) {
                        if (empty($arHLData['UF_AUTHOR'])) {
                            $autorsOb = CIBlockElement::GetByID($arFields['PROPERTY_AUTHORS_VALUE']);
                            if ($autorsAr = $autorsOb -> fetch()) {
                                $arHLData['UF_AUTHOR'] = $autorsAr['NAME'];
                            }
                        }
                    }
                    if(!empty($arFields['PROPERTY_COVER_TYPE_VALUE'])) {
                        if (empty($arHLData['UF_COVER_TYPE'])) {
                            $arHLData['UF_COVER_TYPE'] = $arFields['PROPERTY_COVER_TYPE_VALUE'];
                        }
                    }
                    $arHLData['UF_IBLOCK_ID'] = $arFields['ID'];
                }
                if($arHLData){
                    $hlblock = HL\HighloadBlockTable::getById(SEARCH_INDEX_HL_ID)->fetch();
                    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                    $entity_data_class = $entity->getDataClass();
                    $rsElementID = $entity_data_class::getList(array(
                        "select" => array("ID"),
                        "order"  => array("ID" => "ASC"),
                        "filter" => array('UF_IBLOCK_ID' => $arHLData['UF_IBLOCK_ID'])
                    ));
                    if($arElementID = $rsElementID->Fetch()){
                        if($to_delete) {
                            $result = $entity_data_class::delete($arElementID['ID']);
                        } else {
                            $result = $entity_data_class::update($arElementID['ID'], $arHLData);
                        }
                    } else {
                        if(!$to_delete) {
                            $result = $entity_data_class::add($arHLData);
                        }
                    }
                }
            }
        }
    }

    //Обновляем корзину, требуется для корректного отображения страницы с заказами, при переходе со страницы офорлмения заказа
    \Bitrix\Main\EventManager::getInstance()->addEventHandler(
        'main',
        'OnProlog',
        'UpdateBasket'
    );
    function UpdateBasket(){
        global $APPLICATION;
        $url = $APPLICATION->GetCurPage();
        if (preg_match("/personal\/cart/i", $url)) {
            require_once($_SERVER["DOCUMENT_ROOT"]."/ajax/ajax_add2basket.php");
        }
    }

    //Удаляем предзаказанный товар из HL блока и меняем статус заказа на предзаказ, перед созданием заказа
    \Bitrix\Main\EventManager::getInstance()->addEventHandler(
        'sale',
        'OnBeforeOrderAdd',
        'DeleteBasketElementFromHL'
    );
    function DeleteBasketElementFromHL(&$arFields){
        $arBasketItems = array();
        foreach($arFields['BASKET_ITEMS'] as $basketItem){
            $arBasketItems[] = $basketItem;
            $arBasketID[] = $basketItem['ID'];
        }

        $hl_block = HL\HighloadBlockTable::getById(PREORDER_BASKET_HL_ID)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hl_block);
        $entity_data_class = $entity->getDataClass();

        $table_id = 'tbl_' . $entity_table_name;

        $basket_item_filter = array(
            'UF_BASKET_ID' => $arBasketID
        );

        $result = $entity_data_class::getList(array(
            "select" => array('*'),
            "filter" => $basket_item_filter,
            "order"  => array("ID" => "ASC")
        ));

        $result = new CDBResult($result, $table_id);
        while ($basket_item = $result->Fetch()) {
            if  ($basket_item['UF_DELAY_BEFORE'] == 'Y') {
                $arFields['STATUS_ID'] = 'PR';
            }
            $entity_data_class::Delete($basket_item['ID']);
        }
    }


    function generateAccordPostLabel($order_id) {
        //Данные для генерации этикетки
        $order_id = intval($order_id);
        if (!empty($order_id)) {
            $partner_code = str_pad(ACCORDPOST_PARTNER_ID, 4, "0", STR_PAD_LEFT);
            $order_code = str_pad($order_id, 14, "0", STR_PAD_LEFT);
            $unic_code = $partner_code.$order_code;

            $visual_code = substr($unic_code, -3);

            $rs_order_props = CSaleOrderPropsValue::GetList(array(), array("ORDER_ID" => $order_id), false, false, array());
            while($ar_order_prop = $rs_order_props->Fetch()) {
                if(empty($order_properties[$ar_order_prop['CODE']])) {
                    $order_properties[$ar_order_prop['CODE']] = $ar_order_prop['VALUE'];
                }
            }
            if(empty($order_properties['EXPORTED_TO_ACCORDPOST'])){
                return false;
            }

            //Собираем поля в зависимости от типа лица
            if($order_properties['PERSON_TYPE_ID'] == LEGAL_ENTITY_PERSON_TYPE_ID) {
                //имя получателя
                $cont_name = '';
                $cont_name = (!empty($order_properties["F_CONTACT_PERSON"]) ? $order_properties["F_CONTACT_PERSON"] : $order_properties["F_NAME"]);
                $user_name = preg_replace("/[^\w\s]+/u", "", $cont_name);
            } else {
                //имя получателя
                $cont_name = '';
                $cont_name = (!empty($order_properties["F_CONTACT_PERSON"]) ? $order_properties["F_CONTACT_PERSON"] : $order_properties["F_NAME"]);
                $user_name = preg_replace("/[^\w\s]+/u", "", $cont_name);
            }

            $shipping_date = $order_properties['EXPORTED_TO_ACCORDPOST'];
            $partner_name = ACCORDPOST_PARTNER_TITLE;

            //Если нужно будет расширить для других доставок доработать
            $deliver_code = '01';
            $deliver_type = '23';
            $html = '
            <table style="width: 250px;border: 2px solid black;">
            <tbody>
            <tr>
            <th rowspan="2"><div style="font-size: 15px; font-family: arial; margin: 10px 0; width: 42px;">'.$deliver_code.'-'.$deliver_type.'</div></th>
            <th colspan="2"><div style="font-size: 9px; font-family: arial; font-weight: normal; text-transform: uppercase; font-weight: bold; margin: 5px 0;">'.$user_name.'</div></th>
            <th rowspan="4" style="width: 40px;"><div style="transform: rotate(-90deg); font-size: 25px; font-family: arial;">'.$visual_code.'</div></th>
            </tr>
            <tr>
            <td style="border: 0px;"><div style="font-size: 9px; font-family: arial;">'.$shipping_date.'</div></td>
            <td style="border: 0px;"><div style="font-size: 9px; font-family: arial;">'.$partner_name.'</div></td>
            </tr>
            <tr>
            <td colspan="3" style="border: 0px;">
            <div style="overflow: hidden;text-align: center;height: 77px;margin: 4px 0 6px 0;"><img src="http://barcode.tec-it.com/barcode.ashx?translate-esc=off&data='.$unic_code.'&code=DataMatrix&unit=Px&dpi=80&imagetype=Png&rotation=0&color=000000&bgcolor=FFFFFF&qunit=Mm&quiet=0&modulewidth=4" alt="Barcode Generator TEC-IT"></div>
            </td>
            </tr>
            <tr>
            <td colspan="3" style="border: 0px;"><div style="text-align: center; margin: -1px 0 6px 0; font-size: 10px; font-family: arial;">'.$unic_code.'</div></td>
            </tr>
            </tbody>
            </table>';
            return $html;
        } else {
            return false;
        }
    }

    AddEventHandler("main", "OnSendUserInfo", "MyOnSendUserInfoHandler");
    function MyOnSendUserInfoHandler(&$arParams)
    {
        $arParams["FIELDS"]["SERVER_NAME"] = "www.alpinabook.ru";
    }

    AddEventHandler('main', 'OnBeforeEventSend', "messagesWithAttachments");

    function messagesWithAttachments(&$arFields, &$arTemplate) {
        GLOBAL $arParams;

        //Отрубаем отправку письма о "новом заказе" при офорлмении предзаказа
        if(cancelMail($arFields, $arTemplate)) {
           // return false;
           $arFields["PREORDER"] = "предзаказ";
           $arFields["EMAIL_DELIVERY_TERM"] = "";
           $arFields["PAYMENT_LINK"] = "";
           $arFields["PAYMENT_BUTTON"] = "";

        } else {
           $arFields["PREORDER"] = "заказ";
        }

        // отправка письма по наличию вложенных файлов
        if (is_array($arTemplate['FILE']) && !empty($arTemplate['FILE'])) {

            $mailgun = new Mailgun($arParams['MAILGUN']['KEY']);
            $email_from = trim($arTemplate['EMAIL_FROM'], "#") == "DEFAULT_EMAIL_FROM" ? COption::GetOptionString('main', 'email_from') : $arFields[trim($arTemplate['EMAIL_FROM'], "#")];

            // заменяем все максросы в письме на значения из $arFields
            // Все поля обязательно должны присутсвовать, иначе в письме придет макрос !!
            $message_body = $arTemplate['MESSAGE'];
            $message_title = $arTemplate["SUBJECT"];
            foreach ($arFields as $field_name => $field_value) {
                $message_body = str_replace("#" . $field_name . "#", $field_value, $message_body);
                $message_title = str_replace("#" . $field_name . "#", $field_value, $message_title);
            }
            // подставляем email шаблона который передается от определенного события в переменных либо email либо email_to
            if($arFields[trim($arTemplate['EMAIL'], "#")]){
                $email_to = $arFields[trim($arTemplate['EMAIL'], "#")];
            } else {
                $email_to = $arFields[trim($arTemplate['EMAIL_TO'], "#")];
            }

            $attachments = array();
            foreach ($arTemplate['FILE'] as $file) {
                if ($file_path = CFile::GetPath($file)) {
                    $attachments = "@".$_SERVER["DOCUMENT_ROOT"].$file_path;

                }
            }
            $params = array(
                'from'	=> ($email_from)?$email_from:MAIL_FROM_DEFAULT,
                'to'	  => $email_to,//$arFields["EMAIL"],
                'subject' => $message_title,
                'html'	=> $message_body,
            );

            if ($arTemplate['BCC']) {
                $params['bcc'] .= $arTemplate['BCC'];
            }

            if ($arTemplate['CC']) {
                $params['cc'] .= $arTemplate['CC'];
            }

            $domain = $arParams['MAILGUN']['DOMAIN'];

            //  # Make the call to the client.
            $result = $mailgun->sendMessage($domain, $params, array('attachment' => $attachments));

            return false;
        }
    }

    //Функция смены названия товаров в корзинах
    AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "change_product_name_in_basket");

    function change_product_name_in_basket(&$arParams) {
        if($arParams['IBLOCK_ID'] == CATALOG_IBLOCK_ID) {
            if(!empty($arParams['NAME']) && !empty($arParams['ID'])) {
                $dbBasketItems = CSaleBasket::GetList(array(), array("ORDER_ID" => "NULL", "PRODUCT_ID" => $arParams['ID']), false, false, array());
                while($arItems = $dbBasketItems->Fetch()) {
                    CSaleBasket::Update($arItems['ID'], array('NAME' => $arParams['NAME']));
                }
            }
        }
    };

    //Авторизация пользователя по хешу
    \Bitrix\Main\EventManager::getInstance()->addEventHandler(
        'main',
        'OnProlog',
        'hash_autorization'
    );

    function hash_autorization() {
        if(!empty($_REQUEST['hash'])) {
            $arSelect = Array("ID", "NAME", "PROPERTY_HASH_FOR_AUTHORIZE", "PROPERTY_HASH_UPDATE_DATE");
            $arFilter = Array("IBLOCK_ID" => IntVal(RFM_IBLOCK_ID), "PROPERTY_HASH_FOR_AUTHORIZE" => $_REQUEST['hash'], "ACTIVE"=>"Y");

            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            if ($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();

                $arUserFilter = array(
                    "ACTIVE"	 => "Y",
                    "EMAIL"	  => $arFields['NAME']
                );

                $rsUsers = CUser::GetList(($by="id"), ($order="desc"), $arUserFilter);

                if ($arUser = $rsUsers->Fetch()) {

                    //Проверим на админов
                    $arGroups = CUser::GetUserGroup($arUser['ID']);

                    if (!in_array(ADMIN_GROUP_ID, $arGroups)) {
                        global $USER;
                        $USER->Authorize($arUser['ID']);
                    }
                }
            }
        }
    }

    AddEventHandler("sale", "OnBeforeBasketAdd", "ProductAddPreOrder");  // событие перед добавлением товара в корзину
    function ProductAddPreOrder(&$arFields) {
		if ($_GET["action"] == "ADD2BASKET" && $_GET["id"]) {
			$res = CIBlockElement::GetList(Array(), Array("ID" => $_GET["id"], "PROPERTY_STATE" => STATE_SOON), false, false, Array("ID"));
			if($item = $res->Fetch()) {
				//$arFields["DELAY"] = "Y";	  // перемещаем товар в предзаказ
				return $arFields;   // возвращаем знаячение
			}
		}
    }


    //AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', 'updatingQuantityforPreorderItems');

    function updatingQuantityforPreorderItems (&$arFields) {
        if ($arFields["IBLOCK_ID"] == CATALOG_IBLOCK_ID) {
            $updated_item_info = CIBlockElement::GetList (array(), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "ID" => $arFields["ID"]), false, false, array("IBLOCK_ID", "ID", "PROPERTY_STATE"));
            while ($updated_item = $updated_item_info -> Fetch()) {
                if ($updated_item["PROPERTY_STATE_ENUM_ID"] == getXMLIDByCode (CATALOG_IBLOCK_ID, "STATE", "soon") && $arFields["QUANTITY"] != 0) {
                    $upd_product = new CCatalogProduct();
                    $prodFields = array("QUANTITY" => 99999);
                    $upd_product -> Update($arFields["ID"], $prodFields);
                }
            }

        }
    }


    // Проверяем изменение статуса товара для изменения статуса заказа
    AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "UpdateStatusOrderOnProduct");

    // создаем обработчик события "UpdateStatusOrderOnProduct"
    function UpdateStatusOrderOnProduct(&$arFields) {
        if($arFields["IBLOCK_ID"] == CATALOG_IBLOCK_ID){
            $db_props = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], array("sort" => "asc"), Array("CODE"=>"STATE"));
            if($ar_props = $db_props->Fetch()){
                $status_product = $ar_props["VALUE"];
            }

            if($status_product == STATE_SOON && $status_product != $arFields["PROPERTY_VALUES"][PROPERTY_STATE_ID][0]["VALUE"]){
                $arFilter = Array(
                    "STATUS_ID" => "PR"
                );

                $rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
                $order_new_statys = array();
               // $state = '';
                while ($arSales = $rsSales->Fetch()) {

                    if($arSales["PERSON_TYPE_ID"] == LEGAL_ENTITY_PERSON_TYPE_ID && $arSales["PAY_SYSTEM_ID"] == 12){
                        $dbItemsInOrder = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $arSales["ID"]));

                        while($arproduct = $dbItemsInOrder->Fetch()){
                            $product_order_property = CIBlockElement::GetProperty(CATALOG_IBLOCK_ID, $arproduct["PRODUCT_ID"], array("sort" => "asc"), Array("CODE"=>"STATE"))->Fetch();
                            if($arFields["ID"] == $arproduct["PRODUCT_ID"]){
                                $order_new_statys[$arSales["ID"]]["ORDER"] = $arSales;
                            }
                            if($product_order_property["VALUE"] == STATE_SOON && $arFields["ID"] != $arproduct["PRODUCT_ID"]){
                                $order_new_statys[$arSales["ID"]]["STATUS"] = "N";
                            }

                        }
                    } else {
                        $dbItemsInOrder = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $arSales["ID"]));

                        while($arproduct = $dbItemsInOrder->Fetch()){
                            $product_order_property = CIBlockElement::GetProperty(CATALOG_IBLOCK_ID, $arproduct["PRODUCT_ID"], array("sort" => "asc"), Array("CODE"=>"STATE"))->Fetch();
                            if($arFields["ID"] == $arproduct["PRODUCT_ID"]){
                                $order_new_statys[$arSales["ID"]]["ORDER"] = $arSales;
                            }
                            if($product_order_property["VALUE"] == STATE_SOON && $arFields["ID"] != $arproduct["PRODUCT_ID"]){
                                $order_new_statys[$arSales["ID"]]["STATUS"] = "N";
                            }

                        }
                    }
                }
                foreach($order_new_statys as $order_update){

                    if($order_update["ORDER"] && $order_update["STATUS"] != "N" && $order_update["STATUS"] != "A"){
                        if($order_update["ORDER"]["PAY_SYSTEM_ID"] == CASH_PAY_SISTEM_ID || $order_update["ORDER"]["PAY_SYSTEM_ID"] == PAY_SYSTEM_IN_OFFICE){
                            CSaleOrder::StatusOrder($order_update["ORDER"]["ID"], "N");  // меняем статус на новый
                        }else if($order_update["ORDER"]["PAY_SYSTEM_ID"] == CASHLESS_PAYSYSTEM_ID ){
                            CSaleOrder::StatusOrder($order_update["ORDER"]["ID"], "N");  // меняем статус на новый
                        } else {
                            CSaleOrder::StatusOrder($order_update["ORDER"]["ID"], "O");  // меняем статус на "принят, ожидается оплата"
                        }
                    }
                }

            }
        }
    }

    function object_to_array($a, $b) {
        return strtotime($b) - strtotime($a);
    }


function AddBasketRule() {
    // получение релятивных товаров для создания правила корзины
    CModule::IncludeModule('sale');
    if (isset($_COOKIE["rcuid"])){
        $opts = array('http' =>
            array(
                'method'  => 'GET',
                'timeout' => 3
            )
        );

        $context  = stream_context_create($opts);
        $stringRecs = file_get_contents('https://api.retailrocket.ru/api/2.0/recommendation/personal/50b90f71b994b319dc5fd855/?partnerUserSessionId='.$_COOKIE["rcuid"], false, $context);
        $recsArray = array_slice(json_decode($stringRecs, true), 0, 6);
        $arrFilter = array();
        foreach($recsArray as $val) {
            $arrFilter["ID"][] = $val["ItemId"];

        }

    }

    $id_favorite = $arrFilter["ID"][rand(0,5)];

    $db_enum_list = CIBlockProperty::GetPropertyEnum(SALE_POPULAR_ELEMENT, Array(), Array());
    while($ar_enum_list = $db_enum_list->GetNext()) {
      $ar_prop[] = $ar_enum_list["VALUE"];
    }

    if(is_array($ar_prop)){
      foreach($ar_prop as $prop){
        $arFields["VALUES"][] = Array(
          "VALUE" => $prop,
          "DEF" => "Y",
          "SORT" => "100"
          );
      }
      if(!in_array($id_favorite, $ar_prop)) {
          $arFields["VALUES"][count($ar_prop)] = Array(
              "VALUE" => $id_favorite,
              "DEF" => "Y",
              "SORT" => "100"
              );
      }
    } else {
        $arFields["VALUES"][] = Array(
          "VALUE" => $id_favorite,
          "DEF" => "Y",
          "SORT" => "100"
          );
    }

    $ibp = new CIBlockProperty;
    if(!$ibp->Update(SALE_POPULAR_ELEMENT, $arFields))
        echo $ibp->LAST_ERROR;

     return "AddBasketRule();";
}
// регистрируем обработчик
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "UpdateSaleElement");

    // создаем обработчик события "OnAfterIBlockElementUpdate"
    function UpdateSaleElement(&$arFields)
    {
        CModule::IncludeModule('sale');
        $db_props = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], array("id" => "desc"), Array("CODE"=>"SALE_POPULAR_ELEMENT"));
        if($ar_props = $db_props->Fetch()){
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC"), Array("CODE"=>$ar_props["CODE"], "DEF" => "Y"));
            while($enum_fields = $property_enums->GetNext()) {
                $prop_value = $enum_fields["VALUE"];
            }
        }
        if($prop_value){
            $rsDiscounts = CSaleDiscount::GetList(array(), array("ID" => 409), false, false, array('CONDITIONS'))->Fetch();

            $arDiscount = unserialize($rsDiscounts['CONDITIONS']);
            $CONDITIONS = array (
               "CLASS_ID" => "CondGroup",
               "DATA" => array (
                  "All" => "AND",
                  "True" => "True"
               ),
               "CHILDREN" => array(
                   array(
                      "CLASS_ID" => "CondBsktCntGroup",
                      "DATA" => array (
                         "All" => "OR",
                         "logic" => "EqGr",
                         "Value" => 2
                      ),
                      "CHILDREN" => Array(
                         $arDiscount["CHILDREN"][0]["CHILDREN"][0],
                         array(
                          "CLASS_ID" => "CondBsktFldProduct",
                          "DATA" => array (
                             "logic" => "Equal",
                             "value" => $arFields["ID"]
                          )
                         )
                      )
                   ),array(
                      "CLASS_ID" => "CondBsktCntGroup",
                      "DATA" => array (
                         "All" => "AND",
                         "logic" => "Equal",
                         "Value" => 1
                      ),
                      "CHILDREN" => Array(
                         array(
                          "CLASS_ID" => "CondBsktFldProduct",
                          "DATA" => array (
                             "logic" => "Equal",
                             "value" => $prop_value
                          )
                         )
                      )
                   ),
               ),
            );

            $ACTIONS = array (
               "CLASS_ID" => "CondGroup",
               "DATA" => array (
                  "All" => "AND",
               ),
               "CHILDREN" => array(
                array(
                  "CLASS_ID" => "ActSaleBsktGrp",
                  "DATA" => array (
                     "Type" => "Discount",
                     "Value" => 10,
                     "Unit" => "Perc",
                     "Max" => 0,
                     "All" => "AND",
                     "True" => "True"

                  ),
                  "CHILDREN" => Array(

                  )
                ),
               ),
            );
            $arFields = array(
               "LID" => 's1',
               "NAME" => "Скидка 1+1 для товара ".$prop_value,
               "PRIORITY" => 1,
               "LAST_LEVEL_DISCOUNT" => "N",
               "LAST_DISCOUNT" => "Y",
                "ACTIVE" => "Y",
                "ACTIVE_FROM" => "",
                "ACTIVE_TO" => "",
                "SORT" => 100,
                "XML_ID" => "",
                "CONDITIONS" => $CONDITIONS,
                "ACTIONS" => $ACTIONS,
                "USER_GROUPS" => array(
                    0 => 2
                ),
            );
          //  $ID = CSaleDiscount::Add($arFields);
            $ID = CSaleDiscount::Update(409, $arFields);

           //
        }
    }

    // обработчик на изменение внешенго кода товара перед добавлением в корзину
AddEventHandler("sale", "OnBeforeBasketAdd", "MontageBasketAdd");

function MontageBasketAdd(&$arFields) {
    $arSelect = Array("ID", "XML_ID");
    if($arFields["PRODUCT_ID"]){
        $arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID_REMAINDER, "PROPERTY_ID_BITRIKS_VALUE"=>$arFields["PRODUCT_ID"]);
        $res_element = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while($ob = $res_element->GetNext()) {
            // выясняем остатки у товара остатков
            $rsStore = CCatalogProduct::GetByID($ob["ID"]);

            if($rsStore["QUANTITY"] > 0 ){
                 $ar_quantity[] = $rsStore["QUANTITY"];
                 $ar_xml_id[$rsStore["QUANTITY"]] = $ob["XML_ID"];
            }

        }
        // вычисляем наибольший остаток и подставляем в xml товара
        if($ar_xml_id[max($ar_quantity)]){
            $arFields["PRODUCT_XML_ID"] = $ar_xml_id[max($ar_quantity)];
        }
    }

}


// переводим заказ в статус "выполнен" если статус доставки "возврат"
function UpdateStatusBoxberyCancel() {
     // получаем заказы с Boxbery  и статусом "в пути"
    $arFilter = Array("DELIVERY_ID" => DELIVERY_BOXBERRY_PICKUP, "STATUS_ID" => "I");
    $rsOrder = CSaleOrder::GetList(Array(), $arFilter, Array("ID", "STATUS_ID"), false); // Array("PROPERTY_CONSIGNEE")
    while($arOrder = $rsOrder->Fetch()) {
         $order = \Bitrix\Sale\Order::load($arOrder["ID"]);

        /** @var \Bitrix\Sale\ShipmentCollection $shipmentCollection */
        $shipmentCollection = $order->getShipmentCollection();

        /** @var \Bitrix\Sale\Shipment $shipment */
        foreach ($shipmentCollection as $shipment) {
            $track = $shipment->getField("TRACKING_NUMBER");

            $url='http://api.boxberry.de/json.php?token='.BOXBERRY_TOKEN.'&method=ListStatusesFull&ImId='.$track;

            $handle = fopen($url, "rb");
            $contents = stream_get_contents($handle);
            fclose($handle);
            $data = json_decode($contents,true);

            $end_status = end($data["statuses"]);
            if($end_status["Name"] == "Возвращено в ИМ"){
                CSaleOrder::StatusOrder($arOrder["ID"], "F");  // обновление статуса если заказ был возвращен
            }
        }
    }
    return "UpdateStatusBoxberyCancel();";
}


// регистрируем обработчик для добалвнеия элемента в отдельный список желаний
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "AddElementWishList");

// создаем обработчик события "OnAfterIBlockElementAdd"
function AddElementWishList(&$arFields) {
    global $USER;

    if($arFields["IBLOCK_ID"] == WISHLIST_IBLOCK_ID){

        $el = new CIBlockElement;

        $PROP = array();
        $PROP["EMAIL"] = $USER->GetEmail();
        $PROP["ID_BOOCK"] = $arFields["PROPERTY_VALUES"]["PRODUCTS"];
        $PROP["DATE_CREATE"] = date('d.m.Y');
        $PROP["ID_ELEMENT_LIST"] = $arFields["ID"];

        $arLoadProductArray = Array(
          "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
          "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
          "IBLOCK_ID"      => WISHLIST_LOGGER_IBLOCK_ID,
          "PROPERTY_VALUES"=> $PROP,
          "NAME"           => $arFields['NAME'],
          "ACTIVE"         => "Y",            // активен
          "PREVIEW_TEXT"   => "текст",
          "DETAIL_TEXT"    => "текст",
          );

        $PRODUCT_ID = $el->Add($arLoadProductArray);

    }

}


AddEventHandler("iblock", "OnAfterIBlockElementDelete", "DeleteElementWishList");

    // создаем обработчик события "DeleteElementWishList" на добавление даты удаления элемента из списка желаний
    function DeleteElementWishList($arFields){
        if($arFields["IBLOCK_ID"] == WISHLIST_IBLOCK_ID){
            $arSelect = Array("ID");

            $arFilter = Array("IBLOCK_ID"=>WISHLIST_LOGGER_IBLOCK_ID, "PROPERTY_ID_ELEMENT_LIST" => $arFields["ID"]);
            $arwish = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            if($list = $arwish->GetNext()) {
                $PROPERTY_CODE = "DATE_DELETE";  // код свойства
                $PROPERTY_VALUE = date('d.m.Y');  // значение свойства

                // Установим новое значение для данного свойства данного элемента
                CIBlockElement::SetPropertyValuesEx($list["ID"], false, array($PROPERTY_CODE => $PROPERTY_VALUE));

                $el = new CIBlockElement;
                $arLoadProductArray = Array(
                  "ACTIVE" => "N",            // не активен
                );

                $res = $el->Update($list["ID"], $arLoadProductArray);
            }

        }
     }

 function DELETE_STATUS(){
    if (CModule::IncludeModule("sale")):

       $arFilter = Array(
          "STATUS_ID" => "O",
          "<=DATE_UPDATE" => date("d.m.Y", mktime(0, 0, 0, date('m'), date('d') - 14, date('Y'))),
          "PAYED" => "N"
          );
       $rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
       while ($arSales = $rsSales->Fetch())
       {
          CSaleOrder::StatusOrder($arSales["ID"], "A");
       }
    endif;
    return "DELETE_STATUS();";
 }
    function courier_status(){    // смена статуса у заказов с курьером и ноплатой наличными
        if(date('N') != 6 && date('N') != 7){
            $arFilter = Array("DELIVERY_ID" => array(DELIVERY_COURIER_1, DELIVERY_COURIER_2, DELIVERY_COURIER_MKAD), "PAY_SYSTEM_ID" => CASH_PAY_SISTEM_ID, "STATUS_ID" => array("N", "D"), "PAYED" => 'Y');
            $rsOrder = CSaleOrder::GetList(Array(), $arFilter, Array("ID", "DATE_INSERT"), false); // Array("PROPERTY_CONSIGNEE")
            while($arOrder = $rsOrder->Fetch()) {
                $time = strtotime('-10 minutes');
                $date_today = strtotime(date('d.m.Y H:i:s', $time));
                $date_oldday = strtotime($arOrder["DATE_INSERT"]);
                if($date_today > $date_oldday){
                    logger($arOrder, $_SERVER["DOCUMENT_ROOT"].'/logs/log_status_AC.txt');
                    CSaleOrder::StatusOrder($arOrder["ID"], "AC");
                }
            }
        }
        return "courier_status();";
    }
    AddEventHandler("sale", "OnOrderAdd", "EventProductQuantity");

    function EventProductQuantity($ID, $arFields) {

        $arBasketItems = array();
        foreach($arFields["BASKET_ITEMS"] as $basket_item) {
            $product_quantity = CCatalogProduct::GetByID($basket_item["PRODUCT_ID"]);
            logger($basket_item, $_SERVER["DOCUMENT_ROOT"].'/logs/log_event.txt');

            if($basket_item["QUANTITY"] > $product_quantity["QUANTITY"]){    // если количество в заазе больше чем на складе
                 $arBasketItems[$basket_item["ID"]]["QUANTITY"] = $basket_item["QUANTITY"]; // количество товара
                 $arBasketItems[$basket_item["ID"]]["ID"] = $basket_item["PRODUCT_ID"];
                 $arBasketItems[$basket_item["ID"]]["NAME"] = $basket_item["NAME"];
                 $arBasketItems[$basket_item["ID"]]["DETAIL_PAGE_URL"] = $basket_item["DETAIL_PAGE_URL"];
            };
        }
        foreach($arBasketItems as $basket_event){
            $ar_state = CIBlockElement::GetList(Array(), Array("ID" => IntVal($basket_event["ID"])), false, Array(), Array("ID", "PROPERTY_STATE"));
            if ($arItem = $ar_state->Fetch()) {
                if(intval($arItem["PROPERTY_STATE_ENUM_ID"]) != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "soon")) {
                    $mailFields = array(
                        "QUANTITY"=> round($basket_event["QUANTITY"]),
                        "ID" => $basket_event["ID"],
                        "DETAIL_PAGE_URL" => $_SERVER["HTTP_ORIGIN"].$basket_event["DETAIL_PAGE_URL"],
                        "NAME" => $basket_event["NAME"],
                        "ORDER_ID" => $ID,
                    );

                    CEvent::Send("EVENT_QUANTITY", "s1", $mailFields, "N"); // отправляем письмо недостающем количеств етовара
                }
            }
        }
    }
 function expected_payment(){       // автоматическая смена статуса у заказов с онлайн оплатой
    if (CModule::IncludeModule("sale")){
        $date = date('d.m.Y H:i:s');        // текущая дата
        $time = strtotime("now -1 hour");  // если прошел час
        $date = date('d.m.Y H:i:s',$time); // присваиваем к текущей дате
        $date_day = date('d.m.Y H:i:s',strtotime("now -3 hour")); // дата начала поиска
       $arFilter = Array(
          "<=DATE_INSERT" => $date,
          ">=DATE_INSERT" => $date_day,
          "PAYED" => "N",
          );

       $rsSales = CSaleOrder::GetList(array(), $arFilter, false, false, array("ID", "PAY_SYSTEM_ID", "PERSON_TYPE_ID", "STATUS_ID"));

       while ($arSales = $rsSales->Fetch()) {
           if(($arSales["PAY_SYSTEM_ID"] == RFI_PAYSYSTEM_ID || $arSales["PAY_SYSTEM_ID"] == SBERBANK_PAYSYSTEM_ID) && $arSales["PERSON_TYPE_ID"] == NATURAL_ENTITY_PERSON_TYPE_ID && $arSales["STATUS_ID"] != "PR" &&  $arSales["STATUS_ID"] != "PZ" &&  $arSales["STATUS_ID"] != "A" &&  $arSales["STATUS_ID"] != "O"){
                CSaleOrder::StatusOrder($arSales["ID"], "O");   // изменяем статус на "ожидается оплата"
           }
       }
    }
    return 'expected_payment();';    // возвращаем функцию для агента
 }

 // регистрируем обработчик
AddEventHandler('sale', 'OnOrderSave', "CourierAdd");

function CourierAdd($ID, $arFields){
 if (CModule::IncludeModule("sale")){
       global $USER;

       $dbOrderProps = CSaleOrderPropsValue::GetList(
            array("SORT" => "ASC"),
            array("ORDER_ID" => $ID, "CODE"=>array("CODE_COUPON"))
        );
        while ($arOrderProps = $dbOrderProps->GetNext()){
            if(!empty($arOrderProps["VALUE"])){
                $srtificate_ob = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CERTIFICATE_IBLOCK_ID, "PROPERTY_COUPON_CODE" => $arOrderProps["VALUE"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_COUPON_CODE"));
                while($ar_srtificate = $srtificate_ob->GetNext()) {
                    if(empty($arFields["STATUS_ID"])) {
                        CSaleOrder::StatusOrder($arOrderProps["ORDER_ID"], STATUS_SERTIFICATE);
                    }
                }
            }
        };
       $status_id = array("N", "D", "AC");
       $delivery_id = array(DELIVERY_COURIER_1,DELIVERY_COURIER_2, DELIVERY_COURIER_MKAD);
       $db_props = array();

       if (in_array($arFields["STATUS_ID"], $status_id) && in_array($arFields["DELIVERY_ID"], $delivery_id)) {
            $filter = Array (
                "!UF_STATION_METRO_M" => false,
                "GROUPS_ID" => Array(GROUP_COURIER),
            );
            $params = array(
                "SELECT" => array("UF_STATION_METRO_M"),
                "FIELDS" => array("ID", "NAME"),
            );
            $rsUsers = CUser::GetList(($by="NAME"), ($order="desc"), $filter, $params); // выбираем пользователей
            while($user = $rsUsers->Fetch()) {
                $ar_user[] = $user;
            };
            $dbOrderProps = CSaleOrderPropsValue::GetList(
                array("SORT" => "ASC"),
                array("ORDER_ID" => $ID, "CODE"=>array("METRO_2"))
            )->Fetch();

            $db_props = CSaleOrderPropsVariant::GetByValue($dbOrderProps["ORDER_PROPS_ID"],$dbOrderProps["VALUE"]);

            foreach($ar_user as $user_group){
               if(in_array($db_props["NAME"], $user_group["UF_STATION_METRO_M"])){

                    $arSelect = Array("ID");
                    $ob_courier = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => IBLOCK_ID_COURIER, "NAME" => $ID), false, false, $arSelect);
                    if($courier = $ob_courier->Fetch()) {

                    } else {
                        $el = new CIBlockElement;

                        $PROP = array();
                        $PROP["ORDER"] = $ID;
                        $PROP["COURIRER"] = $user_group["ID"];
                        $arLoadProductArray = Array(
                          "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                          "IBLOCK_ID"      => IBLOCK_ID_COURIER,
                          "PROPERTY_VALUES"=> $PROP,
                          "NAME"           => $ID,
                          "ACTIVE"         => "Y",            // активен
                          );

                        $PRODUCT_ID = $el->Add($arLoadProductArray);
                    }
               }
            }

       }
    }
}
function AdmitedGenerate(){
  $dom = new domDocument("1.0", "utf-8"); // Создаём XML-документ версии 1.0 с кодировкой utf-8
  $root = $dom->createElement("Payments"); // Создаём корневой элемент
  $dom->appendChild($root);
  $comments = array("Отказ при получении"); // Пароли пользователей
  // Выведем даты всех заказов текущего пользователя за текущий месяц, отсортированные по дате заказа
    $date = date('d.m.Y H:i:s');        // текущая дата
    $time = strtotime("-1 month");  // если прошел час
    $date = date('d.m.Y H:i:s',$time); // присваиваем к текущей дате

    $arFilter = Array( ">=DATE_INSERT" => $date );

    $db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter, false, false, array('ID', 'STATUS_ID', 'PRICE'));
    while ($ar_sales = $db_sales->Fetch()) {
        if($ar_sales["STATUS_ID"] == 'A' || $ar_sales["STATUS_ID"] == 'P' || $ar_sales["STATUS_ID"] == 'RT'){
            $state = 2;
        } else {
            $state = 1;
        }
        $url = 'http://admitad.com/payments-revision'; // url сервера
        $user = $dom->createElement("Payment"); // Создаём узел "Payment"
        $root->setAttribute("xmlns", $url); // Устанавливаем атрибут "xmlns" у узла "Payment"
        $order = $dom->createElement("OrderID", $ar_sales["ID"]); // Создаём узел "order" с текстом внутри
        $status = $dom->createElement("Status", $state); // Создаём узел "status" с текстом внутри
        $status = $dom->createElement("OrderAmount", round($ar_sales["PRICE"],2)); // Создаём узел "суммы" с текстом внутри
      //  $comment = $dom->createElement("Comment", $comments[$i]); // Создаём узел "коментария" с текстом внутри
        $user->appendChild($order); // Добавляем в узел "Payment" узел "$order"
        $user->appendChild($status);// Добавляем в узел "Payment" узел "$status"
       // $user->appendChild($comment);// Добавляем в узел "Payment" узел "coments"
        $root->appendChild($user); // Добавляем в корневой узел "Payments" узел "Payment"
    }
  $dom->save($_SERVER["DOCUMENT_ROOT"]."/0yv7PT58Yt0Elm5eFqQW.xml"); // Сохраняем полученный XML-документ в файл
}
