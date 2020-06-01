<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->ShowAjaxHead();
$APPLICATION->RestartBuffer();
$APPLICATION->ShowHeadScripts();
$APPLICATION->ShowCSS();
$APPLICATION->IncludeComponent("nirvana:articles", ".default", array("ARTICLES" => $_POST['iblock']), false);