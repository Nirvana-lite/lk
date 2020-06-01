<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Main\Request;
$request = Context::getCurrent()->getRequest();
$question = $request->getPost("question");
$question['change'] = $request->getPost("change");


if ($question['change'] === 'save'){

    $el = new CIBlockElement;


    $arLoadProductArray = Array(
        "ACTIVE"         => "Y",
        "PREVIEW_TEXT"   => $question['text'],
    );

    $PRODUCT_ID = $question['id'];
    $value[] = $el->Update($PRODUCT_ID, $arLoadProductArray);

}
elseif ($question['change'] === 'del'){

    $el = new CIBlockElement;


    $value = CIBlockElement::Delete($question['id']);
}
elseif ($question['change'] === 'change'){
    $el = new CIBlockElement;


    $arLoadProductArray = Array(
        "PREVIEW_TEXT"   => $question['text'],
    );

    $PRODUCT_ID = $question['id'];
    $value[] = $el->Update($PRODUCT_ID, $arLoadProductArray);
}

echo json_encode($value);
