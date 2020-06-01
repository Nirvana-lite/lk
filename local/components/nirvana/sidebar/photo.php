<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $USER;

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

    $fileName = str_replace(" ", "-", mb_strtolower(basename($_FILES['file']['name'])));
    $uploadfile = $dir . $fileName;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
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

if (makedirs($dir)) {
    array_map('delPhotos', glob("$dir*"));
    if (in_array($_FILES['file']['type'], $goodArr)) {
        $photo = createPhoto($dir);
    } else {
        $arr['error'] = 'Неверный тип фото';
    }
}
$filter = array
(
    "ID" => $USER->GetID(),
);
$select = ['UF_CHANGEDATA'];
$fileds = ['ID'];
$rsUsers = CUser::GetList(($by = "ID"), ($order = "desc"), $filter, array('SELECT' => $select, 'FIELDS' => $fileds));
while ($arUser = $rsUsers->fetch()) {
    $tmp = $arUser;
}
$changesData = json_decode($tmp['UF_CHANGEDATA'], true);

$photoName = basename($photo);
$photoSrc = "/upload/editPhoto/{$USER->GetID()}/{$photoName}";
$changesData['PERSONAL_PHOTO'] = $photoSrc;
$tmp = [
    'UF_CHANGEDATA' => json_encode($changesData)
];

$user = new CUser;
$arr['done'] = $user->Update($USER->GetID(), $tmp);
$arr['err'] = $user->LAST_ERROR;
echo json_encode($arr);
