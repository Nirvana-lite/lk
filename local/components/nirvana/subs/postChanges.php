<?php
define("NO_KEEP_STATISTIC", true); // Не собираем стату по действиям AJAX
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Page\Asset,
    Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
$iblock_id = $request->getPost("iblock_id");
$section_id = $request->getPost("section_id");

$APPLICATION->IncludeComponent(
    "nirvana:subs",
    "",
    Array('iblock_id'=>$iblock_id,'section_id'=> $section_id)
);