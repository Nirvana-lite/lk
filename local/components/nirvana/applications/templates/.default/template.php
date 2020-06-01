<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<link rel="stylesheet"
      href="<?= $componentPath . "/templates/.default/datepicker/css/bootstrap-datepicker3.min.css" ?>">
<script src="<?= $componentPath . "/templates/.default/datepicker/js/bootstrap-datepicker.min.js" ?>"></script>
<script src="<?= $componentPath . "/templates/.default/datepicker/locales/bootstrap-datepicker.ru.min.js" ?>"></script>


<div id="list" class="col-md-12">

    <template v-if="detail">
            <button type="button" class="btn btn-lg btn-secondary" @click="allPrint()">ВСЕ НАПЕЧАТАТЬ</button>
            <hr>
        <div class="comments" id="questions" v-cloak>
            <div class="title-comments row">
                <div class="col-md-6">
                    <div class="input-daterange input-group grp" id="datepicker">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="input-sm form-control" name="start"/>
                        <span class="input-group-addon">до</span>
                        <input type="text" class="input-sm form-control" name="end"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="col-md-3">Всего: {{total.all}}</span>
                    <span class="col-md-3 good">Ок: {{total.done}}</span>
                    <span class="col-md-3 warn">Брак: {{total.defect}}</span>
                    <span class="col-md-3 yel">Ждет: {{total.new}}</span>
                </div>
            </div>
            <ul class="media-list">
                <li class="media" v-for="(item ,key) in items" :key="key">
                    <div class="media-body">
                        <div class="panel" :class="item.status.color">
                            <div class="panel-heading">
                                <div class="date" v-html="item.date"></div>
                                <div class="city" v-if="item.choise.city" v-html="item.choise.city"></div>
                                <div class="authors" v-html="item.autor"></div>
                            </div>
                            <div class="panel-body">
                                <template v-if="item.open">
                                    <div class="detail_info">
                                        <div class="info">Дата:</div>
                                        <div class="date" v-html="item.date"></div>
                                        <div class="info">Автор:</div>
                                        <div class="name" v-html="item.autor"></div>
                                        <div class="info">Телефон:</div>
                                        <div class="phone" v-html="item.phone"></div>
                                        <div class="info">Город:</div>
                                        <div class="city" v-html="item.choise.city"></div>
                                        <div class="info">Раздел:</div>
                                        <div class="city" v-if="item.choise.section" v-html="item.choise.section"></div>
                                        <div class="city" v-else>Не выбран</div>
                                        <div class="info">Вопрос:</div>
                                        <div class="detail" v-html="item.text"></div>
                                    </div>
                                    <div class="pull-right right_button">
                                        <template v-if="item.read === '1'">
                                            <div class="form-control" v-if="item.reason" v-html="item.reason"></div>
                                            <div class="form-control btn btn-default" @click="printElem(key)">Печать
                                            </div>
                                        </template>
                                        <template v-else>
                                            <select class="form-control" v-model="item.choise.city">
                                                <option v-for="city in citys">{{city}}</option>
                                            </select>
                                            <select class="form-control" v-model="item.choise.section">
                                                <option v-for="section in sections">{{section}}</option>
                                            </select>
                                            <template v-if="item.reason !== null">
                                                <div class="form-control btn btn-default" @click="viewReason(key)">
                                                    {{item.reason}}
                                                </div>
                                            </template>
                                            <template v-else-if="item.defect == 'Y'">
                                                <select v-model="item.reason" size="5" class="form-control"
                                                        @change="changeReason(key)">
                                                    <option v-for="reason in defectReason">{{reason}}</option>
                                                </select>
                                            </template>
                                            <template v-else>
                                                <div class="form-control btn btn-default" @click="viewReason(key)">
                                                    Брак?
                                                </div>
                                            </template>
                                            <div class="form-control btn btn-default" @click="saveElem(key)">сохранить
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="media-text text-justify" v-html="item.preview"></div>
                                    <template v-if="item.defect == 'Y'">
                                        <div class="warning">Причина брака: {{item.reason}}</div>
                                    </template>
                                    <div class="pull-right">
                                        <button v-if="item.ok" type="button" class="btn btn-default btn-lg"
                                                @click="openDetail(key)">
                                            Подробнее
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <button type="button" class="btn btn-secondary" @click="goBack()">Назад в Список</button>

    </template>

    <template v-else>
        <div v-for="item in userItems" class="col-md-6">
            <div class="itm">
                <h3 v-html="item.name"></h3>
                <button type="button" class="btn btn-secondary" @click="getDetailList(item.id)">Перейти</button>
            </div>
        </div>
    </template>

