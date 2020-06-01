<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

metatagrazdel(
    'home', // link
    'Российский юридический портал - консультация юриста jur24pro.ru', // title
    '',//SetTitle
    '',// tags
    'бесплатная юридическая консультация, бесплатная юридическая линия, юридический форум, юридические новости, популярные юридические темы, российский юридический портал', // keywords
    'Юридический портал осуществляет консультацию граждан в Москве и РФ. У нас ведущие юристы и адвокаты оказывают бесплатную юридическую помощь населению.', // description
    '' // h1
);


?>
    <div class="content-text block-shadow mwork">
        <div class="row">
            <div class="col-md-3">
                <img src="/local/img/icon_mwork/ico1.png" alt="">
                <p>Более 100 тысяч успешных консультаций</p>
            </div>
            <div class="col-md-3">
                <img src="/local/img/icon_mwork/ico2.png" alt="">
                <p>Более 10 лет успешной работы по юриспруденции</p>
            </div>
            <div class="col-md-3">
                <img src="/local/img/icon_mwork/ico3.png" alt="">
                <p>Всегда более 100 юристов онлайн для оказания помощи</p>
            </div>
            <div class="col-md-3">
                <img src="/local/img/icon_mwork/ico4.png" alt="">
                <p>Принимаем заявки и звонки 24 часа в сутки</p>
            </div>
        </div>
    </div>
    <div class="content-text block-shadow index-list-radel">
        <p style="text-align: center; color: #647ea5; font-size: 22px; margin-top: 0;">
            Юридические темы и обсуждения на портале
        </p>
        <div class="row">
                <?php
                // list theme vopros
                    function result23()
                    {

                    if (CModule::IncludeModule('iblock')) {
                        $arFilter = Array(
                            'IBLOCK_ID' => 15,
                            'GLOBAL_ACTIVE' => 'Y');
                        $arSelect = array('ID', 'NAME', 'IBLOCK_ID', 'SECTION_PAGE_URL', 'DEPTH_LEVEL');

                        $res = CIBlockSection::GetTreeList($arFilter, $arSelect);


                        while ($arSection = $res->GetNext()) {
                            $prop_section[] = $arSection['ID'];
                            $name_section[$arSection['ID']] = array($arSection['NAME'], $arSection['SECTION_PAGE_URL']);
                            if ($arSection['DEPTH_LEVEL'] == 1) {
                                $name_section[$arSection['ID']][] = ' class="ind-list iconrzd-' . $arSection['ID'] . '"';
                            }
                        }


                        if ($prop_section) {

                            $slice = floor(count($prop_section) / 2);
                            $prop_section = array_slice($prop_section, 0, $slice);

                            $slice_name = floor(count($name_section) / 2);
                            $name_section = array_slice($name_section, 0, $slice_name, TRUE);

                            array_pop($name_section); // удаляет 31 элемент 62 /2 = 31
                            array_pop($prop_section); // удаляет 31 элемент 62 /2 = 31

                            $sql_union = '';
                            foreach ($prop_section as $key => $item_union) {
                                $sql_union .= ' UNION ALL (SELECT DISTINCT VALUE_ID, UF_SECTION_VOP FROM b_uts_iblock_52_section  WHERE UF_SECTION_VOP=' . $item_union . ' ORDER BY VALUE_ID DESC LIMIT 0,5)';
                            }
                            $sql_union = trim($sql_union, ' UNION ALL ');

                            if (empty($sql_union)) {
                                die();
                            }

                            global $DB;
                            $results_sect = $DB->Query("
                        SELECT DISTINCT BS.NAME AS NAME,
                        BS.ID AS ID,
                        BS.IBLOCK_ID AS IBLOCK_ID,
                        B.SECTION_PAGE_URL AS SECTION_PAGE_URL,
                        BS.CODE AS CODE,
                        B.CODE AS IBLOCK_CODE,
                        BS.GLOBAL_ACTIVE AS GLOBAL_ACTIVE,
                        t2.VALUE_ID AS VALUE_ID,
                        t2.UF_SECTION_VOP AS SECTION_IDP
                        
                        FROM
                        b_iblock_section BS
                        INNER JOIN b_iblock B ON BS.IBLOCK_ID = B.ID
                        INNER JOIN (SELECT VALUE_ID, UF_SECTION_VOP FROM (" . $sql_union . ") t3) t2 on  t2.VALUE_ID = BS.ID
                        WHERE 1=1 AND (BS.IBLOCK_ID = '52') AND (BS.ACTIVE='Y') AND (B.ID = '52')
                    ");

                            $i = 0;
                            while ($row_dt = $results_sect->Fetch()) {
                                $mas2[$row_dt['SECTION_IDP']][$i]['NAME'] = $row_dt['NAME'];
                                $mas2[$row_dt['SECTION_IDP']][$i]['URL'] = '/moskva-th-' . $row_dt['CODE'] . '/';
                                $i++;
                            }

                            $html_ulli = '';


                            foreach ($name_section as $key => $value) {
                                if (isset($value[2])) {
                                    $rzdclass = $value[2];
                                } else {
                                    $rzdclass = '';
                                }
                                $html_ulli .= "<div class='col-sm-4 col-md-4'><h2" . $rzdclass . "><a target='_blank' href='" . $value[1] . "'>" . $value[0] . "</a></h2>";
                                if ($mas2[$key]) {
                                    $html_ulli .= "<ul>";
                                    foreach ($mas2[$key] as $keynm => $value2) {
                                        $html_ulli .= "<li><a target='_blank' href='" . $value2['URL'] . "'>" . $value2['NAME'] . "</a></li>";
                                    }
                                    $html_ulli .= "</ul>";
                                }
                                $html_ulli .= "</div>";
                            }
                            return $html_ulli;
                        }
                    }
                }

                $cachedDatasas = returnResultCache(3600000, 'index_sect_id', 'result23', ''); ?>
                <? echo $cachedDatasas; ?>
        </div>
    </div>
    <div class="content-text block-shadow work-uslug">
        <div class="row">
            <p style="text-align: center; color: #647ea5; font-size: 22px; margin-top: 0;">
                Оказание услуг
            </p>
            <div class="col-md-6">
                <p>Для граждан</p>
                <ul>
                    <li>
                        Адвокат по уголовным делам
                    </li>
                    <li>
                        Семейный адвокат
                    </li>
                    <li>
                        Жилищные споры
                    </li>
                    <li>
                        Адвокат по ДТП
                    </li>
                    <li>
                        Наследственные дела
                    </li>
                    <li>
                        Возмещение ущерба
                    </li>
                    <li>
                        Личный адвокат
                    </li>
                    <li>
                        Адвокат по гражданским делам
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <p>Для компаний</p>
                <ul>
                    <li>
                        Юридическое обслуживание
                    </li>
                    <li>
                        Ведение арбитражных дел
                    </li>
                    <li>
                        Корпоративный юрист
                    </li>
                    <li>
                        Налоговые споры
                    </li>
                    <li>
                        Защита бизнеса
                    </li>
                    <li>
                        Таможенные споры
                    </li>
                    <li>
                        Взыскание долгов
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="content-text block-shadow">
        <p style="text-align: center;color: #647ea5;font-size: 22px;margin-top: 0;">Как оказываются услуги
            юристами и адвокатами</p>
        <div class="line-uslug">
            <div class="br-line top-line">
                <img class="pictures onepictr" src="img/icon_work/man.png" height="64" width="64"/>
                <img class="arrowpictr" src="img/icon_work/next.png"/>
                <div class="text-one">
                    <span class="left-txt">Вы входите на портал<br> с юридическим вопросом</span>
                    <img class="arrow" src="img/icon_work/arrow.png"/>
                    <span class="rigth-txt">Делаете звонок <br> или оставляете заявку</span>
                </div>
                <img class="customer-phone" src="img/icon_work/customer-phone.png"/>
            </div>
            <div class="br-line center-line">
                <img class="arrow" src="img/icon_work/arrow.png"/>
                <div class="text-two">
                    С вами связываются<br> в удобное для Вас время
                </div>
                <img class="hours24" src="img/icon_work/24-hours.png"/>
            </div>
            <div class="br-line bottom-line">
                <img class="conference" src="img/icon_work/conference.png"/>
                <div class="text-three">
                    <span class="left-txt">Осуществляется консультация <br> по юридическому вопросу</span>
                    <img class="arrow" src="img/icon_work/arrow.png"/>
                    <span class="rigth-txt">Получаете результат <br> по своему вопросу</span>
                </div>
                <img class="resultwp" src="img/icon_work/businessman.png"/>
            </div>
        </div>
        <!-- <div class="testst">
             <div class="wrapper">
                 <div class="one"></div>
                 <div class="two"></div>
                 <div class="three"></div>
                 <div class="circle-right1"></div>
                 <div class="circle-right2"></div>
                 <div class="circle-left1"></div>
                 <div class="circle-left2"></div>
             </div>
         </div>-->
    </div>
    <div class="content-text block-shadow">
        <p>Консультация юриста – Российский Юридический Портал</p>
        <p>Российский Юридический Портал – создан как информационная платформа по правовым вопросам для всех
            слоев населения, для максимального удобства граждан по получению правовой помощи от юристов и
            адвокатов со всей России. Большое количество юристов и адвокатов, зарегистрированных на портале,
            дает возможность максимально быстро получить ответ на вопрос, ознакомиться с публикуемыми
            материалами, изменением законодательства, а также найти нужную юридическую информацию, которая
            требуется всем. Удобства разделов портала сделаны так, что бы каждый мог пользоваться
            сервисами:</p>
        <ul class="hanbs">
            <li>Бесплатная юридическая консультация</li>
            <li>Бесплатная юридическая линия 8-800-777-32-63 которая работает на всей территории России</li>
            <li>Максимально быстрые и развернутые ответы юристов и адвокатов</li>
            <li>Перечень государственных органов России</li>
            <li>Перечень судов России (с адресами и подробной информацией)</li>
            <li>Юридический форум (для обсуждения насыщенных проблем и ситуаций)</li>
            <li>Юридические новости</li>
            <li>Популярные юридические темы (для подробного ознакомления и разъяснения)</li>
        </ul>
        <p>У каждого из нас есть в жизни ситуации, когда требуется помощь юриста и адвоката и без помощи
            юриста и адвоката данные вопросы просто невозможно разрешить. Консультация юриста на Российском
            Юридическом Портале осуществляется на бесплатной основе. Бесплатная юридическая онлайн
            консультация, помогает гражданам своевременно разрешать свои жизненные ситуации. В многих
            случаях платные консультации берут деньги с граждан без основательно с одним лишь умыслом
            обогатиться. Бесплатная юридическая онлайн консультация, дает возможность понять человеку, нужна
            ли ему вообще практическая помощь юриста или адвоката и максимально сэкономить время, которое
            может быть потрачено в пустую на платной юридической консультации которая может обернуться
            простой потерей времени.</p>
        <p>Консультация юриста на портале осуществляется по всем отраслям права и на всей территории России,
            не зависимо от статуса человека, его семейного положения или финансовой подоплеки. Юристы на
            портале оказывают консультации как:</p>
        <p>По телефону бесплатной горячей юридической линии 8-800-777-32-63</p>
        <p>Что бы получить консультацию юриста или адвоката, достаточно позвонить по бесплатному номеру
            телефона или оставить информационную заявку с юридическим вопросом в информационном поле,
            которое для удобства выдвигается на самом портале с нижней части экрана, с правой стороны экрана
            и посередине экрана всех разделов портала. Данные поля выдвигаются для максимального удобства,
            что бы любой желающий не искал на портале где ему оставить свой юридический вопрос, а просто
            войти в информационный блок, написать свой вопрос и нажать кнопку отправить.</p>
        <p>Юридическая консультация на портале за время существования помогла тысячам людей своевременно
            получить ответ на вопрос который был задан на портале. Адвокаты и юристы, кто зарегистрирован на
            портале оказывают бесплатную юридическую консультацию ежедневно, без праздников и выходных и
            связано это с тем, что большое количество юристов и адвокатов кто отвечает на вопросы,
            осуществляют юридическую консультацию, позволяет охватить все уголки России.</p>
        <p>Юридическая консультация на портале позволяет всем своевременно подготовить грамотно обоснованные
            жалобы, заявления, исковые заявления, кассационные жалобы, апелляционные жалобы и другие
            документы, а так же позволяет подготовиться к последствиям и действиям при подаче
            документов.</p>
        <hr>
        <p>
            <strong>Российский Юридический Портал</strong> - это одна из крупнейших информационных платформ
            по предоставлению онлайн консультаций юристов и адвокатов России.
        </p>
        <p>
            <strong>Российский Юридический Портал</strong>, создан для повышения юридической грамотности и
            предоставления юридических консультаций гражданам.
        </p>
        <p>
            Количество юристов и адвокатов, зарегистрированных на портале ежедневно растет, что позволяет
            разносторонне и оперативно отвечать на вопросы пользователей, которым требуется срочная
            юридическая помощь.
        </p>
        <p>
            Консультация предоставляются круглосуточно. Любой желающий может задать вопрос юристу или
            адвокату в любое время суток и получить ответ на интересующий юридический вопрос.
        </p>
        <p>
            На сайте, собрано большое количество правовых материалов, статей, новостей, юридических вопросов
            и ответов на форуме.
        </p>
        <p>
            Объединение большого количества юристов и адвокатов в одном месте, позволило добиться того, что
            любой желающий максимально быстро и своевременно получает ответы на свои вопросы, как в
            электронном виде, в виде ответов на сайте, так и устно по телефону бесплатной горячей
            круглосуточной юридической линии: <strong>8-800-777-32-63.</strong>
        </p>
    </div>
    <div class="content-text block-shadow jur-help">
        <h2>Что дает юридическая помощь?</h2>
        <div class="row">
            <div class="col-md-4">
                <p class="procent">100%</p>
                <div class="arrow-4">
                    <span class="arrow-4-left"></span>
                    <span class="arrow-4-right"></span>
                </div>
                <p>Всем кто обратился была оказана юридическая консультация и помощь</p>
            </div>
            <div class="col-md-4">
                <p class="procent">87%</p>
                <div class="arrow-4">
                    <span class="arrow-4-left"></span>
                    <span class="arrow-4-right"></span>
                </div>
                <p>Всех юридических вопросов разрешилось в досудебном порядке, после консультации
                    обратившиеся решали вопросы самостоятельно</p>
            </div>
            <div class="col-md-4">
                <p class="procent">63%</p>
                <div class="arrow-4">
                    <span class="arrow-4-left"></span>
                    <span class="arrow-4-right"></span>
                </div>
                <p>Юридических вопросов разрешалось всего лишь при помощи подготовки документов или
                    консультации юриста</p>
            </div>
        </div>
    </div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>