<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
?>

<?if ($_REQUEST["forgot_password"] || $_REQUEST["change_password"]) {?>
    <div class="historyCoverWrap">
        <div class="centerWrapper">
            <p>Главная</p>
            <h1>Восстановление пароля</h1>
        </div>
    </div>
    <div class="lostPassWrapper">
        <?
            $APPLICATION->IncludeComponent("bitrix:main.profile", "eshop", Array(
                "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
                ),
                false
            );
        ?>
    </div>
<?} else {?>
    <div class="historyCoverWrap">
        <div class="centerWrapper">
            <p>Главная</p>
            <h1>Регистрация</h1>
        </div>
    </div>

    <div class="signinWrapper">
        <div class="centredWrapper">
            <?if (!$USER->IsAuthorized()) {?>
                <div>
                    <div class="registrationLink <? if (!$_REQUEST["login"]) {?>active<?}?>">Регистрация</div>
                    <div class="signinLink <? if ($_REQUEST["login"]) {?>active<?}?>">Вход на сайт</div>
                </div>



                <div class="signinBlock">
                    <??>
                    <?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "flat", Array(
                        "REGISTER_URL" => "",
                        "PROFILE_URL" => "",
                        "SHOW_ERRORS" => "Y"
                        ),
                        false
                    );?>
                </div>

                <div class="registrationBlock">
                    <?if($_SERVER["HTTP_X_REAL_IP"] == "91.201.253.5") {?>
                        <?$APPLICATION->IncludeComponent("bitrix:system.auth.registration", "flat", Array(

                            ),
                            false
                        );?>
                    <?} else {?>
                        <?if($_GET["register"] != 'yes'){?>
                            <?$APPLICATION->IncludeComponent("bitrix:system.auth.registration", "flat", Array(

                                ),
                                false
                            );?>
                        <?} else {
                            echo '<p style="text-align: center">Вы успешно зарегестрированы!</p>';
                        }?>
                    <?}?>
                </div>
            <?} else {?>
                <div class="reg_text">

                    <p>Спасибо за регистрацию! Теперь Вам будут доступны накопительные скидки и бонусы</p>

                    <br>

                    <p><a href="<?= SITE_DIR ?>">Вернуться на главную страницу</a></p>

                </div>
            <?}?>
        </div>
    </div>
<?}?>
<script>
    $(document).ready(function(){
        $("body").addClass("changePassWr");
    })
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
