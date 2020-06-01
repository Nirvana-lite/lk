<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true); ?>
<div id="list">
    <div class="alert alert-dark" role="alert">
        <h4 class="alert-heading">Баланс общий: <b>16 000</b></h4>
        <hr>
        <button class="btn btn-success mb-0">Пополнить</button>
    </div>
    <template v-if="items.length > 0">
        <button class="btn btn-success mb-5">Создать обьявление</button>
        <div class="card" v-for="item in items">
            <div class="card-body">
                <div class="col-md-4">
                    <div class="card">
                        <img src="" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{item.title}}</h5>
                            <p class="card-text">{{item.description}}</p>
                            <p class="card-text">{{item.phone}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-between col-md-12">
                        <i class="fa fa-eye" aria-hidden="true">&nbsp;<b>{{item.view}}</b></i>
                        <div>
                            <i class="fa fa-2x fa-pencil-square-o mr-2" aria-hidden="true"></i>
                            <i class="fa fa-2x fa-window-close-o" aria-hidden="true"></i>
                        </div>
                    </div>
                    <template v-if="item.pay && item.status == 1">
                        <div class="col-md-12">
                            <i class="fa fa-calendar" aria-hidden="true"></i> <b>{{item.view_start}}</b> - <b>{{item.view_end}}</b>
                        </div>
                    </template>
                    <template v-else if="item.status == 2">
                        <div class="col-md-12">
                            <i class="fa fa-exclamation-triangle danger" aria-hidden="true"></i> Обьявление не прошло
                            модерацию
                        </div>
                    </template>
                    <template v-else if="item.status == 3">
                        <div class="col-md-12">
                            <i class="fa fa-question-circle warning" aria-hidden="true"></i> Обьявление проходит модерацию
                        </div>
                    </template>
                    <template v-if="item.status == 1">
                        <div class="col-md-12 mt-5">
                            <button class="btn btn-primary btn-sm">Продлить</button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </template>
    <template v-else>
        <div class="alert alert-dark" role="alert">
            <h4 class="alert-heading">У Вас пока нет обявлений</h4>
            <p>Создать его проще чем Вы думаете</p>
            <hr>
            <button class="btn btn-success btn-lg mb-0">Создать обьявление</button>
         </div>
    </template>

    <div class="col-md-12 row mt-3">
        <button class="btn btn-secondary" @click="getMain()">Назад</button>
    </div>
</div>
<script>
    new Vue({
        el: "#list",
        data: function () {
            return {
                items: <?=json_encode($arResult['items'], true)?>
            }
        },
        methods: {
            getMain: function () {
                let str = new FormData();
                str.append('info[view]', '.default');
                axios.post("<?=$componentPath?>/getData.php", str)
                    .then((response) => {
                        // console.log(response.data);
                        $('#adv_main').html(response.data)
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    })
</script>