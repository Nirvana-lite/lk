<?
define('STOP_STATISTICS', true);
define('NOT_CHECK_PERMISSIONS', true);
define("PUBLIC_AJAX_MODE", true);
define("NO_KEEP_STATISTIC", "Y");
define("NO_AGENT_STATISTIC", "Y");
define("NO_AGENT_CHECK", true);
define("DisableEventsCheck", true);

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
global $DB;
global $USER;

use Bitrix\Main\Application;

CModule::IncludeModule('iblock');
$connection = \Bitrix\Main\Application::getConnection();
$sqlHelper = $connection->getSqlHelper();

function GenHashOtvet($str)
{
    // генерируем хеш ответов для сравнения
    $str = strip_tags($str);
    $str = mb_strtolower($str);
    $str = str_replace(array("\r", "\n"), " ", $str);
    $str = preg_replace('/\s/', '', $str);
    $str = mb_substr($str, 0, 200);
    $str = trim($str);
    //$str = utf8_encode($str); ??
    return $sha256 = hash('sha256', $str);
}


$dataCity = array(
    678 => 'Москва и область',
    773 => 'Санкт-Петербург и область',
    774 => 'Адыгея',
    775 => 'Алтай',
    776 => 'Алтайский край',
    777 => 'Амурская область',
    778 => 'Архангельская область',
    779 => 'Астраханская область',
    780 => 'Башкортостан',
    781 => 'Белгородская область',
    782 => 'Брянская область',
    783 => 'Бурятия',
    784 => 'Владимирская область',
    785 => 'Волгоградская область',
    786 => 'Вологодская область',
    787 => 'Воронежская область',
    788 => 'Дагестан',
    789 => 'Еврейская АО',
    790 => 'Забайкальский край',
    791 => 'Ивановская область',
    792 => 'Ингушетия',
    793 => 'Иркутская область',
    794 => 'Кабардино-Балкария',
    795 => 'Калининградская область',
    796 => 'Калмыкия',
    797 => 'Калужская область',
    798 => 'Камчатский край',
    799 => 'Карачаево-Черкессия',
    800 => 'Карелия',
    801 => 'Кемеровская область',
    802 => 'Кировская область',
    803 => 'Коми',
    804 => 'Костромская область',
    805 => 'Краснодарский край',
    806 => 'Красноярский край',
    807 => 'Крым',
    808 => 'Курганская область',
    809 => 'Курская область',
    810 => 'Липецкая область',
    811 => 'Магаданская область',
    812 => 'Марий Эл',
    813 => 'Мордовия',
    814 => 'Мурманская область',
    815 => 'Ненецкий АО',
    816 => 'Нижегородская область',
    817 => 'Новгородская область',
    818 => 'Новосибирская область',
    819 => 'Омская область',
    820 => 'Оренбургская область',
    821 => 'Орловская область',
    822 => 'Пензенская область',
    823 => 'Пермский край',
    824 => 'Приморский край',
    825 => 'Псковская область',
    826 => 'Ростовская область',
    827 => 'Рязанская область',
    828 => 'Самарская область',
    829 => 'Саратовская область',
    830 => 'Саха (Якутия)',
    831 => 'Сахалинская область',
    832 => 'Свердловская область',
    833 => 'Северная Осетия - Алания',
    834 => 'Смоленская область',
    835 => 'Ставропольский край',
    836 => 'Тамбовская область',
    837 => 'Татарстан',
    838 => 'Тверская область',
    839 => 'Томская область',
    840 => 'Тульская область',
    841 => 'Тыва',
    842 => 'Тюменская область',
    843 => 'Удмуртская Республика',
    844 => 'Ульяновская область',
    845 => 'Хабаровский край',
    846 => 'Хакасия',
    847 => 'Ханты-Мансийский АО',
    848 => 'Челябинская область',
    849 => 'Чеченская Республика',
    850 => 'Чувашия',
    851 => 'Чукотский АО',
    852 => 'Ямало-Ненецкий АО',
    853 => 'Ярославская область'
);


