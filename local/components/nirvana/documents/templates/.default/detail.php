<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->IncludeComponent(
    "nirvana:documentDetail",
    ".default",
    Array(
        'IBLOCK_ID'=> 19,
        'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
        'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
        ),
    false
);
?>