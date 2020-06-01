<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
CModule::IncludeModule('iblock');
global $USER;
$arResult = $arParams;

/**
 * element
 */

$arSelect = Array("ID", 'IBLOCK_ID', "NAME", "DATE_CREATE","PREVIEW_TEXT", "DETAIL_PICTURE", "DETAIL_TEXT", "IBLOCK_SECTION_ID","PROPERTY_urist","TAGS");
$arFilter = Array("IBLOCK_ID" => IntVal($arParams['IBLOCK_ID']), "=ID" => intval($arParams['ELEMENT_ID']));
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while ($ob = $res->GetNext()) {

    $arResult['item'] = [
        'id' => $ob['ID'],
        'iblock_id' => $ob['IBLOCK_ID'],
        'name' => $ob['NAME'],
        'date' => date('d m Y',strtotime($ob['DATE_CREATE'])),
        'picture' => CFile::GetPath($ob['DETAIL_PICTURE']),
        'text' => $ob["DETAIL_TEXT"],
        'preview' => $ob['PREVIEW_TEXT'],
        'section' => $ob['IBLOCK_SECTION_ID'],
        'urist' => $ob['PROPERTY_URIST_VALUE'],
        'tags' => $ob['TAGS']
    ];
}

/**
 * iblock_id
 */

$arResult['iblock_id'] = $arParams['IBLOCK_ID'];
$arResult['new'] = (is_array($arResult['item'])) ? true : false;
/**
 * sections
 */

$arFilter = array('IBLOCK_ID' => intval($arParams['IBLOCK_ID']));
$rsSections = CIBlockSection::GetList(array('LEFT_MARGIN' => 'ASC'), $arFilter);
while ($arSection = $rsSections->fetch()) {
    $arResult['sections'][] = [
        'id' => $arSection['ID'],
        'name' => $arSection['NAME'],
    ];
}
if (!$USER->isAdmin()){
    $filter = ['ID' => $USER->GetID()];

    $select = array('ID', "NAME","LAST_NAME","PERSONAL_PHOTO");
    $rsUsers = CUser::GetList(($by = "NAME"), ($order = "ASC"), $filter, $select); // выбираем пользователей
    if ($arUser = $rsUsers->fetch()) {
        $arResult['self']= [
            'id' => $arUser['ID'],
            'name' => "{$arUser['NAME']} {$arUser['LAST_NAME']}",
            'photo' => CFile::ResizeImageGet($arUser["PERSONAL_PHOTO"], Array("width" => 60, "height" => 60), BX_RESIZE_IMAGE_PROPORTIONAL_ALT)['src']
    ];
    }
}


if ($USER->isAdmin()) {
    /**
     * list urist
     */

    $filter = Array
    (
        "GROUPS_ID" => Array(8),
        "ACTIVE" => "Y"
    );
    $select = array('ID', "NAME");
    $rsUsers = CUser::GetList(($by = "NAME"), ($order = "ASC"), $filter, $select); // выбираем пользователей
    while ($arUser = $rsUsers->fetch()) {
        $arResult['urists'][] = [
            'value' => $arUser['ID'],
            'selected' => ($arUser['ID'] == $arResult['item']['urist']) ? true : false,
            'text' => "{$arUser['LAST_NAME']} {$arUser['NAME']}",
            'description' => '',
            'imageSrc' => CFile::ResizeImageGet($arUser["PERSONAL_PHOTO"], Array("width" => 60, "height" => 60), BX_RESIZE_IMAGE_PROPORTIONAL_ALT)['src']
        ];
    }

    /**
     *  CNT
     */

    $arSelect = Array("ID", 'IBLOCK_ID', "PROPERTY_urist");
    $arFilter = Array("IBLOCK_ID" => IntVal($arParams['IBLOCK_ID']), "=ACTIVE" => "Y", "!PROPERTY_URIST" => false);
    $res = CIBlockElement::GetList(Array(), $arFilter, array('PROPERTY_URIST'), false, $arSelect);
    while ($ob = $res->fetch()) {
        $arResult['leters'][$ob['PROPERTY_URIST_VALUE']] = $ob['CNT'];

    }

    /**
     * compare
     */

    foreach ($arResult['urists'] as $key => $urist) {
        $cnt = (intval($arResult['leters'][$urist['value']]) > 0) ? $arResult['leters'][$urist['value']] : 0;
        $arResult['urists'][$key]['description'] = "Статей: {$cnt}";
    }

    $uristKey = array_search(true, array_column($arResult['urists'], 'selected'));
    $arResult['selectedUrist'] = $arResult['urists'][$uristKey];
}
$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($arParams["IBLOCK_ID"], $arParams['ELEMENT_ID']);
$arResult["seo"] = $ipropValues->getValues();
$this->IncludeComponentTemplate();
?>