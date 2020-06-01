<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "каталог услуги онайн консультация адвоката юриста России РФ");
$APPLICATION->SetPageProperty("keywords_inner", "каталог услуги онайн консультация адвоката юриста России РФ");
$APPLICATION->SetPageProperty("keywords", "каталог услуги онайн консультация адвоката юриста России РФ");
$APPLICATION->SetTitle("Юристы и адвокаты");

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

//$APPLICATION->SetPageProperty("title", $nomberstr."Юристы и адвокаты Российского Юридического портала - консультация ju24pro.ru");
//$APPLICATION->SetPageProperty("description", $nomberstr."Онлайн консультация юристов и адвокатов, оказывающие профессиональные услуги в России");

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
		"PATH" => "/advokaty/list_advokaty.php"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>