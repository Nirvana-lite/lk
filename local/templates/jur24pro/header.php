<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html lang="ru-RU" itemscope="" itemtype="http://schema.org/WebPage"
      prefix="og: http://ogp.me/ns# website: http://ogp.me/ns/website# article: http://ogp.me/ns/article# profile: http://ogp.me/ns/profile# fb: http://ogp.me/ns/fb#">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <? /* <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
*/ ?>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="jur24pro">
    <meta name="application-name" content="jur24pro">
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="theme-color" content="#ffffff">


    <title><?php $APPLICATION->ShowTitle(); ?></title>
    <? $APPLICATION->ShowMeta("keywords"); ?>
    <? $APPLICATION->ShowMeta("description"); ?>
    <? $APPLICATION->ShowMeta("robots"); ?>
    <? $APPLICATION->ShowLink("canonical"); ?>
    <? $APPLICATION->SetPageProperty("robots",  'all'); ?>

    <?php $APPLICATION->AddHeadScript('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'); ?>
    <? trim(BitrixSeoTools::showMeta()); ?>

    <? $APPLICATION->ShowHeadStrings(); ?>
    <? $APPLICATION->ShowCSS(); ?>
    <? $APPLICATION->ShowHeadScripts(); ?>



    <?php $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/css/bootstrap-3-grid.css'); ?>

    <?php $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/css/mobmenu.css'); ?>
    <?php $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/css/fixed-menu.css'); ?>

    <?php $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.touchSwipe.min.js'); ?>
    <?php $APPLICATION->AddHeadScript("/local/js/jquery-ias.min.js"); ?>

    <?php $APPLICATION->AddHeadScript("/local/js/timeago/timeago.min.js"); ?>
    <?php $APPLICATION->AddHeadScript("/local/js/timeago/timeago.locales.min.js"); ?>
    <?php $APPLICATION->AddHeadScript("/local/js/jquery-ias.min.js"); ?>
    <?php $APPLICATION->AddHeadScript("/local/js/jquery-ias.min.js"); ?>
    <?php $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/main.js'); ?>
    <?php $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/copyright.min.js'); ?>
    <?php $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/mobmenu.js');?>

    <meta name="wot-verification" content="3eb4e3decdd0f316e98f"/>
    <meta name="google-site-verification" content="BVdBvAAxiQs7BaNrafVUJWecNHK8O0IIWHFOudUK8r4"/>
    <meta name="yandex-verification" content="5f005b355604bd7f"/>
    <? //<meta name="yandex-verification" content="907ed5ca8db2885e" />?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <? /*
      <script src="https://code.jquery.com/jquery-migrate-1.4.1.js"></script>
    <script src="/local/templates/yurlitsa/IE9.js"></script>
    <script src="/local/templates/yurlitsa/IE9-css.js"></script>
*/ ?>
    <!--[if lt IE 9]>

    <![endif]-->
<? /*
     <script src="/local/templates/jur24pro/ie/IE9.js"></script>
    <script src="/local/templates/jur24pro/ie/ie9-css.js"></script>
    <script src="/local/templates/jur24pro/ie/ie9-graphics.js"></script>
    <script src="/local/templates/jur24pro/ie/ie9-html.js"></script>
    <script src="/local/templates/jur24pro/ie/ie9-layout.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    */ ?>
</head>
<body>
<? global $USER;
if ($USER->IsAdmin()) { ?>
    <div id="panel">
        <? $APPLICATION->ShowPanel(); ?>
    </div>
<? } ?>

<?

// черное меню пользователя на весь сайт

