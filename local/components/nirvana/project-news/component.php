<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>");
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>");

global $USER;
CModule::IncludeModule('iblock');
CPageOption::SetOptionString("main", "nav_page_in_session", "N");
$arSelect = Array("ID", "NAME", "DATE_CREATE","PREVIEW_TEXT");
$arFilter = Array("IBLOCK_ID"=>IntVal(45), "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("DATE_CREATE" => "DESC"), $arFilter, false, Array("nPageSize"=>10), $arSelect);
while($ob = $res->fetch())
{
   $arResult['items'][] = [
       'id' => $ob['ID'],
       'name' => $ob['NAME'],
       'text' => $ob['PREVIEW_TEXT'],
       'date' => $ob['DATE_CREATE'],
       'view' => false
   ];
}
$arResult['user'] = $USER->isAdmin();
$arResult['pages'] = $res->GetPageNavStringEx($navComponentObject, "", "ajax_news");
$this->IncludeComponentTemplate();
?>