<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("мой кабинет");
$APPLICATION->IncludeComponent("nirvana:registration", ".default", array(), false);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>