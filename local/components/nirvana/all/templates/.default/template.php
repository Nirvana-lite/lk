<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<div id="alls" class="col-md-8">
    <div v-for="(item,key) in items" :key="key" :class="[item.show ? question : letter, 'blocks' ]" :ref="'elem' + item.id">
        <div class="left_tab">
            <div v-html="item.iblock"></div>
        </div>
        <template v-if="item.show">
            <template v-if="item.open">
                <div class="detail_info">
                    <div class="info">Дата:</div>
                    <div class="date" v-html="item.date"></div>
                    <div class="info">Автор:</div>
                    <div class="name" v-html="item.autor"></div>
                    <div class="info">Город:</div>
                    <div class="city" v-html="item.city"></div>
                    <div class="info" v-if="item.section">Раздел:</div>
                    <div class="city" v-if="item.section" v-html="item.section"></div>
                    <div class="info">Вопрос:</div>
                    <div class="detail" v-html="item.text"></div>
                </div>
            </template>
            <template v-else>
                <div class="prev_info">
                    <div class="left_block">
                        <div class="section" v-if="item.section"><span>Раздел:</span> {{item.section}}</div>
                        <div class="authors"><span>Автор:</span> {{item.autor}}</div>
                        <div class="media-text text-justify" v-html="item.preview"></div>
                        <div class="inf">
                            <div class="city"><span>Город:</span> {{item.city}}</div>
                            <div class="date"><span>Дата:</span> {{item.date}}</div>
                            <div class="" @click="openDetailQuestion(key)">
                                <div class=" pull-right detail_button">Подробнее</div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </template>
        <template v-else>
            <template v-if="item.open">
                    <div class="detail_name" v-html="item.name"></div>
                    <img :src="item.detail.picture">
                    <div class="detail_text" v-html="item.detail.text"></div>
            </template>
            <template v-else>
                <div class="prev_text">
                    <div class="left_block">
                        <img :src="item.picture.src">
                        <div class="date"><span>Дата: </span>{{item.date}}</div>
                    </div>
                    <div class="right_block">
                        <div v-html="item.name"></div>
                        <div v-html="item.preview"></div>
                        <div class="" @click="openDetailLetter(key)">
                            <div class=" pull-right detail_button">Подробнее</div>
                        </div>
                    </div>
                </div>
            </template>
        </template>
    </div>
</div>
<div class="col-md-4">test</div>
<script>
    let alls = new Vue({
        el: '#alls',
        data: function () {
            return {
                items: <?=json_encode($arResult)?>,
                question: 'question',
                letter: 'letter'
            }
        },
        methods: {
            openDetailQuestion: function (itemId) {
                for (let item in this.items) {
                    this.items[item].open = false;
                }
                this.items[itemId].open = !this.items[itemId].open
            },
            openDetailLetter: function (itemId) {
                for (let item in this.items) {
                    this.items[item].open = false;
                }
                let str = new FormData();
                str.append('iblock', this.items[itemId].iblockId);
                str.append('id', this.items[itemId].id);
                axios.post("<?=$this->__component->__path?>/getDetail.php", str)
                    .then((response) => {
                        this.items[itemId].detail = response.data;
                        this.items[itemId].open = true;

                        let slide = this.$refs[`elem${this.items[itemId].id}`];
                        // Перемотка
                        window.scrollTo(0, slide[0].offsetTop);
                        console.log(slide);
                        console.log(window.scrollY);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    })
</script>
