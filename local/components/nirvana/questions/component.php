<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");
/*Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>");
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>");*/
global $USER, $DB;
CModule::IncludeModule('iblock');
CPageOption::SetOptionString("main", "nav_page_in_session", "N");
if ($arParams['URIST'] === 'office') {
    $cur_user_id = $USER->GetID();
    $rsUser = CUser::GetByID($cur_user_id);
    $arUser = $rsUser->Fetch();
    $usr_off_id = $arUser['UF_CRM_ID_O'];

    /**
     * time
     */

    $now1 = mktime(18, 20, date('s'), date('m'), date('d') - 1, date('Y'));
    $now1 = date('d.m.Y H:i:s', $now1);
    $now_day1 = date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(18, 20, date('s'), date('m'), date('d') + 1, date('Y')));

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
    $arFilter = Array("IBLOCK_ID" => IntVal(questions), "ACTIVE" => array("Y", "N"), array("<=DATE_CREATE" => $now_day1, ">=DATE_CREATE" => $now1), "=PROPERTY_officeid" => $usr_off_id);
//    $arUser['UF_CRM_ID_O'];
    $resQuest = CIBlockElement::GetList(Array('DATE_CREATE' => 'ASC'), $arFilter, false, Array("nPageSize" => 10), $arSelect);
    while ($ob = $resQuest->GetNextElement()) {
        $item = $ob->GetFields();
        if ($item['PROPERTY_401'] === 'Y') {
            $status = $arResult['status']['defect'];
        } elseif ($item['PROPERTY_399'] == 1) {
            $status = $arResult['status']['done'];
        } else {
            $status = $arResult['status']['new'];
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

    $arResult['total'] = $resQuest->SelectedRowsCount();
} else {
    /**
     * questions
     */
    $sectionsArr = [];
    $questionArr = [];
    $arSelect = Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "PREVIEW_TEXT", "DATE_CREATE", "PROPERTY_*");
    $arFilter = Array("IBLOCK_ID" => IntVal(questions), "ACTIVE" => array("Y","N"));
    $res = CIBlockElement::GetList(Array('DATE_CREATE' => 'DESC'), $arFilter, false, Array("nPageSize" => 10), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $item = $ob->GetFields();
        $sectionsArr[] = $item['IBLOCK_SECTION_ID'];
        $questionArr[] = $item['ID'];
        $arResult['questions'][] = [
            'id' => $item['ID'],
            'autor' => $item['NAME'],
            'date' => date('d.m | H:i', strtotime($item['DATE_CREATE'])),
            'preview' => trim(strip_tags(TruncateText($item["PREVIEW_TEXT"], 150))),
            'text' => trim(strip_tags($item["PREVIEW_TEXT"])),
            'city' =>  $item["PROPERTY_78"],
            'section' => $item['IBLOCK_SECTION_ID'],
            'name' => $item['PROPERTY_125'],
            'answercount' => 0,
            'open' => false,
            'detailComment'=> ''
        ];
    }

    /**
     * get answer count
     */
    $newAnswerArr = [];
    $arSelect = Array("ID", "IBLOCK_ID","PROPERTY_84");
    $arFilter = Array("IBLOCK_ID" => IntVal(18), "ACTIVE" => array("Y"),"PROPERTY_84"=> $questionArr);
    $answerRes = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while ($arAnswer = $answerRes->fetch()){
            $newAnswerArr[$arAnswer['PROPERTY_84_VALUE']]++;
    }


    /**
     * get section Name
     */

    $sectionsArr = array_diff($sectionsArr, array(''));
    if (count($sectionsArr) >0){
        $newArr = [];
        $sectSelect = array('ID',"NAME","IBLOCK_ID");
        $arFilter = array('IBLOCK_ID' => questions, "ID" => $sectionsArr);
        $rsSect = CIBlockSection::GetList(array(),$arFilter,false,$sectSelect);
        while ($arSect = $rsSect->fetch()){
            $newArr[$arSect['ID']] =  $arSect['NAME'];
        }
        foreach ($arResult['questions'] as $key => $quest){
            $arResult['questions'][$key]['section'] = $newArr[$quest['section']];
            $arResult['questions'][$key]['answercount'] = (count($newAnswerArr[$quest['id']]) > 0)?$newAnswerArr[$quest['id']]:0;
        }
    }


    $arResult['pages'] = $res->GetPageNavStringEx($navComponentObject, "", "ajax_news");

}
$this->IncludeComponentTemplate();
?>