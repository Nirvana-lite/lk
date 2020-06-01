<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Page\Asset;
CModule::IncludeModule('iblock');
Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");
Asset::getInstance()->addString("<script src='//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js'></script>");

$arResult['prof'] = ['Пользователь','Юрист','Компания'];
$arSelect = array(
    'ID',
    "NAME"
);
$rsElements = \Bitrix\Iblock\ElementTable::getList(
    array('select' => $arSelect,
        'filter' => array("IBLOCK_ID" => 16, "ACTIVE" => "Y"),
        'order' => array('NAME' => 'ASC'),
    ));
while ($row = $rsElements->fetch())
{
    $arResult['city'][] = $row;
}
$this->IncludeComponentTemplate();
?>