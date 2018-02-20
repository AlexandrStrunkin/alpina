<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("sale"); CModule::IncludeModule("catalog"); CModule::IncludeModule("iblock");
require '/home/bitrix/vendor/autoload.php';
use Mailgun\Mailgun;
if ($_POST['email']) {
	function subscribeTest($id, $mail) {
		$name = '99 рублей акция';
		
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

		echo 'ok';
	}
	
	function subscribeChildren($mail) {
		$name = 'children';
		
		$el = new CIBlockElement;
		global $USER;
		$PROP = array();
		$PROP[385] = '1';  // --- book id
		$PROP[386] = $mail; // --- subscriber E-mail
		$PROP[387] = 'children';  // --- subscription description
		$PROP[388] = "4"; // --- subscription id		
		
		$arLoadProductArray = Array(
		  "MODIFIED_BY"    => $USER->GetID(), 
		  "IBLOCK_SECTION_ID" => false,         
		  "IBLOCK_ID"      => 41,
		  "PROPERTY_VALUES"=> $PROP,
		  "NAME"           => $name,
		  "ACTIVE"         => "Y",
		  ); 
		  
		$el->Add($arLoadProductArray);

		$arEventFields = array(
			"EMAIL" => $mail,
		);
		
		CEvent::Send("SUBSCRIBE_CONFIRM_CHILDREN", "s1", $arEventFields,"N");
		
		echo "Спасибо, что решили читать нас! Мы уже отправили вам письмо с подарком";
		setcookie("subscribePopupChildren","ok",time()+31536000,'/');
		$APPLICATION->set_cookie("subscribePopupChildren","ok",time()+31536000,"/");
	}
	
	if ($_POST['children'] == 1) {
		subscribeChildren($_POST['email']);
	} else {
		subscribeTest($_POST['book'],$_POST['email']);
	}
} elseif ($_REQUEST["close"]) {
	setcookie("subscribePopupChildren", "close",time()+7776000,'/');
	$APPLICATION->set_cookie("subscribePopupChildren","close",time()+7776000,"/");
	echo 'close';
}
?>