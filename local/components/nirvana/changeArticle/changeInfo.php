<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::IncludeModule("iblock");

function guardAuth($input)
{
    $input = trim($input); // - пробелы
    $input = stripslashes($input); // - экранированныe символы
    $input = strip_tags($input); //  - тэги
    $input = htmlspecialchars($input); // преобразуем в сущности если что то осталось

    return $input;
}
$data = [];
foreach ($_POST as $key => $item){
    $data[$key] = guardAuth($item);
}
$el = new CIBlockElement;

if ($data['add'] == false && intval($data['id']) > 0){
    // update

    $PROP = [];

    $arLoadProductArray = Array(
        "IBLOCK_SECTION_ID" => (intval($data['section']) > 0)?$data['section']:false,
        "IBLOCK_ID"      => $data['iblock_id'],
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $data['name'],
        "ACTIVE"         => "Y",            // активен
        "PREVIEW_TEXT"   => $data['preview_text'],
        "DETAIL_TEXT"    => $data['detail_text'],
        "DETAIL_PICTURE" => $_FILES['detail_photo'],
        "PREVIEW_PICTURE" => $_FILES['preview_photo']
    );

    $res = $el->Update($data['id'], $arLoadProductArray);

}else{
    // add

    $PROP = [];

    $arLoadProductArray = Array(
        "IBLOCK_SECTION_ID" => (intval($data['section']) > 0)?$data['section']:false,
        "IBLOCK_ID"      => $data['iblock_id'],
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $data['name'],
        "ACTIVE"         => "Y",            // активен
        "PREVIEW_TEXT"   => $data['preview_text'],
        "DETAIL_TEXT"    => $data['detail_text'],
        "DETAIL_PICTURE" => $_FILES['detail_photo'],
        "PREVIEW_PICTURE" => $_FILES['preview_photo']
    );

    if($PRODUCT_ID = $el->Add($arLoadProductArray))
       $fields = $PRODUCT_ID;
    else
        $fields = $el->LAST_ERROR;
}


echo json_encode($fields);