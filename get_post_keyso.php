<?
require $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php";
global $DB;
use Bitrix\Main\Application;

$connection = \Bitrix\Main\Application::getConnection();
$sqlHelper = $connection->getSqlHelper();
//print_r($_POST);


//$connection->queryExecute("INSERT INTO keyso_category ('CAT_ID', 'NAME', 'URL') VALUES ('', '', '{$_POST['url']}')");


$query_check = "SELECT url FROM `keyso_list_keys` WHERE url = '".$_POST['url']."' limit 1";
$res = $connection->query($query_check);

if($res->getSelectedRowsCount()>0){

} else {
    /*
     * keyso_category
     */

  //  $strSql = "INSERT INTO `keyso_category` ( NAME, URL ) VALUES ('{$_POST['name']}', '{$_POST['url']}')";


  // keyso_list_keys

   $strSql = "INSERT INTO `keyso_list_keys` (CAT_ID, NAME, URL) VALUES ({$_POST['cat_id']}, '{$_POST['name']}', '{$_POST['url']}')";

   $connection->queryExecute($strSql);

}

?>