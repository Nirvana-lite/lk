<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;
use Bitrix\Main\UserTable;
use Bitrix\Main\Entity;
Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");

global $USER;
$rsUser = CUser::GetByID($USER->GetID());
if ($arUser = $rsUser->Fetch()) {
    if (!empty($arUser['PERSONAL_PHOTO'])) {
        $arUser['PERSONAL_PHOTO'] = CFile::GetPath($arUser['PERSONAL_PHOTO']);
    } else {
        $arUser['PERSONAL_PHOTO'] = '/local/img/no_photo.png';
    }
}


if (inGroup(1)) {
    /**
     * admin
     */
    $arResult['adm'] = true;
    $arResult['sidebar'] = [
        [
            'id' => '',
            'name' => 'Главная',
            'class' => 'fa fa-user-circle',
            'url' => '/personal/',
            'fixed' => true,
            'changeName' => 'Профиль'
        ],
        [
            'id' => '',
            'name' => 'Статьи',
            'main' => true,
            'disabled' => true,
            'class' => 'fa fa-book',
            'url' => ''
        ],
        [
            'id' => popular,
            'name' => 'Популярные темы',
            'class' => 'fa fa-thumbs-o-up',
            'url' => '/personal/popular',
            'fixed' => true
        ],
        [
            'id' => vestnik,
            'name' => 'Вестник',
            'class' => 'fa fa-graduation-cap',
            'url' => '/personal/vestnik'
        ],
        [
            'id' => pravo,
            'name' => 'Право и процесс',
            'class' => 'fa fa-gavel',
            'url' => '/personal/pravo',
            'fixed' => true
        ],
        [
            'id' => socprogram,
            'name' => 'Соц программы',
            'class' => 'fa fa-folder-open',
            'url' => '/personal/socprogram',
            'fixed' => true
        ],
        [
            'id' => 2,
            'name' => 'Новости',
            'class' => 'fa fa-file-text-o',
            'url' => '/personal/news',
            'fixed' => true
        ],
        [
            'id' => '',
            'name' => 'Разделы по темам',
            'class' => 'fa fa-pie-chart',
            'disabled' => true,
            'url' => '/personal/themes',
        ],
        [
            'id' => '',
            'name' => 'Услуги',
            'main' => true,
            'disabled' => true,
            'class' => 'fa fa-handshake-o',
            'url' => ''
        ],
        [
            'id' => 18,
            'name' => 'Вопросы и Ответы',
            'class' => 'fa fa-question-circle-o',
            'url' => '/personal/questions',
            'fixed' => true
        ],
        [
            'id' => '',
            'name' => 'Все Вопросы',
            'class' => 'fa fa-question-circle-o',
            'url' => '/personal/allquestions',
            'fixed' => true
        ],
        [
            'id' => 25,
            'name' => 'Комментарии',
            'class' => 'fa fa-commenting-o',
            'disabled' => true,
            'url' => '/personal/comments',
        ],
        [
            'id' => 'alarms',
            'name' => 'Жалобы',
            'class' => 'fa fa-free-code-camp',
            'disabled' => true,
            'url' => '/personal/complaint',
        ],
        [
            'id' => 63,
            'name' => 'Реклама',
            'class' => 'fa fa-podcast',
            'disabled' => true,
            'url' => '/personal/advertising',
        ],
        [
            'id' => '',
            'name' => 'Остальное',
            'main' => true,
            'disabled' => true,
            'class' => 'fa fa-coffee',
            'url' => ''
        ],
        [
            'id' => 44,
            'name' => 'Письма админу',
            'class' => 'fa fa-paper-plane-o',
            'disabled' => true,
            'url' => '/personal/support',
            'fixed' => true
        ],
        [
            'id' => 440,
            'name' => 'Предложенные идеи',
            'class' => 'fa fa-info-circle',
            'disabled' => true,
            'url' => '/personal/sentence',
            'fixed' => true
        ],
        [
            'id' => '',
            'name' => 'Заявки',
            'class' => 'fa fa-envelope-o',
            'disabled' => true,
            'url' => '/personal/applications',
            'fixed' => true
        ],
        [
            'id' => '',
            'name' => 'Новости в ЛК',
            'class' => 'fa fa-newspaper-o',
            'disabled' => true,
            'url' => '/personal/project-news',
        ],
        [
            'id' => 'usr',
            'name' => 'Пользователи',
            'class' => 'fa fa-address-card',
            'disabled' => true,
            'url' => '/personal/user-check',
        ],
        [
            'id' => '',
            'name' => 'Дискуссии',
            'class' => 'fa fa-address-card',
            'disabled' => true,
            'url' => '/discussions-edit/',
        ],
        [
            'id' => '',
            'name' => 'В разработке',
            'class' => 'fa fa-folder-open',
            'main' => true,
            'url' => '',
        ],
       /* [
            'id' => '',
            'name' => 'Подписки',
            'class' => 'fa fa-star-o',
            'disabled' => true,
            'url' => '/personal/subs',
            'fixed' => true
        ],*/
        [
            'id' => '',
            'name' => 'Блог',
            'class' => 'fa fa-commenting-o',
            'disabled' => true,
            'url' => '/personal/loading',
            'fixed' => true
        ],
        [
            'id' => '',
            'name' => 'VIP Вопросы',
            'class' => 'fa fa-cc-visa',
            'disabled' => true,
            'url' => '/personal/loading',
            'fixed' => true
        ],
        [
            'id' => '',
            'name' => 'Документы',
            'class' => 'fa fa-file-word-o',
            'disabled' => true,
            'url' => '/personal/loading',
            'fixed' => true
        ],
        [
            'id' => '',
            'name' => 'Отзывы',
            'class' => 'fa fa-star',
            'disabled' => true,
            'url' => '/personal/loading',
            'fixed' => true
        ],
        [
            'id' => '',
            'name' => 'Форум',
            'class' => 'fa fa-commenting-o',
            'disabled' => true,
            'url' => '/personal/loading',
        ],
    ];
} else {
    if (inGroup(8)) {
        /**
         * urist
         */

        $arResult['sidebar'] = [
            [
                'id' => '',
                'name' => 'Профиль',
                'main' => true,
                'disabled' => true,
                'class' => 'fa fa-address-card-o',
                'url' => ''
            ],
            [
                'id' => '',
                'name' => 'Главная',
                'class' => 'fa fa-user-circle',
                'url' => '/personal/',
                'fixed' => true,
                'changeName' => 'Профиль'
            ],
            [
                'id' => '',
                'name' => 'Изменить профиль',
                'class' => 'fa fa-pencil-square-o',
                'url' => '/personal/setting'
            ],
            [
                'id' => '',
                'name' => 'Статьи',
                'main' => true,
                'disabled' => true,
                'class' => 'fa fa-book',
                'url' => ''
            ],
            [
                'id' => '',
                'name' => 'Популярные темы',
                'class' => 'fa fa-thumbs-o-up',
                'url' => '/personal/popular',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Вестник',
                'class' => 'fa fa-graduation-cap',
                'url' => '/personal/vestnik'
            ],
            [
                'id' => '',
                'name' => 'Право и процесс',
                'class' => 'fa fa-gavel',
                'url' => '/personal/pravo',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Соц программы',
                'class' => 'fa fa-folder-open',
                'url' => '/personal/socprogram',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Блог',
                'class' => 'fa fa-commenting-o',
                'disabled' => true,
                'url' => '/personal/loading',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Услуги',
                'main' => true,
                'class' => 'fa fa-handshake-o',
                'url' => ''
            ],
            [
                'id' => '',
                'name' => 'Вопросы',
                'class' => 'fa fa-question-circle-o',
                'url' => '/personal/questions',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'VIP Вопросы',
                'class' => 'fa fa-cc-visa',
                'disabled' => true,
                'url' => '/personal/loading',
                'fixed' => true

            ],
            [
                'id' => '',
                'name' => 'Задать вопрос',
                'class' => 'fa fa-paper-plane',
                'url' => '/jurist-help/'
            ],
            [
                'id' => '',
                'name' => 'Заказать документы',
                'class' => 'fa fa-file-word-o',
                'disabled' => true,
                'url' => '/personal/loading'
            ],
            [
                'id' => '',
                'name' => 'Заказать услугу',
                'class' => 'fa fa-hand-o-right',
                'disabled' => true,
                'url' => '/personal/loading'
            ],
            [
                'id' => '',
                'name' => 'Шаблоны ответов',
                'class' => 'fa fa-file-text-o',
                'disabled' => true,
                'url' => '/personal/loading'
            ],
            [
                'id' => '',
                'name' => 'Общее',
                'main' => true,
                'class' => 'fa fa-archive',
                'disabled' => true,
                'url' => '/personal/loading'
            ],
            [
                'id' => '44-1',
                'name' => 'Предложить идею',
                'class' => 'fa fa-info-circle',
                'disabled' => true,
                'url' => '/personal/sentence',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Отзывы',
                'class' => 'fa fa-star',
                'disabled' => true,
                'url' => '/personal/loading',
                'fixed' => true
            ],
            [
                'id' => '44-2',
                'name' => 'Связь с администрацией',
                'class' => 'fa fa-paper-plane-o',
                'disabled' => true,
                'url' => '/personal/support',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Новости сайта',
                'class' => 'fa fa-newspaper-o',
                'disabled' => true,
                'url' => '/personal/project-news',
            ],
        ];
        $arResult['usr'] = false;
    }
    else {
        /**
         * users
         */

        $arResult['sidebar'] = [
            [
                'id' => '',
                'name' => 'Профиль',
                'main' => true,
                'disabled' => true,
                'class' => 'fa fa-address-card-o',
                'url' => ''
            ],
            [
                'id' => '',
                'name' => 'Главная',
                'class' => 'fa fa-user-circle',
                'url' => '/personal/',
                'fixed' => true,
                'changeName' => 'Профиль'
            ],
            [
                'id' => '',
                'name' => 'Изменить профиль',
                'class' => 'fa fa-pencil-square-o',
                'url' => '/personal/setting'
            ],
            [
                'id' => '',
                'name' => 'Статьи',
                'main' => true,
                'disabled' => true,
                'class' => 'fa fa-book',
                'url' => ''
            ],
            [
                'id' => '',
                'name' => 'Популярные темы',
                'class' => 'fa fa-thumbs-o-up',
                'url' => '/personal/popular',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Вестник',
                'class' => 'fa fa-graduation-cap',
                'url' => '/personal/vestnik',
            ],
            [
                'id' => '',
                'name' => 'Право и процесс',
                'class' => 'fa fa-gavel',
                'url' => '/personal/pravo',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Соц программы',
                'class' => 'fa fa-folder-open',
                'url' => '/personal/socprogram',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Блог',
                'class' => 'fa fa-commenting-o',
                'disabled' => true,
                'url' => '/personal/loading',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Услуги',
                'main' => true,
                'class' => 'fa fa-handshake-o',
                'url' => ''
            ],
            [
                'id' => '',
                'name' => 'Вопросы',
                'class' => 'fa fa-question-circle-o',
                'url' => '/personal/questions',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Задать вопрос',
                'class' => 'fa fa-paper-plane',
                'url' => '/jurist-help/',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Заказать документы',
                'class' => 'fa fa-file-word-o',
                'disabled' => true,
                'url' => '/personal/loading',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Заказать услугу',
                'class' => 'fa fa-hand-o-right',
                'disabled' => true,
                'url' => '/personal/loading',
                'fixed' => true
            ],
            [
                'id' => '44-2',
                'name' => 'Связь с администрацией',
                'class' => 'fa fa-paper-plane-o',
                'disabled' => true,
                'url' => '/personal/support',
                'fixed' => true
            ],
            [
                'id' => '44-1',
                'name' => 'Предложить идею',
                'class' => 'fa fa-info-circle',
                'disabled' => true,
                'url' => '/personal/sentence',
                'fixed' => true
            ],
            [
                'id' => '',
                'name' => 'Новости сайта',
                'class' => 'fa fa-newspaper-o',
                'disabled' => true,
                'url' => '/personal/project-news',
            ],
        ];
        $arResult['usr'] = true;
    }
}
$dir = $_SERVER['DOCUMENT_ROOT'] . "/local/avatars";
$f = scandir($dir);
foreach ($f as $file) {
    if (is_dir($file)) {
        continue;
    }
    $arResult['my_avatars'][] = "/local/avatars/" . $file;
}
$arResult['user'] = [
    'id' => $arUser['ID'],
    'name' => $arUser['NAME'],
    'photo' => $arUser['PERSONAL_PHOTO'],
    'mail' => $arUser['EMAIL'],
    'lastName' => $arUser['LAST_NAME']
];

