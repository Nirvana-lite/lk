<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;
Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");

CModule::IncludeModule('iblock');
/**
 * answers Arr
 */

if ($arParams['ALL'] == true){
    CPageOption::SetOptionString("main", "nav_page_in_session", "N");
    $arSelect = Array("ID", "PREVIEW_TEXT", "PROPERTY_125","IBLOCK_SECTION_ID");
    $arFilter = Array("IBLOCK_ID"=>IntVal($arParams['QUESTIONS_ID']), "=ACTIVE"=>"N",">PROPERTY_400" => 0);
    $res = CIBlockElement::GetList(Array('DATE_CREATE' => 'DESC'), $arFilter, false, array('nPageSize' => 10), $arSelect);
    while($ob = $res->fetch())
    {
        $sectRes = CIBlockSection::GetByID($ob['IBLOCK_SECTION_ID']);
        if($ar_res = $sectRes->GetNext()){
           $sectName = $ar_res['NAME'];
        }else{
            $sectName = 'Не Выбрано';
        }
        $arResult['items'][] = [
            'id' => $ob['ID'],
            'text'=> $ob['PREVIEW_TEXT'],
            'name' => $ob['PROPERTY_125_VALUE'],
            'section' => $sectName,
            'view' => true,
        ];
    }
    /**
     * sections
     */
    $arFilter = Array('IBLOCK_ID' => 15, 'ACTIVE' => 'Y');
    $db_list = CIBlockSection::GetList(Array('NAME' => 'ASC'), $arFilter, true);
    while ($ar_result = $db_list->GetNext()) {
        $arResult['sections'][] = $ar_result['NAME'];
    }
    $arResult['pages'] = $res->GetPageNavStringEx($navComponentObject, "", "ajax_news");
}
else{
    $arSelect = Array("ID", "PREVIEW_TEXT", "PROPERTY_84","PROPERTY_446","PROPERTY_447","PROPERTY_85");
    $arFilter = Array("IBLOCK_ID"=>IntVal($arParams['ANSWERS_ID']), "=ACTIVE"=>"N");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>50), $arSelect);
    while($ob = $res->fetch())
    {
        if (intval($ob['PROPERTY_85_VALUE']) > 0){
            $rsUser = CUser::GetByID($ob['PROPERTY_85_VALUE']);
            $arUser = $rsUser->fetch();
            $user = [
                'id' => $arUser['ID'],
                'name' => "{$arUser['LAST_NAME']} {$arUser['NAME']}",
                'mail' => "{$arUser['EMAIL']}",
                'prop' => "{$arUser['PERSONAL_PROFESSION']}"
            ];
        }else{
            $user = [
                'name' => "{$ob['PROPERTY_447_VALUE']}",
                'mail' => "{$ob['PROPERTY_446_VALUE']}",
                'prop' => (inGroup(5)) ? 'Пользователь' : 'Посетитель'
            ];
        }
        $arQuestion[$ob['PROPERTY_84_VALUE']][] = [
            'id' => $ob['ID'],
            'text'=> $ob['PREVIEW_TEXT'],
            'user'=> $user,
            'view' => true
        ];
    }

    /**
     * question Arr
     */
//pre($arQuestion);
//pre(array_keys($arQuestion));

    if (count($arQuestion) >0){
        $arSelect = Array("ID", "PREVIEW_TEXT", "PROPERTY_125");
        $arFilter = Array("IBLOCK_ID"=>IntVal($arParams['QUESTIONS_ID']), "ID" => array_keys($arQuestion));
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while($ob = $res->fetch())
        {
            $arResult[] = [
                'id' => $ob['ID'],
                'text'=> $ob['PREVIEW_TEXT'],
                'name' => $ob['PROPERTY_125_VALUE'],
                'view' => true,
                'answer' =>$arQuestion[$ob['ID']]
            ];
        }
    }
}



$this->IncludeComponentTemplate();
?>