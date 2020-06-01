<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
global $USER;
$_SESSION['viewModal'] = true;
$_SESSION['statusModal'] = true;
$ans = $USER->Logout();

echo json_encode($ans);