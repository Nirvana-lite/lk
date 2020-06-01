<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true); ?>
<div class="tabs" id="questionTab">
    <div v-for="(item,key) in tabs" :key="key" class="tab" :class="[activeTab == key ?'viewed':'']"
         @click="changeActive(key)">
        {{item}}
    </div>
    <template v-if="activeTab == 0">
        <div class="item" v-for="(item ,key) in allQuestions.items" :key="key">
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
                <div v-html="item.detailComment"></div>
            </template>
            <template v-else>
                <div class="prev_info">
                    <div class="left_block">
                        <div class="section" v-if="item.section">
                            <div class="inf_check">
                                <span>Раздел:</span> {{item.section}}
                            </div>
                        </div>
                        <div class="authors inf_check"><span>Автор:</span> {{item.autor}}</div>
                        <div class="media-text text-justify" v-html="item.preview"></div>
                        <div class="inf">
                            <div class="city">
                                <div class="inf_check"><span>Город:</span> {{item.city}}</div>
                            </div>
                            <div class="date">
                                <div class="inf_check"><span>Дата:</span> {{item.date}}</div>
                            </div>
                            <div class="count"><span>Ответов:</span>
                                <div class="inf_check">{{item.answercount}}</div>
                            </div>
                            <div class="detail_button" @click="openDetail(key)">Подробнее</div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div class="pages" v-html="allQuestions.pages"></div>
        <div class="loading">
            <div class='spinner-wrapper'><img class='loadimgfr' src='/local/loading.gif'></div>
        </div>
    </template>
    <template v-else-if="activeTab == 1">
        <template v-if="myQuestions.items.length > 0">
            <div class="item" v-for="(item ,key) in myQuestions.items" :key="key">
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
                    <div v-html="item.detailComment"></div>
                </template>
                <template v-else>
                    <div class="prev_info">
                        <div class="left_block">
                            <div class="section" v-if="item.section">
                                <div class="inf_check">
                                    <span>Раздел:</span> {{item.section}}
                                </div>
                            </div>
                            <div class="authors inf_check"><span>Автор:</span> {{item.autor}}</div>
                            <div class="media-text text-justify" v-html="item.preview"></div>
                            <div class="inf">
                                <div class="city">
                                    <div class="inf_check"><span>Город:</span> {{item.city}}</div>
                                </div>
                                <div class="date">
                                    <div class="inf_check"><span>Дата:</span> {{item.date}}</div>
                                </div>
                                <div class="count"><span>Ответов:</span>
                                    <div class="inf_check">{{item.answercount}}</div>
                                </div>
                                <div class="detail_button" @click="openDetail(key)">Подробнее</div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="pages" v-html="myQuestions.pages"></div>
            <div class="loading">
                <div class='spinner-wrapper'><img class='loadimgfr' src='/local/loading.gif'></div>
            </div>
        </template>
        <template v-else>
            Вы еще не задавали вопросы на нашем портале.
            <br>
            Но это легко поправимо! <a target="_blank" href="/jurist-help/">задать вопрос</a>
        </template>
    </template>
    <template v-else-if="activeTab == 2">
        <section class="tab-content">
            <p>В разработке</p>
        </section>
    </template>
    <template v-else-if="activeTab == 3">
        <section class="tab-content">
            <p>В разработке</p>
        </section>
    </template>
    <template v-else-if="activeTab == 4">
        <section class="tab-content">
            <p>В разработке</p>
        </section>
    </template>

</div>
<script>
    new Vue({
        el: '#questionTab',
        data: function () {
            return {
                activeTab: 0,
                tabs: <?=json_encode($arResult['tabs'])?>,
                allQuestions:<?=json_encode($arResult['allQuestions'])?>,
                myQuestions:<?=json_encode($arResult['myQuestions'])?>,
                myAnswers:<?=json_encode($arResult['myAnswers'])?>,
                allAnswers:<?=json_encode($arResult['allAnswers'])?>,

            }
        },
        methods: {
            changeActive: function (elem) {
                this.activeTab = elem;
            },
            openDetail: async function (itemId) {
                let quest = Object;
                if (this.activeTab === 0){
                     quest = this.allQuestions;
                }else if (this.activeTab === 1){
                    quest = this.myQuestions;
                }
                else if (this.activeTab === 2){
                    quest = this.allAnswers;
                }
                else if (this.activeTab === 3){
                    quest = this.myAnswers;
                }
                for (let item in quest.items) {
                    quest.items[item].open = false;
                    quest.items[itemId].detailComment = '';
                }
                quest.items[itemId].open = !quest.items[itemId].open;

                BX.ajax({
                    url: "<?=$this->__component->__path?>/getComment.php",
                    data: {'id': quest.items[itemId].id},
                    method: 'POST',
                    dataType: 'html',
                    timeout: 1,
                    async: false,
                    processData: true,
                    scriptsRunFirst: false,
                    emulateOnload: true,
                    start: true,
                    cache: false,
                    onsuccess: (data => quest.items[itemId].detailComment = data),
                    onfailure: function () {
                    }
                });
                this.$nextTick(function () {
                    if (typeof re_init === 'function') {
                        re_init();
                    }
                });

            },
        },
    })
</script>
