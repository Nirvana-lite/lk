<?
define('STOP_STATISTICS', true);
define('NOT_CHECK_PERMISSIONS', true);
define("PUBLIC_AJAX_MODE", true);
define("NO_KEEP_STATISTIC", "Y");
define("NO_AGENT_STATISTIC","Y");
define("NO_AGENT_CHECK", true);
define("DisableEventsCheck", true);

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
$cache_manager = Bitrix\Main\Application::getInstance()->getTaggedCache();

global $APPLICATION;
use Bitrix\Main\Context,
    Bitrix\Main\Request;

if (!CModule::IncludeModule("iblock")) {
    echo "error";
    return;
}
$request = Context::getCurrent()->getRequest();
$idblock = intval($request->getPost("idblock"));
$idelement = intval($request->getPost("idelement"));
$id_cookei = "like_comment" . $idelement;
$checkbutton = intval($request->getPost("postfun"));
$checkupdate = false;

if ($idelement > 0) {
    $like = [0,0];
    $arSelect = Array("ID", "PROPERTY_like");
    $arFilter = Array("IBLOCK_ID" => IntVal($idblock), "=ID" => $idelement);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount" => 1), $arSelect);
    while ($ob = $res->fetch()) {
        if (is_array(json_decode($ob['PROPERTY_LIKE_VALUE'], true))){
            $like = json_decode($ob['PROPERTY_LIKE_VALUE'], true);
        }
    }
}

$like[$checkbutton-1]++;

$VALUES = array(
    'LIKE' => $like[0],
    'DISLIKE' => $like[1]
);

CModule::IncludeModule('iblock');
CIBlockElement::SetPropertyValuesEx($idelement, $idblock, array('like' => json_encode($like)));
if(defined('BX_COMP_MANAGED_CACHE')) {
    //$GLOBALS['CACHE_MANAGER']->ClearByTag('post_likes_'.$idelement);
    $cache_manager->ClearByTag('post_likes_'.$idelement);
}

BXClearCache(true, "/tagged_post_likes/post".$idelement."/");
exec("rm -rf /tagged_post_likes/post".$idelement."/*");

echo json_encode($VALUES);