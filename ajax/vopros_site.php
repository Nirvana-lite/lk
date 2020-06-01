<?
/* общий обработчик
 * 1 - массив сайтов
 * 2 - массив данных
 *     1. id_iblock - инфоблок для сохранения
 *     2. id_eventsend - ид почтового события
 *
 */


define('STOP_STATISTICS', true);
define('NOT_CHECK_PERMISSIONS', true);
define("PUBLIC_AJAX_MODE", true);
define("NO_KEEP_STATISTIC", "Y");
define("NO_AGENT_STATISTIC", "Y");
define("NO_AGENT_CHECK", true);
define("DisableEventsCheck", true);


// функция для отправки на друой сайт


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die();
}

function POSTsites($url, $post_data)
{
    $post_data = $post_data;
    $url = $url;
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// указываем, что у нас POST запрос
    curl_setopt($ch, CURLOPT_POST, 1);
// добавляем переменные
    if ($post_data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }
    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if (empty($post_data)) {
        if ($httpcode == 200) { // jur24pro работает
            return $httpcode;
        } else {  // jur24pro не работает
            return $httpcode;
        }
    }

}


/*
 * удаляем двойные пробелы
 */

function removeDoubleBackspace($txtpol)
{
    $fixed_str = preg_replace('/[\s]{2,}/', ' ', $txtpol);
    return $fixed_str;
}


/*
 * определение города по ip
 */


/*
 * параметры для конкретного сайта данные инфоблока
 */
$mass_site = array(
    'jur24pro.ru' => array(
        'id_iblock' => 15,           // id block куда записывать
        'id_eventsend' => 50,          // id почтового события
        'type_eventsend' => 'FORM_OTHER_SITES',// название типа почтового сообщения
        'numberphone' => '281',      // номер для проверки по полю телефон
        'mascategory' => 'jur24pro', // разделы для сохранения
        'opredip' => 2,  // функция по определению ip -- 1 = наша, 2 = сторонняя
    ),

    'yurlitsa.ru' => array(
        'id_iblock' => 6,
        'id_eventsend' => 85,
        'type_eventsend' => 'FORM_OTHER_SITES',
        'numberphone' => '23',
        'mascategory' => 'default',
        'opredip' => 1,  // функция по определению ip -- 1 = наша, 2 = сторонняя, 3 - общая
    ),

    'chigiri.ru' => array(
        'id_iblock' => 6,
        'id_eventsend' => 85,
        'type_eventsend' => 'FORM_OTHER_SITES',
        'numberphone' => '23',
        'mascategory' => 'default',
        'opredip' => 1,  // функция по определению ip -- 1 = наша, 2 = сторонняя, 3 - общая
    ),
);

$allowed_http_origins = array( // проверка по HTTP_ORIGIN
    "https://jur24pro.ru",
    "https://yurlitsa.ru",
    "https://chigiri.ru",
);

use Bitrix\Main\Loader,
    Rover\GeoIp\Location;

require($_SERVER["DOCUMENT_ROOT"] . "/local/js/globalform/dataCategoryCity.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


$options_sait = $mass_site[$_SERVER['SERVER_NAME']]; // получаем настройки для определенного сайта
$datamass['namefn'] = $namefn = htmlspecialchars(strip_tags($_REQUEST['namefn']), ENT_QUOTES);     // функция выполнения скрипта


if ($namefn == 'create-vopros') {

    if(!check_bitrix_sessid()) {
        die();
    }
    $userCityip='';
    if ($options_sait['opredip'] == 1) {

        $iper = \Bitrix\Main\Service\GeoIp\Manager::getRealIp();
        $result = \Bitrix\Main\Service\GeoIp\Manager::getDataResult($iper, "ru");
        $getms = $result->getGeoData();
        $userCityip = trim($getms->cityName) . ' ' . trim($getms->regionName);      // город и регион
        $userCityip = trim($userCityip);

    } elseif ($options_sait['opredip'] == 2) {
        //rover.geoip

        if (Loader::includeModule('rover.geoip')) {
            $iper = Location::getCurIp();
            $location = Location::getInstance($iper);
            $location->setLanguage('ru');
            $userCityip = trim($location->getRegionName()) . ' ' . trim($location->getCityName()) . ' ' . trim($location->getDistrict());      // город и регион
            $userCityip = trim($userCityip);
        }

    } else {
        die();
    }

    if(empty(trim($userCityip))){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }


        $ip_address1 = $ip; // IP, который будем проверять
        $url = 'http://ipgeobase.ru:7020/geo?ip=' . $ip_address1;
        $xml1 = new DOMDocument();
        if ($xml1->load($url)) {
            $result = array();
            $root = $xml1->documentElement;
            $result = array(
                'region' => $root->getElementsByTagName('region')->item(0)->nodeValue,
                'city' => $root->getElementsByTagName('city')->item(0)->nodeValue,
                'district' => $root->getElementsByTagName('district')->item(0)->nodeValue
            );

            $userCityip = trim($result['region']) . ' ' . trim($result['city']) . ' ' . trim($result['district']);      // город и регион
            $userCityip = trim($userCityip);
        }
    }




}

