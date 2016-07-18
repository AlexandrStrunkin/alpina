<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    CModule::IncludeModule("sale"); CModule::IncludeModule("catalog"); CModule::IncludeModule("iblock");
?>
<?  
if(intval($_REQUEST["productid"]) > 0 && intval($_REQUEST["quantity"]) > 0){

    global $USER;
    $quantity = $_REQUEST["quantity"];    
    $product = intval($_REQUEST["productid"]);

    $res = CIBlockElement::GetByID($product);
    if($ar_res = $res->GetNext()) {

        // получаем цену соответствующего типа для подвешенного товара
        $ar_price = CPrice::GetList(
            array(), 
            array(
                "PRODUCT_ID" => $ar_res["ID"], 
                "CATALOG_GROUP_ID" => SUSPENDED_BOOKS_PRICE_ID
            ), 
            false, 
            false, 
            array()
        ) -> Fetch();
        $price = $ar_price["PRICE"];
        if(intval($price) > 0){
            $arFields = array(
                "LID" => "s1",
                "PERSON_TYPE_ID" => "1",
                "PAYED" => "N",
                "CANCELED" => "N",
                "STATUS_ID" => "N",
                "PRICE" => 0,
                "CURRENCY" => "RUB",
                "USER_ID" => $USER -> GetID(),
                "PAY_SYSTEM_ID" => RFI_PAYSYSTEM_ID,
                "PRICE_DELIVERY" => 0,
                "DELIVERY_ID" => PICKUP_DELIVERY_ID,
                "DISCOUNT_VALUE" => 0,
                "TAX_VALUE" => 0.0,
                "USER_DESCRIPTION" => $_REQUEST["name"]
            );
            
            // создаём заказ и добавляем туда запрошенный подвешенный товар
            
            if ($ORDER_ID = CSaleOrder::Add($arFields)) {
                $ORDER_ID = intval($ORDER_ID);
                $itemFields = array(
                    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                    "PRODUCT_ID" => $product,
                    "PRODUCT_PRICE_ID" => SUSPENDED_BOOKS_PRICE_ID,
                    "PRICE" => $price,
                    "CURRENCY" => 'RUB',
                    "QUANTITY" => $quantity,
                    "PRODUCT_XML_ID" => $ar_res["ID"],
                    "LID" => "s1",
                    "NAME" => $ar_res["NAME"],
                    "PRODUCT_PROVIDER_CLASS" => "CCatalogProductProvider",
                    "MODULE" => "catalog"
                );
                $gift_item = CSaleBasket::Add($itemFields);
                CSaleBasket::OrderBasket($ORDER_ID, 0, SITE_ID, false);
                echo $ORDER_ID;
            } else {
                CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
                echo "err";
            }

        } else {
            echo "err";
        }
    }
}
?>