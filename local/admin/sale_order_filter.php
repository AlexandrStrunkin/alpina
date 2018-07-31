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

    require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php');
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/prolog.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/general/admin_tool.php");

    Loader::includeModule('sale');

    IncludeModuleLangFile(__FILE__);

    global $USER;
    global $APPLICATION;

	$userGroup = CUser::GetUserGroup($USER->GetID());

    if (!$USER->IsAdmin() && !in_array(6, $userGroup)) {
        $APPLICATION-> Form("");
    }

    IncludeModuleLangFile(__FILE__);

    $APPLICATION->AddHeadScript("//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js");

    //ajax-экспорт заказов. Запрос отправляется из скрипта, который описан ниже
    if (!empty($_REQUEST["ID"]) && $_REQUEST["export_order"] == "yes") {
        //убираем хедер, чтобы в ответе не было лишнего кода
        $APPLICATION->RestartBuffer();

        die();
    }

    $sTableID = "tbl_accordpost_export_orders"; // table ID
    //Не работает соритровка
    //$oSort = new CAdminSorting($sTableID, "ID", "DESC"); // sort object
    $lAdmin = new CAdminList($sTableID, $oSort); // list object
    $lAdmin->bMultipart = true;

    // filter fields
    $FilterArr = Array(
        "find_date_from",
        "find_date_to",
        "find_iblock_sections"
    );

    // init filter
    $lAdmin->InitFilter($FilterArr);

    $arFilter["IBLOCK_ID"] = CATALOG_IBLOCK_ID;
    if(count($_POST["find_iblock_sections"]) > 0) {
        $arSections = $_REQUEST["find_iblock_sections"];

        $arSelectBooks = Array("ID");
        $arFilterBooks = Array("IBLOCK_ID"=>IntVal(CATALOG_IBLOCK_ID), "SECTION_ID"=>$arSections, "INCLUDE_SUBSECTIONS" => "Y");
        $resBooks = CIBlockElement::GetList(Array(), $arFilterBooks, false, Array(), $arSelectBooks);
        while($arBook = $resBooks->fetch()) {
            if(!in_array($arBook["ID"], $arBooks)) {
                $arBooks[] = $arBook["ID"];
            }
        }

        if(count($arBooks) > 0) {
            if(!empty($find_date_from)) {
                $arFilterOrders[">=DATE_INSERT"] = new \Bitrix\Main\Type\DateTime($find_date_from);
            }
            if(!empty($find_date_to)) {
                $arFilterOrders["<=DATE_INSERT"] = new \Bitrix\Main\Type\DateTime($find_date_to);
            }

            $dbOrders = Bitrix\Sale\Internals\OrderTable::getList(
                array(
                    "select" => array("ID", "PERSON_TYPE_ID"),
                    "filter" => $arFilterOrders
                )
            );

            while($arOrder = $dbOrders->fetch()) {
                $arOrdersIDs[] = $arOrder["ID"];
                $arOrdersFields[$arOrder["ID"]] = $arOrder;
            }

            if(count($arOrdersIDs) > 0) {
                $dbBasket = Bitrix\Sale\Internals\BasketTable::getList(
                    array(
                        "select" => array("ID", "ORDER_ID", "FUSER_ID"),
                        "filter" => array("PRODUCT_ID" => $arBooks, "ORDER_ID" => $arOrdersIDs, "!FUSER_ID" => false)
                    )
                );

                while($arBasket = $dbBasket->fetch()) {
                    if(!in_array($arBasket["ORDER_ID"], $arResultOrdersIDs)) {
                        $arResultOrdersIDs[] = $arBasket["ORDER_ID"];
                        $arFilterProps = array();
                        $arFilterProps["ORDER_ID"] = $arBasket["ORDER_ID"];
                        if($arOrdersFields[$arBasket["ORDER_ID"]]['PERSON_TYPE_ID'] == LEGAL_ENTITY_PERSON_TYPE_ID) {
                            $arFilterProps["ORDER_PROPS_ID"][] = 9;
                            $arFilterProps["ORDER_PROPS_ID"][] = 12;
                        } else {
                            $arFilterProps["ORDER_PROPS_ID"][] = 6;
                            $arFilterProps["ORDER_PROPS_ID"][] = 7;
                        }

                        $dbProps = Bitrix\Sale\Internals\OrderPropsValueTable::getList(
                            array(
                                "filter" => $arFilterProps,
                                "select" => array("CODE", "VALUE")
                            )
                        );

                        $arResultFields[$arBasket["ORDER_ID"]]["ID"] = $arBasket["ORDER_ID"];
                        $arResultFields[$arBasket["ORDER_ID"]]["EMAIL"] = "";
                        $arResultFields[$arBasket["ORDER_ID"]]["NAME"] = "";

                        while($arProp = $dbProps->fetch()) {
                            if($arProp["CODE"] == 'EMAIL' || $arProp["CODE"] == 'F_EMAIL') {
                                $arResultFields[$arBasket["ORDER_ID"]]["EMAIL"] = $arProp["VALUE"];
                            }
                            if($arProp["CODE"] == 'F_CONTACT_PERSON' || $arProp["CODE"] == 'F_NAME') {
                                $arResultFields[$arBasket["ORDER_ID"]]["NAME"] = iconv("UTF-8", "CP1251", $arProp["VALUE"]);
                            }
                        }
                    }
                }
            }
        }

        $fp = fopen($_SERVER["DOCUMENT_ROOT"].'/orders_filter.csv', 'w');
        foreach ($arResultFields as $fields) {
            fputcsv($fp, $fields, ";");
        }
        fclose($fp);
    }
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php"); //
$APPLICATION->SetTitle(GetMessage("ACCORDPOST_EXPORT_TITLE"));
?>
<?
$oFilter = new CAdminFilter(
    $sTableID."_filter",
    array(
        GetMessage("FILTER_DATE"),
        GetMessage("FILTER_SECTIONS"),
    )
);
?>
<form name="find_form" method="post" action="<?echo $APPLICATION->GetCurPage();?>">
    <?$oFilter->Begin();?>
    <tr>
        <td>Дата: </td>
        <td><?echo CalendarPeriod("find_date_from", htmlspecialcharsex($find_date_from), "find_date_to", htmlspecialcharsex($find_date_to), "find_form", "Y")?></td>
    </tr>
    <?$arSections = $_REQUEST["find_iblock_sections"];?>
    <tr id="tr_SECTIONS">
        <td width="40%" class="adm-detail-valign-top adm-detail-content-cell-l">Разделы:</td>
		<td width="60%" class="adm-detail-content-cell-r">
		<select name="find_iblock_sections[]" size="14" multiple="" onchange="onSectionChanged()">
            <?$l = CIBlockSection::GetTreeList(Array("IBLOCK_ID"=>4), array("ID", "NAME", "DEPTH_LEVEL"));?>
            <option value="0"<?if(is_array($arSections) && in_array(0, $arSections))echo " selected"?>><?echo GetMessage("IBLOCK_UPPER_LEVEL")?></option>
            <?while($ar_l = $l->GetNext()) {?>
                <option value="<?echo $ar_l["ID"]?>"<?if(is_array($arSections) && in_array($ar_l["ID"], $arSections))echo " selected"?>><?echo str_repeat(" . ", $ar_l["DEPTH_LEVEL"])?><?echo $ar_l["NAME"]?></option>
            <?}?>
        </select>
		</td>
	</tr>
    <?
        $oFilter->Buttons(array("table_id"=>$sTableID,"url"=>$APPLICATION->GetCurPage(),"form"=>"find_form"));
        $oFilter->End();
    ?>
</form>

<?if(count($_POST["find_iblock_sections"]) > 0) {?>
    <br><div><a href="/orders_filter.csv">Ссылка на файл импорта</a></div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>
