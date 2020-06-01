<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Main\Request;
CModule::IncludeModule('iblock');
$request = Context::getCurrent()->getRequest();
$elemID = $request->getPost("answer");
CIBlockElement::Delete(intval($elemID['id']));

$arFilter = Array("IBLOCK_ID"=>IntVal(38),"ID" => intval($elemID['id']));
$arSelect = Array("ID","PROPERTY_OBJECT");
$res = CIBlockElement::GetList(Array('DATE_CREATE'=> 'ASC'), $arFilter, false, false, $arSelect);
while($ob = $res->fetch())
{
    $arr[] = $ob['ID'];
}
if (count($arr) > 0){
    foreach ($arr as $item) {
        CIBlockElement::Delete($item);
    }
}
//echo json_encode();


