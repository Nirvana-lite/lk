<?
$_SERVER['DOCUMENT_ROOT'] = '/home/bitrix/ext_www/jur24pro.ru';
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
$now = mktime(date("H"), date("i") -1, date("s"), date("m"), date("d"), date("Y"));
$now_day = date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0, 0, 0, date("m"), date("d") -1, date("Y")));
$now = date('d.m.Y H:i:s', $now);
if (CModule::IncludeModule("iblock")):

    // получаем список пользователей из определенной группы
    global $USER;
    $filter = Array("GROUPS_ID" => Array(25));
    $arSelect["SELECT"] = array("UF_CRM_ID_O");
    $rsUsers = CUser::GetList(($by = "NAME"), ($order = "asc"), $filter, $arSelect);
    while ($arUser = $rsUsers->Fetch()) {
        $mass2[] = $arUser["UF_CRM_ID_O"]; // список пользователей
    }

    // получаем список некупленных заявок
    $arSelect = Array("ID", "NAME", "DATE_CREATE", "PROPERTY_400", "PROPERTY_403");
    $arFilter = Array("IBLOCK_ID" => 15, "ACTIVE" => array("Y", "N"), "<=DATE_CREATE" => $now, ">=DATE_CREATE" => $now_day, "PROPERTY_403" => "N", "PROPERTY_400" => false );
    $db_list = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, false, false, $arSelect);
    while ($ar_result = $db_list->GetNext()) {
        $mass[] = $ar_result["ID"]; // список заявок
    }


    // получаем последний офис, получивший заявку
    $arSelect = Array("ID", "PROPERTY_400", "PROPERTY_403");
    $arFilter = Array("IBLOCK_ID" => 15, "ACTIVE" => array("Y", "N"), "PROPERTY_403" => "N", "!PROPERTY_400" => false);
    $db_list1 = CIBlockElement::GetList(Array("ID" => "DESC"), $arFilter, false, Array("nTopCount" => 1), $arSelect);
    while ($ar_result1 = $db_list1->GetNext()) {
        $last_ofiice = $ar_result1["PROPERTY_400_VALUE"];
    }


    // $end_value кто последний получил заявку его officeid
    while (($end_value = current($mass2)) !== FALSE) {
        if ($end_value == $last_ofiice) {
            $new_mass = key($mass2);
        }
        next($mass2);
    }
    // вырезаем всех пользователей которые идут перед последним получившим
    $delete_user = array_splice($mass2, 0, $new_mass + 1);
    // добавляем их в конец
    $mass2 = array_merge($mass2, $delete_user);

    // проходим по всем заявкам и раздаем их в порядке очереди по кругу
    for ($i = 0; $i < count($mass); $i++) {
        $ost = $i % count($mass2);
        // echo $mass[$i] . " $mass2[$ost] <br>";

        $el = new CIBlockElement;
        $ELEMENT_ID = $mass[$i];  // код элемента
        $PROPERTY_CODE = "400";  // код свойства
        $PROPERTY_VALUE = $mass2[$ost];  // значение свойства
        CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));

    }
endif;
?>

