<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Образцы документов");
?>
<?php
$APPLICATION->IncludeComponent(
    "nirvana:documents",
    ".default",
    Array(
        "IBLOCK_ID" => "",
        "SEF_FOLDER" => "/obraztsy-dokumentov/",
        "SEF_MODE" => "Y",
        "SEF_URL_TEMPLATES" => Array("detail"=>"#SECTION_CODE#/#ELEMENT_CODE#/","news"=>"","list"=> "#SECTION_CODE#/")
    )
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>