<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
?>
<h1 class="main-title">Авторизация и подтверждение регистрации</h1>
    <div class="mobile-pages block-shadow">

        <? if(
                ($_GET['confirm_registration'] == 'yes') &&
                (!empty($_GET['confirm_user_id'])) &&
                (!empty($_GET['confirm_code']))
            ) {
            ?>
        <div class="mob-success-registration">
            <? $APPLICATION->IncludeComponent(
                "bitrix:system.auth.confirmation",
                "",
                Array()
            ); ?>
        </div>
<? } else {?>

        <div class="mob-auth-form col-xs-12 col-sm-10 col-md-8">
            <? $APPLICATION->IncludeComponent(
                "mycomponents:system.auth.form",
                "",
                Array(
                    "FORGOT_PASSWORD_URL" => "/auth/forget.php",
                    "PROFILE_URL" => "/profile/",
                    "REGISTER_URL" => "/auth/registration.php",
                    "SHOW_ERRORS" => "Y",
                    "FORM_NAME" => "two"
                )
            ); ?>
        </div>
            <div class="dop-btn-auth col-xs-12 col-sm-10 col-md-8">
                <a class="form-control btn-reg" href="/auth/registration.php">Регистрация</a>
                <a class="form-control btn-forget" href="/auth/forget.php">Восстановить пароль</a>
            </div>
    <? } ?>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>