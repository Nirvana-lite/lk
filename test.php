<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $DB;
CModule::IncludeModule("iblock");


$url = "https://api.keys.so/report/keywords?sort=wsk%7Casc&page=1&per_page=25";
$curl = curl_init();
$headers = array('X-Keyso-TOKEN: 5dcd516c3664e6.860454527368e8a4eaf6bd26aed7fff335113351');
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, true);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($curl, CURLOPT_TIMEOUT, 15);
$response = curl_exec($curl);
$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
$headerCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$responseBody = substr($response, $header_size);
curl_close($curl);

pre($response);

die();

use DiDom\Document;
use DiDom\Query;
require($_SERVER["DOCUMENT_ROOT"] . "/local/include/didom/includ_didom.php");

$arFilter = Array(
    "IBLOCK_ID" => 35,
    "CODE" => false
);
$res = CIBlockElement::GetList(
    Array("ID"=>"ASC"),
    $arFilter,
    Array("ID", "IBLOCK_ID", "NAME")
);

$i = 0;
while($itemdf = $res->Fetch() ) {

    $transCode = trim($itemdf['NAME']);
    $arParams = array( "max_len"=>100, "replace_space" => "-", "replace_other" => "-");
    $transCode = Cutil::translit($transCode, "ru", $arParams);
    $transCode = trim($transCode, '-');
    $arLoadProductArray = Array(
        "CODE" => "{$transCode}-{$itemdf['ID']}"
    );

    $arDB = $DB->Query("UPDATE `b_iblock_element` SET `CODE` = '{$transCode}-{$itemdf['ID']}' WHERE `IBLOCK_ID`=35 AND `ID`=" . $itemdf['ID']);

    $i++;

    if($i > 1000){
        break;
    }

}

echo $i;

die();
// парсер https://dbsd.ru/
/* --- 1.2 --- Загрузка страницы при помощи cURL */
function curl_get_contents($page_url, $base_url, $pause_time, $retry) {
    /*
    $page_url - адрес страницы-источника
    $base_url - адрес страницы для поля REFERER
    $pause_time - пауза между попытками парсинга
    $retry - 0 - не повторять запрос, 1 - повторить запрос при неудаче
    */
    $error_page = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0");
    //curl_setopt($ch, CURLOPT_COOKIEJAR, str_replace("\\", "/", getcwd()).'/gearbest.txt');
  //  curl_setopt($ch, CURLOPT_COOKIEFILE, str_replace("\\", "/", getcwd()).'/gearbest.txt');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Автоматом идём по редиректам
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); // Не проверять SSL сертификат
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); // Не проверять Host SSL сертификата
    curl_setopt($ch, CURLOPT_URL, $page_url); // Куда отправляем
    curl_setopt($ch, CURLOPT_REFERER, $base_url); // Откуда пришли
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Возвращаем, но не выводим на экран результат
    $response['html'] = curl_exec($ch);
    $info = curl_getinfo($ch);
    if($info['http_code'] != 200 && $info['http_code'] != 404) {
        $error_page[] = array(1, $page_url, $info['http_code']);
        if($retry) {
            sleep($pause_time);
            $response['html'] = curl_exec($ch);
            $info = curl_getinfo($ch);
            if($info['http_code'] != 200 && $info['http_code'] != 404)
                $error_page[] = array(2, $page_url, $info['http_code']);
        }
    }
    $response['code'] = $info['http_code'];
    $response['errors'] = $error_page;
    curl_close($ch);
    return $response;

}

$gethtml = curl_get_contents(
    'https://dbsd.ru/contracts/lease-contract/34.html',
    'ya.ru',
    '1000',
    1
);

$document = new Document($gethtml['html'], false, 'windows-1251');
$h1 = $document->find('h1')[0]->text();
pre($h1);




die();

//
function generat_keywords($name){
    $name = mb_strtolower($name, 'UTF-8');

    $name = preg_replace('/[^a-zA-Zа-яА-Я0-9\s]/ui', ' ', $name);
    $name = preg_replace('/[\s]{2,}/', ' ', $name);
    $name = trim($name);
    $name = preg_replace('/\s/', ',', $name);
    return $name;
}


//if (!$arResult['IPROPERTY_VALUES']) {
//pre($arResult);