// юристы для ответов
$id_jurist = [
    130971, 130485, 130351, 130199, 130128, 129975,
    100315, 66810, 579, 578, 577, 557, 527, 517, 516, 515,
    514, 512, 511, 510, 509, 508, 507, 506, 505, 504, 503, 502, 501,  500,
    499, 498, 497, 496, 495, 494, 493, 490, 478, 477, 476, 474, 473, 462,
    461, 460, 459, 457, 434, 383, 372, 370, 369, 368, 367, 366, 365, 364, 363, 362,
    361, 360, 359, 358, 357, 356, 355, 354, 353, 352, 351, 350, 349, 348, 347, 346, 344,
    343, 341, 316, 315, 314, 313, 312, 285, 281, 272, 271, 267, 259, 236, 186, 106, 105,
    103, 82, 81,
];

/*

$filter = Array("GROUPS_ID" => array(8));
$rsUsers = CUser::GetList(($by = "id"), ($order = "desc"), $filter);
while ($arUser = $rsUsers->GetNext()) {
    $arFilter = array(
        'IBLOCK_ID' => 17, // ID инфоблока
        'PROPERTY_urist' => $arUser['ID']
    );
    $res = CIBlockElement::GetList(false, $arFilter, array('PROPERTY_urist'));
    if ($el = $res->Fetch()) {
        echo $arUser['ID'].' Записей: ' . $el['CNT'].'<br>';
        $arSpecUser[] = $arUser['ID'];
    }
}
*/



$el = new CIBlockElement;


if ($_POST['spec'] == "add123dtrwersdf") {

    $PROP = array();
    $tp = $_POST['check'];
    switch ($tp) {
        case 'vp': // создания вопроса

            $section_id = false;
            if (intval($_POST['category_jur24pro']) > 0) {
                $section_id = intval($_POST['category_jur24pro']);
            }

            $PROP['region'] =  $dataCity[array_rand($dataCity)];  //регион
            $PROP['name_vopros'] = $_POST['name'];  //название вопроса
            $PROP['officeid'] = 10000;  // офис id


            $arLoadProductArray = Array(
                "IBLOCK_SECTION_ID" => $section_id,          // элемент лежит в корне раздела
                "IBLOCK_ID" => 15,
                "PROPERTY_VALUES" => $PROP,
                "NAME" => $_POST['author'],
                "ACTIVE" => "Y",            // активен
                "PREVIEW_TEXT" => $_POST['text'],
                "PREVIEW_TEXT_TYPE" => 'text',
                "DATE_CREATE" => $_POST['dttime']
            );
           // echo json_encode(array('id_add' => 123 ));
            break;
        case 'vp_otv': // создания ответа к вопросу

            $id_jur = $id_jurist[array_rand($id_jurist)];
            $rsUser = CUser::GetByID($id_jur);
            $arUser = $rsUser->Fetch();
            $autr = $arUser['NAME'].' '.$arUser['LAST_NAME'];
            $autr = trim($autr);


            $PROP['urist'] = $id_jur;
            $PROP['vopros'] =  intval($_POST['id_vp']);
            $PROP['DEPTH'] =  1;
            $PROP['NONUSER'] = $autr;

            $arLoadProductArray = Array(
                "IBLOCK_ID" => 18,
                "PROPERTY_VALUES" => $PROP,
                "NAME" => $autr,
                "EMAIL" => trim($arUser['EMAIL']),
                "ACTIVE" => "Y",            // активен
                "PREVIEW_TEXT" => $_POST['text'],
                "PREVIEW_TEXT_TYPE" => 'html',
                "DATE_CREATE" => $_POST['dttime']
            );

            //echo json_encode(array('id_add' => $arLoadProductArray ));
            break;
        case 'only_otv': // добавление к вопросу новых ответов
            echo "i равно 2";
            break;
    }
 
    //echo json_encode(array('id_add' => $arLoadProductArray));

    $PRODUCT_ID = $el->Add($arLoadProductArray, false, false);
    if ($PRODUCT_ID) {
        echo json_encode(array('id_add' => $PRODUCT_ID));
    }else{
        echo json_encode(array('id_add' => 0));
    }



    // возращаем id и еще дату под которым создалось

} else {
    die();
}

?>