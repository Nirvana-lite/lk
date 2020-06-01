<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule('iblock')){ die(); }
if (!CModule::IncludeModule("forum")) { die(); }

global $APPLICATION;
//global $USER;
?>
<script src="https://jur24pro.ru/include/ajax_form.js"></script>
<?
if (isset($_GET['PAGEN_1']) && intval($_GET['PAGEN_1']) > 0) {
    $nomberstr = "Страница " . $_GET['PAGEN_1'] . " ";
} else {
    $_GET['PAGEN_1'] = 1;
    $str = true;
    $nomberstr = "";
}

if (isset($_GET['PAGEN_1']) && intval($_GET['PAGEN_1']) <= 1) {
    if ($str) {
        $APPLICATION->SetPageProperty("canonical", "https://jur24pro.ru/yuristy-i-advokaty/");
        $APPLICATION->SetPageProperty("robots", 'all');
    } else {
        $APPLICATION->SetPageProperty("robots", 'none');
    }
} else {

    $APPLICATION->SetPageProperty("robots", 'all');
    $APPLICATION->SetPageProperty("canonical", "https://jur24pro.ru/yuristy-i-advokaty/?PAGEN_1=" . $_GET['PAGEN_1']);
}
?>
<? // фильтр юристов по городам ?>

        <?
        $razdel_link = '/notariusy/';


        $page = $APPLICATION->GetCurPage();
        $page = explode("/", $page);
        $page = array_diff($page, array(''));

        if(count($page) > 2){
            // ошибка 404
            error404();
        }

        if(count($page) == 1){
            // находимся на главной
            $selected_reg = 1;
        } else {
            // находимся в городе
            $selected_reg = end($page);
            if($selected_reg == 1){
                error404();
            }

        }


// закешировать результат

function get_list_city($razdel_link)
        {
            $arSelect = Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_*");
            $arFilter = Array("IBLOCK_ID" => IntVal(16));
            $res = CIBlockElement::GetList(Array("name" => "asc"), $arFilter, false, false, $arSelect);
            $regions = array();
            $list_regions = array();
            $list_regions[1] = array(
                'LINK' => '',
                'NAME' => 'Все города'
            );
            while ($ob = $res->Fetch()) {
                $regions[$ob['ID']] = $ob['NAME']; // нужно для списка юриста
                $list_regions[$ob['CODE']] = array(
                    'ID_REGION' => $ob['ID'],
                    'LINK' => $ob['CODE'] . '/',
                    'NAME' => $ob['NAME']
                );  // проверка существования и список в select
            }
            return array(
                'regions' => $regions,
                'list_regions' => $list_regions
            );
        }


        $cachedDatasas = returnResultCache(3600000, 'list_filter_city', 'get_list_city', $razdel_link);

// данные из кеша
        $regions = $cachedDatasas['regions'];
        $list_regions = $cachedDatasas['list_regions'];

       if (!array_key_exists($selected_reg, $list_regions)) { // такого города нет выводим 404
           // ошибка 404
           error404();
       }else{
            // есть город устанавливаем seo
           $code = $list_regions[$selected_reg]['LINK'];
           $reg = ' '.(trim($list_regions[$selected_reg]['NAME'])).' ';

           if($selected_reg == 1) {
               $reg =' ';
               $region_user = 0;
           }else{
               $region_user = $list_regions[$selected_reg]['ID_REGION'];
           }

               $APPLICATION->SetPageProperty("tags", $nomberstr . "в реестр зарегистрированных нотариус нотариусов" . $reg . "России РФ");
               $APPLICATION->SetPageProperty("keywords_inner", "в реестр зарегистрированных нотариус нотариусов" . $reg . "России РФ");
               $APPLICATION->SetPageProperty("keywords", $nomberstr . "в реестр зарегистрированных нотариус нотариусов" . $reg . "России РФ");
               $APPLICATION->SetPageProperty("description", $nomberstr . "Реестр зарегистрированных нотариусов" . (rtrim($reg)) . ", оказывающие профессиональные услуги" . $reg . "в России");
               $APPLICATION->SetTitle("Реестр нотариусов" . $reg);
               $APPLICATION->SetPageProperty("title", $nomberstr . "Реестр нотариусов" . $reg . " Российской Федерации");
               $APPLICATION->SetPageProperty("canonical", "https://jur24pro.ru".$razdel_link. $code );
       }

        ?>
