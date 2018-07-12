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
    <script type="text/javascript" src="<?=$jsonObj["theme_files"][1]["url"]?>" async></script>
    <script type="text/javascript" src="<?=$jsonObj["content_editor_files"][1]["url"]?>" async></script>
    <link rel="stylesheet" href="<?=$jsonObj["theme_files"][0]["url"]?>">
    <link rel="stylesheet" href="<?=$jsonObj["content_editor_files"][0]["url"]?>">
    <script>
         $(document).ready(function () {
           //преобразуем данные формы в строку, но нам же нужен формат JSON
           //var data = $('form').serialize();
                                                           
           //превращаем объект в строку формата JSON
           var strInForm = JSON.stringify({
              "public_token": "vsGI2nrHVEguEh_42iKPx_UsW8eQZm1h",
            });
               $.ajax({
                   url: "https://ceditor.setka.io/path/to/alpinabook.min.json",
                   type: "GET",
                   data: strInForm,
                   contentType: 'application/json; charset=utf-8',
                   dataType: 'json',
                   success: function (data) {
                        //превращаем строку формата JSON в массив
                        var ara = JSON.parse(data);
                        //обращаемся к массиву по индексу
                        console.log(data);
                        $('.stk-editor').text(ara[0]);
                   },
                   error: function() {
                    $('.stk-editor').text('Error!');
                   }
               });
         });    
    </script>
  </head>
  <body>
    <!-- 4. Размещаем на странице контейнер для редактора -->
    <div class="stk-editor" id="setka-editor"></div>
   </body>
</html>


 
