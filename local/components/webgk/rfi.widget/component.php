<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
global $USER;
$arResult['KEY'] = RFI_TEST_KEY;

if ($arParams['OTHER_PAYMENT'] == "Y") {
    $arResult['PRICE'] = $arParams['OTHER_PARAMS']['PAYSUM'];
    $arResult['COMMENT'] = $arParams['OTHER_PARAMS']['COMMENT'];
    $arResult['EMAIL'] = $arParams['OTHER_PARAMS']['EMAIL'];
    $arResult['PHONE'] = $arParams['OTHER_PARAMS']['PHONE'];
    $arResult['ORDER_ID'] = $arParams['ORDER_ID'];
} else {
    $order_id = $arParams['ORDER_ID'];               
    $order = CSaleOrder::GetByID($order_id);
    
    $order_props = CSaleOrderPropsValue::GetList(
        array("SORT" => "ASC"),
        array(
            "ORDER_ID" => $order_id,
            "CODE"     => array("CODE_COUPON", "certificate", "PHONE", "EMAIL")
        )
    );
    // для таких заказов оба параметра должны быть заполнены
    while ($property = $order_props->Fetch()) {
        switch ($property['CODE']) {
            case 'certificate': 
                $certificate_id = $property['VALUE'];
                break;
            case 'CODE_COUPON':
                $certificate_code = $property['VALUE'];
                break;
            case 'PHONE':
                $arResult['PHONE'] = $property['VALUE'];
                break;
            case 'EMAIL':
                $arResult['EMAIL'] = $property['VALUE'];
                break;
        }
    }
    
    $arResult['ORDER_ID'] = $order_id;
    $arResult['PAYED'] = $order['PAYED'];
    $arResult['PRICE'] = $order['PRICE'];
    
    // для заказов, оплаченных сертификатом подставляем стоимость из параметров заказа
    // для таких заказов оба параметра должны быть заполнены
    if ($certificate_id && $certificate_code) {
        $arResult['PRICE'] = $order['PRICE'];
    }
    
    $arResult['COMMENT'] = str_replace("ORDER_ID", $order_id, GetMessage("COMMENT"));
}
$this->IncludeComponentTemplate(); 
?>        