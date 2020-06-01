<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Main\Request;
$request = Context::getCurrent()->getRequest();
$answer = $request->getPost("answer");
$question = $request->getPost("question");
$question['change'] = $request->getPost("change");

echo json_encode($question);
if ($question['change'] === 'save'){

    $el = new CIBlockElement;

    $arLoadProductArray = Array(
        "ACTIVE"         => "Y",            // активен
        "PREVIEW_TEXT"   => $question['text'],
    );

    $PRODUCT_ID = $question['id'];  // изменяем элемент с кодом (ID) 2
    $value[] = $el->Update($PRODUCT_ID, $arLoadProductArray);


    $el = new CIBlockElement;

    $PROP = array();
    $PROP[125] = $answer['name'];

    $arLoadProductArray = Array(
        "ACTIVE"         => "Y",            // активен
        "PREVIEW_TEXT"   => $answer['text'],
    );

    $PRODUCT_ID = $answer['id'];  // изменяем элемент с кодом (ID) 2
    $value[] = $el->Update($PRODUCT_ID, $arLoadProductArray);

}
elseif ($question['change'] === 'del'){
    $value[] = CIBlockElement::Delete($answer);
    $value[] = true;

}
elseif ($question['change'] === 'change'){
    $el = new CIBlockElement;

    $arLoadProductArray = Array(
        "PREVIEW_TEXT"   => $question['text'],
    );

    $PRODUCT_ID = $question['id'];  // изменяем элемент с кодом (ID) 2
    $value[] = $el->Update($PRODUCT_ID, $arLoadProductArray);

    $el = new CIBlockElement;

    $PROP = array();
    $PROP[125] = $answer['name'];

    $arLoadProductArray = Array(
        "PREVIEW_TEXT"   => $answer['text'],
    );

    $PRODUCT_ID = $answer['id'];  // изменяем элемент с кодом (ID) 2
    $value[] = $el->Update($PRODUCT_ID, $arLoadProductArray);
}

echo json_encode($value);
