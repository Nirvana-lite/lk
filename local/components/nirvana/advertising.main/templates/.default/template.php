<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true); ?>
<div id="adv_main" class="col-md-12">
    <div class="alert alert-dark" role="alert">
        <h4 class="alert-heading">Баланс общий: <b>16 000</b></h4>
        <hr>
        <button class="btn btn-success mb-0">Пополнить</button>
    </div>
    <div class="card mb-2" v-for="item in items">
        <div class="card-body">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <div class="col-md-6">
                    <ul class="block_inf ">
                        <li class="d-flex justify-content-between">
                            <small>Просмотров:</small> <b>{{item.view.val}}</b>
                        </li>
                        <li class="d-flex justify-content-between" v-for="status in item.status">
                            <small>{{status.name}}:</small> <b>{{status.val}}</b>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="block_inf ">
                        <li class="d-flex justify-content-between">
                            <small>Баланс:</small> <b>2000</b>
                        </li>
                        <li class="d-flex justify-content-between">
                            <small>День:</small> <b>-----</b>
                        </li>
                        <li class="d-flex justify-content-between">
                            <small>Месяц:</small> <b>-----</b>
                        </li>
                        <li class="d-flex justify-content-between">
                            <small>Год:</small> <b>-----</b>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button class="btn btn-sm btn-primary" @click="getAdvList(item.id)">Перейти</button>
        </div>
    </div>
</div>
<script>
    new Vue({
        el: '#adv_main',
        data: function () {
            return {
                items:<?=json_encode($arResult['items'],true)?>
            }
        },
        methods:{
            getAdvList: function (itemId) {
                let str = new FormData();
                str.append('info[view]', 'list');
                str.append('info[type]', itemId);
                axios.post("<?=$componentPath?>/getData.php", str)
                    .then((response) => {
                        $('#adv_main').html(response.data)
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    })
</script>

