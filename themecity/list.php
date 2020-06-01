<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?

/*
 *#^/jurist-([a-zA-Z0-9_-]*)/#
 *   /city/list.php
 *  CITY=$1&SECTION_CODE_PATH=$1
 *
 *  #^/jurist-([a-zA-Z0-9_-]*)/([a-zA-Z0-9_-]*)/#
 *  /city/detail.php
 *   CITY=$1&SECTION_CODE=$1&ELEMENT_CODE=$2
 */

// оставить PAGEN_ get
$link = strtok(ToLower($_REQUEST['CITY']), '?'); // убираем все get запросы
$link = preg_replace("/[^a-z0-9-]/", '', $link);  // оставляем только английские буквы, цифры и минус


$path = $_SERVER["DOCUMENT_ROOT"] . "/local/datagorod/";

$cache_id = SITE_ID . "|" . md5(serialize($link));
if (($tzOffset = CTimeZone::GetOffset()) <> 0) {
    $cache_id .= "|" . $tzOffset;
}



$cache_dir = "/page_city/city_" . $link;
$obCache = new CPHPCache;
if ($obCache->InitCache(3600000, $cache_id, $cache_dir)) {
    $cacheArrayCache = $obCache->GetVars();
    $cacheArray = $cacheArrayCache['arResultCity'];
    $bVarsFromCache = true;


} elseif (CModule::IncludeModule("iblock") && $obCache->StartDataCache()) {
    global $CACHE_MANAGER;
    $CACHE_MANAGER->StartTagCache($cache_dir);

    $fileCity = file_get_contents($path . "datacity.json"); // отсюда можно кешировать
    $taskListCity = json_decode($fileCity, TRUE);

    if (array_key_exists($link, $taskListCity)) {
        $city = $taskListCity[$link];
        $fileOblast = file_get_contents($path . "dataoblast.json");
        $taskListOblast = json_decode($fileOblast, TRUE);
        $oblast = $taskListOblast[$city['region_id']];

        $fullarray[$city['alias'] ] = array(
            'oblast' => $oblast,
            'city' => $city,
            'alias' => '/jurist-' . $city['alias'] . '/'
        );

        $cacheArray = $fullarray;

        $CACHE_MANAGER->RegisterTag("page_city_" . $city['alias']);
        $CACHE_MANAGER->EndTagCache();

        $obCache->EndDataCache(
            array(
                "arResultCity" => $cacheArray
            )
        );

    } else {
        //$this->abortResultCache();
        show404();
        return;
    }
}

