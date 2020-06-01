<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$params = array(
    "max_len" => "100",
    "change_case" => "L",
    "replace_space" => "-",
    "replace_other" => "-",
    "delete_repeat_replace" => "true",
    "use_google" => "false",
);
CModule::IncludeModule('iblock');

$arSelect = Array("ID", "NAME", "DETAIL_TEXT","CODE","PROPERTY_469");
$arFilter = Array("IBLOCK_ID" => intval($arParams['IBLOCK_ID']), "ACTIVE" => "Y", "CODE" => $arParams['ELEMENT_CODE']);
$res = CIBlockElement::GetList(Array('ID' => 'DESC'), $arFilter, false, array('nTopCount' => 1), $arSelect);
while ($ob = $res->GetNext()) {
    $arResult = [
        'id' => $ob['ID'],
        'name' => $ob['NAME'],
        'text' => $ob['DETAIL_TEXT'],
        'code' => $ob['CODE'],
        'section' => $ob['PROPERTY_469_VALUE']
    ];
}
$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues(
    $arParams['IBLOCK_ID'],
    $arResult["id"]
);
$arResult['canonical'] = CUtil::translit($arParams['SECTION_CODE'], 'ru', $params);
$arResult["meta"] = $ipropValues->getValues();

$this->IncludeComponentTemplate();
?>