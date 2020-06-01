<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
?>
<div id="subs">
    <h3>Вы подписаны:</h3>
    <template v-if="Object.keys(subSections).length > 0">
        <div class="card-columns">
            <div class="card" v-for="(section,key) in subSections" :key="key">
                <div class="card-body">
                    <h5 class="card-title">
                        <a target="_blank" :href="section.url">{{section.name}}</a>
                    </h5>
                    <h6 v-if="section.mainName" class="card-subtitle mb-2 text-muted">
                        {{section.mainName}}
                    </h6>
                    <a href="javascript:void(0);" class="card-link" @click="subSection(section, key)">
                        Отписаться
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </template>
    <template v-else>
        <p>Вы пока не подписаны на разделы</p>
    </template>
    <hr>
<h3>Все разделы:</h3>
    <div class="card-columns">
        <div class="card" v-for="(section,key) in allSections" :key="key">
            <div class="card-body">
                <h5 class="card-title">
                    <a target="_blank" :href="section.url">{{section.name}}</a>
                </h5>
                    <h6 v-if="section.mainName" class="card-subtitle mb-2 text-muted">
                        {{section.mainName}}
                    </h6>
                    <a href="javascript:void(0);" class="card-link" @click="subSection(section, key)">
                        Подписаться
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                    </a>
            </div>
        </div>
    </div>
</div>
<script>
   var subsList = new Vue({
        el: '#subs',
        data: function () {
            return {
                allSections: <?=json_encode($arResult['all'],true)?>,
                subSections:<?=json_encode($arResult['sub'],true)?>
            }
        },
        methods: {
            subSection:function (e, itemKey) {
                let str = new FormData();
                str.append('change', true);
                str.append('iblock_id', e.iblock);
                str.append('section_id', e.id);
                axios.post("/local/components/nirvana/subs/postChanges.php", str)
                    .then((response) => {
                        if (response.data.isSub){
                            this.subSections.push(e);
                            subsList.allSections.splice(itemKey, 1);
                        }else{
                            this.allSections.push(e);
                            subsList.subSections.splice(itemKey, 1);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            },
            unsubSection:function (e) {

            }
        }
    })
</script>
