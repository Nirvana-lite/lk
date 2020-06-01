<?
//define("NO_KEEP_STATISTIC", true); // Не собираем стату по действиям AJAX
define('STOP_STATISTICS', true);
define('NOT_CHECK_PERMISSIONS', true);
define("PUBLIC_AJAX_MODE", true);
define("NO_KEEP_STATISTIC", "Y");
define("NO_AGENT_STATISTIC", "Y");
define("NO_AGENT_CHECK", true);
define("DisableEventsCheck", true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/local/include/class.upload.php');

if (!CModule::IncludeModule("iblock")) {
    die();
}

function slugTranslit($link)
{
    $link = trim($link);
    $arParamsLn = array(
        "max_len" => "50", // обрезаем символьный код до 100 символов
        "change_case" => "L", // приводим к нижнему регистру
        "replace_space" => "-", // меняем пробелы на тире
        "replace_other" => "-", // меняем плохие символы на тире
        "delete_repeat_replace" => "true", // удаляем повторяющиеся тире
        "use_google" => "false", // отключаем использование google
    );
    $linkcode = Cutil::translit($link, "ru", $arParamsLn);
    $linkcode = rtrim($linkcode, "-");
    return $linkcode;
}

$pathtmp ='/upload/tmp/';

// popular-discussions
// questions -> popular-discussions



// проверка что отправил человек, а не робот

$utf8 = htmlspecialchars(ToLower(strip_tags($_REQUEST['utf8'])));
$hint = htmlspecialchars(ToLower(strip_tags($_REQUEST['hint'])));
$authenticity_token = htmlspecialchars(ToLower(strip_tags($_REQUEST['authenticity_token'])));

if( $utf8 != '✓'){
    $mas['error'] = array(
        'message' => 'Ошибка при загрузке картинки. Обновите страницу.',
    );
    echo json_encode($mas);
    die();
}

if (!empty($hint)) {
    $mas['error'] = array(
        'message' => 'Ошибка при загрузке картинки. Обновите страницу.',
    );
    echo json_encode($mas);
    die();
}
/*
if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $_FILES['file']['name'])){
    $mas['error'] = array(
        'message' => 'Ошибка при загрузке картинки. Обновите страницу.',
    );
    echo json_encode($mas);
    die();
}*/

if(!in_array(strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)), array("gif", "jpeg", "jpg", "png"))){
    $mas['error'] = array(
        'message' => 'Ошибка при загрузке картинки. Обновите страницу.',
    );
    echo json_encode($mas);
    die();
}


if( $authenticity_token != bitrix_sessid() ) {
    //не прошла проверка по сессии

    $mas['error'] = array(
        'message' => 'Ошибка при загрузке картинки. Обновите страницу.',
    );
    echo json_encode($mas);
    die();

}else{

    $allowedExts = array(".gif", ".jpg", ".png", ".jpeg");
    $ImageName = str_replace(' ', '-', ToLower($_FILES['file']['name']));
    $ImageExt = substr($ImageName, strpos($ImageName, '.'));

    $nametitle = htmlspecialchars(ToLower(strip_tags($_REQUEST['alt'])));

    if (!empty(trim($nametitle))) {  // название делаем из title введенного
        // название берем из alt
        $name = slugTranslit($nametitle);
    } else {

        // генерируем название файла
        $randnamefail = array(
            'yurist-',
            'konsultaciya-',
            'konsultaciyaadvokata-',
            'konsultaciya-yurista-',
            'onlajn-',
            '9111-',
            'pravoved-',
            'picture-dissc-',
            'consultant-',
            'pomoshch-'
        );
        $key_rand = array_rand($randnamefail);

        $name = $randnamefail[$key_rand] . uniqid();
    }


    if (in_array($ImageExt, $allowedExts)) {
     // проверка по расширению
        $handle = new upload($_FILES['file']);
        if ($handle->uploaded) {
            // переименовываем
            $handle->file_new_name_body = $name;
            // добавить время к названию
            $handle->file_name_body_pre = strtotime(date("Y-m-d H:i:s")) . '-';
            // разрешаем загрузку только изображений
            $handle->allowed = array("image/*");
            // разрешаем изменять размер изображения
            $handle->image_resize = true;
            // ширина изображения будет 600px
            $handle->image_x = 400;
            // сохраняем соотношение сторон в зависимости от ширины
            $handle->image_ratio_y = true;

            $handle->image_ratio_no_zoom_in = true;

            $handle->image_convert = 'jpg';

            // задать права на созданный файл
            $handle->dir_chmod = 0644;
            // отменить изменение размера, если изображение с измененным размером больше исходного изображения
            $handle->image_no_enlarging = true;

            $handle->process($_SERVER["DOCUMENT_ROOT"] . $pathtmp);
            if ($handle->processed) {
                chmod($handle->file_dst_pathname, 0644);

                $mas['image'] = array(
                    'url' => $pathtmp.$handle->file_dst_name,
                );
                echo json_encode($mas);
                $handle->clean();
            } else {

                $mas['error'] = array(
                    'message' => 'Ошибка при загрузке картинки.',
                );
                echo json_encode($mas);
            }
        }


    }else{
        $mas['error'] = array(
            'message' => 'Неверный тип файла. Только.формат jpg. ,png и .gif разрешено!!!',
        );
        echo json_encode($mas);

    }
}
?>