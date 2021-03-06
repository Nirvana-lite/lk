<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?
metatagrazdel(
    'konstitutsionnye-sudy', // link
    'Конституционные и Уставные суды в Российской Федерации', // title
    '',//SetTitle
    '', // tags
    'конституционный суд, конституционные суды рф, адрес конституционного суда', // keywords
    'Конституционные и Уставные суды в Российской Федерации. Всё о судах', // description
    'Конституционные и Уставные суды в Российской Федерации' // h1
);
?>
<?

$mybr = array(
        array(
                'title' => 'Судебная система Российской Федерации',
                'link' => '/sudy/'
        ),
        array(
                'title' => 'Конституционные и Уставные суды в Российской Федерации',
                'link' => '/konstitutsionnye-sudy/'
        )
);

my_create_breadcrums($mybr);

?>

    <div class="content-text">
        <? $APPLICATION->IncludeComponent(
            "mycomponents:news",
            "defaul_page",
            array(
                "ADD_ELEMENT_CHAIN" => "N",
                "ADD_SECTIONS_CHAIN" => "Y",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "BROWSER_TITLE" => "-",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
                "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
                "DETAIL_DISPLAY_TOP_PAGER" => "N",
                "DETAIL_FIELD_CODE" => array(
                    0 => "DETAIL_TEXT",
                    1 => "",
                ),
                "DETAIL_PAGER_SHOW_ALL" => "Y",
                "DETAIL_PAGER_TEMPLATE" => "",
                "DETAIL_PAGER_TITLE" => "Страница",
                "DETAIL_PROPERTY_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "DETAIL_SET_CANONICAL_URL" => "Y",
                "DETAIL_TEMPLATE" => "detail_drugie_sudy",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "N",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FILE_404" => "/404.php",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "54",
                "IBLOCK_TYPE" => "all_sudy",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
                "LIST_FIELD_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "LIST_PROPERTY_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "LIST_TEMPLATE" => "list_drugie_sudy",
                "MESSAGE_404" => "",
                "META_DESCRIPTION" => "-",
                "META_KEYWORDS" => "-",
                "NEWS_COUNT" => 500,
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "3600",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PREVIEW_TRUNCATE_LEN" => "",
                "SEF_FOLDER" => "/konstitutsionnye-sudy/",
                "SEF_MODE" => "Y",
                "SET_LAST_MODIFIED" => "N",
                "SET_STATUS_404" => "Y",
                "SET_TITLE" => "Y",
                "SHOW_404" => "Y",
                "SHOW_DOP_LIST" => true,
                "SORT_BY1" => "ID",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "Y",
                "USE_CATEGORIES" => "N",
                "USE_FILTER" => "N",
                "USE_PERMISSIONS" => "N",
                "USE_RATING" => "N",
                "USE_REVIEW" => "N",
                "USE_RSS" => "N",
                "USE_SEARCH" => "N",
                "USE_SHARE" => "N",
                "COMPONENT_TEMPLATE" => "defaul_page",
                "SEF_URL_TEMPLATES" => array(
                    "news" => "",
                    "section" => "",
                    "detail" => "#ELEMENT_CODE#/",
                )
            ),
            false
        ); ?>
    </div>

