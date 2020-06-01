<?

use DiDom\Document;
use DiDom\Query;
use DiDom\Element;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"] . "/local/include/didom/includ_didom.php");


///if (!CModule::IncludeModule('iblock')) { return false;}


die('no page1');
exit('no page2');

// Корректность ссылки (URL)
function check_url($url)
{
    if (preg_match("@^http://@i", $url)) $url = preg_replace("@(http://)+@i", 'http://', $url);
    else if (preg_match("@^https://@i", $url)) $url = preg_replace("@(https://)+@i", 'https://', $url);
    else $url = 'http://' . $url;


    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
        return false;
    } else return $url;
}

// Существование ссылки (URL)
function open_url($url)
{
    $url_c = parse_url($url);

    if (!empty($url_c['host']) and checkdnsrr($url_c['host'])) {
        // Ответ сервера
        if ($otvet = @get_headers($url)) {
            return substr($otvet[0], 9, 3);
        }
    }
    return false;
}


function imgempty($dettext)
{

    $html = sprintf('<div id="textcm464578">%s</div>', trim($dettext));
    $document = new Document($html);

    $ext150 = $document->text();
    // three p pervie

    $iframe = $document->find('iframe');
    if (count($iframe) > 0) {
        foreach ($iframe as $iframelist) {
            $iframelist->remove();
        }
    }
    $style = $document->find('style');
    if (count($style) > 0) {
        foreach ($style as $stylelist) {
            $stylelist->remove();
        }
    }
    $script = $document->find('script');
    if (count($script) > 0) {
        foreach ($script as $scriptlist) {
            $scriptlist->remove();
        }
    }

    // удаление пустых

   /* $empty_array = $document->find('#textcm464578 *');
    foreach ($empty_array as $tagsn) {
        if($tagsn->tag == 'img'){
            continue;
        }else{
            $tagsn_text = $tagsn->text();
            if (empty(trim(strip_tags($tagsn_text)))) {

                $tagsn->remove();


            }else{
                continue;
            }
        }
    }*/

    $img_array = $document->find('#textcm464578 img');

    // img add alt title
    if (count($img_array) > 0) {
        foreach ($img_array as $img) {

            $src = $img->getAttribute('src');
            $src = trim(strip_tags($src));

            $pos = strpos($src, '/'); // есть символ " / " или vestnikimages

            if ($pos === false) { // нет

                // удалить не правильная ссылка
                $img->remove();

            } else { // есть

                // проверить есть ли файл на сервере
                if (!empty($src)) {
                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . $src)) {
                       continue;
                    } else {
                        $img->remove();  // находится на другом сайте
                    }
                } else {
                    $img->remove();
                }


            }
        }
    }

    $link_array = $document->find('#textcm464578 a');
    if (count($link_array) > 0) {
        foreach ($link_array as $link) {
            $linktxt = $link->text();
            if (empty(trim(strip_tags($linktxt)))) {
                $link->remove();
            }else{
                $link->setInnerHtml($linktxt);
            }
        }
    }

    $det_text = $document->first('#textcm464578')->innerHtml();
    $document = null;
    return $det_text;
}

function checkdetail($dettext)
{
    $html = sprintf('<div id="textcm464578">%s</div>', trim($dettext));
    $document = new Document($html);
    $entrycontent = $document->first('#textcm464578 .entry-content');
    if (count($entrycontent) > 0) {
        $det_text = $entrycontent->innerHtml();
        $det_text = preg_replace('/[\s]{2,}/', ' ', $det_text);
        $document = null;
        return $det_text;
    }else{
        $det_text = $document->first('#textcm464578')->innerHtml();
        $det_text = preg_replace('/[\s]{2,}/', ' ', $det_text);
        $document = null;
        return $det_text;
    }
}

function check_h1_detail($dettext){
    $html = sprintf('<div id="textcm464578">%s</div>', trim($dettext));
    $document = new Document($html);
    $h1_content = $document->find('#textcm464578 h1');
    if (count($h1_content) > 0) {
        foreach ($h1_content as $h1_element) {
            $h1_element->removeAllAttributes();
            $texth1 = $h1_element->text();
            $test_heading = new Element('h2', $texth1);
            $h1_element->replace($test_heading);
        }
        $det_text = $document->first('#textcm464578')->innerHtml();
        $document = null;
        return $det_text;

    } else{
        $document = null;
        return false;
    }

}


function removeempty($text){
    $pattern = "/<p[^>]*>[\s|&nbsp;]*<\/p>/i";
    $DETAIL_TEXT = preg_replace($pattern, '', $text);

    $pattern = "/<span[^>]*>[\s|&nbsp;]*<\/span>/i";
    $DETAIL_TEXT = preg_replace($pattern, '', $DETAIL_TEXT);

    $pattern = "/<a[^>]*>[\s|&nbsp;]*<\/a>/i";
    $DETAIL_TEXT = preg_replace($pattern, '', $DETAIL_TEXT);

    $pattern = "/<h2[^>]*>[\s|&nbsp;]*<\/h2>/i";
    $DETAIL_TEXT = preg_replace($pattern, '', $DETAIL_TEXT);

    $pattern = "/<li[^>]*>[\s|&nbsp;]*<\/li>/i";
    $DETAIL_TEXT = preg_replace($pattern, '', $DETAIL_TEXT);

    $pattern = "/<ul[^>]*>[\s|&nbsp;]*<\/ul>/i";
    $DETAIL_TEXT = preg_replace($pattern, '', $DETAIL_TEXT);

    $pattern = "/<ol[^>]*>[\s|&nbsp;]*<\/ol>/i";
    $DETAIL_TEXT = preg_replace($pattern, '', $DETAIL_TEXT);

    return $DETAIL_TEXT;
}


