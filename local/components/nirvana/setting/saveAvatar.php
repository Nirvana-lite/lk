<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->RestartBuffer();
global $USER;
function guardAuth($input)
{
    $input = trim($input); // - пробелы
    $input = stripslashes($input); // - экранированныe символы
    $input = strip_tags($input); //  - тэги
    $input = htmlspecialchars($input); // преобразуем в сущности если что то осталось

    return $input;
}


$arr = [];
foreach ($_POST as $key => $item) {
    $arr[$key] = guardAuth($item);
}
$dir    = $_SERVER['DOCUMENT_ROOT'] . "/local/avatars/";
$f = scandir($dir);
foreach ($f as $file){
    if (is_dir($file)) continue;

    if ($arr['ava'] === "/local/avatars/" . $file){
        $elem = $dir . $file;
    }
}
$fields = [
    'PERSONAL_PHOTO' => CFile::MakeFileArray($elem)
];
$user = new CUser;

 if ($user->Update($USER->GetID(), $fields)){
     $answer = true;
 }else{
     $answer = $user->LAST_ERROR;
 }


echo json_encode($answer);
