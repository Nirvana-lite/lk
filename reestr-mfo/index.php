<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

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

            if(intval($ar_res['IBLOCK_SECTION_ID']) != 1374){
                show404();
            }else {
                LocalRedirect('/reestr-mfo/'. $ar_res['CODE'] . '/', false,'301 Moved permanently');
            }
        } else{
            show404();
        }


    } else { // состоит из цифр и слов

    }
}

metatagrazdel(
    'reestr-mfo', // link
    'Список МФО Микрофинансовых организаций Российской Федерации', // title
    'Список МФО Микрофинансовых организаций Российской Федерации',//SetTitle
    'список мфо микрофинансовых организаций москва рф российской федерации', // tags
    'список мфо микрофинансовых организаций москва рф российской федерации', // keywords
    'МФО - адреса, инн, огрн микрофинансовых организаций Российской Федерации', // description
    'Список МФО Микрофинансовых организаций Российской Федерации' // h1
);
?>
<? $APPLICATION->IncludeComponent(
	"mycomponents:news", 
	"defaul_page",
	array(
		"COMPONENT_TEMPLATE" => "defaul_page",
		"LIST_TEMPLATE"=> "list_mfo", // шаблон списка
        "DETAIL_TEMPLATE"=> "detail_mfo", // шаблон детальной
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
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
		"CHECK_DATES" => "N",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PROPERTY_CODE" => array(
            0 => "ADRES",
            1 => "DATA_VNES",
            2 => "DATA_ISKLUC",
            3 => "BEZ_DOVEREN",
            4 => "BLANK_SVIDET",
            5 => "GOS_REG_NOMER",
            6 => "FULL_NAME",
            7 => "REG_NOMER_ZAPIS",
            8 => "SOKR_NAME",
            9 => "",
        ),
		"DETAIL_SET_CANONICAL_URL" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILE_404" => "/404.php",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "35",
		"IBLOCK_TYPE" => "kpkMfoStr",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
        "LIST_PROPERTY_CODE" => array(
            0 => "ADRES",
            1 => "GOS_REG_NOMER",
            2 => "",
        ),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "round",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/reestr-mfo/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
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
        "FIXED_SECTION_ID" => "1374",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "#SECTION_CODE#/",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
); ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>