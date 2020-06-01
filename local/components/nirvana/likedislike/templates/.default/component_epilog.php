<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
Asset::getInstance()->addJs($templateFolder."/js/like-dislike.min.js");
Asset::getInstance()->addString('<script>var pathajaxlk = "'.$templateFolder.'";</script>',true);

