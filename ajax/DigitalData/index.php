<?include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
$arResponse["success"] = false;
$arRequest = $_POST;

if(!empty($arRequest["action"])) {
    $action = strval($arRequest["action"]);
    if(strlen($action) > 0) {
        switch ($action) {
            case "getUser":
                global $USER;
                if($USER->IsAuthorized()) {

                    $userId = $USER->GetID();
                    if($userId > 0) {

                        $dbUser = Bitrix\Main\UserTable::GetList(array(
                            "filter" => array("ID" => $userId),
                            "select" => array("ID", "NAME", "LAST_NAME", "EMAIL", "PERSONAL_MOBILE", "DATE_REGISTER")
                        ));

                        if($arUser = $dbUser->fetch()) {

                            //Получим первый заказ
                            $dbOrderFirst = Bitrix\Sale\Internals\OrderTable::GetList(
                                array(
                                    "filter" => array("USER_ID" => $userId, "PAYED" => "Y"),
                                    "order"  => array("DATE_INSERT" => "asc"),
                                    "select" => array("ID", "DATE_INSERT"),
                                    "limit"  => 1
                                )
                            );

                            $firstTransactionDate = NULL;
                            if($arOrderFirst = $dbOrderFirst->fetch()){
                                $firstTransactionDate = $arOrderFirst["DATE_INSERT"]->format("c");
                            }

                            //Получим последний заказ
                            $dbOrderLast = Bitrix\Sale\Internals\OrderTable::GetList(
                                array(
                                    "filter" => array("USER_ID" => $userId, "PAYED" => "Y"),
                                    "order"  => array("DATE_INSERT" => "desc"),
                                    "select" => array("ID", "DATE_INSERT"),
                                    "limit"  => 1
                                )
                            );

                            $lastTransactionDate = NULL;
                            if($arOrderLast = $dbOrderLast->fetch()){
                                $lastTransactionDate = $arOrderLast["DATE_INSERT"]->format("c");
                            }

                            if($lastTransactionDate || $firstTransactionDate) {
                                $hasTransacted = true;
                            } else {
                                $hasTransacted = false;
                            }

                            $arResponseUser = array(
                                "email"                => $arUser["EMAIL"],
                                "firstName"            => $arUser["NAME"],
                                "firstTransactionDate" => $firstTransactionDate,
                                "hasTransacted"        => $hasTransacted,
                                "isLoggedIn"           => true,
                                "lastName"             => $arUser["LAST_NAME"],
                                "lastTransactionDate"  => $lastTransactionDate,
                                "phone"                => $arUser["PERSONAL_MOBILE"],
                                "userId"               => $userId,
                                "registrationDate"     => $arUser["DATE_REGISTER"]->format("c")
                            );

                            $arResponse["success"] = true;
                            $arResponse["user"] = $arResponseUser;
                        }
                    }
                } else {
                    $arResponse["success"] = true;
                    $arResponse["user"]["user_id"] = 0;
                }
            break;
            case "getCart":
                $user_id = Bitrix\Sale\Fuser::getId();
                $basket  = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());

                foreach ($basket as $basketItem) {
                    $arProductIds[] = $basketItem->getProductId();
                }

                if(count($arProductIds) > 0) {
                    $arSelectBooks = Array("ID", "NAME", "PROPERTY_AUTHORS", "IBLOCK_SECTION_ID", "PROPERTY_VIDEOCLIP", "DETAIL_PICTURE", "PREVIEW_PICTURE", "PROPERTY_PUBLISHER", "CATALOG_QUANTITY", "DETAIL_PAGE_URL");
                    $arFilterBooks = Array("IBLOCK_ID"=>IntVal(CATALOG_IBLOCK_ID), "ID"=>$arProductIds);
                    $obCache = new CPHPCache();
                    if ($cache_time > 0 && $obCache->InitCache(86400, $arFilterBooks, "/ddm")) {
                       $arBooks = $cache->GetVars();
                   } elseif($obCache->StartDataCache()) {
                            $rsBooks = CIBlockElement::GetList(Array(), $arFilterBooks, false, Array(), $arSelectBooks);
                            while($arBook = $rsBooks->GetNext()) {
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
                        "author"        => $arBooks[$itemId]["AUTHORS_NAMES"],
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

                    $arResponse["success"] = true;
                    $arResponse["cart"] = $lineItems;
                }
            break;
        }
    }
}


echo json_encode($arResponse);
?>
