<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

    <script>
 $(document).ready(function () {
   //преобразуем данные формы в строку, но нам же нужен формат JSON
   //var data = $('form').serialize();
   
   //превращаем объект в строку формата JSON
   var strInForm = JSON.stringify({
      "public_token": "vsGI2nrHVEguEh_42iKPx_UsW8eQZm1h",
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

