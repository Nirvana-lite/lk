<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
CModule::IncludeModule('iblock');

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");
/**
 * comments Arr
 */

//$arSelect = Array("ID","IBLOCK_ID", "PREVIEW_TEXT", "PROPERTY_OBJECT", "PROPERTY_USER", "PROPERTY_NONUSER","PROPERTY_EMAIL",);
$arFilter = Array("IBLOCK_ID" => [37, 31, 46, 36, 23, 25], "=ACTIVE" => "N");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount" => 50));
while ($ob1 = $res->GetNextElement()) {
    $ob = $ob1->GetFields();
    $ob['prop'] = $ob1->GetProperties();
   if ($ob['IBLOCK_ID'] == 31){
       $rsUser = CUser::GetByID(intval($ob['prop']['OBJECT']['VALUE']));
       if($arUser = $rsUser->fetch())
           $letterName = "{$arUser['LAST_NAME']} {$arUser['NAME']}";
   }else{
       $res1 = CIBlockElement::GetByID($ob['prop']['OBJECT']['VALUE']);
       if ($ar_res = $res1->fetch()) {
           $letterName = $ar_res['NAME'];
       }
   }

    if (intval($ob['prop']['USER']['VALUE']) > 0) {
        $rsUser = CUser::GetByID(intval($ob['prop']['USER']['VALUE']));
        $arUser = $rsUser->fetch();
        $user = [
            'id' => $arUser['ID'],
            'name' => "{$arUser['LAST_NAME']} {$arUser['NAME']}",
            'mail' => $arUser['EMAIL']
        ];
    }else{
        $user = [
            'name' => "{$ob['prop']['NONUSER']['VALUE']}",
            'mail' => "{$ob['prop']['EMAIL']['VALUE']}",
        ];
    }


    $arResult[] = [
        'id' => $ob['ID'],
        'text' => $ob['PREVIEW_TEXT'],
        'letter' => $letterName,
        'user' => $user,
        'view' => true
    ];
}

$this->IncludeComponentTemplate();
?>