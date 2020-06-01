<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->IncludeComponent(
    "d7:list_articles",
    "{$arParams['TEMPLATE_LIST']}",
    Array(
        'IBLOCK_ID'=> intval($arParams['IBLOCK_ID']),
        'COUNT' => intval($arParams['COUNT'])
    ),
    false
);