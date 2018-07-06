<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

    <script>
 $(document).ready(function () {
   //преобразуем данные формы в строку, но нам же нужен формат JSON
   //var data = $('form').serialize();
   
   //превращаем объект в строку формата JSON
   var strInForm = JSON.stringify({
      "public_token": "zda0qJTle6p4h3iB80VSFrUNrWkX6LDa",
      "plugins": [
        {
          "url": "http://setka-editor.s3.amazonaws.com/clients/js_plugins/public.js",
          "filetype": "js",
          "md5": "d41d8cd98f00b204e9800998ecf8427e"
        }
      ],
      "theme_files": [
        {
          "id": 1133,
          "url": "https://ceditor.setka.io/clients/rtzy9E244k_SGaIKMrAQ1UfHUvTSiNwa/css/25_demo301_1_15.min.css",
          "filetype": "css",
          "md5": "6226f7cbe59e99a90b5cef6f94f966fd"
        },
        {
          "id": 1135,
          "url": "https://ceditor.setka.io/clients/rtzy9E244k_SGaIKMrAQ1UfHUvTSiNwa/json/25_demo301_1_15.json",
          "filetype": "json",
          "md5": "d41d8cd98f00b204e9800998ecf8427e"
        }
      ],
      "content_editor_files": [
        {
          "id": 197,
          "url": "https://ceditor.setka.io/clients/rtzy9E244k_SGaIKMrAQ1UfHUvTSiNwa/content_editors/1.0.4/editor.v1.0.4.1475586310.min.css",
          "filetype": "css",
          "md5": "5d154e6b531eea773d2e7132240f66aa"
        },
        {
          "id": 199,
          "url": "https://ceditor.setka.io/clients/rtzy9E244k_SGaIKMrAQ1UfHUvTSiNwa/content_editors/1.0.4/editor.v1.0.4.1475586310.min.js",
          "filetype": "js",
          "md5": "7981950bca8d412a9c26a85213c2f357"
        }
      ]
    });
       $.ajax({
           url: "https://editor.setka.io/api/v1/custom/builds/current",
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

    <!-- 4. Размещаем на странице контейнер для редактора -->
    <div class="stk-editor" id="setka-editor"></div>

