<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*use Bitrix\Main\Page\Asset;

$protocol = ($APPLICATION->IsHTTPS() ? 'https://' : 'http://');
$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");


$strNavQueryString = strtok($strNavQueryString, '?');

if($arResult["NavPageNomer"] > 1) {
    $prev = '<link rel="prev" href="'. $protocol . 'yurlitsa.ru' . $arResult["sUrlPath"] . $strNavQueryString . '?PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] - 1) . '" />';
} else{
    $prev='';
}

if($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
    $next = '<link rel="next" href="'. $protocol. 'yurlitsa.ru' . $arResult["sUrlPath"] . $strNavQueryString . '?PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] + 1) . '" />';
}else{
    $next='';
}

$prev_next = $prev.$next;
Asset::getInstance()->addString($prev_next);
?>