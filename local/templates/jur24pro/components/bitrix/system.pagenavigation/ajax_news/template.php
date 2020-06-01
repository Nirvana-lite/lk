<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->createFrame()->begin("Загрузка навигации");
?>

<?if($arResult["NavPageCount"] > 1):?>
<div class="col-xs-12 paginationnews">
    <?if ($arResult["NavPageNomer"]+1 <= $arResult["nEndPage"]):?>
        <?
        $plus = $arResult["NavPageNomer"]+1;
        $url = $arResult["sUrlPathParams"] . "PAGEN_1=" . (intval($plus))
        ?>

        <div class="load_more" data-url="<?=$url?>">
            Показать еще статьи
        </div>

    <?else:?>

        <div class="load_more">
            Загружено все
        </div>

    <?endif?>
</div>
<?endif?>