<h1 class="main-title">Реестр нотариусов<?=(rtrim($reg));?></h1>
<div class="filter__city block-shadow">
        <p>Выбрать город</p>
        <select id="gorod_select" onchange="location = this.options[this.selectedIndex].value;">
            <? foreach ($list_regions as $key => $item) { ?>
                <option value="<?=($razdel_link.$item['LINK']);?>"<?echo (($selected_reg == $key) ? 'selected' : '');?>><?=$item['NAME'];?></option>
            <? } ?>
        </select>
        <div class="hidden-text">
        <? foreach ($list_regions as $key => $item) { ?>
            <a href="<?=($razdel_link.$item['LINK']);?>"><?=$item['NAME'];?></a>
        <? } ?>
        </div>
</div>

<div class="filter__user">
    <?

 function get_list_user($data_array)
 {
     $region_user = $data_array['data_region_user'];
     $regions = $data_array['data_regions'];
     $PAGEN_1 = $data_array['PAGEN_1'];

     $filter = Array
     (
         "ACTIVE" => "Y",
         "GROUPS_ID" => Array(19),

     );

     if ($region_user > 0) {
         $filter["UF_REGION"] = $region_user;
     }

     $rsUsers = CUser::GetList(
         ($by = "personal_country"),
         ($order = "desc"),
         $filter,
         array("SELECT" => array("UF_*"))
     ); // выбираем пользователей

     $rsUsers->NavStart(21, false, intval($PAGEN_1));// разбиваем постранично по 50 записей
     $result_id_user = array();
     while ($userlist = $rsUsers->GetNext()) {
         $result_id_user[] = $userlist['ID']; // для получения количества

         // аватарку по умолчанию

         $file='';
         if (intval() > 0 ) {
             $file = CFile::ResizeImageGet($userlist['PERSONAL_PHOTO'], array('width' => 150, 'height' => 150), BX_RESIZE_IMAGE_EXACT, true);
         }
         // массив пользователей
         $u_res = array(
             "id" => $userlist["ID"],
             "fio" => $userlist["LAST_NAME"] . ' ' . $userlist["NAME"] . ' ' . $userlist["SECOND_NAME"],
             "img_path" => $file['src'],
             "dolgnost" => $userlist["PERSONAL_PROFESSION"],
             "adres" => $userlist["WORK_CITY"] . ', ' . $regions[$userlist["UF_REGION"]].", Россия",
             "fio_sokr" => $userlist["LAST_NAME"] . ' ',
             "fio_io" => $userlist["NAME"] . ' ' . $userlist["SECOND_NAME"],
             "link_profile" => '/profile/' . $userlist["ID"] . '/',
             //"adress" => $userlist["WORK_COMPANY"].' '.$userlist["WORK_STREET"],
             "adress" => $userlist["WORK_ZIP"].', '.$userlist["WORK_CITY"].', '.$userlist["WORK_STREET"],
             "phone" => $userlist["WORK_PHONE"]
         );
         $result[] = $u_res;
     }
    return array('result' => $result,'rsUsers' => $rsUsers);
 }

 // кеширование пользователей
    $data_result_user = returnResultCache(3600000, 'reestr_notariusy/list_filter_user'.$region_user.'_'.(intval($_GET['PAGEN_1'])), 'get_list_user',
        array(
                'data_region_user' => $region_user,
                'data_regions' => $regions,
                'PAGEN_1' => intval($_GET['PAGEN_1'])
        ));
    $result = $data_result_user['result'];
    $rsUsers = $data_result_user['rsUsers'];


    foreach ($result as $user){ ?>
    <div class="user_item col-md-4 col-sm-6 col-xs-12">
        <div class="filter_reg_user block-shadow">
            <? if( !empty(trim($user['img_path'])) ) { ?>
            <a href="<?=$user['link_profile'];?>">
                <img src="<?=$user['img_path']?>" alt="<? echo (trim($user['dolgnost'])).' '. (trim($user['fio']))?>" width="150" height="150">
            </a>
            <? } ?>
            <div class="reg_user_content">
                <p class="reg_user_name">
                    <a href="<?=$user['link_profile'];?>">
                        <? echo (trim($user['fio']));?>
                    </a>
                    <br>
                    <strong class="first_el"><?echo $user['dolgnost']; ?></strong><br>
                    <br>
                    <?
                    $adres = trim($user['adres'], ',');
                    echo (trim($adres));?>
                </p>
                <p>
                    <strong>Адрес</strong><br>
                    <?
                    if(!empty(trim($user['adress']))) {
                        $res = mb_stripos($user['adress'], '|rasd|', 0,"UTF-8");
                        if ($res !== FALSE){
                            $fadres = explode('|rasd|',$user['adress']);
                            if(!empty(trim($fadres[0]))){
                                echo trim($fadres[0]);
                            }
                        } else {
                            echo $user['adress'];

                        }
                    } else {
                        echo "не указан";
                    }
                    ?>
                    <br><br>
                    <strong>Телефон</strong><br>
                        <?
                        if(empty(trim($user['phone']))){
                            echo "не указан";
                        }else{
                            echo $user['phone'];
                        }
                        ?>
                </p>
            </div>
            <div class="reg_user_footter">
                    <a class="link_profile" href="<?=$user['link_profile'];?>">Профиль</a>
            </div>

        </div>
    </div>
   <? } ?>
    <div class="clearfix"></div>
