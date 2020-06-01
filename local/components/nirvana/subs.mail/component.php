<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
CModule::IncludeModule("iblock");

use Bitrix\Main\Page\Asset,
    Bitrix\Main\Context,
    Bitrix\Main\Request;

global $USER;
$request = Context::getCurrent()->getRequest();
$arResult['userMail'] = ($USER->IsAuthorized()) ? $USER->GetEmail() : $request->getPost("user_mail");

include(__DIR__ . "/sendClass.php");
$arResult['isSub'] = $sendClass->getSub($arResult['userMail'])['sections'];
$arResult['subCount'] = $sendClass->getCount();

/*global $USER;
$filter = Array("!GROUPS_ID" => Array(1));
$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
while ($arUser = $rsUsers->Fetch()) {
    $arSpecUser[] = $arUser["EMAIL"];
}*/
//pre(count($arSpecUser));
$this->IncludeComponentTemplate();


?>
