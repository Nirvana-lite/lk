<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$iblock = $arResult['VARIABLES']['IBLOCK_ID'];
if (!isset($_SESSION['statusModal'])){
    $_SESSION['statusModal'] = true;
}
?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<div class="row">
    <?
    $APPLICATION->IncludeComponent(
        "nirvana:sidebar",
        "notMain",
        Array(),
        false
    );
    ?>
    <main id="mainText" class="main col-md-9">
        <?php if ($_SESSION['statusModal']):?>
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
                <?
                if ($iblock === 'popular'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:articles",
                        "",
                        Array("ARTICLES" => intval(popular))
                    );
                }elseif ($iblock === 'vestnik'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:articles",
                        "",
                        Array("ARTICLES" => intval(vestnik))
                    );
                }elseif ($iblock === 'pravo'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:articles",
                        "",
                        Array("ARTICLES" => intval(pravo))
                    );
                }elseif ($iblock === 'socprogram'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:articles",
                        "",
                        Array("ARTICLES" => intval(socprogram))
                    );
                }elseif ($iblock === 'setting'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:setting",
                        "",
                        Array()
                    );
                }elseif ($iblock === 'questions'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:questionsList",
                        "",
                        Array()
                    );
                }elseif ($iblock === 'support'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:adminMail",
                        "",
                        Array()
                    );
                }elseif ($iblock === 'sentence'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:adminMail",
                        "",
                        Array("METHOD" => 1)
                    );
                }elseif ($iblock === 'project-news'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:project-news",
                        "",
                        Array()
                    );
                }
                elseif ($iblock === 'changestatus'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:change.status",
                        "",
                        Array()
                    );
                }
                elseif ($iblock === 'loading'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:loading",
                        "",
                        Array()
                    );
                }
                else{}
                ?>

    </main>
</div>
<script>
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
</script>