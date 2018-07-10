<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("subscribe");
global $APPLICATION;

if ($_REQUEST["email"]) {

    $subs_list = CSubscription::GetList(array(), array("EMAIL"=>$_REQUEST["email"]), false)->Fetch();
    if (!$subs_list) {
        
        // Ваш ключ доступа к API (из Личного Кабинета Юнисендер)
        $api_key = KEY_UNISENDER;

        // Данные о новом подписчике
        $user_email = $_REQUEST["email"];
        $user_name = iconv('cp1251', 'utf-8', $_REQUEST["email"]);
        $user_lists = "9435203";
        $user_tag = urlencode(iconv('cp1251', 'utf-8', "подписка_на_рассылку"));

        // Создаём POST-запрос
        $POST = array (
          'api_key' => $api_key,
          'list_ids' => $user_lists,
          'fields[email]' => $user_email,
          'fields[Name]' => $user_name,
          'tags' => $user_tag,
          'double_optin' => 3
        );

        // Устанавливаем соединение
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_URL, 
                    'https://api.unisender.com/ru/api/subscribe?format=json');
        $result = curl_exec($ch);

        if ($result) {
          // Раскодируем ответ API-сервера
          $jsonObj = json_decode($result);
        } 

        $subscr = new CSubscription;
        
        $subFields = array(
            "EMAIL" => $_REQUEST["email"],
            "USER_ID" => ($USER->IsAuthorized()? $USER->GetID():false),
            "ACTIVE" => "Y",
            "RUB_ID" => array("1"),
            "CONFIRMED" => "Y"
        );

        if ($subscr->Add($subFields)) {
            $str = "Спасибо, что решили читать нас! Мы уже отправили вам письмо с подарком";
        }
    } else {
        $str = "Похоже, вы уже подписаны на нашу рассылку. Спасибо, что читаете нас!";
    }
    setcookie("subscribePopup","ok",time()+31536000,'/');
    $APPLICATION->set_cookie("subscribePopup","ok",time()+31536000,"/");
    echo $str;
} elseif ($_REQUEST["close"]) {
    setcookie("subscribePopup", "close",time()+7776000,'/');
    $APPLICATION->set_cookie("subscribePopup","close",time()+7776000,"/");
    echo 'close';
}
?>