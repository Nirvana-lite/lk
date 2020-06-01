<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$APPLICATION->IncludeComponent(
    "nirvana:questions",
    "urist",
    Array('URIST' => 'urist'),
    false
);
$APPLICATION->IncludeComponent(
    "nirvana:sidebar",
    ".default",
    Array(),
    false
);
$arResult['modalInfo']['list'] = [
    'Полностью заполнить профиль, для дальнейшей Вашей узнаваемости',
    'Читать и писать статьи в разделах портала, не выходя из своего кабинета',
    'Вести блог',
    'Задавать и отвечать на вопросы',
    'При необходимости связываться с администрацией портала',
    'Предлагать свои новаторские идеи',
    'Читать дайджест портала'
];
if (inGroup(8)) {
    $arResult['modalInfo']['name'] = 'Юрист';
    $list = [
        'Сменить или поставить фото, что даст Вам узнаваемости',
        'Ознакамливаться и отвечать на вип вопросы',
        'Задавать вопросы',
        'Заказывать документы',
        'Пользоваться шаблонами ответов',
        'Выкладывать свою практику',
        'и т.д.'
    ];
} else {
    $arResult['modalInfo']['name'] = 'Пользователь';
    $list = [
        'Сменить аватар или поставить фото, что даст Вам узнаваемости',
        'и т.д.'
    ];
}
$arResult['modalInfo']['list'] = array_merge($arResult['modalInfo']['list'],$list);
if (!isset($_SESSION['viewModal'])){
    $_SESSION['viewModal'] = true;
}
if (!isset($_SESSION['statusModal'])){
    $_SESSION['statusModal'] = true;
}

$this->setFrameMode(true);
?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<?php if ($_SESSION['viewModal']):?>

    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Уважаемый <?= $arResult['modalInfo']['name'] ?>!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <img class="col-md-4 d-none d-md-block" src="/local/img/urist.png">
                            <div class="col-md-8">
                                <span class="ulTitle mb-1">После прохождения регистрации, в своем личном кабинете, Вы cможете:</span>
                                <ul>
                                    <? foreach ($arResult['modalInfo']['list'] as $item): ?>
                                        <li><?= $item ?></li>
                                    <? endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row" id="lk" v-cloak>
    <div class="col-md-3">
        <sidebar></sidebar>
        <div class="row">
            <?
            $APPLICATION->IncludeComponent(
                "nirvana:paper",
                ".default",
                Array(
                    'IMG' => true,
                    'IBLOCK_ID' => popular,
                    'IBLOCK_NAME' => 'popular',
                ),
                false
            );
            ?>
        </div>
        <div class="row">
            <?
            $APPLICATION->IncludeComponent(
                "nirvana:paper",
                ".default",
                Array(
                    'IMG' => false,
                    'IBLOCK_ID' => array(vestnik,pravo),
                    'IBLOCK_NAME' => 'vestnik',
                    'ELEM_LIMIT' => 10
                ),
                false
            );
            ?>
        </div>
        <div class="row">
            <?
            $APPLICATION->IncludeComponent(
                "nirvana:paper",
                ".default",
                Array(
                    'IMG' => true,
                    'IBLOCK_ID' => socprogram,
                    'IBLOCK_NAME' => 'socials'
                ),
                false
            );
            ?>
        </div>
    </div>
    <main id="mainText" class="main col-md-9">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <? if ($_SESSION['statusModal']):?>
                    <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">Уважаемый пользователь!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="closeStatusModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </h4>
                        <p>Для смены статуса с пользователя на <b>юриста</b> или <b>адвоката</b>,
                            Вам необходимо, нажать кнопку <a href="/personal/changestatus/" class="btn btn-success">Сменить статус</a>, и заполнить все необходимые поля.</p>
                        <hr>
                        <p class="mb-0">После прохождения модерации Ваш статус будет изменен. Модерация происходит <b>от 1 дня до 3 дней.</b></p>
                    </div>
                    <?endif;?>
                    <div class="header">
                    <!--    <h1 class="header-title">
                            Добро пожаловать {{userInfo.name}} {{userInfo.lastName}}
                        </h1>-->
                    </div>
                    <myquestions></myquestions>
                </div>
            </div>

        </div>
    </main>
</div>
<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
    });
    function openModalInfo(){
        $('#exampleModalLong').modal('show');
    }
    setTimeout(openModalInfo, 5000);
    function closeStatusModal() {
        let str = new FormData();
        str.append('change', 'status');
        axios.post("/local/components/nirvana/sidebar/changeView.php", str)
            .then((response) => {
            })
            .catch((error) => {
                console.log(error);
            });
    }
    function closeModal(){

        let str = new FormData();
        str.append('change', 'main');
        axios.post("/local/components/nirvana/sidebar/changeView.php", str)
            .then((response) => {
                $('#exampleModalLong').modal('hide');
            })
            .catch((error) => {
                console.log(error);
            });
    }
    window.setTimeout(closeModal,15000);
    var app = new Vue({
        el: '#lk',
        data: function () {
            return {
                userInfo: <?=json_encode($arResult['user'])?>,
            }
        },

    })
</script>
    <style>
        .btn_comment.complaincomment{
            display: none;
        }
    </style>
<?php
$_SESSION['viewModal'] = false;
?>