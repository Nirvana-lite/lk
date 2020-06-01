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
 * get detail for ID
 */

$arSelect = Array("ID","IBLOCK_ID","DETAIL_TEXT","DETAIL_PICTURE");
$arFilter = Array("IBLOCK_ID"=>intval($arr['iblock']), "ACTIVE"=>"Y","=ID"=> intval($arr['id']));
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->Fetch()){
$req =[
    'text' => $ob['DETAIL_TEXT'],
    'picture' => CFile::ResizeImageGet(
        $ob['DETAIL_PICTURE'],
        array('width' => 300, 'height' => 300),
        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
        true
    )['src']
];
}

echo json_encode($req);