<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule('iblock');
$arSelect = Array("ID", "NAME", "PREVIEW_TEXT");
$arFilter = Array("IBLOCK_ID"=>intval($arParams['IBLOCK_ID']), "ACTIVE"=>"Y","ID" =>$arParams["ID"]);
$res = CIBlockElement::GetList(Array('ID'=>'DESC'), $arFilter, false, false, $arSelect);
while($ob = $res->fetch())
{
    $arResult = [
        'id' => $ob['ID'],
        'text' => $ob["PREVIEW_TEXT"],
    ];
}

$this->IncludeComponentTemplate();
?>