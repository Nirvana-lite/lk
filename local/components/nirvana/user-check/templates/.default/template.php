<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>
<?

use Bitrix\Main\Context;
use Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
$value = $request->getPost("USERS");
if (intval($value) > 0) {
    $APPLICATION->RestartBuffer();
    echo json_encode($arResult);
    die();
}

?>

<div id="users" class="col-md-12">

    <template v-if="Object.keys(detailList).length === 0">
        <div v-for="(item, key) in itemList" class="col-md-6">
            <div class="itm">
                <h3 v-html="item.name"></h3>
                <p>Колличество: <span class="itemCnt" v-html="item.cnt"></span></p>
                <button type="button" class="btn btn-primary" @click="getDetailList(item.id)">Перейти</button>
            </div>
        </div>
    </template>
    <template v-else>
        <div class="row">
            <button type="button" class="btn btn-lg btn-secondary" @click="goBack()">Назад</button>
        </div>
        <div class="row mt-2">
            <div class="row row-cols-4 row-cols-md-4">
                <div class="col-4 mb-3" v-for="(item, index) in detailList">
                    <div class="card">
                        <button type="button" class="btn btn-sm btn-danger closeButton" @click="askForDel(item,index)">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                        <span v-if="item.new" class="newUser">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-square-o fa-stack-2x"></i>
                                <i class="fa fa-fire fa-stack-1x"></i>
                            </span>
                        </span>
                        <img :src="item.photo" class="card-img-top">
                        <div class="card-body">
                            <ul class="list-group list-group-flush itemInfo">
                                <li class="list-group-item">
                                    <div class="col-md-12"><small class="bld">{{item.name}}</small></div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <div class="btns justify-content-between">
                                <button type="button" class="btn btn-primary btn-sm" @click="getModal(item)">Подробнее
                                </button>
                                <button v-if="item.changes" type="button" class="btn btn-primary btn-sm" @click="getChanges(item.id)">
                                    Изменения <i class="alrm fa fa-exclamation-triangle" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
    <template v-if="Object.keys(modalBlock).length !== 0">
        <div class="modalWrap">
            <div class="modalItem">
                <button type="button" class="btn btn-lg btn-primary" @click="closeModal()">Назад</button>

                <template v-if="usersId === 8">
                    <div class="card-group mt-1">
                        <div class="card">
                            <!-- Шапка (header) карточки -->
                            <div class="card-header">
                                Личная
                            </div>
                            <!-- Список List groups -->
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="col-md-4">Имя</div>
                                    <div class="col-md-8">{{modalBlock.name}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Фамилия</div>
                                    <div class="col-md-8">{{modalBlock.last}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Отчество</div>
                                    <div class="col-md-8">{{modalBlock.second}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Почта</div>
                                    <div class="col-md-8">{{modalBlock.mail}}</div>
                                </li>
                            </ul>
                        </div>
                        <div class="card">
                            <!-- Шапка (header) карточки -->
                            <div class="card-header">
                                Работа
                            </div>
                            <!-- Список List groups -->
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="col-md-4">Компания</div>
                                    <div class="col-md-8">{{modalBlock.work.company}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Отдел</div>
                                    <div class="col-md-8">{{modalBlock.work.department}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Должность</div>
                                    <div class="col-md-8">{{modalBlock.work.position}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Направление</div>
                                    <div class="col-md-8">{{modalBlock.work.profile}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Адрес</div>
                                    <div class="col-md-8">{{modalBlock.work.address}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Телефон</div>
                                    <div class="col-md-8">{{modalBlock.work.workPhone}}</div>
                                </li>
                            </ul>
                        </div>
                        <div class="card">
                            <!-- Шапка (header) карточки -->
                            <div class="card-header">
                                Образование
                            </div>
                            <!-- Список List groups -->
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="col-md-5">Вуз</div>
                                    <div class="col-md-7">{{modalBlock.educat.vuz}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-5">Факультет</div>
                                    <div class="col-md-7">{{modalBlock.educat.fak}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-5">Специальность</div>
                                    <div class="col-md-7">{{modalBlock.educat.spec}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-5">Год выпуска</div>
                                    <div class="col-md-7">{{modalBlock.educat.year}}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="card-group mt-1">
                        <div class="card">
                            <!-- Шапка (header) карточки -->
                            <div class="card-header">
                                Личная
                            </div>
                            <!-- Список List groups -->
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="col-md-4">Имя</div>
                                    <div class="col-md-8">{{modalBlock.name}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Фамилия</div>
                                    <div class="col-md-8">{{modalBlock.last}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Отчество</div>
                                    <div class="col-md-8">{{modalBlock.second}}</div>
                                </li>
                                <li class="list-group-item">
                                    <div class="col-md-4">Почта</div>
                                    <div class="col-md-8">{{modalBlock.mail}}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </template>
    <template v-if="Object.keys(modalChanges).length !== 0">
        <div class="modalWrap">
            <div class="modalItem">
                <div class="btns justify-content-between">
                    <button type="button" class="btn btn-lg btn-primary" @click="closeModal()">Назад</button>

                    <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-success" @click="doneItem()">Одобрить</button>
                        <button type="button" class="btn btn-warning" @click="errorItem()">Отказать
                        </button>
                    </div>
                </div>

                <template v-if="typeof modalChanges !== 'string'">
                    <div class="card-group mt-1">
                        <div class="card" v-for="(change, key) in modalChanges.user">
                            <!-- Шапка (header) карточки -->
                            <div class="card-header">
                                {{key}}
                            </div>
                            <!-- Список List groups -->
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" v-for="(elem , key) in change">
                                    <div class="col-md-4">{{elem.name}}</div>
                                    <template v-if="key === 'PERSONAL_PHOTO' || key === 'UF_CERT_PHOTO'">
                                        <div class="col-md-8">
                                            <img :src="elem.value" class="changeImg col-md-8">
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="col-md-8">{{elem.value}}</div>
                                    </template>

                                </li>
                            </ul>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="alert alert-danger mt-2" role="alert">
                        <h4 class="alert-heading">Спасибо что заглянули!!</h4>
                        <p>Но изменений нет....</p>
                    </div>
                </template>

            </div>
        </div>
    </template>
    <template v-if="Object.keys(modalDel).length !== 0">
        <div class="modalWrap">
            <div class="modalItem mt-5">
                <div class="alert alert-danger mt-2" role="alert">
                    <h4 class="alert-heading">Удаление пользователя <b>{{modalDel.name}} {{modalDel.last}}
                            {{modalDel.second}}</b>
                    </h4>
                    <p>Вы точно уверены?!</p>
                    <hr>
                    <button type="button" class="btn btn-success" @click="delUser()">ДА</button>
                    <button type="button" class="btn btn-warning" @click="closeModal()">Нет</button>
                </div>
            </div>
    </template>
</div>
<script>
    var app = new Vue({
        el: "#users",
        data: function () {
            return {
                itemList: <?=json_encode($arResult, true)?>,
                detailList: {},
                usersId: 0,
                modalBlock: {},
                modalChanges: {},
                modalDel: {},
                changeItemId: 0
            }
        },
        methods: {
            getDetailList: function (item) {
                let str = new FormData();
                str.append('USERS', item);
                axios.post("<?=$this->__component->__path?>/getUsers.php", str)
                    .then((response) => {
                        this.usersId = item;
                        this.detailList = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            goBack: function () {
                this.detailList = {};
                this.usersId = 0;
            },
            getModal: function (userItem) {
                this.modalBlock = userItem;
            },
            closeModal: function () {
                this.modalBlock = {}
                this.modalChanges = {}
                this.modalDel = {}
            },
            getChanges: function (itemID) {
                let str = new FormData();
                str.append('user', itemID);
                axios.post("<?=$componentPath?>/getChanges.php", str)
                    .then((response) => {
                        this.modalChanges = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            askForDel: function (itemUser, itemKey) {
                this.modalDel = itemUser;
                this.modalDel.itemKey = itemKey;
            },
            doneItem: function () {
                let str = new FormData();
                str.append('user[id]', this.modalChanges.id);
                str.append('user[change]', true);
                axios.post("<?=$componentPath?>/changeData.php", str)
                    .then((response) => {
                        console.log('response', response.data);
                        if (response.data.done){
                            for (let item in this.detailList){
                                if (this.detailList[item].id === this.modalChanges.id){
                                    this.detailList[item].changes = false;
                                }
                            }
                            this.modalChanges = {}
                            this.closeModal();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            errorItem: function () {
                let str = new FormData();
                str.append('user[id]', this.modalChanges.id);
                str.append('user[change]', false);
                axios.post("<?=$componentPath?>/changeData.php", str)
                    .then((response) => {
                        if (response.data.done){

                            for (let item in this.detailList){
                                if (this.detailList[item].id === this.modalChanges.id){
                                    this.detailList[item].changes = false;
                                }
                            }
                            this.modalChanges = {}
                            this.closeModal();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            delUser: function () {
                 let str = new FormData();
                 str.append('user', this.modalDel.id);
                 axios.post("<?=$componentPath?>/delUser.php", str)
                    .then((response) => {
                        if (response.data){
                            Vue.delete(this.detailList, this.modalDel.itemKey)
                            this.closeModal();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    })
</script>
