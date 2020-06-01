<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
\Bitrix\Main\Loader::IncludeModule("iblock");
$SectList = CIBlockSection::GetList(
    array("ID" => "ASC"),
    array("IBLOCK_ID" => IntVal($arParams['IBLOCK_ID']), "ACTIVE" => "Y"),
    false,
    array("ID", "IBLOCK_ID", "NAME"),
    false
);
while ($SectListGet = $SectList->fetch()) {
    $arResult['sections'][] = [
        'id' => $SectListGet['ID'],
        'name' => $SectListGet['NAME']
    ];
 }

 if (intval($arParams['ID'])>0){
     $arSelect = Array("ID","IBLOCK_ID", "NAME","PREVIEW_TEXT","DETAIL_PICTURE","DETAIL_TEXT","PROPERTY_108","SECTION_ID");
     $arFilter = Array("IBLOCK_ID"=>IntVal($arParams['IBLOCK_ID']),"ID" => intval($arParams['ID']));
     $res = CIBlockElement::GetList(Array(), $arFilter, false, $arSelect);
     while($ob = $res->GetNext())
     {
         $arResult['item'] = [
             'name' => $ob['NAME'],
             'preview_text' => $ob['PREVIEW_TEXT'],
             'detail_picture' => (intval($ob['DETAIL_PICTURE'])>0)?CFile::GetPath($ob['DETAIL_PICTURE']):false,
             'detail_text' => $ob['DETAIL_TEXT'],
             'section' => $ob['SECTION_ID'],
             'tags' => $ob['PROPERTY_108_VALUE'],
         ];
     }
 }
$arResult['text'] = $APPLICATION->IncludeComponent(
    "nirvana:editor.tiny.mce",
    "",
    array(
        "TEXT" => "",
        "TEXTAREA_NAME" => "text",
        "TEXTAREA_ID" => "text-element",
        "TEXTAREA_WIDTH" => "99.9%",  //
        "TEXTAREA_HEIGHT" => "300",    //
        "INIT_ID" => "ID", //
        "PATH_SAVE_PHOTO" => "/upload/tmp",
        "TYPE_EDITOR" => "TYPE_1"
    ),
    false
);


$this->IncludeComponentTemplate();
?>