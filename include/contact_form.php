<style>
ul{list-style-type:disc;padding:30px 0 30px 30px}
.stopProp img{max-width:650px;height:auto;display:block;margin:0 auto;padding:20px 0}
.awayLink:hover{background-color:#cab796!important;color:#fff!important}
.addLink:hover{background-color:#c7a271!important;color:#fff!important}
.closeIcon:after{background:url("/img/close.png") left center;width:21px;height:21px;cursor:pointer;display:block;content:"";float:right}
.closeIcon:hover:after{background:url("/img/close.png") right center}
.hideInfo{font-family:'Walshein_light','Helvetica';position:fixed; width:100%; height:100%; top:0; left:0; z-index:999999999998; background:rgba(206,206,206,.62);overflow-y:auto}
.infoPopup{max-width:600px; box-shadow:0 0 1px 0px rgba(0,0,0,.7); top:0; left:50%; margin:3% auto;background:#fff; padding:30px 40px; z-index:999999999999;display:block;color:#2F3839}
.closeIcon{cursor:pointer}
.popupTitle{font-size:28px;clear:both;text-align:center;color:#3f4a4d;padding-bottom:10px}
.options {display:inline-block}
.options div {padding:6px 13px;text-align:center;float:left;margin:9px 19px 0 0}
.options span{color:#00abb8;font-size:18px;border-bottom:1px dashed;cursor:pointer}
.options span:hover{border-bottom:none}
.options .active{background:#00aab8;border-radius:4px}
.options .active span{color:#fff;border-bottom:none}
.textarea {clear:both;margin:30px auto 10px}
.textarea textarea {width:90%;background-color:#fafafa;border:1px solid #00aab8;color:#333;font-size:17px;padding:20px;resize:none;height:100px}
.textarea input[type="email"],.textarea input[type="text"] {width:80%;background-color:#fafafa;border:1px solid #00aab8;color:#333;font-size:17px;padding:6px 20px;margin-top:20px;height:30px}
.textarea p {background-color:#00abb8;border-radius:35px;color:#eee;font-size:19px;padding:14px 19px;width:210px;cursor:pointer;transition:color .3s ease,background-color .3s ease,border-color .3s ease}
.textarea p:hover{color:fff;background-color:#28bcc7}
.feedback {float:right;width:310px;padding:40px;box-shadow:0 5px 5px 0 rgba(0,0,0,.18), 0 10px 7px 0 rgba(0,0,0,.14);background:#fff;margin-bottom:30px}
</style>

<script>
    $(document).ready(function(){
        $(".options div").click(function() {
            $(".options .active").removeClass("active");
            $(this).addClass("active");
        });
    });
    
    function contact() {
        var subject = $(".options .active span").text();
        var text = $(".textarea textarea").val();
        var email = $("input[name='emailContact']").val();
        var phone = $("input[name='emailPhone']").val();
        var name = $("input[name='nameContact']").val();
        
        var stop = false;
        
        if (text == "") {
            $(".textarea textarea").css("border","1px solid red");
            stop = true;
        } else {
            $(".textarea textarea").css("border","1px solid #00aab8");
        }
        
        if (email == "") {
            $("input[name='emailContact']").css("border","1px solid red");
            stop = true;
        } else {
            $("input[name='emailContact']").css("border","1px solid #00aab8");
            var email = $("input[name='emailContact']").val();
            (window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() { rrApi.setEmail(email);    });
        }
        
        if (name == "") {
            $("input[name='nameContact']").css("border","1px solid red");
            stop = true;
        } else {
            $("input[name='nameContact']").css("border","1px solid #00aab8");
        }
        
        if (!stop) {
            $.ajax({
                type: "POST",
                url: "/ajax/contact.php",
                data: {
                    send_contact: "1",
                    email: email,
                    subject: subject,
                    text: text,
                    phone: phone,
                    name: name
                    }
            }).done(function(strResult) {
                if (strResult == 123) {
                    $(".options").html("<p style='color:#00aab8;font-size:24px;text-align:center;padding-top:50px'>Спасибо! Письмо отправлено в правильные руки</p>");
                    $(".textarea").empty();
                }
            });
        }
    }
</script>

<div class="feedback">
    <div class="popupTitle">Обратная связь</div>
    <div class="options">
        <div class="active">
            <span>Вопрос по заказу</span>
        </div>
        <div>
            <span>У вас ошибка на сайте</span>
        </div>
        <div>
            <span>Предлагаю сотрудничество</span>
        </div>
        <div>
            <span>Другое</span>
        </div>
    </div>
    
    <div class="textarea">
        <textarea placeholder="Сообщение *"></textarea>
        <br>
        <center><input type="email" name="emailContact" placeholder="Ваш e-mail *"></center>
        <center><input type="text" name="nameContact" placeholder="Ваше имя *"></center>
        <center><input type="text" name="emailPhone" placeholder="Ваш номер телефона"></center>
        <br>
        <center><p onclick="contact();return false;">Отправить письмо</p></center>
        <br>
        Нажимая на&nbsp;кнопку «Отправить письмо», вы&nbsp;соглашаетесь на&nbsp;обработку персональных данных в&nbsp;соответствии <a href="/content/pii/" target="_blank">с&nbsp;условиями</a>
    </div>
</div>
        