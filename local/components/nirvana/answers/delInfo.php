<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Main\Request;
$request = Context::getCurrent()->getRequest();
$answer = $request->getPost("answer");

$el = new CIBlockElement;


$value = CIBlockElement::Delete($answer);

echo json_encode($value);
