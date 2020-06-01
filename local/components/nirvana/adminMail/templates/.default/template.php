<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
?>
<div id="mails">
    <div class="col-md-12 lists" v-for="(mail,key) in mails">
        <div class="date col-md-1">
            <i class="fa fa-calendar" aria-hidden="true">{{mail.date}}</i>
        </div>
        <div class="names col-md-7">
            <div class="name col-md-6"><i class="fa fa-user-circle-o" aria-hidden="true"> {{mail.user.name}}</i>
            </div>
            <div class="prof col-md-6"><i class="fa fa-info-circle" aria-hidden="true"> {{mail.user.prof}}</i></div>
        </div>
        <div class="col-md-2">
            <i class="fa fa-comments" aria-hidden="true"> {{mail.comment}}</i>
            <i v-if="mail.done" class="fa fa-check-square-o" aria-hidden="true"></i>
            <i v-else class="fa fa-square-o" aria-hidden="true"></i>
        </div>
        <template v-if="mail.view">
            <div class="caret col-md-1" @click="changeView(key)">
                <i class="fa fa-2x fa-caret-up" aria-hidden="true"></i>
            </div>
            <button type="button" class="btn btn-danger" @click="askForDel(mail,key)">Удалить</button>
            <div class="text full col-md-12" v-html="mail.text"></div>
            <div class="col-md-12" v-html="mail.detailComment"></div>
        </template>
        <template v-else>
            <div class="caret col-md-1" @click="changeView(key)">
                <i class="fa fa-2x fa-caret-down" aria-hidden="true"></i>
            </div>
            <div class="text col-md-12" v-html="mail.preview"></div>
        </template>
    </div>
    <template v-if="Object.keys(delElem).length !== 0">
        <div class="delQuestion">
            <p>Точно Удалить?</p>
            <button type="button" @click="delItem(delElem.id)">ДА</button>
            <button type="button" @click="canselDel()">НЕТ</button>
        </div>
    </template>
</div>
<div class="col-md-12">
    <?php
    if (!inGroup(1)) {
        $APPLICATION->IncludeComponent(
            "khayr:all",
            "comment_editor_emoji",
            array(
                "METHOD" => intval($arParams['METHOD']),
                'NEW' => true,
                'IBLOCK_ID' => 44,
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
//        "OBJECT_ID" => intval($_POST['id']),
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
</div>

<script>
    var app = new Vue({
        el: '#mails',
        data: function () {
            return {
                mails: <?=json_encode($arResult['mails'])?>,
                myAnswer: '',
                usr: <?=json_encode($arResult['usr'])?>,
                delElem: {}
            }
        },
        methods: {
            changeView: function (key) {
                this.mails[key].view = !this.mails[key].view;
                let str = new FormData();
                str.append('answer', this.mails[key].id);
                axios.post("<?=$componentPath?>/changeActive.php", str)
                    .then((response) => {
                        console.log(response.data)
                    })
                    .catch((error) => {
                        console.log(error);
                    });
                BX.ajax({
                    url: "<?=$this->__component->__path?>/getComment.php",
                    data: {'id': this.mails[key].id},
                    method: 'POST',
                    dataType: 'html',
                    timeout: 1,
                    async: false,
                    processData: true,
                    scriptsRunFirst: false,
                    emulateOnload: true,
                    start: true,
                    cache: false,
                    onsuccess: (data => this.mails[key].detailComment = data),
                    onfailure: function () {
                    }
                });
                this.$nextTick(function () {
                    if (typeof re_init === 'function') {
                        re_init();
                    }
                });
            },
            askForDel: function (elem, key) {
                this.delElem = elem;
                this.delElem.keys = key;
            },
            canselDel: function () {
                this.delElem = {}
            },
            delItem: function (itemID) {

                let str = new FormData();
                str.append('answer[id]', itemID);
                axios.post("<?=$componentPath?>/sendMail.php", str)
                    .then((response) => {
                        this.mails.splice(this.delElem.keys, 1);
                        this.delElem = {}
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            createText: function () {
                if (this.myAnswer.length > 0) {
                    let str = new FormData();
                    str.append('answer', this.myAnswer);
                    axios.post("<?=$componentPath?>/sendMail.php", str)
                        .then((response) => {
                            this.myAnswer = '';
                            console.log(response.data);
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                } else {
                    console.log('empty');
                }
            }
        }

    })
</script>
