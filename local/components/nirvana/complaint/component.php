<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$arFilter = Array("IBLOCK_ID"=>array(18,23,31,46,37,36), "!PROPERTY_SHALOBA_COMMENT"=>false);
$arSelect = Array("ID","IBLOCK_ID","PROPERTY_SHALOBA_COMMENT","PREVIEW_TEXT");
$res = CIBlockElement::GetList(Array(), $arFilter, false, ["nTopCount" => 30], $arSelect);
while($ob = $res->fetch())
{
    $arResult[] = [
        'id' => $ob['ID'],
        'iblock' => $ob['IBLOCK_ID'],
        'text' => $ob['PREVIEW_TEXT'],
//        'preview' => TruncateText($ob['PREVIEW_TEXT'], 100),
        'complaint' => $ob['PROPERTY_SHALOBA_COMMENT_VALUE'],
        'view' => false
    ];
}

$this->IncludeComponentTemplate();
?>