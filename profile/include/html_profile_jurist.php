<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

//pre($user_data);


$pag_title = $user_data["LAST_NAME"] . ' ' . $user_data["NAME"] . ' ' . $user_data["SECOND_NAME"] . ' ' . $user_data["PERSONAL_PROFESSION"] . ' г. ' . $user_data["WORK_CITY"] . ' ' . $user_data["WORK_COMPANY"];
$page_key = $user_data["LAST_NAME"] . ' ' . $user_data["NAME"] . ' ' . $user_data["SECOND_NAME"] . ' ' . $user_data["PERSONAL_PROFESSION"] . ' ' . $user_data["WORK_CITY"] . ' ' . $user_data["WORK_DEPARTMENT"] . ' ' . $user_data["WORK_STREET"];

$APPLICATION->SetTitle($pag_title);
$APPLICATION->SetPageProperty("title", $pag_title);
$APPLICATION->SetPageProperty("robots", 'all');
$APPLICATION->SetPageProperty("keywords", $page_key);
$APPLICATION->SetPageProperty("canonical", 'https://jur24pro.ru/profile/' . $user_data['ID'] . '/');


// проверка пустоты поля
function check_val($value){
    $str = "Не указано";
    if(!empty(trim($value))){
        $str = trim($value);
    }
    return $str;
}

// возврать даты
function get_date($mydate, $format_date = "YYYY-MM-DD HH:MI:SS"){
    return FormatDate(
        array(
            "tommorow" => "tommorow",      // выведет "завтра", если дата завтрашний день
            "today" => "today",              // выведет "сегодня", если дата текущий день
            "yesterday" => "yesterday",       // выведет "вчера", если дата прошлый день
            "d" => 'j F',                   // выведет "9 июля", если месяц прошел
            "" => 'j F Y',                    // выведет "9 июля 2012", если год прошел
        ),
        MakeTimeStamp($mydate, $format_date),
        time()
    );
}



$name = $user_data["LAST_NAME"] . ' ' . $user_data["NAME"] . ' ' . $user_data['SECOND_NAME'];
if (empty(trim($name))) {
    $name = $user_data['LOGIN'];
}

$user_photo; // картинка по умолчанию

if (intval($user_data['PERSONAL_PHOTO']) > 0) {
    $user_photo = CFile::ResizeImageGet($user_data['PERSONAL_PHOTO'], array('width' => 150, 'height' => 150), BX_RESIZE_IMAGE_EXACT, true);
}

$last_online = $user_data['LAST_ACTIVITY_DATE']; // последний  раз в сети

/*
['UF_REGION']


['WORK_DEPARTMENT']
['WORK_COMPANY']

['WORK_POSITION']
*/

$online = intval(CUser::IsOnLine($user_data['ID']));

if ($online > 0) {
    $online = '<br><span style="color: green;">В сети</span>';
} else {

    $last_date = get_date($user_data['LAST_ACTIVITY_DATE'], "YYYY-MM-DD HH:MI:SS");
    $online = '<br>Онлайн - ' . $last_date;

}

if (!empty($user_data['WORK_STATE'])) {
    $work_state = trim($user_data['WORK_STATE']) . ', ';
}

$masscnt['statii'] = get_cnt(17, array($user_data['ID']), 80);  // статей
$masscnt['pravo'] = get_cnt(24, array($user_data['ID']), 119); // право и процесс
$masscnt['otvet'] = get_cnt(18, array($user_data['ID']), 85); // ответы
$masscnt['otzivi'] = get_cnt(31, array($user_data['ID']), 126); // отзывы

?>
<div class="user_profile">
<h1 class="main-title"><?echo mb_convert_case(trim($name), MB_CASE_TITLE, 'UTF-8'); ?></h1>

