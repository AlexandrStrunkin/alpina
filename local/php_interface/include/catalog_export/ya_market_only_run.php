<?
//<title>Использовать ТОЛЬКО для Yandex Market</title>
set_time_limit(0);

//$IBLOCK_ID = 6;
//$V = array(0);

setlocale(LC_ALL, "ru_RU.utf8");
setlocale(LC_NUMERIC, "C");


global $USER, $APPLICATION;
$bTmpUserCreated = False;

if (!isset($USER) || !is_a($GLOBALS['USER'], 'CUser'))
{
	$bTmpUserCreated = True;
	if (isset($USER))
	{
		$USER_TMP = $USER;
	}

	$USER = new CUser();
}

$arYandexFields = array('vendor', 'vendorCode', 'model', 'author', 'name', 'publisher', 'year', 'ISBN', 'volume', 'part', 'language', 'binding', 'page_extent', 'table_of_contents', 'performed_by', 'performance_type', 'storage', 'format', 'recording_length', 'series', 'artist', 'title', 'year', 'media', 'starring', 'director', 'originalName', 'country', 'description', 'sales_notes', 'promo', 'aliases', 'provider', 'tarifplan', 'xCategory', 'additional', 'worldRegion', 'region', 'days', 'dataTour', 'hotel_stars', 'room', 'meal', 'included', 'transport', 'price_min', 'price_max', 'options', 'manufacturer_warranty', 'country_of_origin', 'downloadable', 'param', 'place', 'hall', 'hall_part', 'is_premiere', 'is_kids', 'date',);

$arYandexFieldsBook = array(
    'author',
    'name',
    'publisher',
    'series',
    'year',
    'ISBN',
    'volume',
    'part',
    'language',
    'binding',
    'page_extent',
    'table_of_contents',
    'description'
    );

$arYandexFieldsAudioBook = array(
    'author',
    'name',
    'publisher',
    'series',
    'year',
    'ISBN',
    'volume',
    'part',
    'language',
    'table_of_contents',
    'performed_by',
    'performance_type',
    'storage',
    'format',
    'recording_length',
    'description',
);

if (!function_exists("yandex_replace_special"))
{
	function yandex_replace_special($arg)
	{
		if (in_array($arg[0], array("&quot;", "&amp;", "&lt;", "&gt;", "&lt;", "&apos;", "&laquo;", "&raquo;", "&mdash;", "&ndash;")))
			return $arg[0];
		else
			return " ";
	}
}

if (!function_exists("yandex_text2xml"))
{
	function yandex_text2xml($text, $bHSC = false)
	{
		$text = $GLOBALS['APPLICATION']->ConvertCharset($text, LANG_CHARSET, 'windows-1251');

		if ($bHSC)
			$text = htmlspecialchars($text);
		$text = preg_replace("/[\x1-\x8\xB-\xC\xE-\x1F]/", "", $text);
        $text = str_replace("'", "&apos;", $text);
        $text = str_replace("&laquo;", "&amp;laquo;", $text);
		$text = str_replace("&raquo;", "&amp;raquo;", $text);
		return $text;
	}
}

