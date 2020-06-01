<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();
?>
</div>
</div>
</div>
</div>

<?
if (!CSite::InDir('/jurist-help/index.php')) {
    $APPLICATION->IncludeFile(
        "/local/include/form-bottom.php",
        Array(),
        Array("MODE" => "php") // text, html, php
    );
} ?>

<div class="scroll_top" onclick="ScrollTop(this); return false;">&#8593;</div>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul class="footer-list-centeron">
                    <li><a target="_blank" href="/vestnik-jur-portala/">Вестник Российского Юридического портала</a></li>
                    <li><a target="_blank" href="/pravo-i-protsess/">Право и процесс</a></li>
                    <li><a target="_blank" href="/sotsialnye-programmy/">Социальные проекты, программы,предложения, обсуждение
                            законопроектов, комментарии</a>
                    </li>
                    <li><a target="_blank" href="/reshenie-sudov/">Решения, приговоры, постонавления, определения судов Российской
                            Федерации</a></li>
                    <li><a target="_blank" href="/koloniya/">Все колонии, СИЗО, Тюрьмы, ИК, Зоны, КП Российской Федерации</a></li>
                    <li><a target="_blank" href="/broker-and-brokers-company/">Список Брокеров и брокерских компаний Российской
                            Федерации</a></li>

                </ul>
            </div>
            <div class="col-md-3">
                <ul>
                    <li><a target="_blank" href="/news/">Новости</a></li>
                    <li><a target="_blank" href="/forum/">Форум</a></li>
                    <li><a target="_blank" href="/sudy/">Суды</a></li>
                    <li><a target="_blank" href="/zakony/">Законы</a></li>
                    <li><a target="_blank" href="/gosorgany/">Госорганы</a></li>
                    <li><a target="_blank" href="/voprosy-yuristu/">Вопросы и Ответы</a></li>
                    <li><a target="_blank" href="/populyarnye-temy/">Популярные темы</a></li>
                    <li><a target="_blank" href="/yuristy-i-advokaty/">Юристы и адвокаты</a></li>
                    <li><a target="_blank" href="/obraztsy-dokumentov/">Документы</a></li>
                    <li><a target="_blank" href="/reestr-kpk/">Список КПК Российской Федерации</a></li>
                    <li><a target="_blank" href="/reestr-mfo/">Список МФО Российской Федерации</a></li>
                    <li><a target="_blank" href="/discussions/">Дискуссии</a></li>
                    <li><a target="_blank" href="/reklama/">Реклама</a></li>
                    <li><a target="_blank" href="/subscribe/">Подписка</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="footer-list-centertw">
                    <li>
                        <span class="footer-icon bg-vopros"></span>
                        <a target="_blank" href="/jurist-help/">Задать вопрос</a>
                    </li>
                    <li>
                        <span class="footer-icon bg-24_hours"></span>
                        <a target="_blank" href="">Заказать звонок</a>
                    </li>
                    <li>
                        <span class="footer-icon bg-contract"></span>
                        <a target="_blank" href="">Заказать документ</a>
                    </li>
                    <li>
                        <span class="footer-icon bg-insurance"></span>
                        <a target="_blank" href="">Заказать услугу</a>
                    </li>
                    <li>
                        <span class="footer-icon bg-conversation"></span>
                        <a target="_blank" href="">Частые вопросы</a>
                    </li>
                    <li>
                        <span class="footer-icon bg-commetns_prev"></span>
                        <a target="_blank" href="">Отзывы</a>
                    </li>
                    <li>
                        <span class="footer-icon bg-favoritesstar"></span>
                        <a target="_blank" href="/theme/">Актуальные темы и вопросы</a>
                    </li>
                    <li>
                        <span class="footer-icon bg-court-hammer"></span>
                        <a target="_blank" href="/advokaty/">Реестр адвокатов</a>
                    </li>
                    <li>
                        <span class="footer-icon bg-team"></span>
                        <a target="_blank" href="/notariusy/">Реестр Нотариусов</a>
                    </li>

                </ul>
            </div>
            <div class="col-md-3">
                <ul class="footer-list-rigth">
                    <li>
                        <span class="footer-icon bg-avatar"></span>
                        <a target="_blank" href="/auth/">Войти на портал</a></li>
                    <li>
                        <span class="footer-icon bg-bus_arrow"></span>
                        <a target="_blank" href="/auth/registration.php">Регистрация на портале</a></li>
                    <li>
                        <span class="footer-icon bg-placeholder"></span>
                        <a target="_blank" href="/contacts/">Контакты</a>
                    </li>
                    <li>
                        <span class="footer-icon bg-rules"></span>
                        <a target="_blank" href="/rules/">Пользовательское соглашение, правила и политика конфиденциальности</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-12">
                <!-- social network -->
                <div class="block-footer-social">
                    <div class="row margin-none">
                        <div class="col-md-6">
                            <h2>
                                <span class="footer-icon bg-users_icon"></span>
                                Мы в социальных сетях
                            </h2>
                        </div>
                        <div class="col-md-6">
                            <ul class="footer-social">
                                <li>
                                    <span class="icon-social bg-vk"></span>
                                </li>
                                <li>
                                    <span class="icon-social bg-odnoklassniki"></span>
                                </li>
                                <li>
                                    <span class="icon-social bg-facebook"></span>
                                </li>
                                <li>
                                    <span class="icon-social bg-twitter"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="techno-help">
                    <div class="row margin-none">
                        <div class="col-md-6">
                            <h2>
                                <span class="footer-icon bg-gear_icon"></span>
                                Техническая поддержка
                            </h2>
                        </div>
                        <div class="col-md-6">
                            <ul class="footer-phonemail">
                                <li>
                                    <span class="footer-icon bg-phone_symbol"></span>
                                    8 800 777 32 63
                                </li>
                                <li>
                                    <span class="footer-icon bg-opened_email"></span>
                                    support@jur24pro.ru
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="copyrigth-bottom-footer clearfix">
                    <span class="footer-icon bg-user_info_icon"></span>
                    <p>
                        Копирование материалов с Российского юридического портала (www.jur24pro.ru) допускается с
                        разрешения
                        администрации портала. Каждый скопированный материал должен сопровождаться прямой ссылкой на
                        источник www.jur24pro.ru и корректным указанием имени автора материала (юриста, адвоката). Любое
                        коммерческое использование материалов и публикаций в печатных изданиях допускается только с
                        письменного согласия администрации www.jur24pro.ru Всю ответственность за размещаемые материалы
                        и содержащиеся в них сведения несут их авторы – зарегистрированные на сайте пользователи. На
                        портале могут использоваться материалы 18+, а так же изображения и описание курения и табачной
                        продукции, алкогольной продукции и иных действующих веществ на организм человека. Мы не
                        рекомендуем к просмотру таких материалов лицам не достигшим 18 лет.
                    </p>
                    <p>
                        © www.jur24pro.ru <?=date('Y')?>
                    </p>
                </div>
            </div>

        </div>
    </div>

