<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if($_SERVER["HTTP_X_REAL_IP"] != "91.201.253.5")
    die();

$user_id = Bitrix\Sale\Fuser::getId();
$basket  = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());

foreach ($basket as $basketItem) {
    $arProductIds[] = $basketItem->getProductId();
}

if(count($arProductIds) > 0) {
    $arSelectBooks = Array("ID", "NAME", "PROPERTY_AUTHORS", "IBLOCK_SECTION_ID", "PROPERTY_VIDEOCLIP", "DETAIL_PICTURE", "PREVIEW_PICTURE", "PROPERTY_PUBLISHER", "CATALOG_QUANTITY", "DETAIL_PAGE_URL");
    $arFilterBooks = Array("IBLOCK_ID"=>IntVal(CATALOG_IBLOCK_ID), "ID"=>$arProductIds);
    $obCache = new CPHPCache();
    if ($cache_time > 0 && $obCache->InitCache($cache_time, $arFilterBooks, "/ddm")) {
       $arBooks = $cache->GetVars();
   } elseif($obCache->StartDataCache()) {
            $rsBooks = CIBlockElement::GetList(Array(), $arFilterBooks, false, Array(), $arSelectBooks);
            while($arBook = $rsBooks->fetch()) {
                //Идентификатор
                $arBooks[$arBook["ID"]]["ID"] = $arBook["ID"];

                //Имя
                $arBooks[$arBook["ID"]]["NAME"] = $arBook["DETAIL_PICTURE"];

                //Идентификатор детальной картинки
                $arBooks[$arBook["ID"]]["DETAIL_PICTURE"] = $arBook["DETAIL_PICTURE"];

                //Идентификатор картинки превью
                $arBooks[$arBook["ID"]]["PREVIEW_PICTURE"] = $arBook["PREVIEW_PICTURE"];

                //Издатель
                $arBooks[$arBook["ID"]]["PUBLISHER"] = $arBook["PROPERTY_PUBLISHER_VALUE"];

                //Видеоклип
                if(!empty([$arBook["ID"]]["PROPERTY_VIDEOCLIP_VALUE"])) {
                    $arBooks[$arBook["ID"]]["HAS_VIDEO"] = true;
                }

                //Раздел книги, в будущем скорее всего придется переделать на множественное
                $arBooks[$arBook["ID"]]["SECTION_ID"] = $arBook["IBLOCK_SECTION_ID"];

                //Авторы
                if(!empty($arBook["PROPERTY_AUTHORS_VALUE"]) && !in_array($arBook["PROPERTY_AUTHORS_VALUE"], $arAuthorsIds)) {
                    $arBooks[$arBook["ID"]]["AUTHORS"][] = $arBook["PROPERTY_AUTHORS_VALUE"];
                    $arAuthorsIds[] = $arBook["PROPERTY_AUTHORS_VALUE"];
                }

                //Количество товара
                $arBooks[$arBook["ID"]]["CATALOG_QUANTITY"] = $arBook["CATALOG_QUANTITY"];

                //Количество товара
                $arBooks[$arBook["ID"]]["DETAIL_PAGE_URL"] = $arBook["DETAIL_PAGE_URL"];
            }



        if(count($arAuthorsIds) > 0) {
            $arSelectAuthors = Array("ID", "NAME", "PROPERTY_ORIG_NAME");
            $arFilterAuthors = Array("IBLOCK_ID"=>IntVal(AUTHORS_IBLOCK_ID), "ID"=>$arAuthorsIds);
            $rsAuthors = CIBlockElement::GetList(Array(), $arFilterAuthors, false, Array(), $arSelectAuthors);
            while($arAuthor = $rsAuthors->fetch()) {
                $arAuthors[$arAuthor["ID"]] = $arAuthor["NAME"];
                if(strlen($arAuthor["PROPERTY_ORIG_NAME_VALUE"]) > 0) {
                    $arAuthors[$arAuthor["ID"]] .= " (".$arAuthor["PROPERTY_ORIG_NAME_VALUE"].")";
                }
            }
        }

        foreach($arBooks as $bookID => $arBook) {
            if(count($arAuthorsIds) > 0) {
                foreach($arBook["AUTHORS"] as $authorID) {
                    $arBooks[$bookID]["AUTHORS_NAMES"][] = $arAuthors[$authorID];
                }
                $arBooks[$bookID]["AUTHORS_NAMES"] = implode(", ", $arBooks[$bookID]["AUTHORS_NAMES"]);
                unset($arBooks[$bookID]["AUTHORS"]);
            }

            if($arBook["SECTION_ID"] > 0) {
                $rsSectionTree = CIBlockSection::GetNavChain(CATALOG_IBLOCK_ID, $arBook["SECTION_ID"], array("ID", "NAME"));
                $arTree = array();
                while($arSection = $rsSectionTree->GetNext()) {
                    $arTree[] = $arSection["NAME"];
                }
                $arBooks[$bookID]["SECTION_NAMES"] = $arTree;
            }

            if($arBook["DETAIL_PICTURE"] > 0) {
                $arBooks[$bookID]["DETAIL_PICTURE"] = CFile::GetPath($arBook["DETAIL_PICTURE"]);
            }

            if($arBook["PREVIEW_PICTURE"] > 0) {
                $arBooks[$bookID]["PREVIEW_PICTURE"] = CFile::GetPath($arBook["PREVIEW_PICTURE"]);
            }
        }

        if(count($arAuthorsBooks) > 0) {
            $obCache->EndDataCache($arBooks);
        } else {
            $obCache->abortDataCache();
        }
    }
}

foreach ($basket as $basketItem) {
    $itemId = $basketItem->getProductId();
    $product = array(
        "author"        => $arBooks[$itemId]["AUTHORS"],
        "category"      => $arBooks[$itemId]["SECTION_NAMES"],
        "categoryId"    => $arBooks[$itemId]["SECTION_ID"],
        "currency"      => "RUB",
        "hasVideo"      => ($arBooks[$itemId]["HAS_VIDEO"]) ? false : true,
        "id"            => $arBooks[$itemId]["ID"],
        "imageUrl"      => $arBooks[$itemId]["DETAIL_PICTURE"],
        "name"          => $arBooks[$itemId]["NAME"],
        "stock"         => $arBooks[$itemId]["CATALOG_QUANTITY"],
        "thumbnailUrl"  => $arBooks[$itemId]["CATALOG_QUANTITY"],
        "unitPrice"     => $basketItem->getField("BASE_PRICE"),
        "unitSalePrice" => $basketItem->getField("PRICE"),
        "url"           => $arBooks[$itemId]["DETAIL_PAGE_URL"]
    );

    $strDiscountValue = $basketItem->getField("DISCOUNT_VALUE");
    $discountValue = 0;
    if(strlen($strDiscountValue) > 0) {
        $discountValue = floatval(str_replace("%", "", $strDiscountValue));
    }

    $lineItems[] = array(
        "product"       => $product,
        "quantity"      => $basketItem->getQuantity(),
        "subtotal"      => $basketItem->getQuantity() * $basketItem->getField("PRICE"),
        "totalDiscount" => $discountValue
    );
}



die();
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
