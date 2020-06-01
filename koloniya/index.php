<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"); ?>
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
        "PATH" => "/koloniya/list_kolonii.php"
    ),
    false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
