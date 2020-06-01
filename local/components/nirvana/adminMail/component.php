<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;
CModule::IncludeModule('iblock');
if ($arParams['METHOD']){$method = ['PROPERTY_METHOD' => 1];}else {$method = ['!PROPERTY_METHOD' => 1];}
if($USER->isAdmin()){
    $arFilter = Array("IBLOCK_ID"=>IntVal(44),$method);
}else{
    $arFilter = Array("IBLOCK_ID"=>IntVal(44),"CREATED_BY" => $USER->GetID(),$method);
    $arResult['usr'] = true;
}
$arr = [];
$arSelect = Array("ID", "NAME","ACTIVE", "DATE_CREATE","PREVIEW_TEXT","CREATED_BY");
$res = CIBlockElement::GetList(Array('DATE_CREATE'=> 'ASC'), $arFilter, false, Array("nPageSize"=>10), $arSelect);
while($ob = $res->fetch())
{
    $arr[] = $ob['ID'];
    $rsUser = CUser::GetByID(intval($ob['CREATED_BY']));
    $arUser = $rsUser->fetch();
    $arResult['mails'][] = [
        'id' => $ob['ID'],
        'date' => date('d/m',strtotime($ob['DATE_CREATE'])),
        'preview' => TruncateText($ob['PREVIEW_TEXT'], 100),
        'text' => $ob['PREVIEW_TEXT'],
        'view' => false,
        'done' => false,
        "detailComment" => '',
        'comment' => 0,
        'user' => [
            'name' => $arUser['NAME'] .' '. $arUser['LAST_NAME'],
            'prof' => (mb_strlen($arUser['PERSONAL_PROFESSION']) > 0)?$arUser['PERSONAL_PROFESSION']:'Пользователь'
        ]
    ];
}
$answers = [];
$arSelect = Array("ID","PROPERTY_OBJECT","CREATED_BY");
$arFilter = Array("IBLOCK_ID"=>IntVal(38), array("PROPERTY_OBJECT" => $arr));
$res = CIBlockElement::GetList(Array('DATE_CREATE'=> 'ASC'), $arFilter, false, false, $arSelect);
while($ob = $res->fetch())
{
    $answers[$ob['PROPERTY_OBJECT_VALUE']][] = [
        'autor' => $ob['CREATED_BY'],
    ];
}

foreach ($answers as $key => $answer){
    $key1 = array_search($key, array_column($arResult['mails'], 'id'));
    $arResult['mails'][$key1]["comment"] = count($answers[$key]);
    $arResult['mails'][$key1]["done"] = inGroup(1,end($answers[$key]));
}
$this->IncludeComponentTemplate();
?>