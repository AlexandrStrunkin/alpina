<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("sale"); CModule::IncludeModule("catalog"); CModule::IncludeModule("iblock");
use Mailgun\Mailgun;
if ($_POST['email']) {
	$email = $_POST['email'];
	$book = $_POST['book'];

	$book = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 4, "ID" => $_POST['book']), false, false, array("ID", "NAME", "DETAIL_PICTURE")) -> Fetch();
	$link = CIBlockElement::GetProperty(4, $_POST['book'], array("sort" => "asc"), Array("CODE"=>"glava"))->Fetch();
	$link = "https://www.alpinabook.ru".CFile::GetPath($link['VALUE']);
	$text = CFile::ResizeImageGet($book["DETAIL_PICTURE"], array("width" => 200, "height" => 270), BX_RESIZE_IMAGE_PROPORTIONAL, true);

	if (strpos($link,"selcdn.ru") !== false) {
		$text = "<a href='https://www.alpinabook.ru/catalog/temporary/".$_POST['book']."/' target='_blank'><img src='https://www.alpinabook.ru".$text[src]."' align='left' style='margin-right:20px;' /></a>
			Скачать главу из книги <a href='https://www.alpinabook.ru/catalog/temporary/".$_POST['book']."/' target='_blank'>«".$book['NAME']."»</a> можно по ссылке ниже. Приятного чтения!<br /><br /><br />
			<center><a href='".$link."' style='padding: 14px 58px; color:#fff; background: #00abb8; border-radius: 35px;font-size:20px;text-decoration:none;' target='_blank'>Скачать главу</a></center>";
	} else {
		$text = "<a href='https://www.alpinabook.ru/catalog/temporary/".$_POST['book']."/' target='_blank'><img src='https://www.alpinabook.ru".$text[src]."' align='left' style='margin-right:20px;' /></a>
			Скачать главу из книги <a href='https://www.alpinabook.ru/catalog/temporary/".$_POST['book']."/' target='_blank'>«".$book['NAME']."»</a> можно по ссылке ниже. Приятного чтения!<br /><br /><br />
			<center><a href='".$link."' style='padding: 14px 58px; color:#fff; background: #00abb8; border-radius: 35px;font-size:20px;text-decoration:none;' target='_blank'>Скачать главу</a></center>";
	}
	$images = array();
	$images[] = $text[src];

	$recs = json_decode(file_get_contents('http://api.retailrocket.ru/api/1.0/Recomendation/UpSellItemToItems/50b90f71b994b319dc5fd855/'.$_POST['book']));
	array_splice($recs, 3);

	if (!empty($recs[0])) {
		$text .= "<br /><br /><table width='100%'><tbody><tr><td colspan='3' style='padding:20px 0 10px;font-size:24px;text-align:center;'>Рекомендуем обратить внимание</td></tr><tr>";
		foreach ($recs as $rec) {
			$recbook = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 4, "ID" => $rec), false, false, array("ID", "NAME", "DETAIL_PICTURE")) -> Fetch();
			$recpic = CFile::ResizeImageGet($recbook["DETAIL_PICTURE"], array("width" => 140, "height" => 200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$text .= "<td width='140'>";
			$text .= "<a href='https://www.alpinabook.ru/catalog/temporary/".$recbook['ID']."/' target='_blank'><img src='https://www.alpinabook.ru".$recpic[src]."' align='left' style='margin-right:20px;' alt='".$recbook['NAME']."' title='".$recbook['NAME']."' /></a>";
			$text .= "</td>";
			$images[] = $recpic[src];
		}
		$text .= "</tr></tbody></table>";
	}


	$mailFields = array(
		"EMAIL"=> $email,
		"BOOK" => $book['NAME'],
		"TEXT" => $text
	);
	//CEvent::Send("SEND_CHAPTER", "s1", $mailFields, "N");
	echo 'ok';




	# Instantiate the client.
	$mgClient = new Mailgun('key-927b58790205fbbfa9f962efd183f0f3');
	$domain = "alpinabook.ru";

	# Make the call to the client.
	$result = $mgClient->sendMessage($domain, array(
		'from'    => 'Альпина Паблишер (Alpina.ru) <shop@alpinabook.ru>',
		'to'      => $_POST['email'],
		//'cc'      => 'baz@example.com',
		'bcc'     => 'noreply@alpinabook.ru',
		'subject' => 'Глава из книги «'.$book['NAME'].'»',
		'text'    => 'Testing some Mailgun awesomness!',
		'html'    => '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Глава из книги #BOOK#</title>
</head>
<body leftmargin="0" marginheight="0" marginwidth="0" offset="0" style="cursor: auto; height: 100% ! important; margin: 0px; padding: 0px; width: 100% ! important; background: #F4F4F4; font-family: &quot;Open Sans&quot;,&quot;Segoe UI&quot;,Roboto,Tahoma,sans-serif;" topmargin="0">
<center>
<table border="0" cellpadding="40" cellspacing="0" style="margin-top:40px;background-color: #FFFFFF;border: 1px solid #ccc; padding-bottom:30px;" width="600">
	<tbody><!-- HEADER -->
		<tr>
			<td align="left" style="padding-top:15px;" valign="top"><span style="color:#fff; font-size:6px;">Здравствуйте!</span>
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tbody>
					<tr>
						<td align="right" width="370"><a href="http://www.alpinabook.ru/" target="_blank"><img align="right" alt="Логотип интернет-магазина Альпина Паблишер" src="http://www.alpinabook.ru/images/unisenderimages/mailing20/iabook.png" style="width: 180px; margin: 0px; border: 0px none; line-height: 100%; outline: medium none; text-decoration: none; float: right; height: 52px;" /></a></td>
						<td align="right">

						</td>
					</tr>
					<tr>
						<td align="center" colspan="2" style="padding-top:20px;color:#202020;font-family:\'Open Sans\',\'Segoe UI\',Roboto,Tahoma,sans-serif;font-size:20px;font-style:normal;font-weight:400;line-height:100%;letter-spacing:normal;margin-bottom:10px;margin-left:0;text-align:center;margin-top:0;margin-right:0;border-style: solid;
		border-color: #808080;
		-moz-border-top-colors: none;
		-moz-border-right-colors: none;
		-moz-border-bottom-colors: none;
		-moz-border-left-colors: none;
		border-image: none;
		border-width: 0px 0px 1px 0px;padding-bottom:10px">
						<h1 style="color:#202020;font-family:\'Open Sans\',\'Segoe UI\',Roboto,Tahoma,sans-serif;font-size:20px;font-style:normal;font-weight:400;line-height:100%;letter-spacing:normal;">Интернет-магазин «Альпина Паблишер»</h1>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2" style="color: #202020;font-family: \'Open Sans\',\'Segoe UI\',\'Times New Roman\',Roboto,Tahoma,sans-serif;font-size: 20px;font-weight: 400;line-height: 150%;letter-spacing:normal;margin: 0px 0px 10px;padding-top:40px;"><span><b>Здравствуйте!</b></span></td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<!-- //HEADER --><!-- Информация о заказе -->
		<tr>
			<td align="center" style="padding-top:0px; padding-bottom:0;color: #393939;font-family: \'Open Sans\',\'Segoe UI\',Roboto,Tahoma,sans-serif;font-size: 16px;line-height: 160%;text-align: left;padding:0;background:#FCFFD4;" valign="top">

			<table align="center" style="width:100%;">
				<tbody>
					<tr>
						<td style="border-collapse: collapse;padding:10px 40px 20px 40px;" width="400">
						<table align="left" width="100%">
							<tbody>
								<!-- Сообщение -->
								<tr>
									<td align="left" style="border-collapse: collapse;color:#393939;font-family: \'Open Sans\',\'Segoe UI\',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 160%;font-style: normal;letter-spacing: normal;padding-top:10px;" width="100" valign="top">
										'.$text.'
									</td>
								</tr>

							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<!-- //Информация о заказе -->

		<!-- Контакты имага -->
		<tr>
			<td align="center" style="color: #393939;font-family: \'Open Sans\',\'Segoe UI\',Roboto,Tahoma,sans-serif;font-size: 16px;line-height: 160%;text-align: left;padding:10px 0; background:#e3e3e3" valign="top">

			<table align="center" style="width:100%;">
				<tbody>
					<tr>
						<td style="border-collapse: collapse;padding:10px 40px 20px 40px;">
						<table align="left" width="100%">
							<tbody>
								<!-- Коллектив имага -->
								<tr>
									<td align="left" style="border-collapse: collapse;color:#393939;font-family: \'Open Sans\',\'Segoe UI\',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 160%;font-style: normal;letter-spacing: normal;padding-top:10px;" width="100" valign="top">
										 Если у Вас есть вопросы, звоните по&nbsp;телефону&nbsp;<a href="tel:+74959808077">+7&nbsp;(495)&nbsp;980-80-77</a> или отправьте свой вопрос на&nbsp;адрес <a href="mailto:shop@alpina.ru">shop@alpina.ru</a>.
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<!-- //Контакты имага -->


		<!-- Подпись -->
		<tr>
			<td align="center" style="padding-top:0px; padding-bottom:0;color: #393939;font-family: \'Open Sans\',\'Segoe UI\',Roboto,Tahoma,sans-serif;font-size: 16px;line-height: 160%;text-align: left;padding:0;" valign="top">

			<table align="center" style="width:100%;">
				<tbody>
					<tr>
						<td style="border-collapse: collapse;padding:10px 40px 20px 40px;">
						<table align="left" width="100%">
							<tbody>
								<tr>
									<td align="right" style="border-collapse: collapse;color:#393939;font-family: \'Open Sans\',\'Segoe UI\',Roboto,Tahoma,sans-serif;font-size: 16px;font-weight: 400;line-height: 160%;font-style: normal;letter-spacing: normal;padding-top:10px;" width="100" valign="top">
									С уважением,
									<br />
									коллектив интернет-магазина «Альпина Паблишер»
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<!-- //Подпись -->


	</tbody>
</table>

<table border="0" cellpadding="0" cellspacing="0" id="templateFooter" width="600">
	<tbody>
		<tr>
			<td align="center" valign="top">
			<table border="0" cellpadding="30" cellspacing="0" width="100%">
				<tbody>
					<tr>
						<td class="footerContent" style="font-size:14px;" valign="top">Вы получили это письмо, так как оформили заказ в интернет-магазине <a href="http://www.alpinabook.ru/">«Альпина Паблишер»</a>.<br />
ООО «Альпина Паблишер», ИНН 7705396957, ОГРН 1027739552136<br /><br />

Юридический адрес: 115035, г. Москва, Набережная Космодамианская, д. 4/22, корпус Б, пом. IX, комната 1 </td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>
</center>
</body>
</html>'
	), array(
    'inline' => $images
));

	function subscribeTest($id, $mail, $name) {
		$arSelect = Array("ID");
		$name = 'Глава из книги '.$name;
		$arFilter = Array("IBLOCK_ID" => 41,"ACTIVE" => "Y","NAME" => $name, "PROPERTY_SUB_EMAIL" => $mail);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 9999), $arSelect);

		if($ob = $res -> GetNextElement()) {
		} else {
			$el = new CIBlockElement;
			global $USER;
			$PROP = array();
			$PROP[385] = '1';  // --- book id
			$PROP[386] = $mail; // --- subscriber E-mail
			$PROP[387] = $name;  // --- subscription description
			$PROP[388] = "3"; // --- subscription id

			$arLoadProductArray = Array(
			  "MODIFIED_BY"    => $USER->GetID(),
			  "IBLOCK_SECTION_ID" => false,
			  "IBLOCK_ID"      => 41,
			  "PROPERTY_VALUES"=> $PROP,
			  "NAME"           => $name,
			  "ACTIVE"         => "Y",
			  );

			$el->Add($arLoadProductArray);
		}
	}

	subscribeTest($_POST['book'],$_POST['email'], $book['NAME']);

	/*function chapterRfm($id, $mail) {
		$arSelect = array(
			"ID",
			"NAME"
		);

		$filter = array(
			"IBLOCK_ID" => 67,
			"ACTIVE" => "Y",
			"NAME" => $mail
		);

		$res = CIBlockElement::GetList(Array("PROPERTY_LASTORDER" => "DESC"), $filter, false, array(), $arSelect);

		if ($ob = $res -> GetNextElement()) {
			$ob = $ob->GetFields();
			$res1 = CIBlockElement::GetByID($ob[ID]);
			$obRes1 = $res1->GetNextElement();
			$ar_res1 = $obRes1->GetProperties();

			if (!empty($ar_res1[WISHBOOKS][VALUE])) {
				array_push($ar_res1[WISHBOOKS][VALUE], $id);
				CIBlockElement::SetPropertyValuesEx($ob[ID], 67, array('WISHBOOKS' => $ar_res1[WISHBOOKS][VALUE]));
			} else {
				CIBlockElement::SetPropertyValuesEx($ob[ID], 67, array('WISHBOOKS' => $id));
			}
		} else {
			$el = new CIBlockElement;
			$PROP = array();
			$PROP[800] = 'sendchapter';
			$PROP[802] = $id;

			$arLoadProductArray = Array(
				"MODIFIED_BY"    => 15,
				"IBLOCK_SECTION" => false,
				"IBLOCK_ID"      => 67,
				"PROPERTY_VALUES"=> $PROP,
				"NAME"           => $mail,
				"ACTIVE"         => "Y"
			);

			if ($el->Add($arLoadProductArray))
				echo 1;
			else
				echo 2;
		}
	}

	chapterRfm($_POST['book'],$_POST['email']);*/

} else {
	$email = 'a.marchenkov@alpinabook.ru';
	$book = 7706;

	$book = CIBlockElement::GetList (array(), array("IBLOCK_ID" => 4, "ID" => $book), false, false, array("ID", "NAME", "DETAIL_PICTURE")) -> Fetch();
	$link = CIBlockElement::GetProperty(4, $book, array("sort" => "asc"), Array("CODE"=>"glava"))->Fetch();
	$link = CFile::GetPath($link['VALUE']);

	$text = CFile::ResizeImageGet($book["DETAIL_PICTURE"], array("width" => 200, "height" => 270), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	print_r($text);
	$text = "<img src='".explode("/", $text[src])[6]."' align='left' style='margin-right:20px;' />";
	echo $text;
}
?>