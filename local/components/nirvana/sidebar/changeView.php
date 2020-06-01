<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

if ($_POST['change'] == 'main'){
    $_SESSION['viewModal'] = false;
}
if ($_POST['change'] == 'status'){
    $_SESSION['statusModal'] = false;
}