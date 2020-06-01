<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
use \Bitrix\Main\Data\Cache,
    \Bitrix\Main\Loader,
    \Bitrix\Iblock\Component\Tools;

$connection = \Bitrix\Main\Application::getConnection();
global $APPLICATION;

$arDefaultUrlTemplates404 = array(
    "news" => "",
    'list' => '#SECTION_CODE#/',
    "detail" => "#SECTION_CODE#/#ELEMENT_CODE#/",
);

$arComponentVariables = array(
    "SECTION_CODE",
    "ELEMENT_CODE",
);

if (intval($arParams['COUNT']) == 0) {
    $arParams['COUNT'] = 10;
}


function StrForSql($string)
{
    // обработка перед вставкой в sql запрос
    $string = \Bitrix\Main\Application::getConnection()->getSqlHelper()->forSql($string);
    return $string;
}


function checkUrl($string)
{
    // проверка на введеное в ссылку
    if (preg_match('/^[a-z0-9-]+$/', $string)) {
        return true;
    }
    return false;
}


if ($arParams["SEF_MODE"] == "Y") {
    $arResult = [];
    $arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams["SEF_URL_TEMPLATES"]);

    $arVariables = array(
        "SECTION_CODE",
        "ELEMENT_CODE",
    );
    $componentPage = CComponentEngine::ParseComponentPath(
        $arParams["SEF_FOLDER"],
        $arUrlTemplates,
        $arVariables
    );

    if ($componentPage === false && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == $arParams['SEF_FOLDER']) {
        $componentPage = "news";
    }

    if (empty($componentPage)) {
        Bitrix\Iblock\Component\Tools::process404(null, true, true, true, '/404.php');
        return;
    }


    $notFound = false;

    $cache = Cache::createInstance();
    // время кеширования в секундах
    $cacheTime = 360000;

    if ($componentPage == 'list' || $componentPage == 'detail') {
        if (checkUrl($arVariables['SECTION_CODE']) && (isset($arVariables['SECTION_CODE']) && strlen($arVariables['SECTION_CODE']) > 0)) {
            // проверка есть ли в бд -> раздел
            $arVariables['SECTION_CODE'] = StrForSql($arVariables['SECTION_CODE']);

            $cacheId = 'list_'.$arVariables['SECTION_CODE'];
            if ($cache->initCache($cacheTime, $cacheId, '/discussions_list/'.$arVariables['SECTION_CODE'].'/')) {
                /*
                 * получаем закешированные переменные
                 */

                $arResult = $cache->getVars();

            } elseif ($cache->startDataCache()) {
                /*
                 * иначе обращаемся к базе
                 */

                $result = $connection
                    ->query("SELECT * FROM keyso_category WHERE URL = '{$arVariables['SECTION_CODE']}' LIMIT 1;")
                    ->fetch();

                if (!$result) {
                    $cache->abortDataCache();
                    $notFound = true;
                } else {
                    $arResult['CAT'] = $result;
                    $arResult['CAT']['LIST_PAGE'] = $arParams["SEF_FOLDER"].$arResult['CAT']['URL'].'/';
                   // if ($componentPage == 'list') {
                       // $arResult['CAT']['COUNT_ELEMENTS'] = GetCountEl('ID', ' WHERE CAT_ID = '. $result['CAT_ID'] );
                        $arResult['CAT']['COUNT_ELEMENTS'] = $connection->queryScalar("SELECT COUNT(ID) FROM keyso_list_keys WHERE CAT_ID = ". $result['CAT_ID'] ." AND ACTIVE='Y'");
                   // }
                    $cache->endDataCache($arResult);
                }
            } else {
                $cache->abortDataCache();
                //$notFound = true;
            }

        } else {
            $notFound = true;
        }

        if ((isset($arVariables['ELEMENT_CODE']) && strlen($arVariables['ELEMENT_CODE']) > 0)) {
            if (!$notFound && checkUrl($arVariables['ELEMENT_CODE'])) {

                // проверка есть ли в бд -> детальная
                $arVariables['ELEMENT_CODE'] = StrForSql($arVariables['ELEMENT_CODE']);

                $result = Bitrix\ListKeysTable\KeysTable::getList(array(
                    'select' => array('*'),
                    'filter' => array('=URL' => $arVariables['ELEMENT_CODE'], '=ACTIVE' => 'Y'),
                    'limit' => 1,
                    'cache' => array(
                        'ttl' => 86400,
                        'cache_joins' => true,
                    )
                ))->fetch();

                /* $result = $connection
                    ->query("SELECT * FROM keyso_list_keys WHERE URL = '{$arVariables['ELEMENT_CODE']}' LIMIT 1;")
                    ->fetch(); */

                $result = array_filter($result);
                if (!$result) {
                    $notFound = true;
                } else {
                    $arResult['ELEMENT'] = $result;
                }

            } else {
                $notFound = true;
            }
        }

    }

    // показываем страницу 404 Not Found
    if ($notFound) {
        $cache->abortDataCache();
        Bitrix\Iblock\Component\Tools::process404(null, true, true, true, '/404.php');
        return;
    } else{
        // хлебные крошки , title, description, canonical
        $chain_link=[];

        if ($componentPage == 'list'){
            $title = $arResult['CAT']['NAME'].' - дискуссии юристов и адвокатов';
            $link_canonical = $arParams["SEF_FOLDER"].$arResult['CAT']['URL'].'/';
            $description = $arResult['CAT']['NAME'].' - дискуссии юристов и адвокатов на Росскийском Юридическом портале';

            $chain_link = array(
                'Дискуссии',
                $arParams["SEF_FOLDER"]
            );

        } elseif ($componentPage == 'detail'){
            $chain_link = array(
                'Дискуссии',
                $arParams["SEF_FOLDER"]
            );
            $APPLICATION->AddChainItem($chain_link[0], $chain_link[1]);

            $title = $arResult['ELEMENT']['NAME'].' - дискуссии юристов и адвокатов';
            $link_canonical = $arParams["SEF_FOLDER"].$arResult['CAT']['URL'].'/'.$arResult['ELEMENT']['URL'].'/';
            $description =$arResult['ELEMENT']['NAME'].' - дискуссии юристов и адвокатов на Росскийском Юридическом портале';

            $chain_link = array(
                $arResult['CAT']['NAME'],
                $arParams["SEF_FOLDER"].$arResult['CAT']['URL'].'/'
            );
        }
        if ($componentPage != 'news') {
            $APPLICATION->SetPageProperty("title", $title);
            $APPLICATION->SetPageProperty("description", $description);
            $APPLICATION->SetPageProperty("canonical", "https://jur24pro.ru" . $link_canonical);
        }
        $APPLICATION->AddChainItem($chain_link[0], $chain_link[1]);
    }


    $arResultdt = array(
        "FOLDER" => $arParams["SEF_FOLDER"],
        "URL_TEMPLATES" => $arUrlTemplates,
        "VARIABLES" => $arVariables);

    $arResult = array_merge($arResultdt, $arResult);

} else {
    $arVariables = array();

    $arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"]);
    CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);


    $componentPage = "";

    if (isset($arVariables["ELEMENT_ID"]) && intval($arVariables["ELEMENT_ID"]) > 0)
        $componentPage = "detail";
    elseif (isset($arVariables["ELEMENT_CODE"]) && strlen($arVariables["ELEMENT_CODE"]) > 0)
        $componentPage = "detail";
    else
        $componentPage = "news";

    $arResult = array(
        "FOLDER" => "",
        "URL_TEMPLATES" => Array(
            "news" => htmlspecialcharsbx($APPLICATION->GetCurPage()),
            "detail" => htmlspecialcharsbx($APPLICATION->GetCurPage() . "?" . $arVariableAliases["ELEMENT_ID"] . "=#ELEMENT_ID#"),
        ),
        "VARIABLES" => $arVariables,
    );
}

$this->IncludeComponentTemplate($componentPage);
?>