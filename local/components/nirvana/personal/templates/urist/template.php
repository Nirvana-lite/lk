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

$this->setFrameMode(true);
?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<div class="row" id="lk" v-cloak>
    <sidebar :userinfo="userInfo" :sidebar="sideBar"></sidebar>
    <main id="mainText" class="main col-md-9">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-9">
                    <div class="header">
                        <h1 class="header-title">
                            Добро пожаловать {{userInfo.name}} {{userInfo.lastName}}
                        </h1>
                    </div>
                    <myquestions></myquestions>
                </div>
                <div class="col-12 col-md-3">
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