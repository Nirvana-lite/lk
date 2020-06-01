<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
if ($_POST['mylist'] == 'getlist') {
    $APPLICATION->RestartBuffer();
    sleep(1);
    echo json_encode($arResult);
    die();
}
 ?>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
<script>
    Vue.component('myquestions', {
        template: `<div id="comments" class="comments" v-cloak>
    <ul class="media-list">
        <li class="media" v-for="(item ,key) in items" :key="key">
            <div class="media-body">
                <div class="card mb-1 card-secondary">
                    <div class="card-body">
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
                                <div class="info">Название:</div>
                                <div class="text">{{item.name}}</div>
                                <div class="info">Вопрос:</div>
                                <div class="detail" v-html="item.text"></div>
                            </div>
                            <div v-html="item.detailComment"></div>
                        </template>
                        <template v-else>
                                <div class="prev_info">
                                    <div class="left_block">
                                        <div class="section" v-if="item.section"><span>Раздел:</span> {{item.section}}</div>
                                        <div class="authors"><span>Автор:</span> {{item.autor}}</div>
<br>
                                        <div class="authors"><span>Название:</span> {{item.name}}</div>
                                        <div class="media-text text-justify" v-html="item.preview"></div>
<div class="inf">
<div class="city"><div class="inf_check"><span>Город:</span> {{item.city}}</div></div>
<div class="date"><div class="inf_check"><span>Дата:</span> {{item.date}}</div></div>
<div class="count"><span>Ответов:</span> <div class="inf_check">{{item.answercount}}</div></div>
<div class="pull-right detail_button" @click="openDetail(key)">Подробнее</div></div>
</div>
                                    </div>
                        </template>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <div class="pages" v-html="pages"></div>
    <div class="loading"><div class='spinner-wrapper'><img  class='loadimgfr' src='/local/loading.gif'></div></div>
</div>`,
        data: function () {
            return {
                items: <?=json_encode($arResult['questions'])?>,
                pages: <?=json_encode($arResult['pages'])?>,
                detailItem: null,
            }
        },
        methods: {
            openDetail: async function (itemId) {
                for (let item in this.items) {
                    this.items[item].open = false;
                    this.items[itemId].detailComment = '';
                }
                this.items[itemId].open = !this.items[itemId].open;

                BX.ajax({
                    url: "<?=$this->__component->__path?>/getComment.php",
                    data: {'id': this.items[itemId].id},
                    method: 'POST',
                    dataType: 'html',
                    timeout: 1,
                    async: false,
                    processData: true,
                    scriptsRunFirst: false,
                    emulateOnload: true,
                    start: true,
                    cache: false,
                    onsuccess: (data => this.items[itemId].detailComment = data),
                    onfailure: function () {
                    }
                });
                this.$nextTick(function () {
                    if (typeof re_init === 'function') {
                        re_init();
                    }
                });

            },
            getNextPage: function(urlMore){
                BX.ajax({
                    url: urlMore,
                    data: {'mylist': 'getlist'},
                    method: 'POST',
                    dataType: 'json',
                    timeout: 1,
                    async: false,
                    processData: true,
                    scriptsRunFirst: false,
                    emulateOnload: true,
                    start: true,
                    cache: false,
                    onsuccess: (data => this.addItem(data)),
                    onfailure: function () {
                    }
                });
            },
            scroll(person) {
                let loadingImage = "";
                let loadingClass = document.querySelector(".loading");
                window.onscroll = () => {
                    let tp = window.pageYOffset + loadingClass.getBoundingClientRect().top;
                    let wp = window.pageYOffset + document.documentElement.clientHeight;
                    if (tp < wp) {
                        loadingClass.className = 'loading hideMore';
                        let urlMore = document.querySelector('.load_more').dataset.url;
                            this.getNextPage(urlMore);
                        this.$nextTick(function () {
                                 loadingClass.className = 'loading';
                        })
                    } else {
                        return false;
                    }

                };
            },
            addItem: function (arr) {
                this.pages = arr.pages;
                for (let itm in arr.questions) {
                    this.items.push(arr.questions[itm])
                }
            },
        },
        mounted() {
            this.scroll(this.items);
        }
    });
</script>
