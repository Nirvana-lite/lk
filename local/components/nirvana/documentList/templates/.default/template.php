<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->SetPageProperty("title", $arResult['meta']['title']);
$APPLICATION->SetPageProperty("keywords", $arResult['meta']['keywords']);
$APPLICATION->SetPageProperty("description",$arResult['meta']['description']);
$APPLICATION->SetTitle($arResult['meta']['title']);
$APPLICATION->SetPageProperty("canonical", $arResult['meta']['canonical']);
$APPLICATION->SetPageProperty("robots", 'all');
?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<h1 class="main-title"><?=$arResult['sectionName']?></h1>
<div class="filter__city block-shadow">
    <p>Выбрать раздел</p>
<select id="section_select" onchange="changeSelect(this)">
    <?foreach ($arResult['sections'] as $section):?>
        <option <?=($section['code'] === "{$arResult['selectedOption']}")?'selected':''?> value="<?=$section['code']?>"><?=$section['name']?></option>
    <?endforeach;?>
</select>
</div>
<div class="lists">
<?foreach ($arResult['items'] as $arItem):?>
    <article itemscope="" itemtype="https://schema.org/Article" class="elem item">
        <i class="fa fa-eye" aria-hidden="true"> <?=$arItem['view']?></i>
        <div class="text"><?=$arItem['name']?></div>
        <a class="pull-right" target="_blank" href="<?=$arItem['url']?>">подробнее</a>
    </article>
<?endforeach;?>
    <div class="clearfix"></div>
</div>
<?php
echo $arResult['pagination'];
?>


