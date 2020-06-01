<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
$this->setFrameMode(true);

if ($request->getPost("ajax")) {
    $APPLICATION->RestartBuffer();
    sleep(1);
    echo json_encode($arResult);
    die();
}elseif ($request->getPost("detail")){
    $APPLICATION->RestartBuffer();
    echo json_encode($arResult);
    die();
} else {?>
    <div class="tabs" id="articles">
        <a href="new/" class="tab new_letter">Написать статью</a>
        <div class="tab" :class="[activeTab == 1 ?'viewed':'']" @click="changeActive(1)">
            Все статьи
        </div>
        <div class="tab" :class="[activeTab == 2 ?'viewed':'']" @click="changeActive(2)">
            Мои статьи
        </div>
        <template v-if="activeTab == 1">
            <section class="tab-content">
                <li class="media" v-for="(item,key) in all" :key="key">
                    <figure class="sign col-md-3">
                        <figcaption>
                            <time class="col-md-6"><i class="fa fa-calendar" aria-hidden="true"></i>{{item.date}}</time>
                            <span class="col-md-6" v-if="item.view"><i class="fa fa-eye" aria-hidden="true"></i>{{item.view}}</span>
                        </figcaption>
                        <img :src="item.picture.src" class="img-thumbnail img-media mr-2 mt-1">
                        <figcaption>
                            <button class="btn btn-default" type="button" @click="openDetail(key)">читать подробнее</button>
                        </figcaption>
                    </figure>
                    <div class="media-body col-md-8">
                        <h4 class="mt-0 mb-1" v-html="item.name"></h4>
                        <p class="prevText" v-html="item.preview"></p>
                        <div v-html="item.detail"></div>
                    </div>
                </li>
                <div class="loading">
                    <div class='spinner-wrapper'><img class='loadimgfr' src='/local/loading.gif'></div>
                </div>
            </section>
        </template>
        <template v-else-if="activeTab == 2">
            <section class="tab-content">
                <li class="media" v-for="(item,key) in my" :key="key">
                    <figure class="sign">
                        <figcaption>
                            <time class="col-md-6"><i class="fa fa-calendar" aria-hidden="true"></i>{{item.date}}</time>
                            <span class="col-md-6"><i class="fa fa-eye" aria-hidden="true"></i>{{item.view}}</span>
                        </figcaption>
                        <img :src="item.picture.src" class="img-thumbnail img-media mr-2 mt-1">
                        <figcaption>
                            <button class="btn btn-default" type="button" @click="openDetail(key)">читать подробнее</button>
                        </figcaption>
                    </figure>
                    <div class="media-body">
                        <h4 class="mt-0 mb-1" v-html="item.name"></h4>
                        <p class="prevText" v-html="item.preview"></p>
                        <div v-html="item.detail"></div>
                    </div>
                </li>
                <div class="loading">
                    <div class='spinner-wrapper'><img class='loadimgfr' src='/local/loading.gif'></div>
                </div>
            </section>
        </template>
    </div>
    <script>
      let articles = new Vue({
            el: '#articles',
            data: function () {
                return {
                    my: <?=json_encode($arResult['my'])?>,
                    all: <?=json_encode($arResult['all'])?>,
                    activeTab: 1,
                    pages: <?=json_encode($arResult['pages'])?>,
                    iblock: <?=$arParams['ARTICLES']?>,
                    breaks: false,
                    id: ''
                }
            },
            methods: {
                changeActive: function (elem) {
                    this.activeTab = elem;
                },
                openDetail: async function (itemId) {
                    if (this.activeTab === 1){
                        for (let item in this.all) {
                            this.all[item].open = false;
                            this.all[itemId].detailComment = '';
                        }
                        this.all[itemId].open = !this.all[itemId].open;
                         this.id = this.all[itemId].id;
                    }else{
                        for (let item in this.my) {
                            this.my[item].open = false;
                            this.my[itemId].detailComment = '';
                        }
                        this.my[itemId].open = !this.my[itemId].open;
                        this.id = this.my[itemId].id;
                    }

                    let str = new FormData();
                    str.append('iblock', this.iblock);
                    str.append('detail', this.id);
                    axios.post("<?=$componentPath?>/getArticles.php", str)
                        .then((response) => {
                            if (this.activeTab === 1){
                                this.all[itemId].detail = response.data.detail;
                            }else if(this.activeTab === 2) {
                                this.my[itemId].detail = response.data.detail;
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });

                   /* BX.ajax({
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
                    });*/

                },
                getNextPage: function () {
                    articles.breaks = true;
                    let str = new FormData();
                    str.append('iblock', this.iblock);
                    str.append('ajax', this.activeTab);
                    str.append('pageCount', this.pageCounts);
                    axios.post("<?=$componentPath?>/getArticles.php", str)
                        .then((response) => {
                            this.addItem(response.data);
                            console.log(this.pageCounts)
                            this.breaks = false;
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                },
                addItem: function (arr) {
                    if (typeof arr.all !== 'undefined') {
                        for (let itm in arr.all) {
                            this.all.push(arr.all[itm])
                        }
                    } else if (typeof arr.my !== 'undefined') {
                        for (let itm in arr.my) {
                            this.my.push(arr.my[itm])
                        }

                    }
                },
                scroll: function () {
                    let loadingClass = document.querySelector(".loading");
                        window.onscroll = (e) => {
                            let tp = window.pageYOffset + loadingClass.getBoundingClientRect().top;
                            let wp = window.pageYOffset + document.documentElement.clientHeight;
                            if (tp < wp) {
                                this.breaks = 1;
                                e.preventDefault();
                                e.stopPropagation();
                                loadingClass.className = 'loading hideMore';
                                this.getNextPage();
                                this.$nextTick(function () {
                                    loadingClass.className = 'loading';
                                });
                                return false
                            }
                        }
                },
            },
            computed: {
                pageCounts: function () {
                    return (this.activeTab === 1) ? this.all.length : this.my.length;
                },
            },
            mounted() {
               // this.scroll();
            }
        })
    </script>
<? }





