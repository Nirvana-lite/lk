<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
CModule::IncludeModule('iblock');
global $USER;

function guardAuth($input)
{
    $input = trim($input); // - пробелы
    $input = stripslashes($input); // - экранированныe символы
    $input = strip_tags($input); //  - тэги
    $input = htmlspecialchars($input); // преобразуем в сущности если что то осталось

    return $input;
}

/**
 * seo elem props
 */
$element['IPROPERTY_TEMPLATES'] = [
    "ELEMENT_META_TITLE" => (!empty($request->getPost("title"))?$request->getPost("title"):$request->getPost("name")), // title элемента
    "ELEMENT_META_KEYWORDS" => $request->getPost("tags"), // ключевые слова элемента
    "ELEMENT_META_DESCRIPTION" => $request->getPost("description"), // сео-описание элемента
    "ELEMENT_PAGE_TITLE" => $request->getPost("h1"), // title страницы
];

/**
 * elem props
 */
$PROP = array();
$PROP['urist'] = intval($request->getPost("urist"));

$arLoadProductArray = Array(
    "CREATED_BY" => intval($request->getPost("urist")), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => ($request->getPost("section")) ? $request->getPost("section") : false,          // элемент лежит в корне раздела
    "IBLOCK_ID" => $request->getPost("iblock"),
    "DATE_ACTIVE_FROM" => date('d.m.Y H:i:s'),
    "NAME" => $request->getPost("name"),
    "TAGS" => $request->getPost('tags'),
    "PROPERTY_VALUES"=> $PROP,
    "ACTIVE" => ($USER->isAdmin()) ? "Y" : "N",
    "PREVIEW_TEXT" => $request->getPost("description"),
    "PREVIEW_TEXT_TYPE" => 'html',
    "DETAIL_TEXT" => $request->getPost('more-text'),
    "DETAIL_TEXT_TYPE" => 'html',
    "DETAIL_PICTURE" => $_FILES['image'],
    'IPROPERTY_TEMPLATES' => $element['IPROPERTY_TEMPLATES']
);

$el = new CIBlockElement;
$myRes = [];
if ($USER->isAdmin()){
    if ($request->getPost("del")){
        $res = CIBlockElement::Delete(intval($request->getPost("id")));
        echo json_encode($res);
        die();
    }
}
if (intval($request->getPost("elem")) > 0) {
    /**
     * update
     */

    $PRODUCT_ID = intval($request->getPost("elem"));
    $res = $el->Update($PRODUCT_ID, $arLoadProductArray);

} else {
    /**
     * add
     */

    $params = Array(
        "max_len" => "100", // обрезает символьный код до 100 символов
        "change_case" => "L", // буквы преобразуются к нижнему регистру
        "replace_space" => "-", // меняем пробелы на нижнее подчеркивание
        "replace_other" => "-", // меняем левые символы на нижнее подчеркивание
        "delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
        "use_google" => "false", // отключаем использование google
    );

    $name = guardAuth($request->getPost("name"));

    $arLoadProductArray['CODE'] = CUtil::translit($name, "ru", $params);


    if ($PRODUCT_ID = $el->Add($arLoadProductArray))
        echo json_encode("New ID: " . $PRODUCT_ID);
    else
        echo json_encode("Error: " . $el->LAST_ERROR);

}