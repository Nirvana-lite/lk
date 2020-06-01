<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule('iblock');
$arSelect = Array("ID", "NAME", "PREVIEW_TEXT");
$arFilter = Array("IBLOCK_ID"=>intval($arParams['IBLOCK_ID']), "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array('ID'=>'DESC'), $arFilter, false, array('nPageSize'=> 10), $arSelect);
while($ob = $res->fetch())
{
    $text =  TruncateText($ob['PREVIEW_TEXT'], 30);
    $arParams = array("replace_space"=>"-","replace_other"=>"");
    $trans = Cutil::translit($text,"ru",$arParams);
    $arResult[] = [
        'id' => $ob['ID'],
        'url'=> "{$trans}-{$ob['ID']}",
        'text' => TruncateText($ob['PREVIEW_TEXT'], 150)
    ];
}

$this->IncludeComponentTemplate();
?>