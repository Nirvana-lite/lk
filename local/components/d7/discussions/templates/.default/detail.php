<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
\Bitrix\Main\Loader::includeModule("iblock");

//(SELECT * FROM News WHERE newsID < 2 ORDER BY ID DESC LIMIT 1)
// UNION
// (SELECT * FROM News WHERE newsID > 2 ORDER BY ID LIMIT 1)


// получение соседних тем
$cat_id = StrForSql($arResult['CAT']['CAT_ID']);

$ResultList[] = Bitrix\ListKeysTable\KeysTable::getList(array(
    'select' => array('ID', 'URL', 'NAME'),
    'filter' => array('=CAT_ID' => $cat_id, '>ID' => $arResult['ELEMENT']['ID']),
    'order' => array('ID' => 'ASC'),
    'limit' => 4
))->fetchAll();

$ResultList[] = Bitrix\ListKeysTable\KeysTable::getList(array(
    'select' => array('ID', 'URL', 'NAME'),
    'filter' => array('=CAT_ID' => $cat_id, '<ID' => $arResult['ELEMENT']['ID']),
    'order' => array('ID' => 'ASC'),
    'limit' => 4
))->fetchAll();

$ResultList = array_merge($ResultList[0], $ResultList[1]);
$ResultListNew = array_rand($ResultList, 4);

function testsearch($text, $name_prop)
{
    $tmpName = preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/ui", ' ', trim($text));
    $arLooksLike = array(
        "INCLUDE_SUBSECTIONS" => "N",
        //"!ID" => intval($ElementID) // не данный элемент
    );

    $stuffWords = MY_ARRAY_PREDLOG; // эти слова не несут смысла
// массив, который будет использоваться для поиска в имени или тегах

    $tmpName = preg_replace('/[\s]{2,}/', ' ', $tmpName);  // убираем двойные пробелы

    $NameItems = explode(" ", $tmpName);
    $NameItems = array_diff($NameItems, array(''));                         // убираем пустые из массива

    $itemsArray = array();
    foreach ($NameItems as $item) {
        if (in_array($item, $stuffWords)) { // убираем предлоги
            continue;
        }
        if (strlen($item) > 1) { // редко бывают значимые слова в одну букву
            if (mb_strlen($item) > 4) {
                $item = mb_substr($item, 1, -1, "UTF-8");
            }
            $itemsArray[] = array($name_prop => "%" . $item . "%");  // ищем элементы, у которых выбранное свойство есть в названии
            $itemsArray[] = array("TAGS" => "%" . $item . "%");  // ищем элементы, у которых выбранное свойство есть в поисковых тегах
        }
    }

    $addFArray = array(
        array(array_merge(array("LOGIC" => "OR"), $itemsArray)),
    );

// массив для фильтра
    return array_merge($arLooksLike, $addFArray);
}

// получение вопросов из слова
$filt = testsearch($arResult['ELEMENT']['NAME'], "PROPERTY_125_VALUE");

$filt_array = array('IBLOCK_ID' => 15, 'ACTIVE' => "Y");
$filt_array[0] = $filt[0];

$dbItems = CIBlockElement::GetList(
    false,
    $filt_array,
    false,
    Array("nTopCount" => 6),
    array('ID', 'NAME', 'PREVIEW_TEXT', 'PROPERTY_125')
);

$array_vop = [];  // вопросы
$ids_vopros = []; // id вопросов
while ($item = $dbItems->fetch()) {
    $ids_vopros[] = $item['ID'];
    //$item['PROPERTY_125_VALUE'] = $item['PROPERTY_125_VALUE'];
    $array_vop[] = $item;
}


// получаем ответы на вопросы -> инфоблок 18

$arSelect = array(
    "ID",
    "IBLOCK_ID",
    "DATE_CREATE",
    "NAME",
    "PREVIEW_TEXT",
    "DETAIL_TEXT",
    "PROPERTY_vopros",
    "PROPERTY_NONUSER",
    "PROPERTY_DEPTH",
    "PROPERTY_PARENT",
    "PROPERTY_AVATAR",
    "PROPERTY_LIKE",
    "PROPERTY_HIDEMODAR",
);

$arFilter_elemnt = array(
    "IBLOCK_ID" => 18,
    "PROPERTY_vopros" => $ids_vopros,
    // "PROPERTY_PARENT" => $ids_vopros,
    "ACTIVE" => "Y",
);
$rsElement_elemnt = CIBlockElement::GetList(array("DATE_CREATE" => "ASC"), $arFilter_elemnt, false, false, $arSelect);

