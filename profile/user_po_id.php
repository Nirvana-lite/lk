<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
if(!CModule::IncludeModule("iblock")){die();}


//$user_id = $_REQUEST['USER_ID']; // id пользователя - юриста, реестр адвокатов и нотариусов

/* проверка
 * есть ли пользователь
 * находится в определенной группе
*/

$array_page = array(
    '/feedback/' // страница отзывы
);

$page = $APPLICATION->GetCurPage(false);
$page_array = explode('/',parse_url($page,PHP_URL_PATH));
$page_array = array_diff($page_array, array(''));
$page_array = array_values($page_array);

$user_id = intval($page_array[1]); // id пользователя

// проверка есть ли пользователь

$rsUser = CUser::GetByID($user_id);
if ($arUser = $rsUser->Fetch()){
    $user_data = $arUser;  // данныепользователя для массива
} else{
    // такого пользователя нет
    error404();
}

/*
switch () {
    case "feedback"://ключевое слово
        echo "Китай занимает первое место"; //вывод на экран
        break;
    case "Китай"://ключевое слово
        echo "Китай занимает первое место"; //вывод на экран
        break;
}




pre($page_array);
pre($user_id);
*/

if( count($page_array) > 2 ){
    echo "asd";
    $id_url = $page_array[2];
    //error404();
    pre($_REQUEST);

} elseif (count($page_array) == 2){
    // разрешенные ссылки втрого уровня
    $id_url = end($page_array);


}


if( !ctype_digit($id_url) ) { // состоит не из цифр
    error404();
} else {
    $user_id = intval($user_id);
}


// проверка есть ли пользователь

$rsUser = CUser::GetByID($user_id);
if ($arUser = $rsUser->Fetch()){
    $user_data = $arUser;  // данныепользователя для массива
} else{
    // такого пользователя нет
    error404();
}

// входит ли пользователь в определенную группу
$arGroups = CUser::GetUserGroup($user_data['ID']);

$groupID = array(
    8,  // юристы
    19, // реестр нотариусы
    20  // реестр адвокаты
);

$int_sec = array_intersect($groupID, $arGroups); // находим совпадения

if(empty($int_sec)){ error404(); } // пользователь в другой группе - выдаем 404

if ( ! in_array ( $int_sec[0], $arGroups ) ){ // пользователь не в группе
    error404();
}

// подключение внешних видов
if($int_sec[0] == 8){
    $include_file = "jurist";
} elseif ($int_sec[0] == 19){
    $include_file = "notarius";
} elseif ($int_sec[0] == 20){
    $include_file = "advokat";
} else{
    $include_file = "";
}

if(empty($include_file)){ error404(); }

global $user_data;
// подключаем внешний вид для определенной группе

require($_SERVER["DOCUMENT_ROOT"] . '/profile/include/html_profile_' . $include_file . '.php');?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>