<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Page\Asset;
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>");
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>");
global $USER;

$filter = Array("GROUPS_ID" => Array(25));
$arParams["SELECT"] = array('UF_CRM_ID_O');
$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter,$arParams);
while ($arUser = $rsUsers->Fetch()) {
    $arResult['items'][] = [
        'id' => $arUser['UF_CRM_ID_O'],
        'name' => $arUser['LOGIN'],
    ];
}
/**
 * status
 */

$arResult['status'] = [
    'defect' => [
        'name' => 'Брак',
        'color' => 'panel-warning'
    ],
    'done' => [
        'name' => 'Прочитано',
        'color' => 'panel-success'
    ],
    'new' => [
        'name' => 'Ожидает',
        'color' => 'panel-secondary'
    ],
];
/**
 * city
 */

$arSelect = Array("ID", "IBLOCK_ID", "NAME");
$arFilter = Array("IBLOCK_ID" => IntVal(16), "ACTIVE" => array("Y"));
$res = CIBlockElement::GetList(Array('DATE_CREATE' => 'ASC'), $arFilter, false, false, $arSelect);
while ($ob = $res->Fetch()) {
    $arResult['citys'][] = $ob['NAME'];
}

/**
 * sections
 */

$arFilter = Array('IBLOCK_ID' => questions, 'ACTIVE' => 'Y');
$db_list = CIBlockSection::GetList(Array('NAME' => 'ASC'), $arFilter, true);
while ($ar_result = $db_list->GetNext()) {
    $arResult['sections'][] = $ar_result['NAME'];
}

/**
 * defectReason
 */

$arResult['defectReason'] = [
    'нет телефона',
    'не оставлял заявку',
    'недозвон',
    'не юр. вопрос',
    'копия',
    'НЕ БРАК'
];

/**
 * status
 */

$arResult['status'] = [
    'defect' => [
        'name' => 'Брак',
        'color' => 'panel-warning'
    ],
    'done' => [
        'name' => 'Прочитано',
        'color' => 'panel-success'
    ],
    'new' => [
        'name' => 'Ожидает',
        'color' => 'panel-secondary'
    ],
];

$this->IncludeComponentTemplate();
?>