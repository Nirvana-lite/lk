<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");
Asset::getInstance()->addString("<script src='//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js'></script>");

global $USER;
$rsUser = CUser::GetByID($USER->GetID());

CModule::IncludeModule('iblock');

$citys = [];
$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID"=>IntVal(16), "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->fetch())
{
    $citys[] = [
        'id' => $ob['ID'],
        'name' => $ob['NAME']
    ];
}


while ($arUser = $rsUser->Fetch()) {
    if (!empty($arUser['PERSONAL_PHOTO'])) {
        $arUser['PERSONAL_PHOTO'] = CFile::GetPath($arUser['PERSONAL_PHOTO']);
    } else {
        $arUser['PERSONAL_PHOTO'] = '/local/img/no_photo.png';
    }
    $arResult = [
        'user' => [
            'id' => $arUser['ID'],
            'name' => $arUser['NAME'],
            'photo' => $arUser['PERSONAL_PHOTO'],
            'mail' => $arUser['EMAIL'],
            'phone' => $arUser['PERSONAL_PHONE'],
            'lastName' => $arUser['LAST_NAME'],
            'secondName' => $arUser['SECOND_NAME'],
            'selectCity' => $arUser['UF_REGION'],
            'citys' => $citys
        ],
    ];

if (inGroup(8)){
    $arResult['work'] = [
        'company' => $arUser['WORK_COMPANY'],
        'department' => $arUser['WORK_DEPARTMENT'],
        'position' => $arUser['PERSONAL_PROFESSION'],
        'address' => $arUser['WORK_STREET'],
        'profile' => $arUser['WORK_PROFILE'],
        'workPhone' => $arUser['WORK_PHONE'],
        'workemail' => $arUser['WORK_MAILBOX'],
    ];
    $arResult['educat'] = [
        'vuz' => $arUser['UF_OB_VUZ'],
        'fak' => $arUser['UF_OB_FAK'],
        'spec' => $arUser['UF_OB_SPEC'],
        'year' => $arUser['UF_OB_GOD'],
    ];
    $arResult['osebe'] = [
        'mytextar' => $arUser['PERSONAL_NOTES'],
    ];
   /* $arResult['selectPosition'] = [
        'Юрист',
        'Юрисконсульт',
        'Юрист представитель',
        'Юрист эксперт',
        'Адвокат'
    ];*/
    $arResult['isUrist'] = true;
}
$arResult['change'] = (!empty($arUser['UF_CHANGEDATA']))?true:false;
}
$dir    = $_SERVER['DOCUMENT_ROOT'] . "/local/avatars";
$f = scandir($dir);
foreach ($f as $file){
    if (is_dir($file)) continue;
        $arResult['my_avatars'][] = "/local/avatars/". $file;
}


$this->IncludeComponentTemplate();
?>