</div>
<script>
    var appList = new Vue({
        el: '#list',
        data: function () {
            return {
                userItems: <?=json_encode($arResult['items'])?>,
                items: {},
                total: {},
                citys: <?=json_encode($arResult['citys'])?>,
                sections: <?=json_encode($arResult['sections'])?>,
                defectReason: <?=json_encode($arResult['defectReason'])?>,
                status: <?=json_encode($arResult['status'])?>,
                news: [],
                infoDate: {
                    startDate: '',
                    endDate: ''
                },
                detail: false,
                userId: 0,
                printText:'',
            }
        },
        methods: {
            goDetail: function (userID) {
                this.detail = true;
                this.userId = userID;
            },
            goBack: function () {
                this.detail = false;
            },
            getDetailList: function (userID, itemsDate = false) {
                if (itemsDate) {
                    let str = new FormData();
                    str.append('id', userID);
                    str.append('start', this.infoDate.startDate);
                    str.append('end', this.infoDate.endDate);
                    str.append('change', true);
                    axios.post("<?=$this->__component->__path?>/userlist.php", str)
                        .then((response) => {
                            this.items = response.data.questions;
                            this.total = response.data.total;
                            this.getFirstElem();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                } else {
                    this.goDetail(userID);
                    let str = new FormData();
                    str.append('id', userID);
                    axios.post("<?=$this->__component->__path?>/userlist.php", str)
                        .then((response) => {
                            this.items = response.data.questions;
                            this.total = response.data.total;
                            this.getFirstElem();
                            this.initDatePicked();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }


            },
            initDatePicked: function () {
                $(document).ready(function () {
                    $('#datepicker').datepicker({
                        format: "dd.mm.yyyy",
                        language: "ru",
                        orientation: "bottom auto",
                        keyboardNavigation: false,
                        forceParse: false,
                        calendarWeeks: true,
                        toggleActive: true,
                    }).on('changeDate', function (e) {
                        if (e.target.name === 'start') {
                            appList.infoDate.startDate = e.target.value;
                        } else {
                            appList.infoDate.endDate = e.target.value
                        }
                        appList.getDetailList(appList.userId, true);
                    });
                })
            },
            changeReason: function (item) {
                if (this.items[item].reason === 'НЕ БРАК') {
                    this.items[item].defect = 'N';
                    this.items[item].reason = null;
                } else {
                    this.items[item].defect = 'Y'
                }
            },
            saveElem: function (item) {
                if (this.items[item].defect === 'Y' && this.items[item].reason == null) {
                    return false;
                } else if (this.items[item].defect === 'Y' && this.items[item].reason !== null) {
                    this.items[item].status = this.status.defect;
                    this.items[item].ok = true;
                    this.items[item].read = '1';
                    this.saveItemDb(this.items[item]);
                    return false;
                } else {
                    this.items[item].status = this.status.done;
                    this.items[item].ok = true;
                    this.items[item].read = '1';
                    this.saveItemDb(this.items[item]);
                    return false;
                }

            },
            saveItemDb: function (item) {
                let elem = item;
                let str = new FormData();
                str.append('id', elem.id);
                str.append('defect', elem.defect);
                str.append('reason', elem.reason);
                str.append('city', elem.choise.city);
                str.append('section', elem.choise.section);
                str.append('read', elem.ok);
                axios.post("<?=$this->__component->__path?>/saveQuestion.php", str)
                    .then((response) => {
                        console.log(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            openDetail: function (itemId) {
                for (let item in this.items) {
                    this.items[item].open = false;
                }
                this.items[itemId].open = !this.items[itemId].open
            },
            printElem: function (item) {
                this.PrintElems(this.items[item]);
                this.getFirstElem();
            },
            allPrint: function(){
                for (let i in this.items){
                this.PrintElemsAll(this.items[i]);
                }
                this.popupPrint(this.printText,999);
            },
            PrintElemsAll: function (elem) {
                let name_vopros = '<p><strong>Вопрос №' + elem.id + '</strong></p>';
                let name_user = '<p style="font-size: 18px !important;">Имя: <strong>' + elem.autor + '</strong></p>';
                let phone_user = '<p style="font-size: 18px !important;">Телефон: <strong>' + elem.phone + '</strong></p>';
                let rgion_user = '<p style="font-size: 18px !important;">Регион: <strong>' + elem.city + '</strong></p>';
                let section_user = '<p style="font-size: 18px !important;">Раздел: <strong>' + elem.choise.section + '</strong></p>';
                let textdetail = name_vopros + '<div class="detailvoprostext" style="font-size: 18px !important;">' + elem.text + '</div><div>' + name_user + phone_user + section_user + rgion_user + '</div><hr>';
                this.printText += textdetail;
            },
            PrintElems: function (elem) {
                let name_vopros = '<p><strong>Вопрос №' + elem.id + '</strong></p>';
                let name_user = '<p style="font-size: 18px !important;">Имя: <strong>' + elem.autor + '</strong></p>';
                let phone_user = '<p style="font-size: 18px !important;">Телефон: <strong>' + elem.phone + '</strong></p>';
                let rgion_user = '<p style="font-size: 18px !important;">Регион: <strong>' + elem.city + '</strong></p>';
                let section_user = '<p style="font-size: 18px !important;">Раздел: <strong>' + elem.choise.section + '</strong></p>';
                let textdetail = name_vopros + '<div class="detailvoprostext" style="font-size: 18px !important;">' + elem.text + '</div><div>' + name_user + phone_user + section_user + rgion_user + '</div>';
                this.popupPrint(textdetail, elem.id);
            },
            popupPrint: function (data, nmvopros) {
                let mywindow = window.open('/personal/', 'Вопрос №' + nmvopros, 'height=800,width=1024px');

                mywindow.onload = function () {
                    mywindow.document.write('<html><head><title>Вопрос №' + nmvopros + '</title>');
                    mywindow.document.write('</head><body style="padding: 15px 50px 0px 50px;">');
                    mywindow.document.write(data);
                    mywindow.print();
                };
                return true;
            },
            viewReason: function (item) {
                this.items[item].defect = 'Y';
                this.items[item].reason = null;
            },
            getFirstElem: function () {
                for (let item in this.items) {
                    if (this.items[item].read !== '1') {
                        this.news.push(item);
                    }
                }
                if (this.news.length === 0) return false;
                let firstIndex = this.news.shift();
                this.news.splice(1, 0);
                this.items[firstIndex].ok = true;
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
                        // loadingClass.innerHTML = '';
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

            /*   this.scroll(this.items);*/
        }
    })


</script>



