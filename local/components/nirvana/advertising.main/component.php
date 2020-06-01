<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>");
Asset::getInstance()->addString("<script src=\"//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js\"></script>");
Asset::getInstance()->addString("<link href=\"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\" rel=\"stylesheet\"
      integrity=\"sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN\" crossorigin=\"anonymous\">");


if (intval($arParams['USER']) > 0) {
    $filter = array
    (
        "ID" => intval($arParams['USER']),
    );
    $rsUsers = CUser::GetList(($by = "personal_country"), ($order = "desc"), $filter);
    echo $rsUsers->NavPrint(GetMessage("PAGES"));
    while ($ob = $rsUsers->NavNext()) {
        $arResult['user'] = [
            'name' => $ob['NAME'],
            'mail' => $ob['EMAIL'],
            'login' => $ob['LOGIN']
        ];
    }
}



/**
CREATE TABLE `advert_elems` (
`id` INT NOT NULL AUTO_INCREMENT ,
`mode` INT(11) NOT NULL ,
`type` INT(11) NOT NULL ,
`view` INT(11) DEFAULT 0,
`img` VARCHAR(255) NOT NULL,
`title` VARCHAR(255),
`description` VARCHAR(255),
`price` VARCHAR(255) NOT NULL,
`phone` VARCHAR(255),
`status` int(11) NOT NULL,
`price` VARCHAR(255) NOT NULL,
`view_start` DATE() NOT NULL,
`view_end` DATE() NOT NULL,
`view_day` int(11) DEFAULT 0,
`pay` int(11) DEFAULT 0,
`user` int(11) NOT NULL,
PRIMARY KEY (`id`))
ENGINE = InnoDB
CHARSET=utf8
COLLATE utf8_general_ci;
 *
CREATE TABLE `modes` (
`id` INT NOT NULL AUTO_INCREMENT ,
`name` VARCHAR(255),
PRIMARY KEY (`id`))
ENGINE = InnoDB
CHARSET=utf8
COLLATE utf8_general_ci;
 *
CREATE TABLE `statuses` (
`id` INT NOT NULL AUTO_INCREMENT ,
`name` VARCHAR(255),
PRIMARY KEY (`id`))
ENGINE = InnoDB
CHARSET=utf8
COLLATE utf8_general_ci;
 */

global $USER;
Class AdvertInfo{
    private $db;
    private $user;

    function __construct()
    {
        global $USER,$DB;
        $this->db = $DB;
        $this->user = $USER;
    }
    function getElemsForId($id){
        $arr = [];
        $res = $this->db->Query("SELECT * FROM advert_elems WHERE user = {$id}");
        while ($tmp = $res->fetch()){
            $arr[] = $tmp;
        }
        return $arr;
    }
    function getElemsList($type,$id){
        $arr = [];
        $res = $this->db->Query("SELECT * FROM advert_elems WHERE (user = {$id} AND type = {$type})");
        while ($tmp = $res->fetch()){
            $arr[] = $tmp;
        }
        return $arr;
    }
    function getStatusList(){
        $arr = [];
        $res = $this->db->Query("SELECT * FROM statuses");
        while ($tmp = $res->fetch()){
            $arr[$tmp['id']] = [
                'name' => $tmp['name'],
                'val' => 0
            ];
        }
        return $arr;
    }
    function getTypes(){
        $arr = [];
        $res = $this->db->Query("SELECT * FROM types");
        while ($tmp = $res->fetch()){
            $arr[$tmp['id']] = $tmp['name'];
        }
        return $arr;
    }
}

/**
 * Общий список
 */
if ($arParams['VIEW'] == '.default'){
$adverts = new AdvertInfo();
$lists = $adverts->getElemsForId($USER->GetID());
$types = $adverts->getTypes();
$statuses = $adverts->getStatusList();
$arr = [];
foreach ($types as $key => $elem){
$arr[$key] = [
    'id' => $key,
    'view' => [
        'name' => 'Просмотров',
        'val' => 0
    ],
    'name' => $elem,
    'status' => $statuses
];
}

foreach ($lists as $list){
    /**
     * просмотры
     */
    $arr[$list['type']]['view']['val'] += $list['view'];

    /**
     * статусы и колличество
     */
    $arr[$list['type']]['status'][$list['status']]['val'] += 1;
}
$arResult['items'] = $arr;
}

/**
 * список определенного типа
 */
if ($arParams['VIEW'] == 'list'){
    $adverts = new AdvertInfo();
    $lists = $adverts->getElemsList($arParams['TYPE'],$USER->GetID());
    $arResult['items'] = $lists;
}
$this->IncludeComponentTemplate();
?>