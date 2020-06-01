<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
$info[] = $request->getPost("anotherInput");
$info[] = $request->getPost("educations");
$info[] = $request->getPost("work");
$info = array_merge($info[0],$info[1],$info[2]);
global $USER;

/**
 * $_FILES['anotherInput']
 */

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

foreach ($info as $key => $item){
    $changesData[$key] = $item;
}

$tmp = json_encode($changesData);


$user = new CUser;

foreach ($_FILES['anotherInput'] as $key => $file){
    $nFile[$key] = $file['UF_CERT_PHOTO'];
}



$answer['done'] = $user->Update($USER->GetID(), ['UF_CHANGEDATA' => $tmp, 'UF_CERT_PHOTO' => $nFile]);
$answer['error'] = $user->LAST_ERROR;



echo json_encode($answer);