<?
//define ("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Восстановить пароль");
?>
    <h1 class="main-title">Восстановить пароль</h1>
    <div class="mobile-pages block-shadow">
        <div class="mob-main-forget col-xs-12 col-sm-10 col-md-8">
            <div>
                <? $APPLICATION->IncludeComponent(
                    "nirvana:system.auth.forgotpasswd",
                    "",
                    Array(
                        "FORGOT_PASSWORD_URL" => "/auth/forget.php",
                        "PROFILE_URL" => "/profile/",
                        "REGISTER_URL" => "/auth/registration.php",
                        "SHOW_ERRORS" => "Y",
                        //'AUTH_RESULT' => $APPLICATION->arAuthResult
                    )
                ); ?>
            </div>
        </div>
        <div class="dop-btn-auth col-xs-12 col-sm-10 col-md-8">
            <a class="form-control btn-auth" href="/auth/">Авторизация</a>
            <a class="form-control btn-reg" href="/auth/registration.php">Регистрация</a>
        </div>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>