if (!function_exists('yandex_get_value'))
{
	function yandex_get_value($arOffer, $param, $PROPERTY)
	{
		global $IBLOCK_ID;
		static $arProperties = null, $arUserTypes = null;

		if (!is_array($arProperties))
		{
			$dbRes = CIBlockProperty::GetList(
				array('id' => 'asc'),
				array('IBLOCK_ID' => $IBLOCK_ID, 'CHECK_PERMISSIONS' => 'N')
			);

			while ($arRes = $dbRes->Fetch())
			{
                if($arRes['PROPERTY_TYPE'] == 'L')
                {
                        $arLSort = array('SORT'=>'ASC');
                        $arLFilter = array('IBLOCK_ID'=>$IBLOCK_ID);
                        $rsEnumList = CIBlockProperty::GetPropertyEnum($arRes['ID'], $arLSort, $arLFilter);
                        $arEList = array();
                        while($ar_enum_list = $rsEnumList->GetNext())
                            $arEList[$ar_enum_list['ID']] = $ar_enum_list;
                        $arRes['ENUM'] = $arEList;
                }
                else
                    $arRes['ENUM'] = array();
				$arProperties[$arRes['ID']] = $arRes;
			}
		}

        //xvar_dump($arOffer);
        //die();

		$strProperty = '';
		$bParam = substr($param, 0, 6) == 'PARAM_';
		if (is_array($arProperties[$PROPERTY]))
		{
			$PROPERTY_CODE = $arProperties[$PROPERTY]['CODE'];

			$arProperty = $arOffer['PROPERTIES'][$PROPERTY_CODE] ? $arOffer['PROPERTIES'][$PROPERTY_CODE] : $arOffer['PROPERTIES'][$PROPERTY];

			$value = '';
			$description = '';
			switch ($arProperties[$PROPERTY]['PROPERTY_TYPE'])
			{
				case 'E':
                    if(is_array($arProperty['VALUE']))
                    {
                        $tmpar = array();
                        foreach($arProperty['VALUE'] as $k=>$tv)
                        {
                            $tv = intval($tv);
                            if($tv > 0)
                                $tmpar[$k] = $tv;
                        }
                        $arProperty['VALUE'] = $tmpar;
                    }
                    else
                    {
                        $tv = intval($arProperty['VALUE']);
                        if($tv > 0)
                            $arProperty['VALUE'] = $tv;
                        else
                            $arProperty['VALUE'] = 0;
                    }
                    if($arProperty['VALUE'])
                    {
					    $dbRes = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $arProperties[$PROPERTY]['LINK_IBLOCK_ID'], 'ID' => $arProperty['VALUE'], 'ACTIVE'=>'Y'), false, false, array('ID', 'NAME', 'PROPERTY_LAST_NAME', 'PROPERTY_FIRST_NAME'));
					    while ($arRes = $dbRes->GetNext())
					    {
                            $vvv = '';
                            $vvv .= (strlen($vvv) > 0 ? ' ' : '').htmlspecialchars($arRes['PROPERTY_FIRST_NAME_VALUE']);
                            $vvv .= (strlen($vvv) > 0 ? ' ' : '').htmlspecialchars($arRes['PROPERTY_LAST_NAME_VALUE']);
                            if(strlen($vvv) <= 0)
                                $vvv = $arRes['NAME'];



                            if($PROPERTY_CODE == 'AUTHORS' || 17 == $PROPERTY)  //
                            {
                                /*if(8263 == $arOffer['ID'])
                                {
                                    xvar_dump($arRes);
                                    die();
                                } */
                                if(!is_array($arProperty['VALUE']))
                                {
                                    $arProperty['VALUE'] = array($arProperty['VALUE']);
                                    $arProperty['DESCRIPTION'] = array($arProperty['DESCRIPTION']);
                                }
                                foreach($arProperty['VALUE'] as $k => $val)
                                {
                                    if($val == $arRes['ID'])
                                    {
                                        $d = trim($arProperty['DESCRIPTION'][$k]);
                                        if(strlen($d)>0)
                                            $vvv .= (strlen($vvv) > 0 ? ' ' : '').$d;
                                        break;
                                    }
                                }
                            }
                            $value .= ($value ? ', ' : '').$vvv;
					    }
                    }
				break;

				case 'L':
                    if(!is_array($arProperty['VALUE_ENUM_ID']))
                    {
                        if(array_key_exists($arProperty['VALUE_ENUM_ID'], $arProperties[$PROPERTY]['ENUM']))
                            $value = $arProperties[$PROPERTY]['ENUM'][$arProperty['VALUE_ENUM_ID']]['VALUE'];
                    }
                    else
                    {
                            foreach($arProperty['VALUE_ENUM_ID'] as $veid)
                                $value .= ($value ? ', ' : '').$arProperties[$PROPERTY]['ENUM'][$veid]['VALUE'];
                    }
                    break;
                break;
				case 'G':
					$dbRes = CIBlockProperty::GetPropertyEnum(
						$PROPERTY,
						array("SORT"=>"asc")
					);
					while ($arRes = $dbRes->Fetch())
					{
						$value .= ($value ? ', ' : '').$arRes['NAME'];
					}
				break;

				default:
					if ($bParam && $arProperty['WITH_DESCRIPTION'] == 'Y')
					{
						$description = $arProperty['DESCRIPTION'];
						$value = $arProperty['VALUE'];
					}
					else
					{
						$value = is_array($arProperty['VALUE']) ? implode(', ', $arProperty['VALUE']) : $arProperty['VALUE'];
					}
			}

			// !!!! check multiple properties and properties like CML2_ATTRIBUTES

			if ($bParam)
			{
				if (is_array($description))
				{
					foreach ($value as $key => $val)
					{
						$strProperty .= $strProperty ? "\n" : "";
						$strProperty .= '<param name="'.htmlspecialchars($description[$key]).'">'.yandex_text2xml($val).'</param>';
					}
				}
				else
				{
					$strProperty = '<param name="'.htmlspecialchars($arProperties[$PROPERTY]['NAME']).'">'.yandex_text2xml($value).'</param>';
				}
			}
			else
			{
				$param_h = htmlspecialchars($param);
				$strProperty = '<'.$param_h.'>'.yandex_text2xml($value).'</'.$param_h.'>';
			}
		}

		return $strProperty;
		//if (is_callable(array($arParams["arUserField"]["USER_TYPE"]['CLASS_NAME'], 'getlist')))
	}
}

