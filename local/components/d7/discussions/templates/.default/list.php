<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

global $NavNum, $APPLICATION;

use Bitrix\Main\Application;
CModule::IncludeModule("iblock");

$connection = Application::getConnection();
$context = Application::getInstance()->getContext();

$Num = intval($NavNum) + 1;

$request = $context->getRequest();
$method = $request->getRequestMethod();
$pageNumber = $request->getQuery('PAGEN_' . $Num);

// 404 ошибку при -1 пагинации
if (intval($pageNumber) < 0) {
    Bitrix\Iblock\Component\Tools::process404(null, true, true, true, '/404.php');
    return;
}

$cat_id = StrForSql($arResult['CAT']['CAT_ID']);
$list_page = $arResult['CAT']['LIST_PAGE'];
$count = $arResult['CAT']['COUNT_ELEMENTS'];
$limit_elements = $arParams['COUNT'];

$limit = array(
    'nPageSize' => $limit_elements, // Укажем количество выводимых элементов
    "bDescPageNumbering" => false, // Обратная навигация или прямая
    'iNumPage' => ($pageNumber ? $pageNumber : 1),
    'bShowAll' => false // тут как вам нравится если надо можно показывать ссылку все
);
$navigation = \CDBResult::GetNavParams($limit);


// кеширование

$offset = ($limit['iNumPage'] - 1) * $limit['nPageSize'];

$ResultList = Bitrix\ListKeysTable\KeysTable::getList(array(
    'select' => array(
            'ID',
            'URL',
            'NAME'
        ),
    'filter' => array('=CAT_ID' => $cat_id, '=ACTIVE' => 'Y'),
    'order' => array('ID' => 'ASC'),
    'limit' => $limit['nPageSize'],
    'offset' => $offset,
    'cache' => array(
        'ttl' => 86400,
        'cache_joins' => true,
    )
));



$nav = new \CDBResult();
$nav->NavStart($navigation, false, true); // page_size; show_all; NumPage
$nav->NavPageCount = ceil($count / $limit['nPageSize']); // общее количество страниц
$nav->NavPageNomer = $limit['iNumPage']; // PAGEN_1 номер
$nav->NavRecordCount = $count;


// выводим 404 на несуществующей страницы -> пагинации
if ($nav->NavPageCount > 0 && $nav->NavPageNomer > $nav->NavPageCount) {
    Bitrix\Iblock\Component\Tools::process404(null, true, true, true, '/404.php');
    return;
}

?>
    <h1 class='main-title'><?= $arResult['CAT']['NAME']; ?></h1>
    <div class="content-text block-shadow list-discussions">
        <div class="list-articles">
            <? while ($row = $ResultList->fetch()) { ?>
                <a class="item" href="<?= ($list_page . $row['URL']) ?>/">
                    <!--googleoff: all-->
                    <!--noindex-->
                    <?= $row['NAME'] ?>
                    <!--/noindex-->
                    <!--/googleoff: all-->
                </a>
            <? } ?>
        </div>
    </div>
    <div class="col-xs-12 clearfix">
        <? echo $navString = $nav->GetPageNavStringEx($navComponentObject, "Страницы:", "round", false, $this);?>
    </div>
<?
$scrollmass = array(

    'container' => ".list-articles",
    'item' => ".item",
    'pagination' => ".bx-pagination  ul",
    'next' => ".bx-pagination .bx-pag-next a",
    'negativeMargin' => "150",
);

include($_SERVER['DOCUMENT_ROOT'] . '/local/include/scrollpagination/scroll_pagination.php');

 ?>