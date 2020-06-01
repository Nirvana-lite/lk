<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вход");

global $USER;

if(inGroup(26)){
//    LocalRedirect("/personal/advert");
}elseif (intval($USER->GetID()) > 0){
    $arrGroups_new = array(26); // в какие группы хотим добавить
    $arrGroups_old = $USER->GetUserGroupArray(); // получим текущие группы
    $arrGroups = array_unique(array_merge($arrGroups_old, $arrGroups_new)); // объединим два массива и удалим дубли
    $USER->Update($USER->GetID(), array("GROUP_ID" => $arrGroups)); // обновим профайл пользователя в базе
    $USER->Authorize($USER->GetID()); // авторизуем
//    LocalRedirect("/personal/advert");
}else{
    $APPLICATION->IncludeComponent(
        "nirvana:advertising.auth",
        "",
        Array()
    );
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>