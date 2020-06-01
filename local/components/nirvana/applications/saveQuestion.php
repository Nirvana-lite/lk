<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('iblock');

/**
 * check $_POST
 */

function guardAuth($input)
{
$input = trim($input); // - пробелы
    $input = stripslashes($input); // - экранированныe символы
    $input = strip_tags($input); //  - тэги
    $input = htmlspecialchars($input); // преобразуем в сущности если что то осталось

    return $input;
}
$arr = [];
foreach ($_POST as $key => $item) {
    $arr[$key] = guardAuth($item);
}

/**
 * find section id
 */

$arFilter = Array('IBLOCK_ID' => questions, '=NAME' => $arr['section']);
$db_list = CIBlockSection::GetList(Array('NAME' => 'ASC'), $arFilter, true);
if ($ar_result = $db_list->Fetch()) {
    $section = $ar_result['ID'];
}

/**
 * update item for ID
 */

$el = new CIBlockElement;

$prop = [
    'region' => $arr['city'],
    'Ready' => ($arr['read'] == 'true')?1:0,
    'defect' => $arr['defect'],
];
if ($arr['reason'] != 'null'){
    $prop['DefectReason'] = trim($arr['reason']);
}


$PRODUCT_ID = $arr['id'];
$answer = CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, questions, $prop);
CIBlockElement::SetElementSection($PRODUCT_ID, $section);
echo json_encode($arr);