<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
 // куки
global $APPLICATION;
$id_cookei = "like_comment" . $arResult["ID"];
$getcokie = $APPLICATION->get_cookie($id_cookei);
//unset($_COOKIE[$id_cookei]);
$getcokie = $_COOKIE[$id_cookei];

$arResult["add_claas"] = '';

if (isset($getcokie) && (int)$getcokie == 1) {
    $arResult["add_claas"] = 'disabled';
}