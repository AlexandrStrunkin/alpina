<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");

CModule::IncludeModule("subscribe");
//активные и подтвержденные адреса, подписанные на рубрики
$subscr = CSubscription::GetList(
    array("ID"=>"ASC"),
    array("ACTIVE"=>"Y")
);
while(($subscr_arr = $subscr->Fetch())){
    
// Ваш ключ доступа к API (из Личного Кабинета)
        $api_key = "6fiazmsxjge4rbwe4i3ws9bssitdhnhoo3hff5ca";

        // Данные о новом подписчике
        $user_email = $subscr_arr["EMAIL"];
        $user_name = iconv('cp1251', 'utf-8', $subscr_arr["EMAIL"]);
  //      $user_lists = "9435203";
        $user_tag = urlencode("подписка_на_рассылку");

        // Создаём POST-запрос
        $POST = array (
          'api_key' => $api_key,
          'list_ids' => $user_lists,
          'fields[email]' => $user_email,
          'fields[Name]' => $user_name,
          'tags' => $user_tag
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
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>