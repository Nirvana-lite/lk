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

$dir = $_SERVER['DOCUMENT_ROOT'] . "/upload/editPhoto/{$USER->GetID()}/";
$goodArr = ['image/gif', 'image/jpeg', 'image/png', 'image/webp'];
function makedirs($dirpath, $mode = 0777)
{
    return is_dir($dirpath) || mkdir($dirpath, $mode, true);
}

function delPhotos($file)
{
    unlink($file);
}

function createPhoto($dir)
{
    $fileName = str_replace(" ", "-", mb_strtolower(basename($_FILES['photo']['name'])));
    $uploadfile = $dir . $fileName;
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
        changeSizePhoto($uploadfile);
    }
    return $uploadfile;
}

function changeSizePhoto($file)
{
    switch (getimagesize($file)['mime']) {
        case 'image/gif':
            $img = imagecreatefromgif($file);
            break;
        case 'image/jpeg':
            $img = imagecreatefromjpeg($file);
            break;
        case 'image/png':
            $img = imagecreatefrompng($file);
            break;
        case 'image/webp':
            $img = imagecreatefromwebp($file);
            break;
    }
    $to = imagecreatetruecolor(220, 240);
    imagecopyresampled(
        $to, $img, 0, 0, 0, 0, imagesx($to), imagesy($to), imagesx($img), imagesy($img)
    );
    imagejpeg($to, $file, 85);
    imagedestroy($to);
}


$arr = [];
foreach ($_POST as $key => $item) {
    $arr[$key] = guardAuth($item);
}
if ($arr['form'] == 'personal') {
    $fields = Array(
        "NAME" => $arr['name'],
        "LAST_NAME" => $arr['lastname'],
        "SECOND_NAME" => $arr['secondname'],
        "PERSONAL_PHONE" => $arr['phone'],
        "EMAIL" => $arr['mail'],
        "WORK_MAILBOX" => $arr['workemail'],
        'UF_REGION' => intval($arr['city'])
    );
    if ($_FILES['photo']['size'] > 0) {
        if (makedirs($dir)) {
            array_map('delPhotos', glob("$dir*"));
            if (in_array($_FILES['photo']['type'], $goodArr)) {
                $photo = createPhoto($dir);
                $photoName = basename($photo);
                $photoSrc = "/upload/editPhoto/{$USER->GetID()}/{$photoName}";
                $fields['PERSONAL_PHOTO'] = $photoSrc;
            } else {
                $arr['error'] = 'Неверный тип фото';
            }
        }

    }
    if (!empty($arr['pass'])) {
        $fields["PASSWORD"] = $arr['pass'];
        $fields["CONFIRM_PASSWORD"] = $arr['confirmpass'];
    }
}
elseif ($arr['form'] == 'work') {
    $fields = Array(
        "WORK_COMPANY" => $arr['company'],
        "WORK_DEPARTMENT" => $arr['department'],
//        "PERSONAL_PROFESSION" => $arr['position'],
        "WORK_STREET" => $arr['address'],
        "WORK_PROFILE" => $arr['profile'],
        "WORK_PHONE" => $arr['workphone'],
    );

}
elseif ($arr['form'] == 'education') {
    $fields = Array(
        "UF_OB_VUZ" => $arr['vuz'],
        "UF_OB_FAK" => $arr['fak'],
        "UF_OB_SPEC" => $arr['spec'],
        "UF_OB_GOD" => $arr['year'],
    );
}
elseif ($arr['form'] == 'osebe') {
    $fields = Array(
        "PERSONAL_NOTES" => $arr['mytextar'],
    );
}
else {
    $answer['fail'] = false;
}
$user = new CUser;


$arFilter = ['ID' => $USER->GetID()];
$res = Bitrix\Main\UserTable::getList(Array(
    "select" => Array("UF_CHANGEDATA"),
    "filter" => $arFilter,
    'limit' => 1
));
while ($arUser = $res->fetch()){
    $tmp = json_decode($arUser['UF_CHANGEDATA'],true);
}
    foreach ($fields as $key => $item){
        $tmp[$key] = $item;
    }
$tmp = json_encode($tmp);
$answer['done'] = $user->Update($USER->GetID(), ['UF_CHANGEDATA' => $tmp]);
//$answer['done'] = $user->Update($USER->GetID(), $fields);
$answer['error'] = $user->LAST_ERROR;

echo json_encode($tmp);