$strExportErrorMessage = "";
if ($XML_DATA)
{
	$XML_DATA = unserialize(stripslashes($XML_DATA));
	if (!is_array($XML_DATA)) $XML_DATA = array();
}


$XML_DATA['XML_DATA'] = array(
    'author' => '62',    //AUTHORS
    'name' => 'NAME',
    'publisher' => '59', //   PUBLISHER
    'series' => '48', //   SERIES
    'year' => '61', //   YEAR
    'ISBN' => '51', //   ISBN  199 ISBN_OLD
    'description' => 'PREVIEW_TEXT', //
    'volume' => '', //
    'part' => '', //
    'language' => '', //
    'binding' => '78', //  COVER_TYPE
    'page_extent' => '63', //  PAGES
    'table_of_contents' => '180', //  BOOK_CONTENT
    'performed_by' => '', //
    'performance_type' => '', //
    'format' => '80', // COVER_FORMAT
    'storage' => '95', //  PRODUCT_TYPE_DESC
    'recording_length' => '91', //  DURATION
);


$GLOBALS['IBLOCK_ID'] = IntVal($IBLOCK_ID);
$db_iblock = CIBlock::GetByID($IBLOCK_ID);
if (!($ar_iblock = $db_iblock->Fetch()))
	$strExportErrorMessage .= "Information block #".$IBLOCK_ID." does not exist.\n";
else
{
	$SETUP_SERVER_NAME = trim($SETUP_SERVER_NAME);

	if (strlen($SETUP_SERVER_NAME) <= 0)
	{
		if (strlen($ar_iblock['SERVER_NAME']) <= 0)
		{
			$rsSite = CSite::GetList(($b="sort"), ($o="asc"), array("LID" => $ar_iblock["LID"]));
			if($arSite = $rsSite->Fetch())
				$ar_iblock["SERVER_NAME"] = $arSite["SERVER_NAME"];
			if(strlen($ar_iblock["SERVER_NAME"])<=0 && defined("SITE_SERVER_NAME"))
				$ar_iblock["SERVER_NAME"] = SITE_SERVER_NAME;
			if(strlen($ar_iblock["SERVER_NAME"])<=0)
				$ar_iblock["SERVER_NAME"] = COption::GetOptionString("main", "server_name", "");
		}
	}
	else
	{
		$ar_iblock['SERVER_NAME'] = $SETUP_SERVER_NAME;
	}
}

if (strlen($strExportErrorMessage)<=0)
{
	$bAllSections = False;
	$arSections = array();
	if (is_array($V))
	{
		foreach ($V as $key => $value)
		{
			if (trim($value)=="0")
			{
				$bAllSections = True;
				break;
			}

			if (IntVal($value)>0)
			{
				$arSections[] = IntVal($value);
			}
		}
	}

	if (!$bAllSections && count($arSections)<=0)
		$strExportErrorMessage .= "Section list is not set.\n";
}

