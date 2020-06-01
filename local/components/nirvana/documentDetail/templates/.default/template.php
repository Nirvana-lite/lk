<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->SetPageProperty("title", $arResult['meta']['ELEMENT_META_TITLE'] ." | {$arResult['section']}");
$APPLICATION->SetPageProperty("keywords", $arResult['meta']['ELEMENT_META_KEYWORDS']);
$APPLICATION->SetPageProperty("description",$arResult['meta']['ELEMENT_META_DESCRIPTION']);
$APPLICATION->SetTitle($arResult['meta']['ELEMENT_META_TITLE']." | {$arResult['section']}");
$APPLICATION->SetPageProperty("canonical", "https://jur24pro.ru/obraztsy-dokumentov/{$arResult['canonical']}/{$arResult['code']}/");
$APPLICATION->SetPageProperty("robots", 'all');
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="main-title"><?=$arResult['name']?></h1>
        <div class="detail"><?=$arResult['text']?></div>
    </div>
</div>