<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $DB;
$item = $_POST;
if ($item['change']){

    /**
     * time
     */

    if (!empty($item['start'])){
        $now1 = date('d.m.Y 00:00:00',strtotime($item['start']));
    }
    else{
        $now1 = date('d.m.Y 00:00:00');
    }

    if (!empty($item['end'])){
        $now_day1 = date('d.m.Y 23:59:59',strtotime($item['end']));
    }
    else{
        $now_day1 = date('d.m.Y 23:59:59');
    }

    $dt = [
      $now1,
      $now_day1
    ];



}else{

    /**
     * time
     */


    $now1 = mktime(18, 20, date('s'), date('m'), date('d') - 1, date('Y'));
    $now1 = date('d.m.Y H:i:s', $now1);
    $now_day1 = date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(18, 20, date('s'), date('m'), date('d') + 1, date('Y')));



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
 * questions
 */

$arSelect = Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "PREVIEW_TEXT", "DATE_CREATE", "PROPERTY_*");
$arFilter = Array("IBLOCK_ID" => IntVal(questions), "ACTIVE" => array("Y", "N"), array("<=DATE_CREATE" => $now_day1, ">=DATE_CREATE" => $now1), "=PROPERTY_officeid" => $item);
$resQuest = CIBlockElement::GetList(Array('DATE_CREATE' => 'ASC'), $arFilter, false, false, $arSelect);
$arResult['total'] = [
    'all' =>$resQuest->SelectedRowsCount(),
    'done' => 0,
    'defect' => 0,
    'new' => 0,
];
while ($ob = $resQuest->GetNextElement()) {
    $item = $ob->GetFields();
    if ($item['PROPERTY_401'] === 'Y') {
        $status = $arResult['status']['defect'];
        $arResult['total']['defect']++;
    } elseif ($item['PROPERTY_399'] == 1) {
        $status = $arResult['status']['done'];
        $arResult['total']['done']++;
    } else {
        $status = $arResult['status']['new'];
        $arResult['total']['new']++;
    }
    $res1 = CIBlockSection::GetByID($item['IBLOCK_SECTION_ID']);
    if ($ar_res = $res1->GetNext()) {
        $sectionName = $ar_res['NAME'];
    } else {
        $statusName = '';
    }
    $arResult['questions'][] = [
        'id' => $item['ID'],
        'autor' => $item['NAME'],
        'date' => date('H:i | d/m', strtotime($item['DATE_CREATE'])),
        'preview' => trim(strip_tags(TruncateText($item["PREVIEW_TEXT"], 150))),
        'text' => trim(strip_tags($item["PREVIEW_TEXT"])),
        'city' => (!$item["PROPERTY_124"]) ? $item["PROPERTY_124"] : $item["PROPERTY_78"],
        'phone' => $item['PROPERTY_281'],
        'status' => $status,
        'read' => $item['PROPERTY_399'],
        'defect' => $item['PROPERTY_401'],
        'reason' => $item['PROPERTY_402'],
        'open' => false,
        'choise' => [
            'city' =>  $item["PROPERTY_78"] ,
            'section' => $sectionName
        ],
        'ok' => ($item['PROPERTY_399'] === '1')?true:false
    ];
}




echo json_encode($arResult);