<?
define('STOP_STATISTICS', true);
define('NOT_CHECK_PERMISSIONS', true);
define("PUBLIC_AJAX_MODE", true);
define("NO_KEEP_STATISTIC", "Y");
define("NO_AGENT_STATISTIC", "Y");
define("NO_AGENT_CHECK", true);
define("DisableEventsCheck", true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;
global $USER;
if (!CModule::IncludeModule("iblock")) {
    echo "!";
}


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die();
}

$namefn = htmlspecialchars(strip_tags($_REQUEST['namefnc']), ENT_QUOTES);
$id_section = intval($_REQUEST['id_section']);


// кеширование фунция кеширования
include($_SERVER['DOCUMENT_ROOT'] . '/local/include/filter_get_pod_tema.php');


if ($namefn == 'getpodtema') {

    $cachedDatasas = returnResultCache(3600000, 'get_podtema/get_podtema_'.$id_section, 'get_podtema', $id_section);
    $mas_list = array(
        'UL_LI' => $cachedDatasas,
    );

    echo json_encode($mas_list);
}