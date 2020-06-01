<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

//CModule::IncludeModule("iblock");
global $DB;
$queryTmp = $DB->Query("
SELECT
b_user.EMAIL as mail,
b_user_group.GROUP_ID as groupID
FROM
b_user_group
LEFT JOIN
b_user ON b_user_group.USER_ID = b_user.ID
WHERE
b_user_group.GROUP_ID = 5
");
while ($a = $queryTmp->fetch()){
    $mail = explode('@',$a['mail'])[1];
    if ($mail == 'test.ru') continue;
    $fields = [
        'mail' => "'{$a['mail']}'",
        'sections' => "'Y'"
    ];
    $DB->PrepareFields("subs");
    $id = $DB->Insert("subs", $fields);

}





/*$arSelect = Array("ID", "CODE");
$arFilter = Array("IBLOCK_ID"=>IntVal(19));
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->fetch())
{
    $arr[] = [
      'id' => $ob['ID'],
      'code' => $ob['CODE']
    ];
}

foreach ($arr as $item){
    $el = new CIBlockElement;
    $arLoadProductArray = Array(
        'CODE' => trim($item['code'],'-')
    );

    $PRODUCT_ID = $item['id'];
    $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
}*/

/*$arUsers = Bitrix\Main\UserGroupTable::getList(
    array(
        'group'=>array('USER_ID'),

        'select' => array(
            'USER_ID',
            'USER_EMAIL' => 'USER.EMAIL',
            'GROUP_ID'
        ),

        'filter' => array(
            'GROUP_ID' => array(1)
        )

    )
)->fetchAll();

vd1($arUsers);*/



/**
 * SELECT
b_user.EMAIL as mail,
b_user_group.GROUP_ID as groupID
FROM
b_user_group
LEFT JOIN
b_user ON b_user_group.USER_ID = b_user.ID
WHERE
b_user_group.GROUP_ID < 20
GROUP BY
b_user.ID
 *
 * Калита Сергей Николаевич
 */