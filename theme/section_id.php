<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

if (!CModule::IncludeModule('iblock')) {
    die();
}


$link = preg_replace('/[^a-zA-Z0-9-]/i', '', ToLower($_REQUEST['CITY']));
$link = strtok($link, '?');

$code_section = preg_replace('/[^a-zA-Z0-9-]/i', '', ToLower($_REQUEST['SECTION_CODE']));
//$code_section = $_REQUEST['SECTION_CODE'];
$code_section = strtok($code_section, '?');


$path = $_SERVER["DOCUMENT_ROOT"] . "/local/datagorod/";


$id_block = 52;
$res = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $id_block, 'CODE' => $code_section));

// замена слова {city} на город
function edit_city($text_edit, $arraydata){

    $podezh = $arraydata["city"]["podezh"];
    $alias_city = $arraydata["city"]["alias"];
    $add_oblast ='';

    //$pos = mb_strpos($text_edit, 'city');
    $pos = preg_match('/{city}/ui', $text_edit);
    if ($pos) {
        $a = true;
    }else{
        $a = false;
    }

    if( preg_match('/\\d/', $alias_city) ){ // если в ссылке есть цифры -> добавить еще область
        $add_oblast = ' '.(trim($arraydata["oblast"]["region_name"])).' ';
    }

    $title = preg_replace('/{city}/ui', $podezh.$add_oblast, $text_edit);
    $title = trim(preg_replace('/[\s]{2,}/', ' ', $title));
    return array(
        'title' => $title,
        'yes'=> $a
    );
}

// город

$fileCity = file_get_contents($path . "datacity.json"); // отсюда можно кешировать
$taskListCity = json_decode($fileCity, TRUE);

if (array_key_exists($link, $taskListCity)) {

    $city = $taskListCity[$link];
    $fileOblast = file_get_contents($path . "dataoblast.json");
    $taskListOblast = json_decode($fileOblast, TRUE);
    $oblast = $taskListOblast[$city['region_id']];

} else { // выводим 404 города не существует
    error404();
}


if ($section = $res->Fetch()) {

    $arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("IBLOCK_52_SECTION", $section['ID']);
    $res2 = CIBlockSection::GetByID($arUF['UF_SECTION_VOP']["VALUE"]);

    if ($ar_res2 = $res2->GetNext()) {
        $NameParentRazdel = $ar_res2['NAME'];
        $NameParentID = $ar_res2['ID'];
        $NameParentCode = $ar_res2['SECTION_PAGE_URL'];
    }

    $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($id_block, $section['ID']);
    $IPROPERTY = $ipropValues->getValues();

    $fullarray = array(
        'oblast' => $oblast,
        'city' => $city
    );

    if ($IPROPERTY['SECTION_META_TITLE']) {

        $check = edit_city($IPROPERTY['SECTION_META_TITLE'], $fullarray);
        if(!empty($check['yes'])){
            $title = $check['title'];
        } else{
            $title =  $IPROPERTY['SECTION_META_TITLE'] . " ".(trim($city['podezh']));
        }

        $name = $title;

        $APPLICATION->SetPageProperty("title", $title ." | ". (trim($NameParentRazdel)));
        // $APPLICATION->SetTitle($IPROPERTY['SECTION_META_TITLE']);
    }
    $myTitle = $title;

    if ($IPROPERTY['SECTION_META_KEYWORDS']) {
        $check = edit_city($IPROPERTY['SECTION_META_KEYWORDS'], $fullarray);
        $APPLICATION->SetPageProperty("keywords", $check['title']);
    }

    if ($IPROPERTY['SECTION_META_DESCRIPTION']) {

        $check = edit_city(strip_tags($IPROPERTY['SECTION_META_DESCRIPTION']), $fullarray);
        if(!empty($check['yes'])){
            $title = $check['title'];
        } else{
            $title =  $city['name'].' '.(strip_tags($IPROPERTY['SECTION_META_DESCRIPTION']));
        }
        $APPLICATION->SetPageProperty("description", $title );

    }

    $link_razdel = $city['alias'].'-th-'. $section['CODE'] . '/';

    $APPLICATION->SetPageProperty("canonical", 'https://jur24pro.ru/' . $link_razdel);
    $APPLICATION->SetPageProperty("robots", 'all');

}
/*
metatagrazdel(
    $section['CODE'], // link
    '', // title
    '',//SetTitle
    $IPROPERTY['SECTION_META_KEYWORDS'], // tags
    $IPROPERTY['SECTION_META_KEYWORDS'], // keywords
    strip_tags($IPROPERTY['SECTION_META_DESCRIPTION']), // description
    $section['NAME'] // h1
);*/