/*
 * Данные передаваемые
 */


$sait_send = $_REQUEST['stsend'];       // сайт с которого отправлено
$sait_utf8 = $_REQUEST['utf8'];       // ✓ отсекаем тех у которых выключено js

if ($sait_utf8 != '✓') {
    die();
}

if (!array_key_exists($sait_send, $mass_site)) {
    die();
}


if (array_key_exists($_SERVER['SERVER_NAME'], $mass_site)) {

    /*
     * ввел пользователь
     */

    // сохранение в бд на этом сайте

    $datamass['nameusr'] = $name_user = htmlspecialchars(removeDoubleBackspace(strip_tags($_REQUEST['nameusr'])), ENT_QUOTES);     // имя пользователя
    $datamass['phoneusr'] = $phone_user = htmlspecialchars(strip_tags($_REQUEST['phoneusr']), ENT_QUOTES);  // телефон пользователя
    $datamass['title'] = $title_user = htmlspecialchars(removeDoubleBackspace(strip_tags($_REQUEST['title'])), ENT_QUOTES);     // тема краткое описание вопроса
    $datamass['txt'] = $txt_user = htmlspecialchars(removeDoubleBackspace(strip_tags($_REQUEST['txt'])), ENT_QUOTES);      // полное описание вопроса


    $catprava_user = intval(strip_tags(trim($_REQUEST['catprava'])));                                   // раздел сохранения когда пусто то возвращает ноль
    $datamass['cityusr'] = $cityusr_user = intval(strip_tags(trim($_REQUEST['cityusr'])));            // выбранный город в списке - число
    $ipuser_user = $userCityip;                     // для определения города по ip

    $mykey = 'Mm?ZOZBC;Zp)J>U_REXx';


    if ($namefn == 'addother') { // ответ пришел по curl
        $ipuser_user = htmlspecialchars(strip_tags($_REQUEST['ipuser']), ENT_QUOTES);

        $keymy = trim($_REQUEST['keymy']);

        if ($keymy != $mykey) {
            die();
        }

    } elseif ($namefn == 'create-vopros') {
        // разрешение на получение ответа
        $http_origin = $_SERVER['HTTP_ORIGIN'];

        if (in_array($http_origin, $allowed_http_origins)) {
            header("Access-Control-Allow-Origin: " . $http_origin);
        } else {
            die();
        }
    } else {
        die();
    }


    //массив ошибок
    $errorarray = array();
    foreach ($datamass as $key => $value) {

        $value = removeDoubleBackspace($value);

        if (empty(trim($value))) {  // проверка на пустоту - значение пустое
            $errorarray[$key] = 'Поле не заполнено.';

        } else { // значение не пустое

            if ($key == 'title' || $key == 'txt') {  // проверка - Должно быть не меньше 10 символов
                $count = strlen($value);
                if ($count < 10) {
                    $errorarray[$key] = 'Должно быть не меньше 10 символов.';

                }
            }

            if ($key == 'phoneusr') { // проверка правильности телефона +7(999)999-99-99
                if (!preg_match('/^\+\d{1,3}\s?\(\d{3}\)\s?\d{3}(-\d{2}){2}$/', $value)) {
                    $errorarray[$key] = 'Неправильно заполнено поле.';
                }
            }
            continue;
        }
    }

    /*
     *  массив с ошибками не пустой
     */
    if ($errorarray) {
        echo json_encode($errorarray); // массив с ошибками
        die();
    }


    // проверка есть ли такая категория


    if (empty($catprava_user)) {
        $number_cat = false;
    } else {
        $getname_mascategory = $options_sait['mascategory'];

        if (array_key_exists($catprava_user, $dataCategory[$getname_mascategory])) {
            $number_cat = $dataCategory[$getname_mascategory][$catprava_user];
        } else {
            $number_cat = false;
        }
    }


    // выбранный город

    if (array_key_exists($cityusr_user, $dataCity)) {
        $get_name_cityuser = $dataCity[$cityusr_user];
    } else {
        $get_name_cityuser = 'Москва и область';
    }


    // проверка есть ли такой номер в бд в течении суток

    $prover = true;
    $tmp = date('d.m.Y', strtotime('yesterday')); //вчера
    list($day, $month, $year) = explode('.', $tmp);

    $tmp1 = date('d.m.Y', strtotime('now')); // сегодня
    list($day1, $month1, $year1) = explode('.', $tmp1);

    $from = mktime(0, 0, 0, $month, $day, $year); // с
    $to = mktime(23, 59, 59, $month1, $day1, $year1);    // по
    $now = ConvertTimeStamp($from, "FULL");
    $now_day = ConvertTimeStamp($to, "FULL");
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_" . $options_sait['numberphone']);
    $arFilter = Array("IBLOCK_ID" => $options_sait['id_iblock'], "PROPERTY_" . $options_sait['numberphone'] => $phone_user, ">=DATE_CREATE" => $now, "<=DATE_CREATE" => $now_day);
    $res = CIBlockElement::GetList(Array("ID" => "DESC"), $arFilter, false, Array("nTopCount" => 1), $arSelect);

    while ($ob = $res->GetNextElement()) {
        $arProps = $ob->GetProperties();
        if ($arProps["phone_form_top"]["VALUE"]) {
            $prover = false;
        }
    }


    /*
     *  БД сайта
     * Name - имя пользователя
     * region
     * gorod_ip
     * name_vopros
     * phone_form_top
     * Ready
     * officeid
     * PREVIEWS_TEXT
     *
     *
     *
     */


    $el = new CIBlockElement;

    $PROP = array();
    $PROP['region'] = $get_name_cityuser;  //регион
    $PROP['gorod_ip'] = $ipuser_user;  //город по ip
    $PROP['name_vopros'] = $title_user;  //название вопроса
    $PROP['phone_form_top'] = $phone_user;  // поле телефон

    $arLoadProductArray = Array(
        "IBLOCK_SECTION_ID" => intval($number_cat),          // элемент лежит в корне раздела
        "IBLOCK_ID" => intval($options_sait['id_iblock']),
        "PROPERTY_VALUES" => $PROP,
        "NAME" => $name_user,
        "ACTIVE" => "N",            // активен
        "PREVIEW_TEXT" => htmlspecialchars_decode($txt_user)
    );


    switch ($namefn) {
        case "create-vopros":

            // проверка на существования этого номера в бд за сутки
            if ($prover) {
                $prover = false;
                $PRODUCT_ID = $el->Add($arLoadProductArray, false, false);
                if ($PRODUCT_ID) {

                    /*
                     *отправка на другие сайты
                     */

                    // массив доменов из параметров для каждого сайта
                    foreach ($mass_site as $key => $value) {
                        $mass_domenov[] = $key;
                    }

                    // удаление из массива этот домен -> поиск познаечению в массиве
                    if (($key = array_search($_SERVER['SERVER_NAME'], $mass_domenov)) !== FALSE) {
                        unset($mass_domenov[$key]);
                    }

                    $mass_domenov = array_unique($mass_domenov); // убираем посторящиеся значения

                    /* foreach ($mass_domenov as $key => $value) {

                         $status_site = POstsit( 'https://'.$value,0);

                         if ($status_site) { // другой сайт работает
                             $arraysendsite[] = $key; ///массив сайтов 200 ок
                         } else {  // другой сайт не работает
                             continue;
                         }
                     }*/


                    $data_other_sait = array(

                        'namefn' => 'addother', // использовать на сайте только добавление
                        'stsend' => $_SERVER['SERVER_NAME'],
                        'utf8' => '✓',
                        'nameusr' => $name_user,
                        'phoneusr' => $phone_user,
                        'title' => $title_user,
                        'txt' => $txt_user,
                        'catprava' => $catprava_user,
                        'cityusr' => $cityusr_user,
                        'ipuser' => $ipuser_user,
                        'keymy' => $mykey,

                    );


                    foreach ($mass_domenov as $key => $value) {
                        POSTsites('https://' . $value . '/ajax/vopros_site.php', $data_other_sait);
                    }

                    /*
                     * отправка на почту
                     */

                    if ($options_sait['id_eventsend']) {
                        $eventName = $options_sait['type_eventsend']; // название типа почтового сообщения
                        $arEventFields = array(
                            "TITLE_USER" => $title_user,
                            "NAME_USER" => $name_user,
                            "PHONE_USER" => $phone_user,
                            "TEXT_USER" => $txt_user,
                            "REGION_USER" => $get_name_cityuser,
                            "REGION_USER_IP" => $ipuser_user,
                        );

                        CEvent::Send($eventName, array('s1'), $arEventFields, "N", $options_sait['id_eventsend']);

                    }

                }
            } else {
                die();
            }


            break;

        case "addother":
            if ($prover) {
                $prover = false;
                $PRODUCT_ID = $el->Add($arLoadProductArray, false, false);
            } else {
                die();
            }
            break;

        default: // по умолчанию и когда  не равняются условию
            exit();
            die();
            break;

    }
}


?>