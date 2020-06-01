<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->IncludeComponent(
    "nirvana:documentList",
    ".default",
    Array('IBLOCK_ID'=> 19,'SECTION_CODE'=>$arResult['VARIABLES']['SECTION_CODE']),
    false
);
