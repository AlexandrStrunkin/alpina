<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if ($USER->isAdmin()) {

    CModule::IncludeModule("blog");
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("sale");
    CModule::IncludeModule("catalog");
    CModule::IncludeModule("main");
	
	
	/***************
	* Новинки в письмо
	*************/
	echo "1<br />
	<style>
	td {border:solid #eee 1px;}
	</style>";
	$newItemsBlock = "";
	$i = 0;
	$NewItems = CIBlockElement::GetList (array("timestamp_x" => "DESC"), array("IBLOCK_ID" => 4, "PROPERTY_STATE" => 21, "ACTIVE" => "Y", ">DETAIL_PICTURE" => 0), false, false, array());
	$newItemsBlock .= '<tr><td style="border-collapse: collapse;padding:10px 40px 20px 40px;">';
	while (($NewItemsList = $NewItems -> Fetch()) && ($i < 3))
	{
		$pict = CFile::ResizeImageGet($NewItemsList["DETAIL_PICTURE"], array("width" => 140, "height" => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		$curr_sect = CIBlockSection::GetByID($NewItemsList["IBLOCK_SECTION_ID"]) -> Fetch();
		
		$newItemsBlock .= '
		<table align="left" border="0" cellpadding="8" cellspacing="0" class="tile" width="32%">
		<tbody>
		<tr>
		<td height="200" style="border-collapse: collapse;text-align:center;" valign="top" width="100%">
		<a href="http://www.alpinabook.ru/catalog/'.$curr_sect["CODE"].'/'.$NewItemsList["ID"].'/?utm_source=autotrigger&amp;utm_medium=email&amp;utm_term=newbooks&amp;utm_campaign=forgottenMails" target="_blank">
		<img alt="'.$NewItemsList["NAME"].'" src="'.$pict["src"].'" style="width: 140px; height: auto;" />
		</a>
		</td>
		</tr>
		<tr>
		<td align="center" height="18" style="color: #336699;font-weight: normal; border-collapse: collapse;font-family: Roboto,Tahoma,sans-serif;font-size: 16px;line-height: 150%;" valign="top" width="126">
		<a href="http://www.alpinabook.ru/catalog/'.$curr_sect["CODE"].'/'.$NewItemsList["ID"].'/?utm_source=autotrigger&amp;utm_medium=email&amp;utm_term=newbooks&amp;utm_campaign=forgottenMails" target="_blank">Подробнее о книге</a>
		</td>
		</tr>
		<tr>
		<td align="center" height="18" style="color: #336699;font-weight: normal; border-collapse: collapse;font-family: Roboto,Tahoma,sans-serif;font-size: 16px;line-height: 150%;padding-top:0;" valign="top" width="126">
		<a href="http://www.alpinabook.ru/catalog/'.$curr_sect["CODE"].'/'.$NewItemsList["ID"].'/?utm_source=autotrigger&amp;utm_medium=email&amp;utm_term=newbooks&amp;utm_campaign=forgottenMails" target="_blank">Купить</a>
		</td>
		</tr>
		</tbody>
		</table>';
		$i++;
	}
	$newItemsBlock .= '</td></tr>';

	
			
	/***************
	* Получаем телефон из заказа
	*************/

	function getPhone($id){
		$db_props = CSaleOrderPropsValue::GetOrderProps($id);
		while ($arProps = $db_props->Fetch()){
			if($arProps['CODE']=='PHONE'){
				$clearedPhone = preg_replace('/[^0-9+]/','',$arProps['VALUE']);
				return $clearedPhone;
			}
		}
	}

	/***************
	* Получаем имя клиента из заказа
	*************/

	function getClientName($id){
		$db_props = CSaleOrderPropsValue::GetOrderProps($id);
		while ($arProps = $db_props->Fetch()){
			if($arProps['CODE']=='F_CONTACT_PERSON'){
				return $arProps['VALUE'];
			}
		}
	}

	/***************
	* Получаем email клиента из заказа
	*************/

	function getClientEmail($id){
		$db_props = CSaleOrderPropsValue::GetOrderProps($id);
		while ($arProps = $db_props->Fetch()){
			if($arProps['CODE']=='EMAIL'){
				return $arProps["VALUE"];
			}
		}
	}	
	
	/***************
	* Отправляем большой эмэйл
	*************/

	function sendNotificationEmail($id,$subject,$notification,$userID, $latestBooks) {
		$arEventFields = array(
			"EMAIL" => getClientEmail($id),
			"ORDER_USER" => getClientName($id),
			"ORDER_ID" => $id,
			"SUBJECT" => $subject,
			"NOTIFICATION" => $notification,
			"NEW_ITEMS_BLOCK" => $latestBooks
		);				
		CEvent::Send("ON_TIME_NOTIFICATIONS", "s1", $arEventFields,"N");
		
		$arFields = array(
			"EMP_STATUS_ID" => $userID
		);
		CSaleOrder::Update($id, $arFields);
		//echo $id."*".$subject."*".$userID."<br />";
	}
	
	$userID1 = 175985; 			//triggerMailUser_1
	$userID2 = 175986; 			//triggerMailUser_2
	$userIDabroad = 176080; 	//triggerMailUser_abroad
	$userIDontheway = 176775; 	//triggerMailUser_ontheway
	$userIDreturn = 176835; 	//triggerMailUser_return

	/***************
	* Пользователи API Почты России
	*************/
	$allUsers = array(
		array('login'=>'reCbiSaKylFiDh','password'=>'VdbVsIc7dtuf'), //Марченков
		array('login'=>'cruZXgcQzVDFRc','password'=>'s98awuYAXRrG'), //Петухова
		array('login'=>'dxviIPkwrlaEHS','password'=>'8dZACYAfBEqj'), //Данилова
		array('login'=>'AGSEccWQxDUTVY','password'=>'RbOU2Eh3cJqH') //Разумовская
	);
	
	$countUsers = count($allUsers);	
	
	
	/***************
	* Итоговое отчетное письмо
	*************/
	$finalReport = "triggerMailUser_1 - ".$userID1."<br />";
	$finalReport .= "triggerMailUser_2 - ".$userID2."<br />";
	$finalReport .= "triggerMailUser_abroad - ".$userIDabroad."<br /><br />";
	$finalReport .= "<table width='100%'><tbody><tr>
					<td><b>ID заказа</b></td>
					<td><b>Доставка</b></td>
					<td><b>Текущий статус</b></td>
					<td><b>ID пользователя</b></td>
					<td><b>Будущий статус</b></td>
					<td><b>Идентификатор</b></td>
					<td><b>Состояние</b></td>
					<td><b>Комментарий</b></td>
					</tr>					
	";

	
	echo "2<br />";
	/* I Проверяем даты собранных самовывозов */
	$arFilter = Array(
		"DELIVERY_ID" => "2",
		"@STATUS_ID" => array("C")
	);
	$rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
	while ($arSales = $rsSales->Fetch())
	{
		$id = $arSales["ID"];
		if (
			(time() - strtotime($arSales[DATE_STATUS]))/86400 > 7 && 	// Если прошло больше 7 дней
			(time() - strtotime($arSales[DATE_STATUS]))/86400 < 12 && 	// и меньше 12 дней
			$arSales["EMP_STATUS_ID"] != $userID1) 						// еще не отправляли первое уведомление о собранном заказе
		{
			
			$subject = 'Истекает срок хранения заказа №'.$id.'. Альпина Паблишер';
			$notification = "Ваши книги скучают и ждут Вас. Скорее приезжайте за ними, срок хранения вашего заказа истекает уже через неделю.<br />
			Вы можете забрать заказ ".$id." по адресу: метро «Полежаевская», 4-я Магистральная улица, дом 5, подъезд 2, второй этаж.<br /><br />
			Да, кстати, у нас есть несколько хороших новинок, которые должны вам понравиться.";
			$result = sendNotificationEmail($id, $subject, $notification, $userID1, $newItemsBlock);
			$finalReport .= "<tr>
				<td>".$id."</td>
				<td>Самовывоз</td>
				<td>Собран</td>
				<td>".$userID1."</td>
				<td>Собран</td>
				<td></td>
				<td></td>
				<td>Прошла неделя</td>
				</tr>";
		} elseif (
			(time() - strtotime($arSales[DATE_STATUS]))/86400 >= 12 && 	// Если прошло больше 11 дней
			$arSales["EMP_STATUS_ID"] != $userID2)						// и еще не отправляли второе уведомление
		{
			$subject = 'Истекает срок хранения заказа №'.$id.'. Альпина Паблишер';
			$notification = "Ваши книги скучают и ждут вас. Скорее приезжайте за ними, срок хранения вашего заказа истекает уже через 2 дня.<br />
			Вы можете забрать заказ ".$id." по адресу: метро «Полежаевская», 4-я Магистральная улица, дом 5, подъезд 2, второй этаж.<br /><br />
			Да, кстати, у нас есть несколько хороших новинок, которые должны вам понравиться.";
			$result = sendNotificationEmail($id, $subject, $notification, $userID2, $newItemsBlock);
			$finalReport .= "<tr>
				<td>".$id."</td>
				<td>Самовывоз</td>
				<td>Собран</td>
				<td>".$userID2."</td>
				<td>Собран</td>
				<td></td>
				<td></td>
				<td>Осталось два дня</td>
				</tr>";			
		}
	}
	echo "3<br />";
	/* II Проверяем даты отправленных пикпоинтов */
	/*$arFilter = Array(
		"DELIVERY_ID" => "17",
		"@STATUS_ID" => array("I")
	);
	$rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
	while ($arSales = $rsSales->Fetch())
	{
	  echo "<pre>";
	  if ((time() - strtotime($arSales[DATE_STATUS]))/86400 > 7)
		  echo "Заказ выполнен! Спасибо!";
	  echo "</pre>";
	}*/
	
	echo "4<br />";
	/* III Проверяем доставку почтой */
	$arFilter = Array(
		"DELIVERY_ID" => array(10,11,16,24,25,26,28),
		"!USER_ID" => array($userIDreturn),
		"@STATUS_ID" => array("I","K"),
		">=DATE_INSERT" => "07.04.2016"
	);
	$rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
	while ($arSales = $rsSales->Fetch())
	{

		$id = $arSales["ID"];
		$list = \Bitrix\Sale\Internals\OrderTable::getList(array(
			"select" => array(
				"TRACKING_NUM" => "\Bitrix\Sale\Internals\ShipmentTable:ORDER.TRACKING_NUMBER"
			),
			"filter" => array(
				"!=\Bitrix\Sale\Internals\ShipmentTable:ORDER.TRACKING_NUMBER" => "",
				"=ID" => $id
			),
			'limit'=> 1 
		))->fetchAll();
		
		if (!empty($list[0]['TRACKING_NUM'])) {
			$trackingNumber = $list[0]['TRACKING_NUM'];
		} else {
			$order = CSaleOrder::GetByID($id);
			$trackingNumber = $order["DELIVERY_DOC_NUM"];
		}
		
		//$trackingNumber = $list[0]['TRACKING_NUM'];
		if ((time() - strtotime($arSales[DATE_STATUS]))/86400 < 3 && $arSales["EMP_STATUS_ID"] == $userIDontheway) {
			$finalReport .= "<tr>
				<td>".$id."</td>
				<td>Почта</td>
				<td>В пути, отправлен на почту</td>
				<td>---</td>
				<td>В пути, отправлен на почту</td>
				<td>".$trackingNumber."</td>
				<td>Ждем поступлени в отделение</td>
				<td>Уже проверяли</td>
				</tr>";			
			continue;
		}
		
		if ($stopAuth) {
			$finalReport .= "<tr>
				<td>".$id."</td>
				<td>Почта</td>
				<td>В пути, отправлен на почту</td>
				<td>---</td>
				<td>В пути, отправлен на почту</td>
				<td>".$trackingNumber."</td>
				<td>Ошибка авторизации</td>
				<td></td>
				</tr>";
				continue;
		}
		
		if (!empty($trackingNumber) &&								// Трекер проставлен
			preg_match('/([0-9]){13,20}/', $trackingNumber)) {
			
			$wsdlurl = 'https://tracking.russianpost.ru/rtm34?wsdl';
			$client2 = '';

			$client2 = new SoapClient($wsdlurl, array('trace' => 1, 'soap_version' => SOAP_1_2));

			$params3 = array ('OperationHistoryRequest' => array ('Barcode' => $trackingNumber, 'MessageType' => '0','Language' => 'RUS'),
							  'AuthorizationHeader' => $allUsers[0]);

			for ($i = 1; $i <= $countUsers; $i++) {
				try {
					$result = $client2->getOperationHistory(new SoapParam($params3,'OperationHistoryRequest'));
					$i = $countUsers;
					
					$parcelReturn = false;
					foreach ($result->OperationHistoryData->historyRecord as $record) {
						if ($record->OperationParameters->OperType->Id == 3) {
							$parcelReturn = true;
						}
					}

					if ($result->OperationHistoryData->historyRecord[count($result->OperationHistoryData->historyRecord)-1]->OperationParameters->OperType->Id == 2) {
							
						$arFields = array(
							"EMP_STATUS_ID" => $userID1,
							"STATUS_ID" => "F"
						);
						CSaleOrder::Update($id, $arFields);
						//echo $id."*Заказ почтой выполнен*".$userID1."<br />";
						$finalReport .= "<tr style='color:green;font-weight:700;'>
							<td>".$id."</td>
							<td>Почта</td>
							<td>В пути, отправлен на почту</td>
							<td>".$userID1."</td>
							<td>Выполнен</td>
							<td>".$trackingNumber."</td>
							<td>ok</td>
							<td></td>
							</tr>";	
					} elseif ($parcelReturn) {
						$arFields = array(
							"EMP_STATUS_ID" => $userIDreturn
						);
						CSaleOrder::Update($id, $arFields);
						//echo "return ".$id."<br />";
						$finalReport .= "<tr style='color:red;font-weight:700;'>
							<td>".$id."</td>
							<td>Почта</td>
							<td>В пути, отправлен на почту</td>
							<td>".$userIDreturn."</td>
							<td>В пути, отправлен на почту</td>
							<td>".$trackingNumber."</td>
							<td>Возврат</td>
							<td>Уведомить доставку</td>
							</tr>";	
					} elseif ($result->OperationHistoryData->historyRecord[count($result->OperationHistoryData->historyRecord)-1]->OperationParameters->OperType->Id == 8 &&
							  $result->OperationHistoryData->historyRecord[count($result->OperationHistoryData->historyRecord)-1]->OperationParameters->OperAttr->Id == 2) {
						$arFields = array(
							"EMP_STATUS_ID" => $userID2
						);
						CSaleOrder::Update($id, $arFields);
						//echo "поступил в отделение ".$id."<br />";
						$finalReport .= "<tr style='color:red;font-weight:700;'>
							<td>".$id."</td>
							<td>Почта</td>
							<td>В пути, отправлен на почту</td>
							<td>".$userID2."</td>
							<td>В пути, отправлен на почту</td>
							<td>".$trackingNumber."</td>
							<td>Прибыло в место вручения</td>
							<td>Уведомить клиента</td>
							</tr>";	
					} else {
						//echo 'Заказ в пути'.$id.'<br />';
						$arFields = array(
							"EMP_STATUS_ID" => $userIDontheway
						);
						CSaleOrder::Update($id, $arFields);
						
						$finalReport .= "<tr>
							<td>".$id."</td>
							<td>Почта</td>
							<td>В пути, отправлен на почту</td>
							<td>".$userIDontheway."</td>
							<td>В пути, отправлен на почту</td>
							<td>".$trackingNumber."</td>
							<td>Заказ в пути</td>
							<td></td>
							</tr>";	
					}
				} catch (SoapFault $e) {
					//var_dump($e); 
					//echo 'Ошибка авторизации<br />';
					$params3['AuthorizationHeader'] = $allUsers[$i];
					if ($i == $countUsers) {
						$finalReport .= "<tr>
							<td>".$id."</td>
							<td>Почта</td>
							<td>В пути, отправлен на почту</td>
							<td>---</td>
							<td>В пути, отправлен на почту</td>
							<td>".$trackingNumber."</td>
							<td>Ошибка авторизации".$i."</td>
							<td></td>
							</tr>";
						$stopAuth = true;
					}
				}
			}
		} elseif (
			!empty($trackingNumber) &&								// Трекер проставлен
			preg_match('/([a-z0-9]){13,20}/i', $trackingNumber)) {			// еще не простален флаг, что доставка по миру
			
				
			$wsdlurl = 'https://tracking.russianpost.ru/rtm34?wsdl';
			$client2 = '';

			$client2 = new SoapClient($wsdlurl, array('trace' => 1, 'soap_version' => SOAP_1_2));
			
			$params3 = array ('OperationHistoryRequest' => array ('Barcode' => $trackingNumber, 'MessageType' => '0','Language' => 'RUS'),
							  'AuthorizationHeader' => $allUsers[0]);

			
			/*if ($arSales["EMP_STATUS_ID"] != $userIDabroad) {
				$arFields = array(
					"EMP_STATUS_ID" => $userIDabroad
				);
				CSaleOrder::Update($id, $arFields);
				//echo "abroad ".$id."<br />";
				$finalReport .= "<tr>
					<td>".$id."</td>
					<td>Почта</td>
					<td>В пути, отправлен на почту</td>
					<td>".$userIDabroad."</td>
					<td>В пути, отправлен на почту</td>
					<td>".$trackingNumber."</td>
					<td>Заграницу</td>
					<td></td>
					</tr>";
			}*/
			for ($i = 1; $i <= $countUsers; $i++) {
				try {
					$result = $client2->getOperationHistory(new SoapParam($params3,'OperationHistoryRequest'));
					$i = $countUsers;
				
					
					$parcelReturn = false;
					foreach ($result->OperationHistoryData->historyRecord as $record) {
						if ($record->OperationParameters->OperType->Id == 3) {
							$parcelReturn = true;
						}
					}

					if ($result->OperationHistoryData->historyRecord[count($result->OperationHistoryData->historyRecord)-1]->OperationParameters->OperType->Id == 2) {
						$arFields = array(
							"EMP_STATUS_ID" => $userID1,
							"STATUS_ID" => "F"
						);
						CSaleOrder::Update($id, $arFields);
						//echo $id."*Заказ почтой заграницу выполнен*".$userID1."<br />";
						$finalReport .= "<tr style='color:green;font-weight:700;'>
							<td>".$id."</td>
							<td>Почта</td>
							<td>В пути, отправлен на почту</td>
							<td>".$userID1."</td>
							<td>Выполнен</td>
							<td>".$trackingNumber."</td>
							<td>Заграницу выполнен</td>
							<td></td>
							</tr>";
					} elseif ($parcelReturn) {
						$arFields = array(
							"EMP_STATUS_ID" => $userIDreturn
						);
						CSaleOrder::Update($id, $arFields);
						//echo "return ".$id."<br />";
						$finalReport .= "<tr style='color:red;font-weight:700;'>
							<td>".$id."</td>
							<td>Почта</td>
							<td>В пути, отправлен на почту</td>
							<td>".$userIDreturn."</td>
							<td>В пути, отправлен на почту</td>
							<td>".$trackingNumber."</td>
							<td>Возврат</td>
							<td>Уведомить доставку</td>
							</tr>";	
					} else {
						$arFields = array(
							"EMP_STATUS_ID" => $userIDabroad
						);
						CSaleOrder::Update($id, $arFields);
						//echo "abroad ".$id."<br />";
						$finalReport .= "<tr>
							<td>".$id."</td>
							<td>Почта</td>
							<td>В пути, отправлен на почту</td>
							<td>".$userIDabroad."</td>
							<td>В пути, отправлен на почту</td>
							<td>".$trackingNumber."</td>
							<td>Заграницу в пути</td>
							<td></td>
							</tr>";
					}
				} catch (SoapFault $e) {
					//var_dump($e); 
					//echo 'Ошибка авторизации<br />';
					$params3['AuthorizationHeader'] = $allUsers[$i];
					if ($i == $countUsers) {
						$finalReport .= "<tr>
							<td>".$id."</td>
							<td>Почта</td>
							<td>В пути, отправлен на почту</td>
							<td>---</td>
							<td>В пути, отправлен на почту</td>
							<td>".$trackingNumber."</td>
							<td>Ошибка авторизации".$i."</td>
							<td></td>
							</tr>";
						$stopAuth = true;
					}
				}
			}
		} elseif (empty($trackingNumber)) {
			$arFields = array(
				"EMP_STATUS_ID" => $userID2
			);
			CSaleOrder::Update($id, $arFields);
			//echo "noid ".$id."<br />";
			$finalReport .= "<tr>
					<td>".$id."</td>
					<td>Почта</td>
					<td>В пути, отправлен на почту</td>
					<td>".$userID2."</td>
					<td>В пути, отправлен на почту</td>
					<td>noid</td>
					<td>Нет идентификатора</td>
					<td></td>
					</tr>";
		} elseif (!empty($trackingNumber) &&								// Трекер проставлен
				  preg_match('/([0-9]){4}\-([0-9]){4}/i', $trackingNumber)) {
			$arFields = array(
				"EMP_STATUS_ID" => $userID2,
				"DELIVERY_ID" => 30
			);
			CSaleOrder::Update($id, $arFields);
			//echo "noid ".$id."<br />";
			$finalReport .= "<tr>
					<td>".$id."</td>
					<td>Flippost</td>
					<td>В пути, отправлен на почту</td>
					<td>".$userID2."</td>
					<td>В пути, отправлен на почту</td>
					<td>".$trackingNumber."</td>
					<td>В пути</td>
					<td>Изменили на Flippost</td>
					</tr>";
		} else {
			$arFields = array(
				"EMP_STATUS_ID" => $userID2
			);
			CSaleOrder::Update($id, $arFields);
			//echo "noid ".$id."<br />";
			$finalReport .= "<tr>
					<td>".$id."</td>
					<td>Почта</td>
					<td>В пути, отправлен на почту</td>
					<td>".$userID2."</td>
					<td>В пути, отправлен на почту</td>
					<td>".$trackingNumber."</td>
					<td>Проверить</td>
					<td>error</td>
					</tr>";
		}
	}
	
	echo "5<br />";
	/* IV Проверяем даты отправленной Flippost */
	$arFilter = Array(
		"DELIVERY_ID" => "23",
		"@STATUS_ID" => array("I")
	);
	$rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
	while ($arSales = $rsSales->Fetch())
	{
		if ((time() - strtotime($arSales[DATE_STATUS]))/86400 > 14) {
			$id = $arSales["ID"];
			$arFields = array(
				"EMP_STATUS_ID" => $userID1,
				"STATUS_ID" => "F"
			);
			CSaleOrder::Update($id, $arFields);
			$finalReport .= "<tr>
				<td>".$id."</td>
				<td>Flippost</td>
				<td>В пути</td>
				<td>".$userID1."</td>
				<td>Выполнен</td>
				<td></td>
				<td></td>
				<td></td>
				</tr>";	
		}
	}
	
	echo "6<br />";
	/* V Заказ еще не оплачен, ждем */
	$arFilter = Array(
		"DELIVERY_ID" => array(10,11,16,17,23,24,25,26,28),
		"@STATUS_ID" => array("N", "O")
	);
	$rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
	while ($arSales = $rsSales->Fetch())
	{
		$id = $arSales["ID"];
		if (
			(time() - strtotime($arSales[DATE_STATUS]))/86400 > 5 &&	// Если прошло больше пяти дней
			(time() - strtotime($arSales[DATE_STATUS]))/86400 < 10 &&	// и меньше 10 дней
			$arSales["EMP_STATUS_ID"] != $userID1)						// и еще не отправляли первое уведомление
			{
			$subject = 'Заказ №'.$id.' собран и ожидает оплаты. Альпина Паблишер.';
			$notification = 'Ваш заказ №'.$id.' уже готов. Как только вы оплатите его, мы передадим его вам тем способом доставки, который вы выбрали.<br />
			Спасибо, что читаете наши книги! <br /><br />
			Вот, кстати, несколько новинок, которые тоже должны вам понравиться:';
			$result = sendNotificationEmail($id, $subject, $notification, $userID1, $newItemsBlock);
			$finalReport .= "<tr>
				<td>".$id."</td>
				<td>Неоплаченные заказа</td>
				<td>Новый, обработан</td>
				<td>".$userID1."</td>
				<td>Новый, обработан</td>
				<td></td>
				<td></td>
				<td>Прошло пять дней</td>
				</tr>";	
		} elseif (
			(time() - strtotime($arSales[DATE_STATUS]))/86400 >= 10 &&	// Если прошло больше 10 дней
			$arSales["EMP_STATUS_ID"] != $userID2)						// и еще не отправляли второе уведомление
			{
			$subject = 'Заказ '.$id.' собран и ожидает оплаты. Альпина Паблишер.';
			$notification = 'Ваш заказ №'.$id.' уже готов. Как только вы оплатите его, мы передадим его вам тем способом доставки, который вы выбрали.<br />
			Спасибо, что читаете наши книги! <br /><br />
			Вот, кстати, несколько новинок, которые тоже должны вам понравиться:';
			$result = sendNotificationEmail($id, $subject, $notification, $userID2, $newItemsBlock);
			$finalReport .= "<tr>
				<td>".$id."</td>
				<td>Неоплаченные заказа</td>
				<td>Новый, обработан</td>
				<td>".$userID1."</td>
				<td>Новый, обработан</td>
				<td></td>
				<td></td>
				<td>Прошло десять дней</td>
				</tr>";	
		}
	}
	echo "7<br />";
	$finalReport .= "</tbody></table>";
	print $finalReport;
	
	$arEventFields = array(
		"ORDER_USER" => "Александр",
		"REPORT" => $finalReport
	);				
	CEvent::Send("SEND_TRIGGER_REPORT", "s1", $arEventFields,"N");	
} else {
	echo "Not authorized";
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>