$arFilter = Array(
    "IBLOCK_ID" => 56,
);
$res = CIBlockElement::GetList(
    Array("ID"=>"ASC"),
    $arFilter,
    Array("ID", "IBLOCK_ID", "NAME", "DETAIL_TEXT")
);
while($itemdf = $res->Fetch() ) {


    $document = new Document($itemdf['DETAIL_TEXT']);
    $ul = $document->find('.kol-table .content');

    $mass = '';
    foreach ($ul as $item) {
        $item = $item->text();
        $mass .= ' ' . $item.' ';
    }
    $mass = preg_replace("/\<br(\s*)?\/?\>/i", " ", $mass);
    $mass = preg_replace("/[\s]{2,}/", " ", $mass);
    $mass = trim($mass);



/*
    $mass = strip_tags($itemdf['DETAIL_TEXT']);
    $mass = str_replace(array("\r","\n")," ",$mass);
    $mass = preg_replace("/[\s]{2,}/", " ", $mass);

*/


 echo $itemdf['ID'];

    $arFields = Array(
        "ELEMENT_META_TITLE" => $itemdf['NAME'],
        "ELEMENT_META_DESCRIPTION" => desc150($mass),
        "ELEMENT_META_KEYWORDS" => generat_keywords($itemdf['NAME']),
    );
    $ipropTemplates = new \Bitrix\Iblock\InheritedProperty\ElementTemplates($itemdf['IBLOCK_ID'], $itemdf['ID']);
    $ipropTemplates->set($arFields);

    $document = null;
// break;
}


echo 'end';

die();
function check_page_http($url)
{
    $headers = get_headers($url);
    return $headers = explode(' ', $headers[0]);
}

// $tstone = check_page_http('http://s155365.hostiman.com/profile/1538/stati/');

// pre($tstone);

set_time_limit(0);
//ini_set('memory_limit', '2048M');

/*
 *
 *  исправление файлов
$file_nameone = $_SERVER["DOCUMENT_ROOT"] . '/id_comments/iblock_23_to_53_rts_2_old.json';
$json = file_get_contents($file_nameone);
$array_dt = json_decode($json, true);

$file_nameone = $_SERVER["DOCUMENT_ROOT"] . '/id_comments/iblock_23_to_53_rts_1.json';
$json = file_get_contents($file_nameone);
$array_dt1 = json_decode($json, true);

foreach ($array_dt as $key => $item){

    $db_props = CIBlockElement::GetProperty(23, $key, array("sort" => "asc"), Array("CODE"=>"PARENT"));
    $ar_props = $db_props->Fetch();
    $parent_id = IntVal($ar_props["VALUE"]);
    //echo $parent_id;
    //pre($array_dt1[$parent_id]);

    $array_dt[$key]['parent_id'] = $array_dt1[$parent_id]['parent_id'];
}


$fp = fopen($_SERVER["DOCUMENT_ROOT"] . '/id_comments/iblock_23_to_53_rts_2.json', 'w');
fwrite($fp, json_encode($array_dt));
fclose($fp);

*/


global $array_dt;

function add_level($depht, $arraydata, $array_dt){


    if($depht > 1){
        // загрузка предыдущего файла для привязки -> поле родитель
        $parent_idone = $arraydata['PROPERTY_VALUES']['PARENT']; // id родителя
        $arraydata['PROPERTY_VALUES']['PARENT'] = $array_dt[$parent_idone]['new']; // получаем новый id привязанный и перезаписываем
        $arraydata['PROPERTY_VALUES']['OP'] = $array_dt[$parent_idone]['parent_id'];
    }

   /* if($depht == 1){
        $arraydata['PROPERTY_VALUES']
    }*/


    $el = new CIBlockElement;
    $arLoadArray = Array( // поля в которые добавляем
        "NAME" => $arraydata['NAME'],
        "PREVIEW_TEXT" => $arraydata['PREVIEW_TEXT'],
        "IBLOCK_ID"=>53,
        "DATE_CREATE" => $arraydata['DATE_CREATE'],
        "CREATED_BY" => $arraydata['CREATED_BY'],
        "PROPERTY_VALUES" => $arraydata['PROPERTY_VALUES'],
        "ACTIVE" => "Y",
    );

    if($PRODUCT_ID = $el->Add($arLoadArray)){ // добавление элемента
        $el = null;
        return array ( 'new' =>$PRODUCT_ID, 'parent_id' => $arraydata['PROPERTY_VALUES']['OP']);
    } else{
        $el = null;
        return 0;
    }

}