$SETUP_FILE_NAME = Rel2Abs("/", $SETUP_FILE_NAME);
/*
if (strtolower(substr($SETUP_FILE_NAME, strlen($SETUP_FILE_NAME)-4)) != ".csv")
	$SETUP_FILE_NAME .= ".csv";
*/

if (!$bTmpUserCreated && $GLOBALS["APPLICATION"]->GetFileAccessPermission($SETUP_FILE_NAME) < "W")
	$strExportErrorMessage .= str_replace("#FILE#", $SETUP_FILE_NAME, "Not enough access rights to replace file #FILE#")."<br>";

if (strlen($strExportErrorMessage)<=0)
{
	CheckDirPath($_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME);

	if (!$fp = @fopen($_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME, "wb"))
	{
		$strExportErrorMessage .= "Can not open \"".$_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME."\" file for writing.\n";
	}
	else
	{

		if (!@fwrite($fp, '<?if (!isset($_GET["referer1"]) || strlen($_GET["referer1"])<=0) $_GET["referer1"] = "yandext";?>'))
		{
			$strExportErrorMessage .= "Can not write in \"".$_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME."\" file.\n";
			@fclose($fp);
		}
		else
		{
			fwrite($fp, '<?if (!isset($_GET["referer2"])) $_GET["referer2"] = "";?>');
		}
	}
}

