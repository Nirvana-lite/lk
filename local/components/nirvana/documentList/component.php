<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

CModule::IncludeModule('iblock');

$params = array(
    "max_len" => "100",
    "change_case" => "L",
    "replace_space" => "-",
    "replace_other" => "-",
    "delete_repeat_replace" => "true",
    "use_google" => "false",
);
CPageOption::SetOptionString("main", "nav_page_in_session", "N");
$arFilter = Array("IBLOCK_ID" => intval($arParams['IBLOCK_ID']), "ACTIVE" => "Y", "!PROPERTY_469" => false);
$res = CIBlockElement::GetList(Array('PROPERTY_469' => 'ASC'), $arFilter, array('PROPERTY_469'));
while ($ob = $res->fetch()) {
    $arResult['sections'][] = [
        'name' => $ob['PROPERTY_469_VALUE'],
        'code' => CUtil::translit($ob['PROPERTY_469_VALUE'], 'ru', $params)
    ];
}
array_unshift($arResult['sections'], ['name'=> 'Все','code'=> '']);
$value = $arParams['SECTION_CODE'];
$key = array_search($value, array_column($arResult['sections'], 'code'));
$arResult['selected'] = $arResult['sections'][$key]["name"];
$arResult['selectedOption'] = $arResult['sections'][$key]["code"];
$keywords = mb_strtolower(str_replace(" ", ", ", $arResult['selected']));
$canon = CUtil::translit($arParams['SECTION_CODE'], 'ru', $params);
$arResult['meta'] = [
    'title' => (!empty($value)) ? $arResult['selected']." | Образцы документов" : 'Образцы документов, жалоб, ходатайств',
    'keywords' => (!empty($value)) ? $keywords : 'образцы, документов',
    'description' => (!empty($value)) ? $arResult['selected'] : 'Образцы документов',
    'canonical' => (!empty($value)) ? 'https://jur24pro.ru/obraztsy-dokumentov/'."{$canon}/" : 'https://jur24pro.ru/obraztsy-dokumentov/',
];

$arResult['sectionName'] = (!empty($value))?$arResult['selected']:'Образцы документов';
$sectionArr = (!empty($value))?["PROPERTY_469" => "{$arResult['selected']}"]:[];
$arSelect = Array("ID", "NAME", "CODE", "SHOW_COUNTER","PROPERTY_469");
$arFilter = Array("IBLOCK_ID" => intval($arParams['IBLOCK_ID']), "ACTIVE" => "Y",$sectionArr);
$res = CIBlockElement::GetList(Array('ID' => 'DESC'), $arFilter, false, array('nPageSize' => 10), $arSelect);
while ($ob = $res->fetch()) {
    $code = CUtil::translit($ob['PROPERTY_469_VALUE'], "ru", $params);
    $elem = $ob['CODE'];
    $arResult['items'][] = [
        'name' => $ob['NAME'],
        'url' => "/obraztsy-dokumentov/{$code}/{$elem}/",
        'view' => (intval($ob['SHOW_COUNTER']) >0)?$ob['SHOW_COUNTER']:0
    ];
}
$arResult['pagination'] = $res->GetPageNavStringEx($navComponentObject, "Страницы:", "round");
$this->IncludeComponentTemplate();

$scrollmass = array(

    'container' => ".lists",
    'item' => ".elem",
    'pagination' => ".bx-pagination  ul",
    'next' => ".bx-pagination .bx-pag-next a",
    'negativeMargin' => "-250",
);

include ($_SERVER['DOCUMENT_ROOT'].'/local/include/scrollpagination/scroll_pagination.php');
?>