$arSelect = Array(
    "ID",
    "IBLOCK_ID",
    "NAME",
    "DATE_CREATE",
    "CREATED_BY",
    "PREVIEW_TEXT",
    "PROPERTY_OBJECT",
    "PROPERTY_USER",
    "PROPERTY_EMAIL",
    "PROPERTY_NONUSER",
    "PROPERTY_DEPTH",
    "PROPERTY_PARENT",
    "SHALOBA_COMMENT",
    "PROPERTY_LIKE",
    "PROPERTY_DISLIKE",
    "PROPERTY_MORE_PHOTO",
    "PROPERTY_AVATARNONUSER",

);


$depht = 9;
$file_name = $_SERVER["DOCUMENT_ROOT"].'/id_comments/iblock_23_to_53_rts_'.$depht.'.json';


$arFilter = Array(
   // "ID" => 277481,
    "IBLOCK_ID"=>23,
    "ACTIVE"=>"Y",
    "PROPERTY_DEPTH"=>$depht,
);

$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    //pre($arFields);


    $props = $ob->GetProperties();

    $cm[$arFields['ID']] = array(
        "ID" => $arFields['ID'],
        "IBLOCK_ID" => $arFields['IBLOCK_ID'],
        "NAME" => $arFields['NAME'],
        "PREVIEW_TEXT" => $arFields['PREVIEW_TEXT'],
        "DATE_CREATE" => $arFields['DATE_CREATE'],
        "CREATED_BY" => $arFields['CREATED_BY'],
        "PROPERTY_VALUES" => array(
                'OBJECT' => $arFields['PROPERTY_OBJECT_VALUE'],
                'USER' => $arFields['PROPERTY_USER_VALUE'],
                'EMAIL' => $arFields['PROPERTY_EMAIL_VALUE'],
                'NONUSER' => $arFields['PROPERTY_NONUSER_VALUE'],
                'DEPTH' => $arFields['PROPERTY_DEPTH_VALUE'],
                'PARENT' => $arFields['PROPERTY_PARENT_VALUE'],
                'SHALOBA_COMMENT' => $props['SHALOBA_COMMENT']['VALUE'],
                'LIKE' => '['.(intval($arFields['PROPERTY_LIKE_VALUE'])).','. (intval($arFields['PROPERTY_DISLIKE_VALUE'])).']',
                'AVATARNONUSER' => $props['AVATARNONUSER']['VALUE'],
                'MORE_PHOTO' => $props['MORE_PHOTO']['VALUE'],
        ),

    );


    //pre(array($arFields['ID'] => $arFields['PROPERTY_DEPTH_VALUE']));

}







// собираем json файл для DEPTH и его сравнения
// [id старый] = [id новый]


if($depht > 1) {
    // загрузка предыдущего файла для привязки -> поле родитель
    $file_nameone = $_SERVER["DOCUMENT_ROOT"] . '/id_comments/iblock_23_to_53_rts_' . ($depht - 1) . '.json';
    $json = file_get_contents($file_nameone);
    $array_dt = json_decode($json, true); // из object в array assoc -> parametr true
}

//pre(count($array_dt));
//pre(count($cm));

//die();

$error_id = false;




foreach ($cm as $key => $value){


    $id_new = add_level($depht, $cm[$key], $array_dt); // передаем массив с данными

    if( count($id_new) < 1){
        echo "ошибка";
        $error_id = true;
        break;
    }

    $response[$key] = array(
        'new' => $id_new['new'],  // новый id элемента
        'old' => $key,    // id привязанный
        'parent_id' => $id_new['parent_id'], // id самого первого комментария
    );


}

if(!$error_id) { // при создании не было ошибок
    $fp = fopen($file_name, 'w');
    fwrite($fp, json_encode($response));
    fclose($fp);
}





/*

$arParams["OBJECT_ID"] =  276185;
$arParams["COUNT"] = 10;
$arNavParams = array(
    "nTopCount" => $arParams["COUNT"],
    "bDescPageNumbering" => $arParams["PAGER_DESC_NUMBERING"],
);

//$arResult = array_merge($arResult, KhayRComment::Show(23,$arParams, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "PROPERTY_*"), array("DATE_CREATE" => "DESC"), $arNavParams));
$arResult = KhayRComment::Show(23,$arParams, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "PROPERTY_*"), array("DATE_CREATE" => "DESC"), $arNavParams);

pre($arResult);

*/
?>