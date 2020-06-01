<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Page\Asset;
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");
Asset::getInstance()->addString("<script src='//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js'></script>");

$this->IncludeComponentTemplate();
?>