if ($USER->IsAuthorized() && !CSite::InDir('/personal/')) {
    $APPLICATION->IncludeComponent(
        "nirvana:sidebar",
        "fixedMenu",
        Array()
    );
}
?>
<header class="box-shadow">
    <div class="container header-bg">
        <div class="row">
            <div class="col-md-7">
                <?if($APPLICATION->GetCurPage() == "/"){?>
                    <h1 class="block-h1">
                        РОССИЙСКИЙ ЮРИДИЧЕСКИЙ ПОРТАЛ
                    </h1>
                <? } else { ?>
                    <span class="block-h1">
                        РОССИЙСКИЙ ЮРИДИЧЕСКИЙ ПОРТАЛ
                    </span>
                <? } ?>
            </div>
            <div class="col-md-5">
                <p class="hot-line">
                    <span class="hot-line__span1">бесплатная горячая линия</span>
                    <span class="hot-line__span2"><a href="tel:+78007773263">8 800 777 32 63</a></span>
                </p>
            </div>
        </div>
    </div>
</header>


<div class="main">
    <div class="container">
        <div class="row">
            <!-- left menu -->
            <?
            if (!CSite::InDir(personalDir)) {
            if ($APPLICATION->arAuthResult) {
                LocalRedirect("/personal/");
            }
            ?>
            <div class="col-md-3 left-menu">
                <? if (!$USER->IsAuthorized()) { ?>
                    <ul class="user-login">

                        <li>
                            <a href="/auth/" class="first">
                                Вход на портал
                            </a>

                            <? $APPLICATION->IncludeComponent(
                                "mycomponents:system.auth.form",
                                "",
                                Array(
                                    "FORGOT_PASSWORD_URL" => "/auth/forget.php",
                                    "PROFILE_URL" => "/personal/", // component add ID user
                                    "REGISTER_URL" => "",
                                    "SHOW_ERRORS" => "Y",
                                    "AUTH_RESULT" => $APPLICATION->arAuthResult
                                )
                            );

                            ?>
                        </li>

                        <li>
                            <a href="/auth/registration.php" class="reg">
                                Регистрация
                            </a>
                            <div class="menu-login-reg">
                                <? $APPLICATION->IncludeComponent(
                                    "mycomponents:main.register",
                                    "",
                                    Array(
                                        "USE_BACKURL" => "Y",
                                        "REQUIRED_FIELDS" => array("NAME", "PASSWORD", "CONFIRM_PASSWORD", "EMAIL"),
                                        "SHOW_FIELDS" => array("NAME", "LAST_NAME", "WORK_COMPANY", "PASSWORD", "CONFIRM_PASSWORD", "EMAIL"),
                                        "USER_PROPERTY" => array(),
                                        "SUCCESS_PAGE" => '/personal/'
                                    ),
                                    false
                                ); ?>
                            </div>
                            <div class="block-soc-menu">
                                <p>Войти через социальные сети</p>
                                <a href="" class="siclog lgsocial-vk"></a>
                                <a href="" class="siclog lgsocial-twitter"></a>
                                <a href="" class="siclog lgsocial-facebook"></a>
                            </div>
                        </li>

                    </ul>
                <? } ?>
                <a href="/subscribe/" class="btn-sub">Подписаться</a>

                <?
                // global menu left

                $APPLICATION->IncludeComponent(
                    "mycomponents:menu",
                    "leftmenu",
                    array(
                        "ROOT_MENU_TYPE" => "top",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "36000000",
                        "CACHE_SELECTED_ITEMS" => "N",
                        "MENU_CACHE_USE_GROUPS" => "N",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MAX_LEVEL" => "2",
                        "CHILD_MENU_TYPE" => "top_podmenu",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_TITLE" => "Разделы"
                    ),
                    false
                ); ?>
            </div>

            <div class="col-md-9 main-page">
                <? get_url_to_id(); ?>
                <?
                if (!CSite::InDir('/jurist-help/index.php')) {
                    $APPLICATION->IncludeFile(
                        "/local/include/form-top.php",
                        Array(),
                        Array("MODE" => "php") // text, html, php
                    );
                }

                $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "mybreadcrumb",
                    Array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "s1"
                    )
                ); ?>



                <? }else{
                ?>
                <div class="col-lg-12">
                    <? } ?>

