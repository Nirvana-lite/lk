<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$iblock = $arResult['VARIABLES']['IBLOCK_ID'];

?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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
        <div class="container-fluid">
            <div class="row">
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
                }elseif ($iblock === 'loading'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:loading",
                        "",
                        Array()
                    );
                }
                else{}
                ?>
            </div>
        </div>
    </main>
</div>
