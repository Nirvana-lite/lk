<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;
$filter = [
    'ID' => $USER->GetID()
];
$select = [
    'UF_OB_VUZ',
    'UF_OB_FAK',
    'UF_OB_SPEC',
    'UF_OB_GOD',
    'UF_CERT_NUMB',
    'UF_REG_NUMB',
    'UF_REG_PAL',
    'UF_CHANGEDATA'
];
$rsUsers = CUser::GetList(($by = "ID"), ($order = "desc"), $filter, array('SELECT' => $select));
while ($arUser = $rsUsers->fetch()) {
    $tmp = $arUser;
}

$changesData = json_decode($tmp['UF_CHANGEDATA'], true);


$arResult['info'] = [
    'work' => [
        'company' => [
            'bdName' => 'WORK_COMPANY',
            'name' => 'Компания',
            'value' => ''
        ],
        'department' => [
            'bdName' => 'WORK_DEPARTMENT',
            'name' => "Отдел",
            'value' => ''
        ],
        'position' => [
            'bdName' => 'PERSONAL_PROFESSION',
            'name' => "Должность",
            'value' => 'Юрист'
        ] ,
        'address' => [
            'bdName' => 'WORK_STREET',
            'name' => "Адрес",
            'value' => ''
        ] ,
        'profile' => [
            'bdName' => 'WORK_PROFILE',
            'name' => "Направление",
            'value' => ''
        ] ,
        'workPhone' => [
            'bdName' => 'WORK_PHONE',
            'name' => "Телефон",
            'value' => ''
        ],
    ],
    'education' => [
        'vuz' => [
            'bdName' => 'UF_OB_VUZ',
            'name' => "ВУЗ",
            'value' => ''
        ],
        'fak' => [
            'bdName' => 'UF_OB_FAK',
            'name' => "Факультет",
            'value' => ''
        ],
        'spec' => [
            'bdName' => 'UF_OB_SPEC',
            'name' => "Специальность",
            'value' => ''
        ],
        'year' => [
            'bdName' => 'UF_OB_GOD',
            'name' => "Год выпуска",
            'value' => ''
        ],
    ]
];
/**
 * Номер удостоверения, Регистрационный номер, палата ( кабинет, коллегия), фото удостоверения.
 */
$arResult['anotherInput'] = [
    'certificate_number' => [
        'bdName' => 'UF_CERT_NUMB',
        'name' => 'Номер удостоверения',
        'value' => ''
    ],
    'reg_number' => [
        'bdName' => 'UF_REG_NUMB',
        'name' => 'Регистрационный номер',
        'value' => ''
    ],
    'palace' => [
        'bdName' => 'UF_REG_PAL',
        'name' => 'палата ( кабинет, коллегия)',
        'value' => ''
    ],
    'certificate_photo' => [
        'bdName' => 'UF_CERT_PHOTO',
        'name' => 'фото удостоверения',
        'value' => ''
    ],
];
$arResult['selectPosition'] = [
    'Юрист',
    'Юрисконсульт',
    'Юрист представитель',
    'Юрист эксперт'
];

foreach ($arResult['info']['work'] as $key => $item){
    $arResult['info']['work'][$key]['value'] = (isset($changesData[$item['bdName']]))?$changesData[$item['bdName']]:$tmp[$item['bdName']];
}
foreach ($arResult['info']['education'] as $key => $item){
    $arResult['info']['education'][$key]['value'] = (isset($changesData[$item['bdName']]))?$changesData[$item['bdName']]:$tmp[$item['bdName']];
}
foreach ($arResult['anotherInput'] as $key => $item){
    $arResult['anotherInput'][$key]['value'] = (isset($changesData[$item['bdName']]))?$changesData[$item['bdName']]:$tmp[$item['bdName']];
}

//pre($changesData);
$this->IncludeComponentTemplate();
?>