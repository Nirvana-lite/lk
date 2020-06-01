<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Реклама");

$APPLICATION->IncludeComponent(
    "nirvana:advertising",
    "user",
    Array()
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>