<div class="block-shadow clearfix">

    <div class="col-md-3">
        <img src="<?= $user_photo['src']; ?>" alt="" width="150" height="150">
    </div>

    <div class="col-md-6">
        <p><?= (trim($user_data['PERSONAL_PROFESSION'])) . ', ' . $work_state . (trim($user_data['WORK_CITY'])); ?><?= $online; ?></p>
        <ul>
            <li>Статей: <?=$masscnt['statii'][$user_data['ID']];?></li>
            <li>Право и процесс: <?=$masscnt['pravo'][$user_data['ID']];?></li>
            <li>Ответов: <?=$masscnt['otvet'][$user_data['ID']];?></li>
        </ul>
    </div>
    <div class="col-md-3">
        <a href="#" class="btn_pr">Обратиться к юристу</a>
    </div>
</div>

<div class="info_user clearfix">
    <div class="col-sm-6 col-xs-12">
        <div class="block-shadow">
            <h2>О себе</h2>
            <p>

            </p>
            <h2>Работа</h2>
            <ul class="spisok">
                <li><strong>Компания:</strong> <?= check_val($user_data["WORK_COMPANY"]); ?></li>
                <li><strong>Отдел:</strong> <?= check_val($user_data["WORK_DEPARTMENT"]); ?></li>
                <li><strong>Должность:</strong> <?= check_val($user_data["WORK_POSITION"]); ?></li>
                <li><strong>Адрес:</strong> <?= check_val($user_data["WORK_STREET"]); ?></li>
                <li><strong>Направление:</strong>
                    <?= check_val($user_data["WORK_PROFILE"]); ?>
                </li>
                <li><strong>Телефон:</strong> <?= check_val($user_data["WORK_PHONE"]); ?></li>
            </ul>
        </div>
    </div>
    <div class="col-sm-6 col-xs-12">
        <div class="block-shadow">
            <h2>Образование</h2>
            <ul class="spisok">
                <li><strong>ВУЗ:</strong> <?= check_val($user_data["UF_OB_VUZ"]) ?></li>
                <li><strong>Факультет:</strong> <?= check_val($user_data["UF_OB_FAK"]) ?></li>
                <li><strong>Специальность:</strong> <?= check_val($user_data["UF_OB_SPEC"]) ?></li>
                <li><strong>Год выпуска:</strong> <?= check_val($user_data["UF_OB_GOD"]) ?></li>
            </ul>
        </div>
    </div>
</div>

<h2>Последние отзывы (всего <?= $masscnt['otzivi'][$user_data['ID']]; ?>)</h2>
<div class="block-shadow">
    <div>
        <?
        if($masscnt['otzivi'][$user_data['ID']] > 0 ) {
            $arSelect = Array("ID", "IBLOCK_ID", "DATE_CREATE", "NAME", "PREVIEW_TEXT", "PROPERTY_129");
            $arFilter = Array("IBLOCK_ID" => IntVal(31), "PROPERTY_126" => $user_data["ID"], "ACTIVE" => "Y");
            $res = CIBlockElement::GetList(Array("id" => "desc"), $arFilter, false, Array("nPageSize" => 4), $arSelect);
            while ($ob = $res->GetNext()) {

                // если в имени указана почта брать текст до @
                if (filter_var($ob["PROPERTY_129_VALUE"], FILTER_VALIDATE_EMAIL) !== false) {
                    $author = trim(strstr($ob["PROPERTY_129_VALUE"], '@', true));
                } else {
                    $author = $ob["PROPERTY_129_VALUE"];
                }

                $last_date_otziv = get_date($ob['DATE_CREATE'], "DD.MM.YYYY HH:MI:SS");
                $li .= '<li class="col-md-6"><div><p>' . (desc150($ob["PREVIEW_TEXT"], 100)) . '...</p><p><small>' . $author . ', ' . $last_date_otziv . '</small></p></div></li>';
            }
            $ul_list = '<ul class="list_otsiv clearfix">'.$li.'</ul>';

            echo $ul_list;

        }else{
            echo "<p><strong>Нет отзывов</strong></p>";
        }
         ?>
    </div>
    <div class="all_otzivi">
        <a href="/profile/<?=$user_data['ID'];?>/feedbacks/" class="btn_pr">Посмотреть все отзывы</a>
    </div>
</div>

