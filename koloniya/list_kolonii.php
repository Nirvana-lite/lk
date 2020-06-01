<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
if (!CModule::IncludeModule('iblock')) {
    die();
}
global $APPLICATION;
?>
<? // фильтр юристов по городам

$razdel_link = '/koloniya/';


$page = $APPLICATION->GetCurPage();
$page = explode("/", $page);
$page = array_diff($page, array(''));

if (count($page) > 2) {
    // ошибка 404
    error404();
}

if (count($page) == 1) {
    // находимся на главной
    $selected_reg = 1;
} else {
    // находимся в городе
    $selected_reg = end($page);
    if ($selected_reg == 1) {
        error404();
    }
}


// закешировать результат

function get_list_city($razdel_link)
{
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_*");
    $arFilter = Array("IBLOCK_ID" => IntVal(42));
    $res = CIBlockElement::GetList(Array("name" => "asc"), $arFilter, false, false, $arSelect);
    $regions = array();
    $list_regions = array();
    $list_regions[1] = array(
        'LINK' => '',
        'NAME' => 'Все города'
    );
    while ($ob = $res->Fetch()) {
        $regions[$ob['ID']] = $ob['NAME']; // нужно для списка юриста
        $list_regions[$ob['CODE']] = array(
            'ID_REGION' => $ob['ID'],
            'LINK' => $ob['CODE'] . '/',
            'NAME' => $ob['NAME']
        );  // проверка существования и список в select
    }
    return array(
        'regions' => $regions,
        'list_regions' => $list_regions
    );
}


$cachedDatasas = returnResultCache(3600000, 'list_filter_kolonii_city', 'get_list_city', $razdel_link);
// данные из кеша
$regions = $cachedDatasas['regions'];
$list_regions = $cachedDatasas['list_regions'];

if (!array_key_exists($selected_reg, $list_regions)) { // такого города нет выводим 404
    // ошибка 404
    //  error404();

    // находимся внутри
    $use_filter = false;

} else {
    // находимся на фильтре

    $use_filter = true;

    // есть город устанавливаем seo
    $code = $list_regions[$selected_reg]['LINK'];
    $reg = ' ' . (trim($list_regions[$selected_reg]['NAME'])) . ' ';

    if ($selected_reg == 1) {
        $reg = 'Все ';
        $region_user = 0;
    } else {
        $region_user = $list_regions[$selected_reg]['LINK'];
    }


    $APPLICATION->SetPageProperty("description",
        (trim($reg)) . " колонии, сизо, ик, кп, луи, вк, исправительная система");
    $APPLICATION->SetPageProperty("title", (trim($reg)) . " колонии, СИЗО, ИК, КП, ЛИУ, ВК Российской Федерации");
    $APPLICATION->SetPageProperty("keywords", (trim($reg)) . ", колонии, сизо, ик, кп, луи, вк, российской, федерации");
    $APPLICATION->SetPageProperty("canonical", "https://jur24pro.ru" . $razdel_link . $code);
}


