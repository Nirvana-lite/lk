<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "реестр услуги зарегистрированных нотариусов россии рф");
$APPLICATION->SetPageProperty("keywords_inner", "реестр услуги зарегистрированных нотариусов россии рф");
$APPLICATION->SetPageProperty("keywords", "реестр услуги зарегистрированных нотариусов россии рф");
$APPLICATION->SetTitle("Реестр нотариусов России");

if (isset($_GET['PAGEN_1']) && intval($_GET['PAGEN_1'])>0) {
$nomberstr = "Страница ".$_GET['PAGEN_1']." ";
} else {
$nomberstr = "";
}

if (isset($_GET['PAGEN_1']) && intval($_GET['PAGEN_1'])<=1) {
$APPLICATION->SetPageProperty("robots", 'none');
} else {
$APPLICATION->SetPageProperty("robots", 'all');
}

?>

<?
$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => "",
		"AREA_FILE_RECURSIVE" => "Y",
		"PATH" => "/notariusy/list_notariusy.php"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>