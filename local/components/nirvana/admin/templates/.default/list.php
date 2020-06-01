<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$iblock = $arResult['VARIABLES']['IBLOCK_ID'];

?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<div class="row">
    <main id="mainText" class="main col-md-9">
        <div class="container-fluid">
            <div class="row">
                <?
                if ($iblock === 'popular'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:articles",
                        "admin",
                        Array("ARTICLES" => intval(popular))
                    );
                }elseif ($iblock === 'vestnik'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:articles",
                        "admin",
                        Array("ARTICLES" => intval(vestnik))
                    );
                }elseif ($iblock === 'pravo'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:articles",
                        "admin",
                        Array("ARTICLES" => intval(pravo))
                    );
                }elseif ($iblock === 'socprogram'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:articles",
                        "admin",
                        Array("ARTICLES" => intval(socprogram))
                    );
                }elseif ($iblock === 'news'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:articles",
                        "admin",
                        Array("ARTICLES" => intval(2))
                    );
                }
                elseif ($iblock === 'setting'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:setting",
                        "",
                        Array()
                    );
                }elseif ($iblock === 'questions'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:answers",
                        "",
                        Array(
                                'QUESTIONS_ID' => 15,
                                'ANSWERS_ID' => 18
                        )
                    );

                }elseif ($iblock === 'allquestions'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:answers",
                        "",
                        Array(
                            'QUESTIONS_ID' => 15,
                            'ANSWERS_ID' => 18,
                            'ALL' => true
                        )
                    );

                }elseif ($iblock === 'comments'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:comments",
                        "",
                        Array(
                            'QUESTIONS_ID' => 15,
                            'ANSWERS_ID' => 18
                        )
                    );

                }
                elseif ($iblock === 'themes'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:themes",
                        "",
                        Array()
                    );
                }
                elseif ($iblock === 'support'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:adminMail",
                        "",
                        Array()
                    );
                }
                elseif ($iblock === 'sentence'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:adminMail",
                        "",
                        Array("METHOD" => 1)
                    );
                }
                elseif ($iblock === 'applications'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:applications",
                        "",
                        Array()
                    );
                }
                elseif ($iblock === 'project-news'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:project-news",
                        "",
                        Array()
                    );
                }
                elseif ($iblock === 'user-check'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:user-check",
                        "",
                        Array()
                    );
                }
                elseif ($iblock === 'complaint'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:complaint",
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
                elseif ($iblock === 'subs'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:subs.list",
                        "",
                        Array()
                    );
                }
                elseif ($iblock === 'test'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:advertising.main",
                        "",
                        Array('VIEW'=> '.default')
                    );
                }
                elseif ($iblock === 'advertising'){
                    $APPLICATION->IncludeComponent(
                        "nirvana:advertising",
                        "admin",
                        Array('ADMIN'=> 'Y')
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
            </div>
        </div>
    </main>
    <?
    $APPLICATION->IncludeComponent(
        "nirvana:sidebar",
        "notMain",
        Array(),
        false
    );
    ?>
</div>
