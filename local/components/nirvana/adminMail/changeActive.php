<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Main\Request;
global $USER;
CModule::IncludeModule('iblock');
$request = Context::getCurrent()->getRequest();
$elemID = $request->getPost("answer");

$el = new CIBlockElement;

$arLoadProductArray = Array(
    "ACTIVE"         => "Y",            // активен
);

$PRODUCT_ID = $elemID;  // изменяем элемент с кодом (ID) 2
$value[] = $el->Update($PRODUCT_ID, $arLoadProductArray);


$userId = $USER->GetID();
$props = [
  'VIEWED' => 1
];
$arSelect = Array("ID", "PREVIEW_TEXT","CREATED_BY","PROPERTY_VIEWED");
$arFilter = Array("IBLOCK_ID"=>IntVal(38), "PROPERTY_OBJECT" => $PRODUCT_ID,"!CREATED_BY" => $userId,"!PROPERTY_VIEWED" => 1);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
if (intval($res->SelectedRowsCount())>0){
    while($ob = $res->fetch())
    {
        $arr[] = $ob['ID'];
    }
    foreach ($arr as $item){
      $value[] =  CIBlockElement::SetPropertyValuesEx($item,38, $props);
    }
}


echo json_encode($value);


