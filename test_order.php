<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
$dbOrderProps = CSaleOrderPropsValue::GetList(
     array("SORT" => "ASC"),
     array("ORDER_ID" => 121101, "CODE"=>array("CODE_COUPON"))
 );
 while ($arOrderProps = $dbOrderProps->GetNext()){
     arshow($arOrderProps);
     if(!empty($arOrderProps["VALUE"])){
         $certificate_ob = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CERTIFICATE_IBLOCK_ID, "PROPERTY_COUPON_CODE" => $arOrderProps["VALUE"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_COUPON_CODE"));
         while($ar_certificate = $certificate_ob->fetch()) {
             if(empty($ar_certificate["STATUS_ID"])) {
                 arshow($arFields);
             }
         }
     }
 };
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
