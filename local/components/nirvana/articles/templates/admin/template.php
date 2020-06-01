<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
$this->setFrameMode(true);

if ($request->getPost("ajax")) {
    $APPLICATION->RestartBuffer();
    echo json_encode($arResult);
    die();
} else {
    ?>
    <div class="row col-md-12 new_btn">
        <a target="_blank" href="new/" class="btn btn-info">Создать статью</a>
    </div>
    <div class="tabs" id="articles">
        <div v-for="item in all">
            <div class="item row">
                <div class="col-md-8">
                    <h2 class="name" v-html="item.name"></h2>
                    <div class="preview" v-html="item.preview"></div>
                </div>
                <div class="col-md-4 info">
                    <div class="date col-md-12">
                        <span>Дата: {{item.date}}</span>
                    </div>
                    <div class="autor row col-md-12">
                            <span class="col-md-4">
                                <img :src="item.autor.photo">
                            </span>
                        <span class="col-md-8">
                                <span v-html="item.autor.fullName"></span>
                            </span>
                    </div>
                    <div class="link col-md-12">
                        <a target="_blank" :href='item.id'><i class="fa fa-2x fa-pencil-square-o" aria-hidden="true">
                                Редактировать</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let articles = new Vue({
            el: '#articles',
            data: function () {
                return {
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
                    for (let item in this.all) {
                        this.all[item].open = false;
                        this.all[itemId].detailComment = '';
                    }
                    let str = new FormData();
                    str.append('iblock', this.iblock);
                    str.append('detail', this.id);
                    axios.post("<?=$componentPath?>/getArticles.php", str)
                        .then((response) => {
                            if (this.activeTab === 1) {
                                this.all[itemId].detail = response.data.detail;
                            } else if (this.activeTab === 2) {
                                this.my[itemId].detail = response.data.detail;
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
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





