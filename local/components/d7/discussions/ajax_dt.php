<?
use Bitrix\Main\Context;
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CPageOption::SetOptionString("main", "nav_page_in_session", "N");

// подклдючаем класс компонента
\CBitrixComponent::includeComponentClass('d7:discussions');

$pageNumber = intval($_REQUEST['pageNumber']);
$limit = array(
    'nPageSize' => 10, // Укажем количество выводимых элементов
    "bDescPageNumbering" => false, // Обратная навигация или прямая
    'iNumPage' => ($pageNumber ? $pageNumber : 1),
    'bShowAll' => false // тут как вам нравится если надо можно показывать ссылку все
);
$navigation = \CDBResult::GetNavParams($limit);

$offset = ($limit['iNumPage'] - 1) * $limit['nPageSize'];

global $USER;
if($USER->IsAdmin()) {


    if (!empty($_REQUEST['txt']) && $_REQUEST['checkdb'] == 'ert!sd42') {


        $ResultList = Bitrix\ListKeysTable\KeysTable::getList(
            array(
                'select' => array(
                    'ID',
                    'URL',
                    'NAME'
                ),
                'filter' => array('%NAME' => $_REQUEST['txt'], '=ACTIVE' => 'Y'),
                'order' => array('ID' => 'ASC'),
                'limit' => $limit['nPageSize'],
                'offset' => $offset,
                'count_total' => true,
            )
        );

        $res_req['pagin']['offset'] = $offset;
        $res_req['pagin']['pageNumber'] = $pageNumber + 1;
        $res_req['pagin']['count'] = intval($ResultList->getCount());
        $res_req['elements'] = [];
        while ($row = $ResultList->fetch()) {
            $res_req['elements'][] = $row;
        }


        echo json_encode($res_req);
    }

// удаление
    $edelem = $_REQUEST['fndelem'];

    if ($edelem == 'a1@erd#rfs') {
        $id_elem = intval($_REQUEST['id_elem']);

        $update_res = Bitrix\ListKeysTable\KeysTable::update($id_elem, ['ACTIVE' => 'N']);
        echo json_encode(array('id_elem' => $id_elem));
    }
}
?>