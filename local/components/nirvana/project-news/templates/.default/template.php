<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
if ($_POST['mylist'] == 'getlist') {
    $APPLICATION->RestartBuffer();
    sleep(1);
    echo json_encode($arResult);
    die();
}

if (inGroup(1)) {
    $APPLICATION->IncludeComponent(
        "khayr:addnews",
        "comment_editor_emoji",
        Array(
            'IBLOCK_ID' => 45,
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADDITIONAL" => array(""),
            "ALLOW_RATING" => "Y",
            "AUTH_PATH" => "/auth/",
            "CAN_MODIFY" => "N",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "COUNT" => "10",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "JQUERY" => "Y",
            "LEGAL" => "N",
            "LEGAL_TEXT" => "Я согласен с правилами размещения сообщений на сайте.",
            "LOAD_AVATAR" => "Y",
            "LOAD_DIGNITY" => "Y",
            "LOAD_FAULT" => "Y",
            "LOAD_MARK" => "Y",
            "MAX_DEPTH" => "5",
            "MODERATE" => "N",
            "NON_AUTHORIZED_USER_CAN_COMMENT" => "Y",
            "PAGER_DESC_NUMBERING" => "Y",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "ajax_comments",
            "PAGER_TITLE" => "",
            "REQUIRE_EMAIL" => "Y",
            "USE_CAPTCHA" => "N"
        )
    );
}

?>
<div id="news" v-cloak>

    <div class="panel panel-primary" v-for="(item,key) in items">
        <div class="panel-heading" @click="changeView(key)">
            <i class="fa fa-thumb-tack" aria-hidden="true">
                <h3 class="panel-title" v-html="item.name"></h3>
            </i>
            <template v-if="item.view">
                <div class="detailIcon">
                    <i class="fa fa-minus-square-o fa-2x" aria-hidden="true"></i>
                </div>

            </template>

            <template v-else>
                <div class="detailIcon">
                    <i class="fa fa-plus-square-o fa-2x" aria-hidden="true"></i>
                </div>
            </template>
        </div>
        <div class="panel-body" v-if="item.view">
            <div class="itemText" v-html="item.text"></div>
        </div>
        <div class="panel-footer">
            <i class="fa fa-calendar" aria-hidden="true"> <span class="itemDate" v-html="item.date"></span></i>
            <button type="button" class="btn btn-lg btn-primary" @click="changeView(key)">Подробнее</button>
        </div>
    </div>
    <div class="pages" v-html="pages"></div>
    <!--    <div class="loading"><div class='spinner-wrapper'><img  class='loadimgfr' src='/local/loading.gif'></div></div>-->
</div>
<script>
    new Vue({
        el: '#news',
        data: function () {
            return {
                items: <?=json_encode($arResult['items'], true)?>,
                user:<?=json_encode($arResult['user'])?>,
                pages:<?=json_encode($arResult['pages'])?>
            }
        },
        methods: {
            changeView: function (itemKey) {
                this.items[itemKey].view = !this.items[itemKey].view

            },
            getNextPage: function (urlMore) {
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
                let loadingClass = document.querySelector(".pages");
                window.onscroll = () => {
                    let tp = window.pageYOffset + loadingClass.getBoundingClientRect().top;
                    let wp = window.pageYOffset + document.documentElement.clientHeight;
                    if (tp < wp) {
                        loadingClass.className = 'pages hideMore';
                        let urlMore = document.querySelector('.load_more').dataset.url;
                        this.getNextPage(urlMore);
                        this.$nextTick(function () {
                            loadingClass.className = 'pages';
                        })
                    } else {
                        loadingClass.innerHTML = '';
                        return false;
                    }

                };
            },
            addItem: function (arr) {
                this.pages = arr.pages;
                for (let itm in arr.items) {
                    this.items.push(arr.items[itm])
                }
            }
        },
        mounted() {
            this.scroll(this.items);
        }
    })
</script>