if ($use_filter) {
    ?>
    <h1 class="main-title"><?= (ltrim($reg)); ?> колонии, СИЗО, ИК, КП, ЛИУ, ВК Российской Федерации</h1>
    <div class="filter__city block-shadow">
        <p>Выбрать город</p>
        <select id="gorod_select" onchange="location = this.options[this.selectedIndex].value;">
            <? foreach ($list_regions as $key => $item) { ?>
                <option value="<?= ($razdel_link . $item['LINK']); ?>"<? echo(($selected_reg == $key) ? 'selected' : ''); ?>><?= $item['NAME']; ?></option>
            <? } ?>
        </select>
        <div class="hidden-text">
            <? foreach ($list_regions as $key => $item) { ?>
                <a href="<?= ($razdel_link . $item['LINK']); ?>"><?= $item['NAME']; ?></a>
            <? } ?>
        </div>
    </div>


    <div class="filter__user">
        <?
        function get_list_kolonii($data_array)
        {
            $region_user = $data_array['data_region_user'];
            $regions = $data_array['data_regions'];
            $PAGEN_1 = $data_array['PAGEN_1'];


            $filter = Array
            (
                "ACTIVE" => "Y",
                "IBLOCK_ID" => 41,
            );


            if ($region_user) {
                $filter["PROPERTY_352_VALUE"] = trim($region_user, '/');
            }

            $arSelect = Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_352", "PROPERTY_285", "PROPERTY_283");
            $pol_spisok = CIBlockElement::GetList(Array("ID" => "asc"), $filter, false, false, $arSelect);
            $pol_spisok->NavStart(21, false, intval($PAGEN_1));// разбиваем постранично по 50 записей


            while ($item = $pol_spisok->GetNext()) {
                // массив данных
                $u_res = array(
                    "NAME" => $item["NAME"],
                    "CODE" => $item["CODE"],
                    "~PROPERTY_283_VALUE" => trim($item["~PROPERTY_283_VALUE"]),
                    "~PROPERTY_285_VALUE" => trim($item["~PROPERTY_285_VALUE"]),

                );
                $result[] = $u_res;
            }
            return array('result' => $result, 'rsUsers' => $pol_spisok);
        }


        // кеширование
        $data_result_kolonii = returnResultCache(3600000,
            'reestr_kolonii/list_filter' . (trim($region_user, '/')) . '_' . (intval($_GET['PAGEN_1'])),
            'get_list_kolonii',
            array(
                'data_region_user' => $region_user,
                'data_regions' => $regions,
                'PAGEN_1' => intval($_GET['PAGEN_1'])
            ));


        $result = $data_result_kolonii['result'];
        $rsUsers = $data_result_kolonii['rsUsers'];

        foreach ($result as $kolon) { ?>
            <div class="user_item col-md-4 col-sm-6 col-xs-12">
                <div class="filter_reg_user block-shadow">
                    <h2><?= $kolon['NAME']; ?></h2>
                    <p>
                        <strong>Расположение</strong>
                        <br>
                        <?= $kolon["~PROPERTY_283_VALUE"]; ?>
                        <br>
                        <br>
                        <strong>Адрес</strong>
                        <br>
                        <?= $kolon["~PROPERTY_285_VALUE"]; ?>
                    </p>
                    <div class="reg_user_footter">
                        <a target="_blank" class="link_profile" href="<?= ($razdel_link . $kolon['CODE']); ?>/">Подробнее</a>
                    </div>
                </div>
            </div>
        <? } ?>
        <div class="clearfix"></div>
    </div>
    <?

    $navStr = $rsUsers->GetPageNavStringEx($navComponentObject, "Страницы:", "round");
    echo $navStr;


    $scrollmass = array(

        'container' => ".filter__user",
        'item' => ".user_item",
        'pagination' => ".bx-pagination  ul",
        'next' => ".bx-pagination .bx-pag-next a",
        'negativeMargin' => "-250",
    );

    include($_SERVER['DOCUMENT_ROOT'] . '/local/include/scrollpagination/scroll_pagination.php');
    ?>

    <style>
        #gorod_select {
            padding: 7px;
            font: 400 18px Lora, serif !important;
            width: 100% !important;
            outline: none;
            background-color: #fff;
            display: block !important;
            cursor: pointer;
        }

        #gorod_select option:selected {
            font-weight: bold;
        }

        .filter__user {
            width: 100%;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            overflow: hidden;
            font-family: Lora, serif;
        }

        .filter_reg_user {
            height: 95%;
            text-align: center;
            position: relative;
            padding-bottom: 30px;
        }

        .reg_user_content {
            font-size: 16px;
        }

        .first_el {
            text-transform: capitalize;
            margin: 0;
        }

        .reg_user_name {
            margin: 2px 0;
        }

        .reg_user_footter {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 24px;
            line-height: 26px;
        }

        .link_profile {
            padding: 10px 20px;
            outline: 0;
            font-size: 18px;
            color: #000;
            background: #ffc800;
            font-family: Lora, serif;
            border: 1px solid #ccc;
            box-shadow: 0 3px 5px -5px #717171;
            cursor: pointer;
            text-decoration: none !important;
        }

        .link_profile:hover {
            background: #d6d8db;
        }

        .spinner-wrapper {
            display: block;
            width: 100%;
            text-align: center !important;
        }

        .spinner-wrapper:after, .spinner-wrapper:before {
            clear: both;
            display: block;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
    </style>
<? } else { ?>
    <?
    // детальная страница
    // если нет такой страницы то покажет 404 ошибку

    $ElementID = $APPLICATION->IncludeComponent(
        "mycomponents:news.detail",
        "koloniya",
        array(
            "COMPONENT_TEMPLATE" => "koloniya",
            "IBLOCK_TYPE" => "koloniya",
            "IBLOCK_ID" => "41",
            "ELEMENT_ID" => "",
            "ELEMENT_CODE" => trim($page[2]),
            "CHECK_DATES" => "N",
            "FIELD_CODE" => array(
                0 => "NAME",
                1 => "DETAIL_TEXT",
                2 => "DETAIL_PICTURE",
                3 => "",
            ),
            "PROPERTY_CODE" => array(
                0 => "",
                1 => "PROPERTY_*",
                2 => "",
            ),
            "IBLOCK_URL" => "",
            "DETAIL_URL" => "#ELEMENT_CODE#/",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "CACHE_TYPE" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_GROUPS" => "N",
            "SET_TITLE" => "Y",
            "SET_CANONICAL_URL" => "Y",
            "SET_BROWSER_TITLE" => "Y",
            "BROWSER_TITLE" => "-",
            "SET_META_KEYWORDS" => "N",
            "META_KEYWORDS" => "-",
            "SET_META_DESCRIPTION" => "Y",
            "META_DESCRIPTION" => "-",
            "SET_LAST_MODIFIED" => "Y",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "ADD_ELEMENT_CHAIN" => "N",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "USE_PERMISSIONS" => "N",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "N",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "USE_SHARE" => "N",
            "PAGER_TEMPLATE" => ".default",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "Страница",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "SET_STATUS_404" => "Y",
            "SHOW_404" => "Y",
            "MESSAGE_404" => "",
            "S_ASK_QUESTION" => "",
            "S_ORDER_PROJECT" => "",
            "T_GALLERY" => "",
            "T_DOCS" => "",
            "T_PROJECTS" => "",
            "T_CHARACTERISTICS" => "",
            "STRICT_SECTION_CHECK" => "N",
            "FILE_404" => "/404.php"
        ),
        false
    ); ?>
    <? $APPLICATION->IncludeComponent(
        "khayr:comments",
        "comment_editor_emoji",
        Array(
            "IBLOCK_ID" => 23,
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADDITIONAL" => array(""),
            "ALLOW_RATING" => "Y",
            "AUTH_PATH" => "/auth/",
            "CAN_MODIFY" => "N",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "COUNT" => "10",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "JQUERY" => "Y",
            "LEGAL" => "N",
            "LEGAL_TEXT" => "Я согласен с правилами размещения сообщений на сайте.",
            "LOAD_AVATAR" => "Y",
            "LOAD_DIGNITY" => "Y",
            "LOAD_FAULT" => "Y",
            "LOAD_MARK" => "Y",
            "MAX_DEPTH" => "5",
            "MODERATE" => "N",
            "NON_AUTHORIZED_USER_CAN_COMMENT" => "Y",
            "OBJECT_ID" => $ElementID,
            "PAGER_DESC_NUMBERING" => "Y",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "ajax_comments",
            "PAGER_TITLE" => "",
            "REQUIRE_EMAIL" => "Y",
            "USE_CAPTCHA" => "N",
            "SHOW_h1" => false
        )
    ); ?>
<? } ?>