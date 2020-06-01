<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="row">
<?foreach ($arResult as $arItem):?>
    <div class="col-md-12">
        <div class="text"><?=$arItem['text']?></div>
        <a target="_blank" href="<?=$arItem['url']?>">подробнее</a>
    </div>
<?endforeach;?>
</div>