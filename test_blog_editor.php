<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
            // Ваш ключ доступа к API (из Личного Кабинета Юнисендер)
        $api_key = 'zda0qJTle6p4h3iB80VSFrUNrWkX6LDa';
        
        // Создаём POST-запрос
        $POST = array (
          'token' => $api_key,
        );

        // Устанавливаем соединение
          if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'https://editor.setka.io/api/v1/custom/builds/current?token='.$api_key);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $result = curl_exec($curl);
          }

        if ($result) {
          // Раскодируем ответ API-сервера
          $jsonObj = object_in_array(json_decode($result));
        }         
?>
<!DOCTYPE html>
<html>
  <head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <!-- 1. Подключаем основной файл редактора -->
    <script type="text/javascript" src="<?=$jsonObj["plugins"][0]["url"]?>" async></script>
    
    <!-- 2. Подключаем стили интерфейса редактора -->
    <script type="text/javascript" src="<?//=$jsonObj["theme_files"][1]["url"]?>" async></script>
    <script type="text/javascript" src="<?=$jsonObj["content_editor_files"][1]["url"]?>" async></script>
    <link rel="stylesheet" href="<?=$jsonObj["theme_files"][0]["url"]?>">
    <link rel="stylesheet" href="<?=$jsonObj["content_editor_files"][0]["url"]?>">
    <script>
         $(document).ready(function () {


            fetch('https://www.alpinabook.ru/js/setka/setka.json').then(response => response.json()).then(response => {

                const config = response.config;
                const assets = response.assets;
                config.headerTopOffset = 20;    // ерхний отступ для верхней панели редактора.
                config.footerBottomOffset = 20; // нижний отступ для нижней панели редактора.

            // Передаем публичный токен (public_token) компании
            // (он нужен для отправки запросов из редактора в API editor.setka.io)
            config.public_token = 'zda0qJTle6p4h3iB80VSFrUNrWkX6LDa';
            config.token = 'zda0qJTle6p4h3iB80VSFrUNrWkX6LDa';

             // Стартуем редактор 
            SetkaEditor.start(config, assets); 
            }) .catch(ex => alert(ex));
         }); 
    </script>
  </head>
  <body>
    <!-- 4. Размещаем на странице контейнер для редактора -->
    <div class="stk-editor" id="setka-editor"></div>
   </body>
</html>


 
