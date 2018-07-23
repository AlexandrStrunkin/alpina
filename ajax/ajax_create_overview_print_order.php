 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
global $APPLICATION;
// парсим данные формы
parse_str($_POST['data'], $print_data);
$return = array(
    "status" => "",
    "data"   => ""
);

if ($print_data['natural_email']) {
    $element_object = new CIBlockElement();
    
    $properties = array(
        "print_type" => $_POST['print_type'],
        "size" => $_POST['print_size'],
        "format" => $_POST['print_format'],
        "price" => $_POST['print_price']
    );

    $properties["buyer_name"] = $print_data['natural_name'];
    $properties["buyer_email"] = $print_data['natural_email'];
    $properties["buyer_phone"] = $print_data['natural_phone'];
    
    if ($_POST['print_card'] == "Y")
        $properties["card"] = 948;
    
    // общие поля
    $fields = array(
        "ACTIVE"            => "Y",
        "NAME"              => $_POST['print_name'],
        "IBLOCK_ID"         => 74,
        "PROPERTY_VALUES"   => $properties                          
    );

    

    if ($product_id = $element_object->Add($fields)) {
        $return['status'] = "success";
        $return['data'] = $product_id;
        
        $arEventFields = array(
            "EMAIL" => $print_data['natural_email'],
            "ORDER_ID" => $product_id,
            "INFO" => implode(',', $properties)
        );
                
        CEvent::Send("POSTER_ORDER", "s1", $arEventFields,"N");
    } else {
        $return['status'] = "error";
        $return['data'] = $element_object->LAST_ERROR;
    }
    
    echo json_encode($return);
}
?>