<? if ($APPLICATION->GetCurDir() == "/konstitutsionnye-sudy/") { ?>
    <div class="content-text block-shadow">
        <p>
            <strong>Конституционный Суд Республики в составе Российской Федерации</strong> — судебный орган
            конституционного контроля, самостоятельно и независимо осуществляющий судебную власть посредством
            конституционного судопроизводства. Полномочия, порядок формирования и деятельности Конституционных Судов
            Республик определяются Конституцией Республики и Законом Республики&nbsp; «О Конституционном Суде
            Республики».
        </p>
        <p>
            Конституционные Суды Республик состоит из судей, назначаемых на должность Законодательным Собранием
            Республик по представлению Глав Республик. Свои полномочия Конституционный Суд Республики вправе
            осуществлять в составе не менее трех судей. Полномочия судьи Конституционного Суда Республики не ограничены
            определенным сроком.
        </p>
        <p>
            Конституционный Суд Республики разрешает дела в открытых судебных заседаниях. Проведение закрытых судебных
            заседаний допускается лишь в случаях, предусмотренных федеральным законом.
        </p>
        <p>
            Поводом к рассмотрению дела является обращение в Конституционный Суд Республики. Обращение направляется в
            Конституционный Суд в письменном виде и подписывается заявителем (заявителями) или уполномоченным лицом и
            должно соответствовать требованиям, установленным Законом Республики.
        </p>
        <p>
            Правом на обращение в Конституционный Суд Республики обладают Глава Республики, Законодательное Собрание
            Республики, депутаты Законодательного Собрания Республики Карелия, прокурор Республики Карелия,
            Уполномоченный по правам человека Республики Карелия, органы местного самоуправления, общественные
            объединения, юридические лица и граждане.
        </p>
        <p>
            <strong>Основаниями к рассмотрению дела</strong> являются обнаружившаяся неопределенность в вопросе о том,
            соответствует ли Конституции Республики тот или иной Закон Республики, нормативные правовые акты (или их
            отдельные положения) Законодательного Собрания Республики, Главы Республики, Правительства Республики, иных
            органов исполнительной власти Республики, уставы муниципальных образований, нормативные правовые акты (их
            отдельные положения) органов местного самоуправления и их должностных лиц, а также обнаружившаяся
            неопределенность в понимании положений Конституции Республики.
        </p>
        <p>
            Законы Республик «О Конституционном Суде Республики» устанавливают порядок распределения поступающих в суд
            обращений, порядок определения очередности рассмотрения дел, особенности делопроизводства в Конституционном
            Суде, а некоторые правила процедуры и этикета в заседаниях и иные вопросы внутренней деятельности
            Конституционного Суда устанавливаются Регламентом Конституционного Суда Республики, который принимается
            решением собрания судей Конституционного Суда Республики.
        </p>
        <p>
            С целью оказания научного содействия Конституционному Суду Республики в осуществлении задач, определенных
            Законом Республики «О Конституционном Суде Республики», и разработки научно обоснованных рекомендаций по
            вопросам судебной практики созданы научно-консультативные советы, которые являются совещательными органами
            при Конституционных Судах Республик.
        </p>
        <p>
            <strong>Уставные Суды в России</strong> являются судебными органами государственной власти в субъектах
            Российской
            Федерации. Уставные Суды входят в единую судебную систему Российской Федерации. Уставные Суды созданы на
            основании Федерального конституционного Закона от 31 декабря 1996 года № 1-ФЗ «О судебной системе Российской
            Федерации», Уставов (Основных Законов)&nbsp; субъектов России. Уставные Суды состоят из судей, назначаемых
            на должность Думой.
        </p>
        <p>
            <strong>Срок полномочий судьи - 12 лет.</strong> Свои полномочия Уставные Суды вправе осуществлять в составе
            не менее
            трех судей. Уставные Суды разрешают дела в открытых судебных заседаниях. Проведение закрытых судебных
            заседаний допускается лишь в случаях, предусмотренных федеральным законом.
        </p>
        <p>
            Уставный Суд разрешает дела о соответствии Уставу (Основному Закону) области иных областных законов,
            нормативных правовых актов Губернатора, Правительства области, областной Думы, органов местного
            самоуправления муниципальных образований. Кроме того, Уставный суд осуществляет официальное толкование
            Устава области, разрешает споры о компетенции между органами государственной власти и органами местного
            самоуправления, дает заключение о соответствии Уставу области вопроса, выносимого на областной референдум.
        </p>
        <p>
            Поводом к рассмотрению дела является обращение в Уставный Суд. Обращение направляется в Уставный Суд в
            письменном виде и подписывается заявителем (заявителями) или уполномоченным лицом и должно соответствовать
            требованиям Закона «Об Уставном Суде».
        </p>
        <p>
            Правом на обращение в Уставный Суд обладают Губернатор области, областная Дума, Правительство области,
            каждый депутат областной Думы, прокурор области, уполномоченный по правам человека в области, избирательная
            комиссия области, ассоциация муниципальных образований области, областной суд, арбитражный суд области,
            нотариальная палата, органы местного самоуправления, группа депутатов представительного органа местного
            самоуправления численностью не менее пяти человек, граждане, включая иностранных граждан и лиц без
            гражданства, объединения граждан.
        </p>
        <p>
            При обращении в Уставный Суд граждан об обжаловании нормативных правовых актов, изданных органом
            государственной власти, органом местного самоуправления, в указанном обращении в обязательном порядке должны
            содержаться сведения о том, какие права граждан и каким образом права нарушены обжалуемым нормативным
            правовым актом.
        </p>
    </div>
<? } ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>