if (strlen($strExportErrorMessage)<=0)
{
	@fwrite($fp, '<? header("Content-Type: text/xml; charset=windows-1251");?>');
	@fwrite($fp, '<? echo "<"."?xml version=\"1.0\" encoding=\"windows-1251\"?".">"?>');
	@fwrite($fp, "\n<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n");
	@fwrite($fp, "<yml_catalog date=\"".Date("Y-m-d H:i")."\">\n");
	@fwrite($fp, "<shop>\n");

	@fwrite($fp, "<name>".yandex_text2xml(htmlspecialchars(COption::GetOptionString("main", "site_name", "")))."</name>\n");

	@fwrite($fp, "<company>".yandex_text2xml(htmlspecialchars(COption::GetOptionString("main", "site_name", "")))."</company>\n");
	@fwrite($fp, "<url>http://".htmlspecialchars($ar_iblock['SERVER_NAME'])."</url>\n");

	$strTmp = "<currencies>\n";

	if ($arCurrency = CCurrency::GetByID('RUR'))
		$RUR = 'RUR';
	else
		$RUR = 'RUB';

	$arCurrencyAllowed = array($RUR, 'USD', 'EUR', 'UAH', 'BYR', 'KZT');

	$BASE_CURRENCY = CCurrency::GetBaseCurrency();
	if (is_array($XML_DATA['CURRENCY']))
	{
		foreach ($XML_DATA['CURRENCY'] as $CURRENCY => $arCurData)
		{
			if (in_array($CURRENCY, $arCurrencyAllowed))
			{
				$strTmp.= "<currency id=\"".$CURRENCY."\""
				." rate=\"".($arCurData['rate'] == 'SITE' ? CCurrencyRates::ConvertCurrency(1, $CURRENCY, $RUR) : $arCurData['rate'])."\""
				.($arCurData['plus'] > 0 ? ' plus="'.intval($arCurData['plus']).'"' : '')
				." />\n";
			}
		}
	}
	else
	{
		$db_acc = CCurrency::GetList(($by="sort"), ($order="asc"));
		while ($arAcc = $db_acc->Fetch())
		{
			if (in_array($arAcc['CURRENCY'], $arCurrencyAllowed))
				$strTmp.= "<currency id=\"".$arAcc["CURRENCY"]."\" rate=\"".(CCurrencyRates::ConvertCurrency(1, $arAcc["CURRENCY"], $RUR))."\"/>\n";
		}
	}
	$strTmp.= "</currencies>\n";

    $strTmp = "<currencies>\n<currency id=\"RUB\" rate=\"1\"/>\n</currencies>\n";

	@fwrite($fp, $strTmp);

	//*****************************************//

	$arSelect = array("ID", "LID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "ACTIVE", "ACTIVE_FROM", "ACTIVE_TO", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "PREVIEW_TEXT_TYPE", "DETAIL_PICTURE", "LANG_DIR", "DETAIL_PAGE_URL");

	$db_res = CCatalogGroup::GetGroupsList(array("GROUP_ID"=>2));
	$arPTypes = array();
	while ($ar_res = $db_res->Fetch())
	{
		if (!in_array($ar_res["CATALOG_GROUP_ID"], $arPTypes))
		{
			$arPTypes[] = $ar_res["CATALOG_GROUP_ID"];
			$arSelect[] = "CATALOG_GROUP_".$ar_res["CATALOG_GROUP_ID"];
		}
	}

	$strTmpCat = "";
	$strTmpOff = "";

	$arAvailGroups = array();
	if (!$bAllSections)
	{
		for ($i = 0; $i < count($arSections); $i++)
		{
			$filter_tmp = $filter;
			$db_res = CIBlockSection::GetNavChain($IBLOCK_ID, $arSections[$i]);
			$curLEFT_MARGIN = 0;
			$curRIGHT_MARGIN = 0;
			while ($ar_res = $db_res->Fetch())
			{
				$curLEFT_MARGIN = IntVal($ar_res["LEFT_MARGIN"]);
				$curRIGHT_MARGIN = IntVal($ar_res["RIGHT_MARGIN"]);
				$arAvailGroups[] = array(
					"ID" => IntVal($ar_res["ID"]),
					"IBLOCK_SECTION_ID" => IntVal($ar_res["IBLOCK_SECTION_ID"]),
					"NAME" => $ar_res["NAME"]
					);
			}

			$filter = Array("IBLOCK_ID"=>$IBLOCK_ID, ">LEFT_MARGIN"=>$curLEFT_MARGIN, "<RIGHT_MARGIN"=>$curRIGHT_MARGIN, "ACTIVE"=>"Y", "IBLOCK_ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y");
			$db_res = CIBlockSection::GetList(array("left_margin"=>"asc"), $filter);
			while ($ar_res = $db_res->Fetch())
			{
				$arAvailGroups[] = array(
					"ID" => IntVal($ar_res["ID"]),
					"IBLOCK_SECTION_ID" => IntVal($ar_res["IBLOCK_SECTION_ID"]),
					"NAME" => $ar_res["NAME"]
					);
			}
		}
		$cnt_arAvailGroups = count($arAvailGroups);
		for ($i = 0; $i < $cnt_arAvailGroups-1; $i++)
		{
			if (!isset($arAvailGroups[$i])) continue;

			for ($j = $i + 1; $j < $cnt_arAvailGroups; $j++)
			{
				if (!isset($arAvailGroups[$j])) continue;

				if ($arAvailGroups[$i]["ID"]==$arAvailGroups[$j]["ID"])
				{
					unset($arAvailGroups[$j]);
				}
			}
		}
	}
	else
	{
		$filter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y", "IBLOCK_ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y");
		$db_res = CIBlockSection::GetList(array("left_margin"=>"asc"), $filter);
		while ($ar_res = $db_res->Fetch())
		{
			$arAvailGroups[] = array(
				"ID" => IntVal($ar_res["ID"]),
				"IBLOCK_SECTION_ID" => IntVal($ar_res["IBLOCK_SECTION_ID"]),
				"NAME" => $ar_res["NAME"]
				);
		}
	}

	$arSectionIDs = array();
	foreach ($arAvailGroups as $key => $value)
	{
		$strTmpCat.= "<category id=\"".$value["ID"]."\"".(IntVal($value["IBLOCK_SECTION_ID"])>0?" parentId=\"".$value["IBLOCK_SECTION_ID"]."\"":"").">".yandex_text2xml($value["NAME"], false)."</category>\n";
		$arSectionIDs[] = $value["ID"];
	}

	//*****************************************//

	$filter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", '!PROPERTY_hide_price'=>'241','PROPERTY_STATE'=>Array(false,21));
	if (!$bAllSections)
	{
		$filter["INCLUDE_SUBSECTIONS"] = "Y";
		$filter["SECTION_ID"] = $arSectionIDs;
	}
	$res = CIBlockElement::GetList(array(), $filter, false, false, $arSelect);

	$db_acc = new CIBlockResult($res);

	$total_sum = 0;
	$is_exists = false;
	$cnt = 0;

	while ($obElement = $db_acc->GetNextElement())
	{
		$arAcc = $obElement->GetFields();

		if (is_array($XML_DATA['XML_DATA']))
		{
			$arAcc["PROPERTIES"] = $obElement->GetProperties();
		}

		$str_QUANTITY = DoubleVal($arAcc["CATALOG_QUANTITY"]);
		$str_QUANTITY_TRACE = $arAcc["CATALOG_QUANTITY_TRACE"];
		if (($str_QUANTITY <= 0) && ($str_QUANTITY_TRACE == "Y"))
			$str_AVAILABLE = ' available="false"';
		else
			$str_AVAILABLE = ' available="true"';

        if(($arAcc["PROPERTIES"]['STATE']['VALUE_XML_ID'] == 'soon') || ($arAcc["PROPERTIES"]['STATE']['VALUE_XML_ID'] == 'net_v_nal'))
            $str_AVAILABLE = ' available="false"';
        else
            $str_AVAILABLE = ' available="true"';


		// TODO: use PRICE setting. this code is only for PRICE=0

		$minPrice = 0;
		$minPriceRUR = 0;
		$minPriceGroup = 0;
		$minPriceCurrency = "";

		$arPriceGroups = $XML_DATA['PRICE'] > 0 ? array($XML_DATA['PRICE']) : array();
		if (!$arPrice = CCatalogProduct::GetOptimalPrice(
			$arAcc['ID'],
			1,
			array(2), // anonymous
			'N',
			$arPriceGroups,
			$ar_iblock['LID']
		))
		{
			continue;
		}
		else
		{
			$minPrice = $arPrice['DISCOUNT_PRICE'];
			$minPriceCurrency = $BASE_CURRENCY;
			$minPriceRUR = CCurrencyRates::ConvertCurrency($minPrice, $BASE_CURRENCY, $RUR);
			$minPriceGroup = $arPrice['PRICE']['CATALOG_GROUP_ID'];
		}

		/*
		if ($XML_DATA['PRICE'] > 0 && strlen($arAcc["CATALOG_CURRENCY_".$XML_DATA['PRICE']]) > 0)
		{
			$minPrice = $arAcc["CATALOG_PRICE_".$XML_DATA['PRICE']];
			$minPriceGroup = $XML_DATA['PRICE'];
			$minPriceCurrency = $arAcc["CATALOG_CURRENCY_".$XML_DATA['PRICE']];
			$minPriceRUR = CCurrencyRates::ConvertCurrency($arAcc["CATALOG_PRICE_".$XML_DATA['PRICE']], $arAcc["CATALOG_CURRENCY_".$XML_DATA['PRICE']], $RUR);
		}
		else
		{
			for ($i = 0; $i < count($arPTypes); $i++)
			{
				if (strlen($arAcc["CATALOG_CURRENCY_".$arPTypes[$i]])<=0) continue;

				$tmpPrice = CCurrencyRates::ConvertCurrency($arAcc["CATALOG_PRICE_".$arPTypes[$i]], $arAcc["CATALOG_CURRENCY_".$arPTypes[$i]], $RUR);
				if ($minPriceRUR<=0 || $minPriceRUR>$tmpPrice)
				{
					$minPriceRUR = $tmpPrice;
					$minPrice = $arAcc["CATALOG_PRICE_".$arPTypes[$i]];
					$minPriceGroup = $arPTypes[$i];
					$minPriceCurrency = $arAcc["CATALOG_CURRENCY_".$arPTypes[$i]];
					if (!in_array($minPriceCurrency, $arCurrencyAllowed) || $minPriceCurrency == 'RUB')
					{
						$minPriceCurrency = $RUR;
						$minPrice = $tmpPrice;
					}
				}
			}
		}
		*/

		if ($minPrice <= 0) continue;

		$bNoActiveGroup = True;
		$strTmpOff_tmp = "";
		$db_res1 = CIBlockElement::GetElementGroups($arAcc["ID"]);
		while ($ar_res1 = $db_res1->Fetch())
		{
			if (in_array(IntVal($ar_res1["ID"]), $arSectionIDs))
			{
				$strTmpOff_tmp.= "<categoryId>".$ar_res1["ID"]."</categoryId>\n";
				$bNoActiveGroup = False;
			}
		}
		if ($bNoActiveGroup) continue;

		if (strlen($arAcc['DETAIL_PAGE_URL']) <= 0) $arAcc['DETAIL_PAGE_URL'] = '/';
		else $arAcc['DETAIL_PAGE_URL'] = str_replace(' ', '%20', $arAcc['DETAIL_PAGE_URL']);

		if (is_array($XML_DATA) && $XML_DATA['TYPE'] && $XML_DATA['TYPE'] != 'none')
			$str_TYPE = ' type="'.htmlspecialchars($XML_DATA['TYPE']).'"';
		else
			$strType = '';

        $arAcc['TYPE'] = $arAcc['PROPERTIES']['TYPE']['VALUE_XML_ID'];
        if($arAcc['TYPE'] == 'TYPE_AUDIO')
            $str_TYPE = ' type="audiobook" ';
        else
            $str_TYPE = ' type="book" ';
		if ($arAcc['PROPERTIES']['age_group']['VALUE'])
			$age_group = $arAcc['PROPERTIES']['age_group']['VALUE'];
		else
			$age_group = 0;

		$strTmpOff.= "<offer id=\"".$arAcc["ID"]."\"".$str_TYPE.$str_AVAILABLE.">\n";
        $strTmpOff.= "<url>http://".$ar_iblock['SERVER_NAME'].htmlspecialchars($arAcc["~DETAIL_PAGE_URL"]."?utm_source=yandex.market&utm_medium=cpc")."</url>\n";

		$strTmpOff.= "<price>".$minPrice."</price>\n";
        $strTmpOff.= "<currencyId>".$minPriceCurrency."</currencyId>\n";





		$strTmpOff.= $strTmpOff_tmp;

		if (IntVal($arAcc["DETAIL_PICTURE"])>0 || IntVal($arAcc["PREVIEW_PICTURE"])>0)
		{
			$pictNo = IntVal($arAcc["DETAIL_PICTURE"]);
			if ($pictNo<=0) $pictNo = IntVal($arAcc["PREVIEW_PICTURE"]);

			$db_file = CFile::GetByID($pictNo);
			if ($ar_file = $db_file->Fetch())
			{

                $strFile = "/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".$ar_file["FILE_NAME"];
				$strFile = str_replace("//", "/", $strFile);
				$strTmpOff.="<picture>http://".$ar_iblock['SERVER_NAME'].implode("/", array_map("rawurlencode", explode("/", $strFile)))."</picture>\n";


                /*$strFile = "/".$ar_file["SUBDIR"]."/".$ar_file["FILE_NAME"];
                $strFile = str_replace("//", "/", $strFile);
                $strTmpOff.="<picture>http://alpinabook-a.akamaihd.net".implode("/", array_map("rawurlencode", explode("/", $strFile)))."</picture>\n";*/
			}
		}

        $strTmpOff .= "<delivery>true</delivery>\n
					<pickup>true</pickup>\n";

		$y = 0;
        if($arAcc['TYPE'] == 'TYPE_AUDIO')
            $arTmpYandexFields = $arYandexFieldsAudioBook;
        else
            $arTmpYandexFields = $arYandexFieldsBook;



		foreach ($arTmpYandexFields as $key)
		{
			switch ($key)
			{
				case 'name':

                    $age = 16;
                    if($arAcc['PROPERTIES']['age_group']['VALUE']){
                        $age = $arAcc['PROPERTIES']['age_group']['VALUE'];
                    }

					if (is_array($XML_DATA) && ($XML_DATA['TYPE'] == 'vendor.model' || $XML_DATA['TYPE'] == 'artist.title'))
						continue;
					if($arAcc['TYPE'] == 'TYPE_AUDIO') $arAcc["NAME"] .= ' (аудиокнига)';
                    elseif($arAcc['TYPE'] == 'TYPE_VIDEO') $arAcc["NAME"] .= ' (видеокурс)';
                    elseif($arAcc['TYPE'] == 'TYPE_SET') $arAcc["NAME"] .= ' (комплект из '.count($arAcc['PROPERTIES']['COMPLECT_BOOKS']['VALUE']).' книг'.(count($arAcc['PROPERTIES']['COMPLECT_BOOKS']['VALUE'])%10 == 1?'и':'').')';
					$strTmpOff.= "<name>".yandex_text2xml('('.$age_group.'+) '.htmlspecialchars($arAcc["NAME"]), false)."</name>\n";
				break;
				case 'description':
					$strTmpOff.=
						"<description>".
						yandex_text2xml(
							($arAcc["PREVIEW_TEXT_TYPE"]=="html"?
							htmlspecialchars(TruncateText(strip_tags($arAcc["~PREVIEW_TEXT"]),800)) : htmlspecialchars(TruncateText(strip_tags($arAcc["PREVIEW_TEXT"]),800))), false).
						"</description>\n";
				break;


                case 'ISBN':
                    $t = trim($arAcc['PROPERTIES']['ISBN']['~VALUE']);
                    $t2 = trim($arAcc['PROPERTIES']['ISBN_OLD']['~VALUE']);
                    /*if(strlen($t2) > 0)
                        $t .= (strlen($t) > 0 ? ', ':'').$t2;*/
                    $strTmpOff.= "<".$key.">".yandex_text2xml($t, true)."</".$key.">\n";
                break;



				case 'param':
					if (is_array($XML_DATA) && is_array($XML_DATA['XML_DATA']) && is_array($XML_DATA['XML_DATA']['PARAMS']))
					{
						foreach ($XML_DATA['XML_DATA']['PARAMS'] as $key => $prop_id)
						{
							if ($prop_id)
							{
								$strTmpOff .= yandex_get_value($arAcc, 'PARAM_'.$key, $prop_id)."\n";
							}
						}
					}
				break;

				case 'model':
				case 'language':
					$strTmpOff.= "<".$key.">rus</".$key.">\n";
				break;

				case 'title':
					if (!is_array($XML_DATA) || !is_array($XML_DATA['XML_DATA']) || !$XML_DATA['XML_DATA'][$key])
					{
						if (
							$key == 'model' && $XML_DATA['TYPE'] == 'vendor.model'
							||
							$key == 'title' && $XML_DATA['TYPE'] == 'artist.title'
						)

						$strTmpOff.= "<".$key.">".yandex_text2xml($arAcc["NAME"], true)."</".$key.">\n";
					}
					else
						$strTmpOff.= yandex_get_value($arAcc, $key, $XML_DATA['XML_DATA'][$key]);
				//break;

				/*case 'year':
					$y++;
					if ($XML_DATA['TYPE'] == 'artist.title')
					{
						if ($y == 1) continue;
					}
					else
					{
						if ($y > 1) continue;
					}
				*/
					// no break here

				default:
					if (is_array($XML_DATA) && is_array($XML_DATA['XML_DATA']) && $XML_DATA['XML_DATA'][$key])
						$strTmpOff .= yandex_get_value($arAcc, $key, $XML_DATA['XML_DATA'][$key])."\n";
			}
		}
		if($arAcc['TYPE'] == 'TYPE_BOOK')
			$strTmpOff.= "<age unit='age'>".$age_group."</age>\n";
		$strTmpOff.= "</offer>\n";
	}

	@fwrite($fp, "<categories>\n");
	@fwrite($fp, $strTmpCat);
	@fwrite($fp, "</categories>\n");

	@fwrite($fp, "<delivery-options>\n
				<option cost='149' days='1-2'/>\n
			</delivery-options>\n");

	@fwrite($fp, "<offers>\n");
	@fwrite($fp, $strTmpOff);
	@fwrite($fp, "</offers>\n");

	@fwrite($fp, "</shop>\n");
	@fwrite($fp, "</yml_catalog>\n");

	@fclose($fp);
}

if ($bTmpUserCreated)
{
	unset($USER);

	if (isset($USER_TMP))
	{
		$USER = $USER_TMP;
		unset($USER_TMP);
	}
}
?>
