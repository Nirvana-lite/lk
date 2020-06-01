<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


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
            if(trim($ar_res['LIST_PAGE_URL'], '/') != 'voprosy-yuristu'){
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
    'voprosy-yuristu', // link
    'Вопросы и ответы на юридические темы', // title
    '',//SetTitle
    '', // tags
    'консультация адвоката, задать вопрос юристу, спросить у юриста, помощь юриста, консультация юриста, помощь адвоката, вопрос адвокату, задать вопрос адвокату', // keywords
    'Любой посетитель портала, может задать вопрос по любому юридическому вопросу, что бы юристы и адвокаты, кто зарегистрирован на портале, дал исчерпывающий ответ не только на основании практики, но и на основании законодательства.', // description
    '' // h1
);

?><?



$APPLICATION->IncludeComponent(
	"mycomponents:news", 
	"voprosy-yuristu", 
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
			0 => "DATE_ACTIVE_FROM",
			1 => "ACTIVE_FROM",
			2 => "DATE_CREATE",
			3 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "N",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "name_vopros",
			1 => "otveti",
			2 => "region",
			3 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILE_404" => "/404.php",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "15",
		"IBLOCK_TYPE" => "services",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
		"LIST_FIELD_CODE" => array(
			0 => "DATE_ACTIVE_FROM",
			1 => "ACTIVE_FROM",
			2 => "DATE_CREATE",
			3 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "name_vopros",
			1 => "otveti",
			2 => "region",
			3 => "",
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
		"SEF_FOLDER" => "/voprosy-yuristu/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "voprosy-yuristu",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "#SECTION_CODE_PATH#/",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
);
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>