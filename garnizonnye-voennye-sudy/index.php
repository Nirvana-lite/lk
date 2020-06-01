<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?
metatagrazdel(
    'garnizonnye-voennye-sudy', // link
    'Гарнизонные военные суды', // title
    '',//SetTitle
    '', // tags
    'гарнизонные, военные, суды', // keywords
    'Гарнизонные военные суды Российской Федерации', // description
    '' // h1
);
?>
<?

$mybr = array(
    array(
        'title' => 'Судебная система Российской Федерации',
        'link' => '/sudy/'
    ),
    array(
        'title' => 'Гарнизонные военные суды',
        'link' => '/garnizonnye-voennye-sudy/'
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
                "IBLOCK_ID" => "59",
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
                "SEF_FOLDER" => "/garnizonnye-voennye-sudy/",
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
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>