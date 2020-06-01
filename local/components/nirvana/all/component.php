<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");


CModule::IncludeModule('iblock');
function changeDetail($text){
    preg_match_all('/<p[^>]*?>(.*?)<\/p>/si', $text, $arrs);
    preg_match_all('#<p>(.+?)</p>#is', $arrs[0][0], $arr);
    $arFields['preview'] = trim($arr[1][0]);
    return $arFields;
}
$arSelect = Array("ID","IBLOCK_ID", "NAME", "DATE_CREATE","PREVIEW_TEXT","DETAIL_PICTURE","SHOW_COUNTER","DETAIL_TEXT","DETAIL_PAGE_URL","PROPERTY_*");
$arFilter = Array("IBLOCK_ID"=>array(popular,pravo,socprogram,questions), "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array('ID'=> 'RAND'), $arFilter, false, Array("nPageSize"=>10), $arSelect);
while($ob = $res->GetNext())
{
    switch ($ob['IBLOCK_ID']) {
        case 17:
            $sectName = 'Популярные темы';
            break;
        case 24:
            $sectName = 'Право и процесс';
            break;
        case 21:
            $sectName = 'Социальные Программы';
            break;
        default:
            $sectName = 'Вопросы';

    }
   if ($ob['IBLOCK_ID'] == questions){
       $res1 = CIBlockSection::GetByID($ob['IBLOCK_SECTION_ID']);
       if ($ar_res = $res1->GetNext()) {
           $sectionName = $ar_res['NAME'];
       } else {
           $sectionName = '';
       }
       $arResult[] = [
           'iblock' => $sectName,
           'id' => $ob['ID'],
           'autor' => $ob['NAME'],
           'show' => 1,
           'date' => date('d.m | H:i', strtotime($ob['DATE_CREATE'])),
           'preview' => trim(strip_tags(TruncateText($ob["PREVIEW_TEXT"], 150))),
           'text' => trim(strip_tags($ob["PREVIEW_TEXT"])),
           'city' =>  (!empty($ob["PROPERTY_78"]))?$ob["PROPERTY_78"]:$ob["PROPERTY_124"],
           'section' => $sectionName,
           'open' => false,
       ];
   }else{

       $text = changeDetail($ob['DETAIL_TEXT']);
       $arResult[] = [
           'iblock' => $sectName,
           'iblockId'=> $ob['IBLOCK_ID'],
           'id' => $ob['ID'],
           'show' => 0,
           'name' => $ob['NAME'],
           'url' => $ob['DETAIL_PAGE_URL'],
           'date' => date('d/m',strtotime($ob['DATE_CREATE'])),
           'picture' => CFile::ResizeImageGet(
               $ob['DETAIL_PICTURE'],
               array('width' => 150, 'height' => 150),
               BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
               true
           ),
           'view' => $ob['SHOW_COUNTER'],
           'preview' => TruncateText($text['preview'], 300),
           'detail' => null,
           'open'=> false
       ];
   }
}

$this->IncludeComponentTemplate();
?>