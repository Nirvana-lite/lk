<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent(
    "nirvana:sidebar",
    ".default",
    array(),
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
if (inGroup(1)) {
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
$this->setFrameMode(true);
?>

<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<!-- Modal -->
<?php if ($_SESSION['viewModal']):?>
<!--<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Уважаемый <?/*= $arResult['modalInfo']['name'] */?>!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <img class="col-md-4" src="/local/img/urist.png">
                        <div class="col-md-8">
                            <span class="ulTitle mb-1">После прохождения регистрации, в своем личном кабинете, Вы cможете:</span>
                            <ul>
                                <?/* foreach ($arResult['modalInfo']['list'] as $item): */?>
                                    <li><?/*= $item */?></li>
                                <?/* endforeach; */?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>-->
<?php endif; ?>

<div class="row" id="lk" v-cloak>
    <main id="mainText" class="main col-md-9">
    </main>
    <div class="col-md-3">
        <sidebar></sidebar>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<script>
function closeModal(){

    let str = new FormData();
    str.append('change', 'main');
    axios.post("/local/components/nirvana/sidebar/changeView.php", str)
        .then((response) => {
            $('#exampleModal').modal('hide');
        })
        .catch((error) => {
            console.log(error);
        });
}

$('#exampleModal').modal('show');
window.setTimeout(closeModal,3000);

    var app = new Vue({
        el: '#lk',
        data: function () {
            return {
                userInfo: <?=json_encode($arResult['user'])?>,
            }
        },

    })
</script>
<?php
$_SESSION['viewModal'] = false;
?>