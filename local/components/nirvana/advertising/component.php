<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>");
Asset::getInstance()->addString("<script src=\"//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js\"></script>");
Asset::getInstance()->addString("<link href=\"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\" rel=\"stylesheet\"
      integrity=\"sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN\" crossorigin=\"anonymous\">");

if ($arParams['ADMIN'] == 'Y'){
    CModule::IncludeModule('iblock');

    $arSelect = Array("ID", "PROPERTY_478","PROPERTY_479","PROPERTY_480","DATE_CREATE","ACTIVE");
    $arFilter = Array("IBLOCK_ID"=>IntVal(63));
    $res = CIBlockElement::GetList(Array('ACTIVE'=>'asc'), $arFilter, false, Array("nTopCount"=>50), $arSelect);
    while($tmp = $res->fetch())
    {
        $new = false;
        $dayRegister = date('d.m.Y',strtotime($tmp['DATE_CREATE']));
        $curday = date('d.m.Y');
        $d1 = strtotime($dayRegister);
        $d2 = strtotime($curday);
        $diff = $d2-$d1;
        $diff = $diff/(60*60*24);
        $years = floor($diff);
        if ($years <=4){
            $new = true;
        }
        $arResult['items'][] = [
          'id' => $tmp['ID'],
          'name' => $tmp['PROPERTY_478_VALUE'],
            'mail' => $tmp['PROPERTY_479_VALUE'],
            'text' => $tmp['PROPERTY_480_VALUE'],
            'preview' => TruncateText($tmp['PROPERTY_480_VALUE'], 100),
            'new' => $new,
            'isActive' => ($tmp['ACTIVE'] == 'Y'),
            'view' => false
        ];
    }
}


$this->IncludeComponentTemplate();
?>