//$begin = microtime(true);
if (array_key_exists($link, $cacheArray)) { // есть в массиве такой ключ

    $city = $cacheArray[$link]['city'];
    $oblast = $cacheArray[$link]['oblast'];
    $fullarray = array(
        'oblast' => $oblast,
        'city' => $city
    );
    // подключаем список статей и добавляем ссылку и передаем для проверки ссылку город
    $alias = $cacheArray[$link]['alias'];

    if (preg_match('/\\d/', $alias)){ // если в ссылке есть цифры -> добавить еще область
        $city['podezh'] = (trim($city['podezh'])).' '.(trim($oblast['region_name']));
    }

    if ($APPLICATION->GetCurPage() == $alias) {



        $title = "Юрист " . (trim($city['podezh'])) . " и адвокат бесплатная консультация оказание для физических и юридических лиц на портале ЮЛ+многое другое";
        $keywords = "юрист, адвокат, оказание, юридические услуги, помощь, вопросы," . ToLower($city['name']) . ',' . ToLower(trim($city['podezh']));
        $description = "Юрист " . (trim($city['podezh'])) . " и адвокат оказание юридической услуги для физических и юридических лиц на портале ЮЛ+многое другое";

        $APPLICATION->SetPageProperty("keywords_inner", $keywords);
        $APPLICATION->SetPageProperty("keywords", $keywords);
        $APPLICATION->SetPageProperty("description", $description);
        $APPLICATION->SetPageProperty("title", $title);
        $APPLICATION->SetPageProperty("robots", 'all');
       // $APPLICATION->SetPageProperty("canonical", MY_GET_SITE_URL.$alias);
        $APPLICATION->AddHeadString("<link rel=\"canonical\" href=\"".MY_GET_SITE_URL.$alias."\" />");
    }


    $namebreack = "Юрист и адвокат " . (trim($city['podezh'])); // название в лебных крошках
    if (defined('ERROR_404') && ERROR_404 == 'Y' || CHTTP::GetLastStatus() == "404 Not Found") {
    } else {
        $APPLICATION->AddChainItem($namebreack, $alias); // добавляем в цепочку хлебные крошки
    }
?>
  <div class="row">
<?

    //if ($APPLICATION->GetCurPage() == $alias) {
        $APPLICATION->IncludeComponent(
            "mycomponents:pagecity",
            "",
            Array(
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "3600000",
                "CACHE_TYPE" => "A",
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "IBLOCK_ID" => "3",
                "IBLOCK_TYPE" => "city",
                "ID" => "",
                "MDATA_CITY" => "datacity.json",
                "MDATA_CITY_ALIAS" => "alias",
                "MDATA_CITY_NAME" => "name",
                "MDATA_OBLAST" => "dataoblast.json",
                "OTHER" => "N",
                "CITY_SELECTDATA" => $city,
                "LINK_RAZDEl" => $alias,
                "PATH_DATA" => "/local/datagorod/"
            )
        );
  //  }

    $APPLICATION->IncludeComponent(
        "mycomponents:news",
        "pagecity",
        Array(
            "ADD_ELEMENT_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "Y",
            "AJAX_MODE" => "N",
            "DATA_CITY" => $fullarray,
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "BROWSER_TITLE" => "-",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CATEGORY_CODE" => "CATEGORY",
            "CATEGORY_IBLOCK" => "",
            "CATEGORY_ITEMS_COUNT" => "5",
            "CHECK_DATES" => "Y",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
            "DETAIL_DISPLAY_TOP_PAGER" => "N",
            "DETAIL_FIELD_CODE" => array("ID", "NAME", "TAGS", "DETAIL_TEXT", "DETAIL_PICTURE", "SHOW_COUNTER", "DATE_CREATE", "TIMESTAMP_X", ""),
            "DETAIL_PAGER_SHOW_ALL" => "N",
            "DETAIL_PAGER_TEMPLATE" => "",
            "DETAIL_PAGER_TITLE" => "Страница",
            "DETAIL_PROPERTY_CODE" => array("", ""),
            "DETAIL_SET_CANONICAL_URL" => "Y",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "FILE_404" => "/404.php",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "3",
            "IBLOCK_TYPE" => "city",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "LIST_FIELD_CODE" => array("", ""),
            "LIST_PROPERTY_CODE" => array("", ""),
            "MESSAGE_404" => "",
            "META_DESCRIPTION" => "-",
            "META_KEYWORDS" => "-",
            "NEWS_COUNT" => "20",
            "NEWS_DETAIL" => "articles_detail",
            "NEWS_LIST" => "articles_list",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "ajax_news",
            "PAGER_TITLE" => "Новости",
            "PREVIEW_TRUNCATE_LEN" => "",
            "SEF_FOLDER" => $alias,
            "SEF_MODE" => "Y",
            "SEF_URL_TEMPLATES" => Array("detail" => "#ELEMENT_CODE#/", "news" => "", "section" => ""),
            "SET_LAST_MODIFIED" => "N",
            "SET_STATUS_404" => "Y",
            "SET_TITLE" => "Y",
            "SHOW_404" => "Y",
            "SORT_BY1" => "ACTIVE_FROM",
            "SORT_BY2" => "SORT",
            "SORT_ORDER1" => "DESC",
            "SORT_ORDER2" => "ASC",
            "STRICT_SECTION_CHECK" => "Y",
            "USE_CATEGORIES" => "N",
            "USE_FILTER" => "N",
            "USE_PERMISSIONS" => "N",
            "USE_RATING" => "N",
            "USE_RSS" => "N",
            "USE_SEARCH" => "N",
            "USE_SHARE" => "N"
        )
    );
?>
    </div>
<?
} else { // такого ключа нет вывести 404 ошибку
    show404();
}

//echo microtime(true) - $begin;
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
