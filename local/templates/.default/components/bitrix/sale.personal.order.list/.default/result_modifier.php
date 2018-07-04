<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	use Bitrix\Main\Localization\Loc;

	Loc::loadMessages(__FILE__);
   
	// we dont trust input params, so validation is required
	$legalColors = array(
		'green' => true,
		'yellow' => true,
		'red' => true,
		'gray' => true
	);
	// default colors in case parameters unset
	$defaultColors = array(
		'N' => 'green',
		'P' => 'yellow',
		'F' => 'gray',
		'PSEUDO_CANCELLED' => 'red'
	);

	foreach ($arParams as $key => $val)
		if(strpos($key, "STATUS_COLOR_") !== false && !$legalColors[$val])
			unset($arParams[$key]);

	// to make orders follow in right status order
	if(is_array($arResult['INFO']) && !empty($arResult['INFO']))
	{
		foreach($arResult['INFO']['STATUS'] as $id => $stat)
		{
			$arResult['INFO']['STATUS'][$id]["COLOR"] = $arParams['STATUS_COLOR_'.$id] ? $arParams['STATUS_COLOR_'.$id] : (isset($defaultColors[$id]) ? $defaultColors[$id] : 'gray');
			$arResult["ORDER_BY_STATUS"][$id] = array();
		}
	}
	$arResult["ORDER_BY_STATUS"]["PSEUDO_CANCELLED"] = array();

	$arResult["INFO"]["STATUS"]["PSEUDO_CANCELLED"] = array(
		"NAME" => Loc::getMessage('SPOL_PSEUDO_CANCELLED'),
		"COLOR" => $arParams['STATUS_COLOR_PSEUDO_CANCELLED'] ? $arParams['STATUS_COLOR_PSEUDO_CANCELLED'] : (isset($defaultColors['PSEUDO_CANCELLED']) ? $defaultColors['PSEUDO_CANCELLED'] : 'gray')
	);

	if(is_array($arResult["ORDERS"]) && !empty($arResult["ORDERS"]))
	{
		foreach ($arResult["ORDERS"] as $order)
		{
			$order['HAS_DELIVERY'] = intval($order["ORDER"]["DELIVERY_ID"]) || strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false;

			$stat = $order['ORDER']['CANCELED'] == 'Y' ? 'PSEUDO_CANCELLED' : $order["ORDER"]["STATUS_ID"];
			$color = $arParams['STATUS_COLOR_'.$stat];
			$order['STATUS_COLOR_CLASS'] = empty($color) ? 'gray' : $color;

			$arResult["ORDER_BY_STATUS"][$stat][] = $order;       
		}

	}
    
    foreach ($arResult["ORDER_BY_STATUS"] as $order_key => $group) {
        foreach ($group as $k => $order) {
            
            $user_IDs[] = $order["ORDER"]["USER_ID"];
            $order_IDs[] = $order["ORDER"]["ID"];
        }
    }
    arshow();
    if(count($arResult["ORDERS"]) > 0){
        $users_info = CUser::GetList (($by = "id"), ($sort = "desc"), array("ID" => $user_IDs[0]));
                      
        while ($users = $users_info -> Fetch()) {
            $arResult["USER_INFO"][$users["ID"]] = $users;    
        }
    }                
    $order_info = CSaleOrderPropsValue::GetList(array(), array("ORDER_ID" => $order_IDs), false, false, array());
    while ($info = $order_info->Fetch()) {             
        $boxberryDelivery = '';
        foreach ($arResult["ORDERS"] as $orderNum => $order) {           
            if($order['ORDER']['ID'] == $info["ORDER_ID"]) {
                if($arResult["ORDERS"][$orderNum]['ORDER']['DELIVERY_ID'] == BOXBERRY_PICKUP_DELIVERY_ID) {
                    $boxberryDelivery = 'Y';
                };
            }
        }                   
        if($boxberryDelivery == 'Y') {                                                  
            if (in_array($info["ORDER_PROPS_ID"], array(PVZ_ADRESS_NATURAL, PVZ_ADRESS_LEGAL))) {        
                $arResult["ORDER_INFO"][$info["ORDER_ID"]]["DELIVERY_ADDR"] = $info["VALUE"];         
            }         
        } else {
            if (in_array($info["ORDER_PROPS_ID"], array(CITY_INDIVIDUAL_ORDER_PROP_ID, CITY_ENTITY_ORDER_PROP_ID))) {
                $arResult["ORDER_INFO"][$info["ORDER_ID"]]["DELIVERY_CITY"] = CSaleLocation::GetByID($info["VALUE"]);
            }
            if (in_array($info["ORDER_PROPS_ID"], array(ADDRESS_INDIVIDUAL_ORDER_PROP_ID, ADDRESS_ENTITY_ORDER_PROP_ID))) {
                $arResult["ORDER_INFO"][$info["ORDER_ID"]]["DELIVERY_ADDR"] = $info["VALUE"];
            } 
        }  
        if (in_array($info["CODE"], array("PHONE", "F_PHONE"))) {
            $arResult["ORDER_INFO"][$info["ORDER_ID"]]["ORDER_PHONE"] = $info["VALUE"];
        } 
    }
     
?>