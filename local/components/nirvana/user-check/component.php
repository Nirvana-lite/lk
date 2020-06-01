<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

use Bitrix\Main\Page\Asset;
use Bitrix\Main\UserTable;
use Bitrix\Main\Entity;
use Bitrix\Main\Context;
use Bitrix\Main\Request;
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>");
//Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' integrity='sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp' crossorigin='anonymous'>");

/*global $USER;
$filter = Array( "!GROUPS_ID" => 8, "UF_USER_CHECK" => 0);
//$filter = Array("GROUPS_ID" => Array(5), "UF_USER_CHECK" => 0);
$navs = array("nPageSize" => "20");
$rsUsers = CUser::GetList(($by = "DATE_REGISTER"), ($order = "desc"), $filter, array("NAV_PARAMS" => $navs));*/



$request = Context::getCurrent()->getRequest();
$value = $request->getPost("USERS");
if (empty($value)) {

    $arResult = [
        'urists' => [
            'id' => 8,
            'name' => 'Юристы',
            'cnt' => 0,
            'elems' => []
        ],
        'users' => [
            'id' => 5,
            'name' => 'Пользователи',
            'cnt' => 0,
            'elems' => []
        ]
    ];

    $ugt = "Bitrix\Main\UserGroupTable:USER.";


    /**
     * get all users non 8 group
     */
    $userFilter = Array(
        Array(
            "LOGIC" => "AND",
            Array(
                "UF_USER_CHECK" => 0,
                "{$ugt}GROUP_ID" => 5,
            )
        )
    );

    /**
     * get all users in 8 group
     */
    $uristFilter = Array(
        Array(
            "LOGIC" => "AND",
            Array(
                "UF_USER_CHECK" => 0,
                "{$ugt}GROUP_ID" => 8,
            )
        )
    );


    $userRes = Bitrix\Main\UserTable::getList(Array(
        'select' => array(
            new Entity\ExpressionField('CNT', 'COUNT(*)')
        ),
        "filter" => $userFilter,
        "data_doubling" => false,
//        "cache"=>array("ttl"=>36000, "cache_joins"=>true)
    ));

    $uristRes = Bitrix\Main\UserTable::getList(Array(
        'select' => array(
            new Entity\ExpressionField('CNT', 'COUNT(*)')
        ),
        "filter" => $uristFilter,
        "data_doubling" => false,
//        "cache"=>array("ttl"=>36000, "cache_joins"=>true)
    ));

    $arResult['users']['cnt'] = $userRes->fetchAll()[0]['CNT'];
    $arResult['urists']['cnt'] = $uristRes->fetchAll()[0]['CNT'];
}
else{
    $ugt = "Bitrix\Main\UserGroupTable:USER.";

    $userGroup = intval($value);
    $arFilter = Array(
        Array(
            "UF_USER_CHECK" => 0,
            "{$ugt}GROUP_ID" => 5
        )
    );
    if ($userGroup === 8){
        $arFilter = Array(
            Array(
                "UF_USER_CHECK" => 0,
                "{$ugt}GROUP_ID" => 8
            )
        );
    }

    $res = Bitrix\Main\UserTable::getList(Array(
        "select" => Array("*","UF_OB_VUZ","UF_OB_FAK","UF_OB_SPEC","UF_OB_GOD","UF_CHANGEDATA","UF_CERT_NUMB","UF_REG_NUMB","UF_REG_PAL","UF_CERT_PHOTO"),
        "filter" => $arFilter,
        'order' => ['UF_CHANGEDATA' => 'desc','ID' => 'desc',],
        "data_doubling" => false,
        'limit' => 21
    ));

    while ($arUser = $res->Fetch()) {
        if (!empty($arUser['PERSONAL_PHOTO'])) {
            $arUser['PERSONAL_PHOTO'] = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width' => 150, 'height' => 150))['src'];
        } else {
            $arUser['PERSONAL_PHOTO'] = '/local/img/no_photo.png';
        }
        if (!empty($arUser['UF_CERT_PHOTO'])) {
            $arUser['UF_CERT_PHOTO'] = CFile::ResizeImageGet($arUser['UF_CERT_PHOTO'], array('width' => 150, 'height' => 150))['src'];
        }
        $new = false;

        $dayRegister = date('d.m.Y',strtotime($arUser['DATE_REGISTER']));
        $curday = date('d.m.Y');
        $d1 = strtotime($dayRegister);
        $d2 = strtotime($curday);
        $diff = $d2-$d1;
        $diff = $diff/(60*60*24);
        $years = floor($diff);
        if ($years <=4){
            $new = true;
        }
        if ($userGroup === 8) {
            $arResult[] = [
                'id' => $arUser['ID'],
                'new' => $new,
                'changes' => !empty($arUser['UF_CHANGEDATA']),
                'name' => "{$arUser['NAME']}",
                'last' => "{$arUser['LAST_NAME']}",
                'second' => "{$arUser['SECOND_NAME']}",
                'photo' => $arUser['PERSONAL_PHOTO'],
                'mail' => $arUser['EMAIL'],
                'work' => [
                    'company' => $arUser['WORK_COMPANY'],
                    'department' => $arUser['WORK_DEPARTMENT'],
                    'position' => $arUser['PERSONAL_PROFESSION'],
                    'address' => $arUser['WORK_STREET'],
                    'profile' => $arUser['WORK_PROFILE'],
                    'workPhone' => $arUser['WORK_PHONE'],
                ],
                'educat' => [
                    'vuz' => $arUser['UF_OB_VUZ'],
                    'fak' => $arUser['UF_OB_FAK'],
                    'spec' => $arUser['UF_OB_SPEC'],
                    'year' => $arUser['UF_OB_GOD'],
                ],
            ];
        } else {
            $arResult[] = [
                'id' => $arUser['ID'],
                'new' => $new,
                'changes' => !empty($arUser['UF_CHANGEDATA']),
                'name' => "{$arUser['NAME']} {$arUser['LAST_NAME']} {$arUser['SECOND_NAME']}",
                'photo' => $arUser['PERSONAL_PHOTO'],
                'mail' => $arUser['EMAIL'],
                'phone' => $arUser['PERSONAL_PHONE'],
                'lastName' => $arUser['LAST_NAME'],
                'secondName' => $arUser['SECOND_NAME'],
            ];
        }

    }
}
$this->IncludeComponentTemplate($componentPage);
?>