<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION;

$title = "Список городов для актуальных тем";
$keywords = "список, городов, актуальных тем";
$description = "Список городов для актуальных тем Российской Федерации";

$APPLICATION->SetPageProperty("keywords_inner", $keywords);
$APPLICATION->SetPageProperty("keywords", $keywords);
$APPLICATION->SetPageProperty("description", $description);
$APPLICATION->SetPageProperty("title", $title);
$APPLICATION->SetPageProperty("canonical", MY_GET_SITE_URL.'/themecity/');
//$APPLICATION->AddChainItem("Юридические услуги в городах России", '/themecity/');
?>
<h1 class="main-title">Список городов для актуальных тем</h1>
<div class="content-text block-shadow">
<?

// list theme vopros
function result_themecity()
{
    setlocale(LC_ALL, 'rus_RUS.CP1251');
    $path = $_SERVER["DOCUMENT_ROOT"] . "/local/datagorod/";
    $fileCity = file_get_contents($path . "datacity.json");
    $taskListCity = json_decode($fileCity, TRUE);


    $namegoroda = array();
    $linkgoroda = array();
    $i = 0;
    foreach ($taskListCity as $key => $value) {
        $namegoroda[$i] = $value['name'];
        $linkgoroda[$i] = $value['alias'];
        $i++;
    }

    asort($namegoroda, SORT_LOCALE_STRING);

    $fullarray = array();
    foreach ($namegoroda as $key => $value) {
        $fullarray[mb_substr(ToLower($value), 0, 1, "UTF-8")][] = array($value, $linkgoroda[$key]);
    }
    return $fullarray;
}

$cachedDatasas = returnResultCache(3600000, 'razdel_themecity', 'result_themecity', '');


foreach ($cachedDatasas as $keyfull => $massivone) { ?>
    <div><strong><? echo ToUpper($keyfull);?></strong></div>
<ul>
    <? foreach ($massivone as $inner_key => $value){ ?>
        <li>
            <a href="/theme-<? echo $value[1];?>/"><? echo $value[0];?></a>
        </li>
    <? } ?>
</ul>
<? } ?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