</div>
<?

$navStr = $rsUsers->GetPageNavStringEx($navComponentObject, "Страницы:", "round");
echo $navStr;


$scrollmass = array(

    'container' => ".filter__user",
    'item' => ".user_item",
    'pagination' => ".bx-pagination  ul",
    'next' => ".bx-pagination .bx-pag-next a",
    'negativeMargin' => "-250",
);

include ($_SERVER['DOCUMENT_ROOT'].'/local/include/scrollpagination/scroll_pagination.php');
?>

<style>
    #gorod_select{
        padding: 7px;
        font: 400 18px Lora, serif !important;
        width: 100% !important;
        outline: none;
        background-color: #fff;
        display: block !important;
        cursor: pointer;
    }
    #gorod_select option:selected{font-weight: bold;}
    .filter__user{
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        overflow: hidden;
        font-family: Lora, serif;
    }
    .filter_reg_user {
        height: 95%;
        text-align: center;
        position:relative;
        padding-bottom:30px;
    }
    .reg_user_content{
        font-size: 16px;
    }

    .first_el{
        text-transform: capitalize;
        margin: 0;
    }
    .reg_user_name{
        margin: 2px 0;
    }

    .reg_user_footter{
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 24px;
        line-height: 26px;
    }

    .link_profile {
        padding: 10px 20px;
        outline: 0;
        font-size: 18px;
        color: #000;
        background: #ffc800;
        font-family: Lora, serif;
        border: 1px solid #ccc;
        box-shadow: 0 3px 5px -5px #717171;
        cursor: pointer;
        text-decoration: none !important;
    }
    .link_profile:hover{
        background: #d6d8db;
    }

    .spinner-wrapper{
        display: block;
        width: 100%;
        text-align: center !important;
    }
    .spinner-wrapper:after, .spinner-wrapper:before{
        clear: both;
        display: block;
        width: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }
</style>