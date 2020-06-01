<? require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
$info = $request->getPost("info");
$tmp = [];

/**
 * validate Mail
 */
if (strlen(trim($info['mail'])) > 0) {
    if (filter_var($info['mail'], FILTER_VALIDATE_EMAIL)) {
        $tmp['mail'] = $info['mail'];
    } else {
        $tmp['error'][] = 'Не правильная Почта';
    }
} else {
    $tmp['error'][] = 'Не заполнено поле Почта';
}

/**
 * validate Name
 */
if (strlen(trim($info['name'])) > 0) {
    $str = trim($info['name']);
    $pattern = "/^(?:(?:[а-я\W]+))+$/iu";
    $a = preg_match($pattern, $str);
    if ($a) {
        $tmp['name'] = $info['name'];
    } else {
        $tmp['error'][] = 'поле Имя должно содержать только Кириллицу';
    }
} else {
    $tmp['error'][] = 'Не заполнено поле Имя';
}

/**
 * validate Text
 */
if (strlen(trim($info['text'])) > 0) {
    $text = trim($info['text']);
    $text = htmlspecialchars($text);
    $text = strip_tags($text);
    $text = stripslashes($text);
    $tmp['text'] = $text;
} else {
    $tmp['error'][] = 'Не заполнено поле Текст';
}
if (count($tmp['error']) == 0) {
    $el = new CIBlockElement;

    $PROP = array();
    $PROP[478] = $tmp['name'];
    $PROP[479] = $tmp['mail'];
    $PROP[480] = $tmp['text'];


    $arLoadProductArray = array(
        "IBLOCK_ID" => 63,
        "PROPERTY_VALUES" => $PROP,
        "ACTIVE" => 'N',
        "NAME" => date('d.m.Y H:i:s'),

    );

    if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {

        $arFields = array(
            "NAME" => $tmp['name'],
            "MAIL" => $tmp['mail'],
            "TEXT" => $tmp['text'],
        );

        CEvent::Send("SEND_ADVERT", array('s1','s2'), $arFields, "N", 53);
        echo json_encode($PRODUCT_ID);
        die();
    } else {
        $tmp['error'][] = $el->LAST_ERROR;
    }
}
echo json_encode($tmp);