?>
<?
// компнент фильтр

// выводить список разделов 62 штуки
$APPLICATION->IncludeComponent(
    "mycomponents:pagecity",
    "",
    Array(
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "3600000",
        "CACHE_TYPE" => "A",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "IBLOCK_ID" => "15",
        "PARENT_RAZDEL" => array('name' => $NameParentRazdel, 'id' => $NameParentID, 'code' => $NameParentCode),
        "IBLOCK_TYPE" => "city",
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

?>
    <article class="clearfix" itemscope="" itemtype="https://schema.org/Article">
        <header>
            <?php

         /*   $check = edit_city(strip_tags($section['NAME']), $fullarray);
            if(!empty($check['yes'])){
                $title = $check['title'];
            } else{
                $title =  $section['NAME'].' '.(trim($city['podezh']));
            }
            */
//         pre($section);
            $name =  $section['NAME'].' '.(trim($city['podezh']));
            ?>
            <h1 class="main-title"><?=$myTitle; ?></h1>
            <link itemprop="mainEntityOfPage"
                  href="https://jur24pro.ru/<?=(trim($link_razdel));?>">
        </header>
        <div class="content-text block-shadow">
           <?=$title;?>
            <? $DESCRIPTION = preg_replace('/<h1[^>]*>.*?<\/h1>/', '', $section['DESCRIPTION']);
            echo $DESCRIPTION; ?>
        </div>
    </article>

<? // список вопросов по ключам и самого раздела исключая вопросы по ключам по id


$includelist = false;

// похожие статьи
// удаляем лишние знаки
//$tmpName = str_replace(array(".", ",", "?", "!", "-", ":", " - "), " ", );
$tmpName = preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/ui", ' ', trim($section['NAME'] . " " . $IPROPERTY['SECTION_META_KEYWORDS']));
// если есть с чем работать
if (strlen($tmpName) > 0) {
    $arLooksLike = array(
        "INCLUDE_SUBSECTIONS" => "Y",
        "PARENT_SECTION" => $NameParentID
        //  "!ID" => intval($ElementID) // не данный элемент
    );

    $stuffWords = MY_ARRAY_PREDLOG; // эти слова не несут смысла
// массив, который будет использоваться для поиска в имени или тегах

    $tmpName = preg_replace('/[\s]{2,}/', ' ', $tmpName);  // убираем двойные пробелы

    $NameItems = explode(" ", $tmpName);
    $NameItems = array_diff($NameItems, array(''));                         // убираем пустые из массива

    $itemsArray = array();
    foreach ($NameItems as $item) {
        if (in_array($item, $stuffWords)) { // убираем предлоги
            continue;
        }
        if (strlen($item) > 1) { // редко бывают значимые слова в одну букву
            $itemsArray[] = array("name_vopros" => "%" . $item . "%");  // ищем элементы, у которых выбранное свойство есть в названии
            $itemsArray[] = array("PREVIEW_TEXT" => "%" . $item . "%");  // ищем элементы, у которых выбранное свойство есть в поисковых тегах
        }
    }

    $addFArray = array(
        array(array_merge(array("LOGIC" => "OR"), $itemsArray)),
    );

// массив для фильтра
    $GLOBALS["similarArticles"] = array_merge($arLooksLike, $addFArray);
    $includelist = true;
}

if ($includelist) {
    $APPLICATION->IncludeComponent(
	"mycomponents:news.list", 
	"mylist-vopros", 
	array(
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "-",
		"IBLOCK_ID" => "15",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER2" => "DESC",
		"FILTER_NAME" => "similarArticles",
		"FIELD_CODE" => array(
			0 => "CODE",
			1 => "PREVIEW_TEXT",
			2 => "DATE_ACTIVE_FROM",
			3 => "ACTIVE_FROM",
			4 => "DATE_CREATE",
			5 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "name_vopros",
			1 => "otveti",
			2 => "region",
			3 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "/voprosy-yuristu/#ELEMENT_CODE#/",
		"SEF_FOLDER" => "/",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "N",
		"PAGER_TEMPLATE" => "round",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "mylist-vopros",
		"AJAX_OPTION_ADDITIONAL" => "",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"FILE_404" => "/404.php"
	),
	false
);
}


?>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>