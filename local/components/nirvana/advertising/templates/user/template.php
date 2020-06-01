<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {die();}
$this->setFrameMode(true);
?>
<div id="frm"></div>
<div class="card-deck" id="rekChoise">
    <div class="card">
        <div class="card-header">Заявка на размещение рекламы</div>
        <div class="card-body">
            <h5 class="card-title">Размещение рекламы на портале</h5>
            <p class="card-text">Для размещения рекламы на портале Вам необходимо перейти по ссылке ниже</p>
        </div>
        <div class="card-footer">
            <button class="btn btn-sm btn-primary" @click="openForm()">Перейти</button>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Настройка рекламы</div>
        <div class="card-body">
            <h5 class="card-title">Самостоятельная настройка рекламы на портале</h5>
            <p class="card-text">Для самостоятельной настройки и управления рекламной компанией на портале.</p>
        </div>
        <div class="card-footer">
            <button disabled class="btn btn-sm btn-primary">Перейти</button>
<!--            <a href="/reklama/auth/" class="btn btn-sm btn-primary">Перейти</a>-->
        </div>
    </div>
</div>
<script>
    new Vue({
        el:"#rekChoise",
        methods:{
            openForm: function () {
                $.post(
                    "<?=$componentPath?>/getForm.php",
                    onAjaxSuccess
                );

                function onAjaxSuccess(data)
                {
                    $('#rekChoise').remove();
                    $('#frm').html(data);
                }
            }
        }
    })
</script>

