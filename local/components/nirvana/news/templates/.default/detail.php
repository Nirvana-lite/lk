<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arr = end(explode('-',$arResult['VARIABLES']['ELEMENT_ID']));
$APPLICATION->IncludeComponent(
    "nirvana:news.detail",
    "",
    Array("IBLOCK_ID" => 15,"ID"=> $arr)
);
?>