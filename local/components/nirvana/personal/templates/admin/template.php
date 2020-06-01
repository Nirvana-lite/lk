<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$APPLICATION->IncludeComponent(
    "nirvana:sidebar",
    ".default",
    Array(),
    false
);
$APPLICATION->IncludeComponent(
    "nirvana:changeArticle",
    ".default",
    Array(
            'IBLOCK_ID' => popular,
            'ID' => 303142
    ),
    false
);

$this->setFrameMode(true);
?>
<div class="row" id="lk" v-cloak>
    <sidebar :userinfo="userInfo" :sidebar="sideBar"></sidebar>
    <main id="mainText" class="main col-md-9">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Добро пожаловать {{userInfo.name}} {{userInfo.lastName}}
                </h1>
                <p class="header-subtitle">У вас много новых уведомлений</p>
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <changearticle></changearticle>
                </div>
            </div>

        </div>
    </main>
</div>
<script>

    var app = new Vue({
        el: '#lk',
        data: function () {
            return {
                userInfo: <?=json_encode($arResult['user'])?>,
                sideBar: <?=json_encode($arResult['sidebar'])?>
            }
        },

    })
</script>