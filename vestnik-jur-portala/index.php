<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

metatagrazdel(
    'vestnik-jur-portala', // link
    'Вестник Российского Юридического Портала', // title
    'Вестник Российского Юридического Портала',//SetTitle
    '', // tags
    '', // keywords
    'Вестник Российского Юридического Портала jur24pro', // description
    'Вестник Российского Юридического Портала' // h1
);
?>
<?$APPLICATION->IncludeComponent(
	"mycomponents:news", 
	"vestnik",
	array(
        "SEF_FOLDER" => "/vestnik-jur-portala/",
        "SEF_URL_TEMPLATES" => array(
            "news" => "",
            "section" => "#SECTION_CODE_PATH#/",
            "detail" => "#ELEMENT_CODE#/",
        ),

        "LIST_FIELD_CODE" => array(
            0 => "TAGS",
            1 => "DETAIL_PICTURE",
            2 => "DATE_ACTIVE_FROM",
            3 => "ACTIVE_FROM",
            4 => "DATE_CREATE",
            5 => "",
        ),
        "LIST_PROPERTY_CODE" => array(
            0 => "",
        ),

        "DETAIL_FIELD_CODE" => array(
            0 => "TAGS",
            1 => "PREVIEW_PICTURE",
            2 => "DETAIL_PICTURE",
            3 => "DATE_ACTIVE_FROM",
            4 => "ACTIVE_FROM",
            5 => "DATE_CREATE",
            6 => "",
        ),

        "DETAIL_PROPERTY_CODE" => array(
            0 => "",
        ),
        "IBLOCK_ID" => "29",
        "IBLOCK_TYPE" => "stati_partnerov",
        "COMPONENT_TEMPLATE" => "vestnik",

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
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_PAGER_SHOW_ALL" => "N",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_SET_CANONICAL_URL" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
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
		"SHARE_HANDLERS" => array(
			0 => "facebook",
			1 => "mailru",
			2 => "twitter",
			3 => "delicious",
			4 => "lj",
			5 => "vk",
		),
		"SHARE_SHORTEN_URL_LOGIN" => "",
		"SHARE_SHORTEN_URL_KEY" => "",
		"STRICT_SECTION_CHECK" => "N"
	),
	false
);?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
