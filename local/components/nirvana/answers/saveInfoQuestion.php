<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Main\Request;
CModule::IncludeModule('iblock');
$request = Context::getCurrent()->getRequest();
$question = $request->getPost("question");
$question['change'] = $request->getPost("change");

if ($question['change'] !== 'del'){
    /**
     * get section_id
     */
    $test = 'Интеллектуальная собственность';
    $arFilter = array('IBLOCK_ID' => 15, "NAME" => "{$question['section']}");
    $rsSections = CIBlockSection::GetList(array('LEFT_MARGIN' => 'ASC'), $arFilter);
    if ($arSection = $rsSections->fetch())
    {
       $sectID = $arSection['ID'];
    }
    else{
        $sectID = false;
    }
}

if ($question['change'] === 'save'){



    $el = new CIBlockElement;

    $arLoadProductArray = Array(
        "ACTIVE"         => "Y",            // активен
        "IBLOCK_SECTION_ID" => $sectID,
        "PREVIEW_TEXT"   => $question['text'],
    );

    $PRODUCT_ID = $question['id'];  // изменяем элемент с кодом (ID) 2
    $value = $el->Update($PRODUCT_ID, $arLoadProductArray);
}
elseif ($question['change'] === 'del'){
    $value = CIBlockElement::Delete($question['id']);
}
elseif ($question['change'] === 'change'){
    $el = new CIBlockElement;

    $arLoadProductArray = Array(
        "IBLOCK_SECTION_ID" => $sectID,
        "PREVIEW_TEXT"   => $question['text'],
    );


    $PRODUCT_ID = $question['id'];
    $PROPERTY_CODE = "name_vopros";  // код свойства
    $PROPERTY_VALUE = $question['name'];  // значение свойства

    CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
    $value = $el->Update($PRODUCT_ID, $arLoadProductArray);

}

echo json_encode($value);
