<?php
define("NO_KEEP_STATISTIC", true); // Не собираем стату по действиям AJAX
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
$value = $request->getPost("user");

global $USER;
$filter = array
(
    "ID" => intval($value),
);
$new = [];
$elems = [];
$select = ['UF_CHANGEDATA'];
$fileds = ['ID'];
$rsUsers = CUser::GetList(($by = "ID"), ($order = "desc"), $filter, array('SELECT' => $select, 'FIELDS' => $fileds));
while ($arUser = $rsUsers->fetch()) {
    $new = $arUser;
}
if (!empty($new['UF_CHANGEDATA'])) {
    $normalName = [
        'NAME' => 'Имя',
        'LAST_NAME' => 'Фамилия',
        'SECOND_NAME' => 'Отчество',
        'PERSONAL_PHOTO' => 'Фото',
        'PERSONAL_PHONE' => 'Телефон',
        'EMAIL' => 'Почта',
        'WORK_COMPANY' => 'Компания',
        'WORK_DEPARTMENT' => 'Отдел',
        'PERSONAL_PROFESSION' => 'Должность',
        'WORK_STREET' => 'Улица',
        'WORK_PROFILE' => 'Направление',
        "WORK_PHONE" => 'Рабочий телефон',
        'UF_OB_VUZ' => 'ВУЗ',
        'UF_OB_FAK' => 'Факультет',
        'UF_OB_SPEC' => 'Специальность',
        'UF_OB_GOD' => 'Год выпуска',
        'UF_CERT_NUMB' => 'Номер удостоверения',
        'UF_REG_NUMB' => 'Регистрационный номер',
        "UF_REG_PAL" => 'Палата ( кабинет, коллегия)',
        "UF_CERT_PHOTO" => 'фото удостоверения'
    ];
    $changesData = json_decode($new['UF_CHANGEDATA'], true);
    $select = [
        'UF_OB_VUZ',
        'UF_OB_FAK',
        'UF_OB_SPEC',
        'UF_OB_GOD',
        'UF_REGION',
        'UF_CERT_NUMB',
        'UF_REG_NUMB',
        "UF_REG_PAL",
        "UF_CERT_PHOTO"
    ];
    $rsUsers = CUser::GetList(($by = "ID"), ($order = "desc"), $filter, array('SELECT' => $select));
    while ($arUser = $rsUsers->fetch()) {
        $tmp = $arUser;
    }

    foreach ($changesData as $key => $change) {
        if ($changesData[$key] != $tmp[$key] && $changesData[$key] != 'null') {
            if ($key === 'PERSONAL_PHOTO') {
                $info['user']['old'][$key] = CFile::GetPath($tmp[$key]);
                $info['user']['new'][$key] = $changesData[$key];
            } else {
                $info['user']['old'][$key] = $tmp[$key];
                $info['user']['new'][$key] = $changesData[$key];
            }
        }
    }
    if (intval($tmp['UF_CERT_PHOTO']) > 0) {
        $info['user']['old']['UF_CERT_PHOTO'] = '';
        $info['user']['new']['UF_CERT_PHOTO'] = CFile::GetPath($tmp['UF_CERT_PHOTO']);
    }
    $info['id'] = $tmp['ID'];
    foreach ($info['user'] as $sectKey => $sect) {
        foreach ($sect as $key => $item) {
            $info['user'][$sectKey][$key] = [
                'name' => $normalName[$key],
                'value' => $item
            ];
        }
    }
    echo json_encode($info);
} else {
    echo json_encode('Нет Изменений');
}




