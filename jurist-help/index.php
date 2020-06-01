<?

use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Консультация онлайн юриста или адвоката");

Asset::getInstance()->addCss("/local/js/globalform/styleform.css");
Asset::getInstance()->addJs("/local/js/globalform/dateform.js");
Asset::getInstance()->addJs("/local/js/globalform/form.js");

?>
<?
/* parser otzivi */
//require_once 'parser_otzivi.php';
?>
<?
session_start();
$min = 80;
$max = 300;
if (isset($_SESSION['cnt_yurist'])) {
    $znak = rand(0, 1);
    if (!$znak) {
        $_SESSION['cnt_yurist'] -= rand(0, 2);
    }
    if ($znak) {
        $_SESSION['cnt_yurist'] += rand(0, 2);
    }
    if ($_SESSION['cnt_yurist'] < $min) {
        $_SESSION['cnt_yurist'] = $min;
    }
    if ($_SESSION['cnt_yurist'] > $max) {
        $_SESSION['cnt_yurist'] = $max;
    }
} else {
    $_SESSION['cnt_yurist'] = rand($min, $max);
}


function textXss($name)
{
    $name = strip_tags($name);
    $name = htmlentities($name, ENT_QUOTES, "UTF-8");
    $name = htmlspecialchars($name, ENT_QUOTES);
    return $name;
}

if ((!empty(trim($_REQUEST['form_title_test']))) || (!empty(trim($_REQUEST['form_textarea_test'])))) {
    $data_form['POST_FORM'] = array(
        'title_form_top' => textXss($_REQUEST['form_title_test']),
        'text_form_top' => textXss($_REQUEST['form_textarea_test'])
    );
}


metatagrazdel(
    'jurist-help', // link
    'Консультация онлайн юриста или адвоката', // title
    'Консультация онлайн юриста или адвоката',//SetTitle
    'задать вопрос юристу, спросить у юриста, помощь юриста, консультация юриста, помощь адвоката, вопрос адвокату, задать вопрос адвокату, защита прав потребителей, помощь автовладельцам, споры с застройщиками, возврат товара, возврат техники, возврат мебели', // tags
    'задать вопрос юристу, спросить у юриста, помощь юриста, консультация юриста, помощь адвоката, вопрос адвокату, задать вопрос адвокату, защита прав потребителей, помощь автовладельцам, споры с застройщиками, возврат товара, возврат техники, возврат мебели', // keywords
    'Консультация онлайн юриста или адвоката Российского Юридического портала jur24pro', // description
    'Задайте свой вопрос акредитованному юристу!' // h1
);
?>
    <style>
        .blocks_znach.element::after {
            content: "\00BB";
            font-size: 200%;
            color: #c0daaf;
        }

        h2.h2_work {
            font-family: Lora, serif;
            text-align: center;
        }

        .fr_work h2, .fr_work h3 {
            font-size: 1.17em;
            margin: 0px 0px 6px 0px;
        }

        .fr_work {
            display: flex;
            justify-content: space-around;
            align-items: center;
            font-family: Lora, serif;
            overflow: hidden;
            flex-wrap: wrap;
        }

        .fr_work > div {
            padding: 0;
        }

        .fr_work .blocks_descrip {
            font-size: 15px;
            line-height: 27px;
        }

        hr.hr_work {
            background: #c0daaf;
            height: 1px;
            border: 0;
        }
        .block_info {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            text-align: center;
            font-family: Lora, serif;
        }
        .block_info .inf > p span {font-weight: bold;font-size: 1.5em;}
        #formio{font-family: Lora, serif;}
    </style>

    <div class="block-shadow">
        <h2 class="h2_work">Как работает Портал?</h2>
        <hr class="hr_work">
        <div class="clearfix fr_work">
            <div class="blocks_znach">
                <h3>Задайте вопрос</h3>
                <div class="blocks_descrip">
                    Мы получаем более 1000<br>
                    вопросов каждый день.<br>
                    Задайте свой!
                </div>
            </div>
            <div class="blocks_znach element"></div>
            <div class="blocks_znach">
                <h3>Получите ответы</h3>
                <div class="blocks_descrip">
                    На вопросы круглосуточно<br>
                    отвечают юристы со всей России.<br>
                    Среднее время ответа — 15 минут.<br>
                </div>
            </div>
            <div class="blocks_znach element"></div>
            <div class="blocks_znach">
                <h3>Проблема решена!</h3>
                <div class="blocks_descrip">
                    97,3% клиентов остаются<br>
                    полностью довольны ответами<br>
                    и рекомендуют нас друзьям.<br>
                </div>
            </div>
        </div>
        <hr class="hr_work">
        <div class="block_info">
            <div class="inf">
                <p><span id="chislo1" class="chislo1">0</span>%</p>
                <p class="des">положительных отзывов</p>
            </div>
            <div class="inf">
                <p><span class="chislo2">0</span> <span>минут</span></p>
                <p class="des">средняя скорость ответа</p>
            </div>
            <div class="inf">
                <p><span class="chislo3">0</span></p>
                <p class="des">юристов сейчас на сайте</p>
            </div>
            <div class="inf">
                <p><span class="chislo4">0</span></p>
                <p class="des">консультаций за сегодня</p>
            </div>
        </div>
    </div>

    <div id="message_zayvka"></div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        $(function () {
            $('.chislo1')
                .animate({number: 97.3}, {
                    duration: 7000,
                    fixed: 1
                });

            $('.chislo2')
                .animate({number: 15}, {
                    duration: 7000,
                });

            $('.chislo3')
                .animate({number: <?=$_SESSION['cnt_yurist']?> }, {
                    duration: 7000,
                });
            $('.chislo4')
                .animate({number: 750}, {
                    duration: 7000,
                });

            $.Tween.propHooks.number = {
                get: function (tween) {
                    var num = tween.elem.innerHTML.replace(/^[^\d-]+/, '');
                    return parseFloat(num) || 0;
                },

                set: function (tween) {
                    var opts = tween.options;
                    tween.elem.innerHTML = (opts.prefix || '')
                        + tween.now.toFixed(opts.fixed || 0)
                        + (opts.postfix || '');
                }
            };

            $('#formio').createformst(
                {
                    sitelink: 'jur24pro.ru',
                    form_title: `<? echo empty($data_form['POST_FORM']['title_form_top']) ? '' : $data_form['POST_FORM']['title_form_top']; ?>`,
                    form_text: `<? echo empty($data_form['POST_FORM']['text_form_top']) ? '' : $data_form['POST_FORM']['text_form_top']; ?>`,
                    linkajax: '/ajax/vopros_site.php',
                    pravilatxt: '<p class="text-pravila">Размещая на сайте вопрос, комментарии, обсуждения, статьи Вы соглашаетесь с <a href="/rules/" target="_blank">Правилами сайта</a> и даёте согласие на обработку персональных данных.</p>'
                }
            );
        });
    </script>


    <div id="formio" class="htmlform"></div>

<? unset($data_form['POST_FORM']); ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>