if (inGroup(admin)) {
    $arr = [];
    $arrComment = [23, 25, 31, 36, 37, 46];
    $arSelect = array("ID", "IBLOCK_ID");
    $arFilter = array(
        "IBLOCK_ID" => array(popular, vestnik, socprogram, pravo, 2, 18, 23, 25, 31, 46, 37, 36,63),
        "ACTIVE" => "N"
    );
    $res = CIBlockElement::GetList(array(), $arFilter, ['IBLOCK_ID'], false, $arSelect);
    while ($ob = $res->fetch()) {
        if (in_array(intval($ob['IBLOCK_ID']), $arrComment)) {
            $arr[25] += $ob['CNT'];
        } else {
            $arr[$ob['IBLOCK_ID']] = $ob['CNT'];
        }

    }
    $arSelect = array("ID", "IBLOCK_ID", "PROPERTY_474");
    $arFilter = array("IBLOCK_ID" => array(44), "ACTIVE" => "N");
    $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
    while ($ob = $res->fetch()) {
        if ($ob['PROPERTY_474_VALUE'] == 1) {
            $arr[440] += 1;
        } else {
            $arr[44] += 1;
        }

    }

    $arFilter = Array(
        Array(
            "!UF_CHANGEDATA" => false,
        )
    );
    $res1 = Bitrix\Main\UserTable::getList(Array(
        "select" => Array('CNT'),
        "filter" => $arFilter,
        'runtime' => array(
            new Entity\ExpressionField('CNT', 'COUNT(*)')
        )
    ))->fetchAll();
    if (intval($res1[0]['CNT']) > 0){
        $key = array_search('usr', array_column($arResult['sidebar'], 'id'));
        $arResult['sidebar'][$key]['cnt'] = $res1[0]['CNT'];
    }

    $arSelect = array("ID", "IBLOCK_ID");
    $arFilter = array("IBLOCK_ID" => array(18, 23, 31, 46, 37, 36), "!PROPERTY_SHALOBA_COMMENT" => false);
    $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
    $arr['alarms'] = $res->SelectedRowsCount();

    if (count($arr) > 0) {
        foreach ($arr as $elemKey => $item) {
            $key = array_search($elemKey, array_column($arResult['sidebar'], 'id'));
            $arResult['sidebar'][$key]['cnt'] = $item;
        }
    }

}
else {
    $userQuest = [];
    $arSelect = array("ID", "IBLOCK_ID", "PROPERTY_METHOD");
    $arFilter = array("IBLOCK_ID" => array(44), "ACTIVE" => "Y", "CREATED_BY" => $USER->GetID());
    $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
    while ($ob = $res->fetch()) {
        if ($ob['PROPERTY_METHOD_VALUE'] == 1) {
            $userQuest['sentence'][] = $ob['ID'];
        } else {
            $userQuest['quest'][] = $ob['ID'];
        }
    }

    $all = array_merge($userQuest['sentence'], $userQuest['quest']);
    $arr = [];

    $arSelect = array("ID", "IBLOCK_ID", "CREATED_BY","PROPERTY_VIEWED","PROPERTY_OBJECT");
    $arFilter = array(
        "IBLOCK_ID" => array(38),
        "ACTIVE" => "Y",
        "PROPERTY_OBJECT" => $all,
        "!CREATED_BY"=>$USER->GetID(),
        "!PROPERTY_VIEWED" => 1
    );
    $res = CIBlockElement::GetList(array('ID' => 'desc'), $arFilter, false, false, $arSelect);
    if (intval($res->SelectedRowsCount())>0){
        while ($ob = $res->fetch()) {
            if (in_array($ob['PROPERTY_OBJECT_VALUE'],$userQuest['sentence'])){
                $tmp['44-1']++;
            }else if(in_array($ob['PROPERTY_OBJECT_VALUE'],$userQuest['quest'])){
                $tmp['44-2']++;
            }
        }
        $arResult['test'] = $tmp;
        foreach ($tmp as $key => $item){
            $key = array_search($key, array_column($arResult['sidebar'], 'id'));
            $arResult['sidebar'][$key]['cnt'] = $item;
        }
    }


//    $arResult['test'] = 'asdasd';
}


$this->IncludeComponentTemplate();
?>