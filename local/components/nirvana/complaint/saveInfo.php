<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Main\Request;
$request = Context::getCurrent()->getRequest();
$question = $request->getPost("question");
$question['change'] = $request->getPost("change");

if ($question['change'] === 'save'){
//   $value = $question;
    $el = new CIBlockElement;

    $arLoadProductArray = Array(
        "PREVIEW_TEXT"   => $question['text'],
    );
    $PRODUCT_ID = $question['id'];
    $value = $el->Update($PRODUCT_ID, $arLoadProductArray);

    $PROPERTY_CODE = "SHALOBA_COMMENT";
    $PROPERTY_VALUE = false;
    CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, intval($question['iblock']), array($PROPERTY_CODE => $PROPERTY_VALUE));

}
elseif ($question['change'] === 'change'){
    $el = new CIBlockElement;
    $arLoadProductArray = Array(
        "PREVIEW_TEXT"   => $question['text'],
    );

    $PRODUCT_ID = $question['id'];
    $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
}
elseif ($question['change'] === 'delItem'){
    $value = CIBlockElement::Delete($question['id']);
}
elseif ($question['change'] === 'delComplaint'){
    $ELEMENT_ID = $question['id'];
    $PROPERTY_CODE = "SHALOBA_COMMENT";
    $PROPERTY_VALUE = false;
    CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, intval($question['iblock']), array($PROPERTY_CODE => $PROPERTY_VALUE));
    $value = true;
}


echo json_encode($value);
