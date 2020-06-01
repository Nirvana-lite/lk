<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;

$connection = Application::getConnection();

/*$result = $connection
    ->query("SELECT * FROM keyso_category ORDER BY CAT_ID ASC;");
*/

$result = \Bitrix\ListKeysTable\KeysCategoryTable::getList(array(
    'select' => array('CAT_ID', 'URL', 'NAME'),
    'order' => array('CAT_ID' => 'ASC'),
    'cache' => array(
        'ttl' => 864000,
        'cache_joins' => true,
    )
));


while ($row = $result->fetch()) {
    $ids[] = $row;
}

// get keyso_list_keys -> element limit 5
$sql_union = '';
foreach ($ids as $item_union) {
    $sql_union .= ' UNION (SELECT ID, CAT_ID, NAME, URL FROM keyso_list_keys  WHERE CAT_ID=' . $item_union['CAT_ID'] . ' AND ACTIVE="Y" ORDER BY ID DESC LIMIT 5)';
}
$sql_union = trim($sql_union, ' UNION ');

$result = $connection
    ->query($sql_union);

while ($row = $result->fetch()) {
    $el_cat[$row['CAT_ID']][] = $row;
}


?>
<div class="content-text block-shadow list-discussions">
   <? foreach ($ids as $k => $item){ ?>
    <div class="item">
        <h2>
            <a href="/discussions/<?=$item['URL'];?>/">
                <?=$item['NAME'];?>
            </a>
        </h2>
        <ul>
            <? foreach ( $el_cat[$item['CAT_ID']] as $el){ ?>
                <li>
                    <a href="/discussions/<?=$item['URL'];?>/<?=$el['URL'];?>/">
                        <?=$el['NAME'];?>
                    </a>
                </li>
            <? } ?>
            <li>
                <a class="more-desc" href="/discussions/<?=$item['URL'];?>/">
                    Еще &rarr;
                </a>
            </li>
        </ul>
    </div>
    <? } ?>
</div>