CModule::IncludeModule('iblock');
global $CACHE_MANAGER;

/*
function geturl($textnb, $idnb = 0){
    $textnb = html_entity_decode($textnb); // &quot;
    $rpstr = array('"',"'", '&nbsp;', '&quot;', '&amp;');
    $textnb = str_replace($rpstr, ' ', $textnb);
    //$textnb = str_replace("&nbsp;", ' ', $textnb);
    //$textnb = preg_replace("/&#?[a-z0-9]{2,8};/i"," ",$textnb);
    $textnb = trim($textnb);
    $textnb = preg_replace('/[\s]{2,}/', ' ', $textnb);

    $arParamsLn = array(
        "max_len" => "100", // обрезаем символьный код до 100 символов
        "change_case" => "L", // приводим к нижнему регистру
        "replace_space" => "-", // меняем пробелы на тире
        "replace_other" => "-", // меняем плохие символы на тире
        "delete_repeat_replace" => "true", // удаляем повторяющиеся тире
        "use_google" => "false", // отключаем использование google
    );
    $linkcode = Cutil::translit($textnb, "ru", $arParamsLn);
    $linkcode = rtrim($linkcode, "-");

    if ($idnb > 0) {
        $linkcode = $linkcode . '-' . $idnb;
    }

    return $linkcode;
}

$arSelect = Array("ID", "NAME", "CODE", "PREVIEW_TEXT", "PROPERTY_125");
$arFilter = Array("IBLOCK_ID"=>15, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array('ID'=>'DESC'), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{

    $fild = $ob->GetFields();

    if( empty(trim($fild['CODE'])) ){

        if ( empty($fild['~PROPERTY_125_VALUE']) ){ // название вопроса не заполнено

            $gen_name_vopros = trim(strip_tags($fild['PREVIEW_TEXT']));
            $gen_name_vopros = desc150($gen_name_vopros, 70 );


            //CIBlockElement::SetPropertyValuesEx($fild['ID'], 15, array('name_vopros' => $gen_name_vopros));
            // pre($fild['ID']);
            //break;

        } else { // название вопроса заполнено

        }
        pre($fild['ID']);
        $link = geturl($fild["PROPERTY_125_VALUE"], $fild['ID']);
        $el = new CIBlockElement;
        $arLoadProductArray = Array(
            "CODE" => $link
        );
        //$el->Update($fild['ID'], $arLoadProductArray);

        $el=null;

        //break;
        //pre($fild['~PROPERTY_125_VALUE']);



    } else {
        continue;
    }



//break;
}*/

$arSelect = Array("ID", "NAME", "DETAIL_TEXT", "PREVIEW_TEXT");

$arFilter = Array("IBLOCK_ID"=>29); // все элементы


// 34002 -> путь к картинке не правильный
// 31912 -> путь к картинки верный - 31377


//$arFilter = Array("IBLOCK_ID" => 29, "ID" => 34002); // конкретный id


$res = CIBlockElement::GetList(Array('ID' => 'DESC'), $arFilter, false, false, $arSelect);

$i = 0;
$check =0;
while ($ob = $res->GetNext()) {

    $el = new CIBlockElement;

    echo '<h1>'.$ob['ID'].' - ' . $ob['NAME'] . '</h1>';
    echo "<hr>";
    $PREVIEW_TEXT = imgempty($ob['PREVIEW_TEXT']);
    $DETAIL_TEXT = imgempty($ob['DETAIL_TEXT']);

    //$PREVIEW_TEXT = removeempty($PREVIEW_TEXT);
    //$DETAIL_TEXT = removeempty($DETAIL_TEXT);

   /* $arLoadProductArray = Array(
        "PREVIEW_TEXT" => strip_tags(removeempty($PREVIEW_TEXT)),
        "PREVIEW_TEXT_TYPE" => 'html',
        "DETAIL_TEXT" => removeempty($DETAIL_TEXT),
        "DETAIL_TEXT_TYPE" => 'html',
    );*/

    $checkh1 = check_h1_detail($DETAIL_TEXT);

    if($checkh1 === false){
        $el = null;
        continue;
    }else{
        $DETAIL_TEXT = $checkh1;
        $arLoadProductArray = Array(
            // "DETAIL_TEXT" => checkdetail($DETAIL_TEXT),
            "DETAIL_TEXT" => $DETAIL_TEXT,
            "DETAIL_TEXT_TYPE" => 'html',
        );
       // echo "<hr><h1>id - ".$ob['ID']."</h1><hr>";
        //$el->Update($ob['ID'], $arLoadProductArray);
    }



    $el = null;
    $i++;
    //break;
}

echo "<hr>всего ".$i. " - ".$check;
$CACHE_MANAGER->ClearByTag("iblock_id_29");
CIBlock::clearIblockTagCache(29);

?>