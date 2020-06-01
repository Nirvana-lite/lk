<?php
define("NO_KEEP_STATISTIC", true); // Не собираем стату по действиям AJAX
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
$value = $request->getPost("user");
global $USER;
if ($USER->isAdmin()){
    if (CUser::Delete(intval($value))){
        echo json_encode(true);
    }else{
        echo json_encode(false);
    }
}