$otvet = [];
while ($item = $rsElement_elemnt->Fetch()) {

    $otvet[$item['PROPERTY_VOPROS_VALUE']][] = $item;
}


list($one, $two) = array_chunk($array_vop, ceil(count($array_vop) / 2));


// получение статей из слова -> популярные темы, право и процесс
$filt_select = testsearch($arResult['ELEMENT']['NAME'], "NAME");

$filt_array = array('IBLOCK_ID' => array(17, 24, 29), 'ACTIVE' => "Y");
$filt_array[0] = $filt_select[0];

$articles_list = CIBlockElement::GetList(
    false,
    $filt_array,
    false,
    Array("nTopCount" => 8),
    array('ID', 'NAME', 'IBLOCK_ID', 'PREVIEW_TEXT', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL')
);

while ($item_art = $articles_list->GetNextElement()) {
    $articles[] = $item_art->fields;
}

list($articles_one, $articles_two) = array_chunk($articles, ceil(count($articles) / 2));

function txtRemove_nbsp($text)
{
    $text = strip_tags($text);
    $s = str_replace("\xc2\xa0", ' ', $text);
    $s = preg_replace('/\s+/', ' ', $s);
    return $s;
}




?>
<script>
    function scrollView(id) {
        $('html, body').animate({
            scrollTop: parseInt($("#question-anons-" + id).offset().top - 100)
        }, 200);
    }
    function show_vopr(id) {
        $('.show-quest-' + id).html('Хотите бесплатно уточнить вопрос и получить ответ от юристов? <a target="_blank" class="link_vopros" href="/jurist-help/">Спросить</a>');
    }
</script>


<? function question_list($quest_array, $otvet_array)
{
    // вывод вопросов и к ним ответы
    ?>
    <div class="question-list">
        <? foreach ($quest_array as $item) { ?>
        <div class="content-text block-shadow">
            <div class="question-card" id="question-anons-<?= $item['ID']; ?>">
                <?
                // не делаем длинные h2
                if (mb_strlen(trim(strip_tags($item['PREVIEW_TEXT']))) > 100) {
                    echo '<div class="quest-h2">' . (txtRemove_nbsp($item['PREVIEW_TEXT'])) . '</div>';
                } else {
                    echo '<h2>' . (txtRemove_nbsp($item['PREVIEW_TEXT'])) . '</h2>';
                } ?>
                <? foreach ($otvet_array[$item['ID']] as $itemdf) { ?>
                    <? if(!empty(trim(txtRemove_nbsp($itemdf['DETAIL_TEXT'])))) { ?>
                    <p>
                        <?
                        echo txtRemove_nbsp($itemdf['DETAIL_TEXT']);
                        ?>
                    </p>
                     <div class="block_btn show-quest-<?=$itemdf['ID'];?>">
                         Вам помог ответ?
                         <span onclick="show_vopr(<?=$itemdf['ID'];?>);" class="btn_s help_yes">Да</span>
                         <span onclick="show_vopr(<?=$itemdf['ID'];?>);" class="btn_s help_no">Нет</span>
                     </div>
                <? } } ?>
                </div>
            </div>
        <? } ?>
    </div>
<? } ?>


<? function articles_list($articles_array)
{
    // вывод статей
    if (!empty($articles_array)) { ?>
        <div class="content-text block-shadow">
            <div class="articles-list">
                <? foreach ($articles_array as $item) { ?>
                    <div class="art-item">
                        <h2><a href="<?= $item['DETAIL_PAGE_URL']; ?>"><?= $item['~NAME']; ?></a></h2>
                        <div class="clearfix">
                            <? if (intval($item['DETAIL_PICTURE']) > 0) {
                                $file = CFile::ResizeImageGet($item['DETAIL_PICTURE'], array('width' => 80, 'height' => 80), BX_RESIZE_IMAGE_EXACT, true);
                                ?>
                                <img src="<?= $file['src']; ?>" alt="<?= $item['~NAME']; ?>">
                            <? } ?>
                            <? if (mb_strlen(trim(strip_tags($item['PREVIEW_TEXT']))) > 0) { ?>
                                <p><?= (desc150($item['PREVIEW_TEXT'])); ?>...</p>
                            <? } ?>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    <? }
} ?>


<? function articles_listp($articles_array)
{
    // вывод статей
    if (!empty($articles_array)) { ?>
        <div class="bl_cop clearfix">
                <? foreach ($articles_array as $item) { ?>
                    <div class="articles_section col-xs-12 col-sm-6 col-md-6 ">
                        <div class="block-shadow">
                            <? if (intval($item['DETAIL_PICTURE']) > 0) {
                                $file = CFile::ResizeImageGet($item['DETAIL_PICTURE'], array('width' => 400, 'height' => 300), BX_RESIZE_IMAGE_EXACT, true);
                                ?>
                            <a href="<?= $item['DETAIL_PAGE_URL']; ?>">
                                <img src="<?= $file['src']; ?>" alt="<?= $item['~NAME']; ?>">
                            </a>
                            <? } ?>
                            <p><a href="<?= $item['DETAIL_PAGE_URL']; ?>"><?= $item['~NAME']; ?></a></p>
                        </div>
                    </div>
                <? } ?>
        </div>
    <? }
} ?>


<h1 class='main-title'><?= $arResult['ELEMENT']['NAME']; ?></h1>
<div class="content-text block-shadow">
    <ul class="chapter-list">
        <li class="first-chapter-list"><strong>Краткое содержание:</strong></li>
        <? foreach ($array_vop as $item) { ?>
            <li class="chapter-item" onclick="scrollView('<?= $item['ID']; ?>');">
                <?= (desc150($item['PROPERTY_125_VALUE'], 80)); ?>...
            </li>
        <? } ?>

        <? foreach ($ResultListNew as $key) { ?>
            <li>
                <a href="<?= $arResult['CAT']['LIST_PAGE'] . $ResultList[$key]['URL']; ?>/"><?= $ResultList[$key]['NAME']; ?></a>
            </li>
        <? } ?>

    </ul>
</div>

<h2 class="main-title">Дискусии юристов и адвокатов</h2>
<? question_list($one, $otvet); ?>
<? articles_listp($articles_one); ?>
<h2 class="main-title">Консультация по Вашему вопросу</h2>
<div class="content-text block-shadow bl_form_center">
    <div class="form-center-desc clearfix">
        <div class="col-md-4">
            <div class="fr_img">
                <div class="fr-center_img"></div>
                <p class="fr_phone">8 800 777 32 63</p>
            </div>
        </div>
        <div class="col-md-8">
            <form id="fr-center_desc" method="POST" action="/jurist-help/">
                <input type="text" name="form_title_test" autocomplete="off" class="form-control"
                       placeholder="Ваш вопрос">
                <textarea name="form_textarea_test" autocomplete="off" class="form-control form_textarea__test"
                          placeholder="Опишите вашу ситуацию"></textarea>
                <button class="form_slide_bottom-sumbit" type="submit">Спросить</button>
            </form>
        </div>
    </div>
</div>
<? question_list($two, $otvet); ?>
<? articles_list($articles_two); ?>

<h2 class="main-title">Похожие темы</h2>
<div class="content-text block-shadow">
    <ul>
        <?
        foreach ($ResultList as $item) { ?>
            <li>
                <a href="<?= $arResult['CAT']['LIST_PAGE'] . $item['URL']; ?>/"><?= $item['NAME']; ?></a>
            </li>
        <? } ?>
    </ul>
</div>


<?
CPageOption::SetOptionString("main", "nav_page_in_session", "N");

$arNavParams = array(
    'nPageSize' => 6,   // количество элементов на странице
    'bShowAll' => false, // показывать ссылку «Все элементы»?
);

$articles_dop = CIBlockElement::GetList(
    false,
    array('IBLOCK_ID' => 21, 'ACTIVE' => "Y"),
    false,
    $arNavParams,
    array('ID', 'NAME', 'IBLOCK_ID', 'DETAIL_TEXT', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL')
);
while ($item_art = $articles_dop->GetNextElement()) {
    $articles3[] = $item_art->fields;
}

foreach ($articles3 as $item) { ?>
    <div class="content-text block-shadow more-niz-item">
        <div class="art-item">
            <h2><a href="<?= $item['DETAIL_PAGE_URL']; ?>"><?= $item['~NAME']; ?></a></h2>
            <div class="clearfix">
                <? if (intval($item['DETAIL_PICTURE']) > 0) {
                    $file = CFile::ResizeImageGet($item['DETAIL_PICTURE'], array('width' => 710, 'height' => 390), BX_RESIZE_IMAGE_EXACT, true);
                    ?>
                    <img src="<?= $file['src']; ?>" alt="<?= $item['~NAME']; ?>">
                <? } ?>
                <? if (mb_strlen(trim(strip_tags($item['DETAIL_TEXT']))) > 0) { ?>
                    <p><?= (desc150($item['DETAIL_TEXT'])); ?>...</p>
                <? } ?>
            </div>
            <a class="redmore" href="<?= $item['DETAIL_PAGE_URL']; ?>">Показать полностью</a>
        </div>
    </div>

<? }

echo $navString = $articles_dop->GetPageNavStringEx($navComponentObject, "Страницы:", "round");

?>