</div>
<?
global $APPLICATION;

if (!CSite::InDir('/content/')) { /*?>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter40376935 = new Ya.Metrika({ id:40376935, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/40376935" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
    <script src="<?=SITE_TEMPLATE_PATH?>/js/copyright.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113545900-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-113545900-1');
    </script>
<? */
} ?>
<!-- Yandex.Metrika counter --> <script> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter40907449 = new Ya.Metrika({ id:40907449, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/40907449" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<!-- Rating@Mail.ru counter --> <script>
    var _tmr = window._tmr || (window._tmr = []);
    _tmr.push({id: "2761841", type: "pageView", start: (new Date()).getTime()});
    (function (d, w, id) {
        if (d.getElementById(id)) return;
        var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
        ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
        var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
        if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
    })(document, window, "topmailru-code");
</script> <!-- //Rating@Mail.ru counter -->
<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Organization",
  "name" : "Российский юридический портал",
  "url" : "http://jur24pro.ru",
  "sameAs" : [
    "https://www.facebook.com/jur24pro.ru",
    "https://vk.com/jur24pro",
    "http://jur24pro-ru.livejournal.com"
  ]
}
</script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script src="https://www.googletagmanager.com/gtag/js?id=UA-102569414-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-102569414-1');
    </script>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1252327708146186',
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

</body>

<? if (!CSite::InDir('/content/')) { ?>

    <script>
         $(function() {
             $('body').copyright ({
                 extratxt: 'Источник: %link% &copy; %source%',
                 sourcetxt: 'jur24pro.ru',
                 length : 1,
                 hide: false
             });
         });
    </script>
<? } ?>
<!-- CLEANTALK template addon -->
<?php \Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("area"); if(CModule::IncludeModule("cleantalk.antispam")) echo CleantalkAntispam::FormAddon(); \Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("area", "Loading..."); ?>
<!-- /CLEANTALK template addon -->
</html>