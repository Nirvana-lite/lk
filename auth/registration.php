<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
?>
<h1>Регистрации</h1>
<div class="mobile-pages block-shadow">
    <div class="mob-main-registration col-xs-12 col-sm-10 col-md-8">
        <div>
            <? $APPLICATION->IncludeComponent(
                "mycomponents:main.register",
                "",
                Array(
                    "USE_BACKURL" => "Y",
                    "REQUIRED_FIELDS" => array("NAME", "PASSWORD", "CONFIRM_PASSWORD", "EMAIL"),
                    "SHOW_FIELDS" => array("NAME", "LAST_NAME", "WORK_COMPANY", "UF_REGION", "PASSWORD", "CONFIRM_PASSWORD", "EMAIL"),
                    "USER_PROPERTY" => array(0 => "UF_REGION"),
                    "SUCCESS_PAGE" => '/auth/'
                ),
                false
            ); ?>
        </div>
    </div>
    <div class="dop-btn-auth col-xs-12 col-sm-10 col-md-8">
        <a class="form-control btn-auth" href="/auth/">Авторизация</a>
        <a class="form-control btn-forget" href="/auth/forget.php">Восстановить пароль</a>
    </div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
