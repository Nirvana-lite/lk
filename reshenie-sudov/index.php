<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

if(!CModule::IncludeModule("iblock")){die();}

// редирект с id на code
$page = $APPLICATION->GetCurPage(false);
$page = strtok($page, '?');

$page_array = explode('/',parse_url($page,PHP_URL_PATH));
$page_array = array_diff($page_array, array(''));

$id_url = end($page_array);

if( count($page_array) == 2 ){

    $id_url = end($page_array);


    if( ctype_digit($id_url) ){ // состоит из цифр

        $res = CIBlockElement::GetByID(intval($id_url));
        if($ar_res = $res->Fetch()){
            if(trim($ar_res['LIST_PAGE_URL'], '/') != 'reshenie-sudov'){
                show404();
            }else {
                LocalRedirect($ar_res['LIST_PAGE_URL'] . $ar_res['CODE'] . '/', false,'301 Moved permanently');
            }
        } else{
            show404();
        }


    } else { // состоит из цифр и слов

    }
}



metatagrazdel(
    'reshenie-sudov', // link
    'Гражданские дела и уголовное делопроизводство', // title
    '',//SetTitle
    '', // tags
    'гражданские дела, уголовное делопроизводство', // keywords
    'Гражданские дела и уголовное делопроизводство в Российской Федерации', // description
    'Гражданские дела и уголовное делопроизводство' // h1
);
?>

    <div class="in_reshenie-sudov clearfix block-shadow">
        <div class="col-md-6 col-xs-12">
            <a target="_blank" href="/reshenie-sudov/">Гражданские дела</a>
        </div>
        <div class="col-md-6 col-xs-12">
            <a target="_blank" href="/ugolovnye-dela/">Уголовные дела</a>
        </div>
        <div class="col-md-6 col-xs-12">
            <a target="_blank" href="/dela-ob-administrativnykh-pravonarusheniyakh/">
                Дела об административных правонарушениях
            </a>
        </div>
        <div class="col-md-6 col-xs-12">
            <a target="_blank" href="/proizvodstvo-po-materialam/">
                Производство по материалам
            </a>
        </div>
    </div>

    <div class="content-text">
        <?
        $APPLICATION->IncludeComponent(
            "mycomponents:news",
            "reshenie_sudov",
            array(
                "LIST_TEMPLATE" => 'list_rechenie',
                "ADD_ELEMENT_CHAIN" => "N",
                "ADD_SECTIONS_CHAIN" => "Y",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "BROWSER_TITLE" => "-",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "N",
                "CACHE_TIME" => "31536001",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "N",
                "COMPONENT_TEMPLATE" => "reshenie_sudov",
                "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
                "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
                "DETAIL_DISPLAY_TOP_PAGER" => "N",
                "DETAIL_FIELD_CODE" => '',
                "DETAIL_PAGER_SHOW_ALL" => "N",
                "DETAIL_PAGER_TEMPLATE" => "",
                "DETAIL_PAGER_TITLE" => "Страница",
                "DETAIL_PROPERTY_CODE" => array(
                    0 => "VID_DOCK",
                    1 => "DATE_DOCK",
                    2 => "INSTANTION_DOCK",
                    3 => "ISTEC_DOCK",
                    4 => "NUM_DOCK",
                    5 => "OTVETCHIK_DOCK",
                    6 => "REGION_DOCK",
                    7 => "LAW_DOCK",
                    8 => "LAWUER_DOCK",
                ),
                "DETAIL_SET_CANONICAL_URL" => "Y",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "33",
                "IBLOCK_TYPE" => "resolution_law",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
                "LIST_FIELD_CODE" => '',
                "LIST_PROPERTY_CODE" => array(
                    0 => "VID_DOKUMENTA",
                    1 => "SUBIEKT",
                    2 => "NAIMEN_SUDA",
                    3 => "SUDIA",
                ),
                "MESSAGE_404" => "",
                "META_DESCRIPTION" => "-",
                "META_KEYWORDS" => "-",
                "NEWS_COUNT" => "10",
                "NUM_DAYS" => "5",
                "NUM_NEWS" => "20",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "3600",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => "round",
                "PAGER_TITLE" => "Новости",
                "PREVIEW_TRUNCATE_LEN" => "",
                "SEF_FOLDER" => "/reshenie-sudov/",
                "SEF_MODE" => "Y",
                "SET_LAST_MODIFIED" => "Y",
                "SET_STATUS_404" => "Y",
                "SET_TITLE" => "Y",
                "SHOW_404" => "Y",
                "SORT_BY1" => "",
                "USE_CATEGORIES" => "N",
                "USE_FILTER" => "N",
                "USE_PERMISSIONS" => "N",
                "USE_RATING" => "N",
                "USE_REVIEW" => "N",
                "USE_RSS" => "N",
                "USE_SEARCH" => "N",
                "USE_SHARE" => "N",
                "YANDEX" => "Y",
                "FILE_404" => "/404.php",
                "SORT_ORDER1" => "DESC",
                "SORT_BY2" => "SORT",
                "SORT_ORDER2" => "ASC",
                "SHARE_HIDE" => "N",
                "SHARE_TEMPLATE" => "",
                "SHARE_HANDLERS" => '',
                "SHARE_SHORTEN_URL_LOGIN" => "",
                "SHARE_SHORTEN_URL_KEY" => "",
                "STRICT_SECTION_CHECK" => "N",
                "SEF_URL_TEMPLATES" => array(
                    "news" => "",
                    "section" => "",
                    "detail" => "#ELEMENT_CODE#/",
                )
            ),
            false
        );
?>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>