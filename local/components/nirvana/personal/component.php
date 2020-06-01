<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");

global $USER;
$rsUser = CUser::GetByID($USER->GetID());
while ($arUser = $rsUser->Fetch()) {
    $arResult = [
        'user' => [
            'id' => $arUser['ID'],
            'name' => $arUser['NAME'],
            'photo' => $arUser['PERSONAL_PHOTO'],
            'mail' => $arUser['EMAIL'],
            'lastName' => $arUser['LAST_NAME']
        ],
    ];
}
$this->IncludeComponentTemplate();
?>