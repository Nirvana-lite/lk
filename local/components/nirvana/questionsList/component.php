<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>");
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>");

global $USER;
CModule::IncludeModule('iblock');


function getQuestions($my = false){
    CModule::IncludeModule('iblock');
    CPageOption::SetOptionString("main", "nav_page_in_session", "N");
    if (intval($my) > 0){
        $arFilter = Array("IBLOCK_ID" => IntVal(questions), "ACTIVE" => array("Y","N"),"ID" => intval($my));
    }else{
        $arFilter = Array("IBLOCK_ID" => IntVal(questions), "ACTIVE" => array("Y","N"));
    }

    /**
     * questions
     */
    $sectionsArr =  $questionArr = $arResult['items'] = [];
    $arSelect = Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "PREVIEW_TEXT", "DATE_CREATE", "PROPERTY_*");
    $res = CIBlockElement::GetList(Array('DATE_CREATE' => 'DESC'), $arFilter, false, Array("nPageSize" => 10), $arSelect);
    while ($items = $res->GetNextElement()) {
        $item = $items->GetFields();
        $sectionsArr[] = $item['IBLOCK_SECTION_ID'];
        $questionArr[] = $item['ID'];
        $arResult['items'][] = [
            'id' => $item['ID'],
            'autor' => $item['NAME'],
            'date' => date('d.m | H:i', strtotime($item['DATE_CREATE'])),
            'preview' => trim(strip_tags(TruncateText($item["PREVIEW_TEXT"], 150))),
            'text' => trim(strip_tags($item["PREVIEW_TEXT"])),
            'city' =>  $item["PROPERTY_78"],
            'section' => $item['IBLOCK_SECTION_ID'],
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
        foreach ($arResult['items'] as $key => $quest){
            $arResult['items'][$key]['section'] = $newArr[$quest['section']];
            $arResult['items'][$key]['answercount'] = (is_array($newAnswerArr[$quest['id']]))?$newAnswerArr[$quest['id']]:0;
        }
    }
    $arResult['pages'] = $res->GetPageNavStringEx($navComponentObject, "", "ajax_news");
    return $arResult;
}

function getAnswers($my = false){
    CModule::IncludeModule('iblock');
    CPageOption::SetOptionString("main", "nav_page_in_session", "N");
    if (intval($my) > 0){
        $arAnswerFilter = Array("IBLOCK_ID" => IntVal(18), "ACTIVE" => "Y","PROPERTY_85" => intval($my));
    }
    $arAnswerSelect = Array("ID", "IBLOCK_ID","PROPERTY_*","DETAIL_TEXT");
    $resAnswerItems = CIBlockElement::GetList(Array(), $arAnswerFilter, false, false, $arAnswerSelect);
    while ($ob = $resAnswerItems->GetNextElement()){
        $elems = $ob->GetFields();
        $answers[$elems['ID']] = $elems;
    }

    $arQuestionSelect = Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "PREVIEW_TEXT", "DATE_CREATE", "PROPERTY_*");
    $arQuestionFilter = Array("IBLOCK_ID" => IntVal(18), "ACTIVE" => "Y","PROPERTY_83" => $answers);
    $resItems = CIBlockElement::GetList(Array('DATE_CREATE' => 'DESC'), $arQuestionFilter, false, Array("nPageSize" => 10), $arQuestionSelect);
    while ($questOb = $resItems->GetNextElement()){
        $answers[] = $questOb->GetFields();
        /*'id' => $item['ID'],
            'autor' => $item['NAME'],
            'date' => date('d.m | H:i', strtotime($item['DATE_CREATE'])),
            'preview' => trim(strip_tags(TruncateText($item["PREVIEW_TEXT"], 150))),
            'text' => trim(strip_tags($item["PREVIEW_TEXT"])),
            'city' =>  $item["PROPERTY_78"],
            'section' => $item['IBLOCK_SECTION_ID'],
            'answercount' => 0,
            'open' => false,
            'detailComment'=> ''*/
    }

    $arResult['pages'] = $resItems->GetPageNavStringEx($navComponentObject, "", "ajax_news");
    return $arResult;
}

$arResult['tabs'] = [
    'Все вопросы',
    'Мои вопросы',
    'Мои ответы',
    'Ответы на мои вопросы',
    'Комментарии на мои ответы',
];

$userId = $USER->GetID();
$arResult['allQuestions'] = getQuestions();
//$arResult['myQuestions'] = getQuestions($userId);
/*$arResult['myAnswers'] = getAnswers($userId);
$arResult['allAnswers'] = getAnswers();*/


$this->IncludeComponentTemplate();
?>