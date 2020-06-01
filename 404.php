<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("410 Gone");
//CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Ошибка 404");
?>
    <section class="error-page">
        <div class="error-404"></div>
        <div class="error-text">к сожалению,<br>запрашиваемая страница<br>не найдена</div>
        <div class="error-action">
            <a href="/">Перейти на главную</a>
            <span>или</span>

        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>