<h2>Специализация</h2>
<div class="block-shadow">

    <?
   /* function faviconius($name)
    {
        switch ($name) {
            case 'Дисциплинарные взыскания':
                return '<i class="fa fa-2x fa-ban"></i>' . $name;
                break;
            case 'Сокращение на работе':
                return '<i class="fa fa-2x fa-frown-o" aria-hidden="true"></i>' . $name;
                break;
            case 'Косметика и право':
                return '<i class="fa fa-2x fa-eye" aria-hidden="true"></i>' . $name;
                break;
            case 'Улучшение жилищных условий':
                return '<i class="fa fa-2x fa-building" aria-hidden="true"></i>' . $name;
                break;
            case 'Жалобы':
                return '<i class="fa fa-2x fa-bullhorn" aria-hidden="true"></i>' . $name;
                break;
            case 'Депортация и запрет на въезд':
                return '<i class="fa fa-2x fa-lock" aria-hidden="true"></i>' . $name;
                break;
            case 'Арбитраж':
                return '<i class="fa fa-2x fa-gavel" aria-hidden="true"></i>' . $name;
                break;
            case 'Приставы':
                return '<i class="fa fa-2x fa-street-view" aria-hidden="true"></i>' . $name;
                break;
            case 'Алкоголизм, наркомания и право':
                return '<i class="fa fa-2x fa-glass" aria-hidden="true"></i>' . $name;
                break;
            case 'Услуги и консультации юриста':
                return '<i class="fa fa-2x fa-handshake-o" aria-hidden="true"></i>' . $name;
                break;
            case 'Взыскания':
                return '<i class="fa fa-2x fa-fax" aria-hidden="true"></i>' . $name;
                break;
            case 'Административные правонарушения':
                return '<i class="fa fa-2x fa-user-secret" aria-hidden="true"></i>' . $name;
                break;
            case 'ЖКХ':
                return '<i class="fa fa-2x fa-diamond" aria-hidden="true"></i>' . $name;
                break;
            case 'Суды':
                return '<i class="fa fa-2x fa-money" aria-hidden="true"></i>' . $name;
                break;
            case 'Застройщики и ответственность':
                return '<i class="fa fa-2x fa-cubes" aria-hidden="true"></i>' . $name;
                break;
            case 'Страхование':
                return '<i class="fa fa-2x fa-heartbeat" aria-hidden="true"></i>' . $name;
                break;
            case 'Развод и дети':
                return '<i class="fa fa-2x fa-child" aria-hidden="true"></i>' . $name;
                break;
            case 'Социальные выплаты и льготы':
                return '<i class="fa fa-2x fa-medkit" aria-hidden="true"></i>' . $name;
                break;
            case 'Земельные вопросы':
                return '<i class="fa fa-2x fa-map-o" aria-hidden="true"></i>' . $name;
                break;
            case 'Уголовное право':
                return '<i class="fa fa-2x fa-user-secret" aria-hidden="true"></i>' . $name;
                break;
            case 'Права и собственность':
                return '<i class="fa fa-2x fa-home" aria-hidden="true"></i>' . $name;
                break;
            case 'Ответственность':
                return '<i class="fa fa-2x fa-child" aria-hidden="true"></i>' . $name;
                break;
            case 'Адвокаты: услуги и консультации':
                return '<i class="fa fa-2x fa-handshake-o" aria-hidden="true"></i>' . $name;
                break;
            case 'Мошенничество':
                return '<i class="fa fa-2x fa-handshake-o" aria-hidden="true"></i>' . $name;
                break;
            case 'Пенсия и право':
                return '<i class="fa fa-2x fa-wheelchair" aria-hidden="true"></i>' . $name;
                break;
            case 'Образование: права и вопросы':
                return '<i class="fa fa-2x fa-graduation-cap" aria-hidden="true"></i>' . $name;
                break;
            case 'Правоохранительные органы':
                return '<i class="fa fa-2x fa-gavel" aria-hidden="true"></i>' . $name;
                break;
            case 'Армия':
                return '<i class="fa fa-2x fa-bomb" aria-hidden="true"></i>' . $name;
                break;
            case 'Миграция: правовые вопросы':
                return '<i class="fa fa-2x fa-ship" aria-hidden="true"></i>' . $name;
                break;
            case 'Семья и родственники':
                return '<i class="fa fa-2x fa-users" aria-hidden="true"></i>' . $name;
                break;
            case 'Наследство':
                return '<i class="fa fa-2x fa-rub" aria-hidden="true"></i>' . $name;
                break;
            case 'Медицина и право':
                return '<i class="fa fa-2x fa-plus-square" aria-hidden="true"></i>' . $name;
                break;
            case 'Налоги, юридические лица, коммерция':
                return '<i class="fa fa-2x fa-money" aria-hidden="true"></i>' . $name;
                break;
            case 'Гражданское право':
                return '<i class="fa fa-2x fa-trash" aria-hidden="true"></i>' . $name;
                break;
            case 'Авто, права, ГИБДД':
                return '<i class="fa fa-2x fa-car" aria-hidden="true"></i>' . $name;
                break;
            case 'Трудовые споры':
                return '<i class="fa fa-2x fa-id-card" aria-hidden="true"></i>' . $name;
                break;
            case 'Банки: вклады, кредиты, коллекторы':
                return '<i class="fa fa-2x fa-cc-visa" aria-hidden="true"></i>' . $name;
                break;
            case 'КПК, МФО и финансы: кредиты, вклады':
                return '<i class="fa fa-2x fa-bar-chart" aria-hidden="true"></i>' . $name;
                break;
            case 'Жилье: квартиры, дома':
                return '<i class="fa fa-2x fa-bed" aria-hidden="true"></i>' . $name;
                break;
            case 'Защита прав потребителей':
                return '<i class="fa fa-2x fa-shopping-basket" aria-hidden="true"></i>' . $name;
                break;
        }
    }*/

    $arSelect = Array("ID", "NAME", "IBLOCK_SECTION_ID");
    $arFilter = Array("IBLOCK_ID" => IntVal(17), "PROPERTY_urist" => $user_data['ID']);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while ($ob = $res->Fetch()) {
        $section_ids[] = $ob["IBLOCK_SECTION_ID"];
    }
    $section_ids = array_unique($section_ids);
    if (count($section_ids) > 0) { ?>
        <ul class="spisok special">
            <?
            $arFilter = Array('IBLOCK_ID' => 17, 'ID' => $section_ids);
            $db_list = CIBlockSection::GetList(Array('ID' => 'DESC'), $arFilter, false, array('NAME', 'SECTION_PAGE_URL'), false);
            while ($ar_result = $db_list->GetNext()) {
                echo '<li> <a href="' . $ar_result['SECTION_PAGE_URL'] . '">' . $ar_result['NAME'] . '</a></li>';
            } ?>
        </ul>
        <?
    }else{
        echo "<p><strong>Не указано</strong></p>";
    } ?>
