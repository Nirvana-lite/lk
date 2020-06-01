<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<<?=$arParams['IBLOCK_NAME']?>></<?=$arParams['IBLOCK_NAME']?>>
<script>
    Vue.component('<?=$arParams['IBLOCK_NAME']?>', {
        data: function () {
            return {
                items: <?=json_encode($arResult)?>,
            }
        },
        template: `<div class="articles">
    <div class="article" v-for="item in items">
        <a target="_blank" :href="item.url"><h6 v-html="item.name"></h6></a>
        <a target="_blank" :href="item.url" v-if="!item.viewImg" class="detail_link">Подробнее</a>
        <img :src="item.picture" v-if="item.viewImg">
    </div>
</div>`
    })
</script>
