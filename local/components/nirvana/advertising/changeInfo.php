<? require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
$info = $request->getPost("info");

if ($info['change']== 'active'){
    $el = new CIBlockElement;
    $arLoadProductArray = array(
        "ACTIVE" => 'Y',

    );
    $PRODUCT_ID = $info['id'];  // изменяем элемент с кодом (ID) 2
    $res = $el->Update($PRODUCT_ID, $arLoadProductArray);

    echo json_encode($res);
}elseif ($info['change']== 'del'){
    $PRODUCT_ID = $info['id'];
  echo json_encode(CIBlockElement::Delete($PRODUCT_ID));
}