</div>

</div>

<style>
    .user_profile h2{
        color: #0d5b90;
    }
    .list_otsiv{
        list-style: none;
        padding-left: 0px;
    }
    .list_otsiv li{margin: 5px 0;}
    .list_otsiv li div{
        padding: 5px 10px;
        border: 1px solid #5181b8;
        border-radius: 4px;
        background: #e1e7f0;
    }
    .list_otsiv li p{
        margin: 6px 0;
    }
    .spisok{
        list-style: none;
        padding-left: 20px;
        line-height: 24px;
    }
    .spisok li{margin-bottom: 6px;}
    .all_otzivi{text-align: center;margin-top: 10px;}
    a.btn_pr {
        padding: 10px 20px;
        outline: 0;
        font-size: 18px;
        color: #000;
        background: #ffc800;
        font-family: Lora, serif;
        border: 1px solid #ccc;
        box-shadow: 0 3px 5px -5px #717171;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .info_user{
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }
    .info_user > div{
        padding: 0;
    }
    .info_user > div .block-shadow{
        height: 95%;
    }
    .info_user h2{border-bottom: 1px solid #e1e7f0; color: #0d5b90;}
    .special li{
        display: inline-block;
        margin: 0 5px;
    }
    .special li a{text-decoration: underline;}
</style>