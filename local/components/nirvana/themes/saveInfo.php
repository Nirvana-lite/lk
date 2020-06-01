<?php
define("NO_KEEP_STATISTIC", true); // Не собираем стату по действиям AJAX
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');

function slugTranslit($link) {
    $link = trim($link);
    $arParamsLn = array(
        "max_len" => "100", // обрезаем символьный код до 100 символов
        "change_case" => "L", // приводим к нижнему регистру
        "replace_space" => "-", // меняем пробелы на тире
        "replace_other" => "-", // меняем плохие символы на тире
        "delete_repeat_replace" => "true", // удаляем повторяющиеся тире
        "use_google" => "false", // отключаем использование google
    );
    return $linkcode = Cutil::translit($link, "ru", $arParamsLn);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_REQUEST['type_action'] == 'ADD') {
        $section_vopros = intval(htmlspecialcharsEx($_REQUEST['section_vopros']));   // привязка к разделам вопросов
        $DESCRIPTION = trim($_REQUEST['DESCRIPTION']);        // описание мета тег DESCRIPTION
        $DETAIL_TEXT = trim($_REQUEST['DETAIL_TEXT']);       // детальный текст раздела
        $NAME = trim($_REQUEST['NAME']);                    // название раздела
        $TAGS = trim(htmlspecialcharsEx($_REQUEST['TAGS']));                   // keywords раздела
        $h1 = trim(strip_tags($_REQUEST['h1']));                   // h1 раздела
        $TITLE = trim($_REQUEST['TITLE']);                    // название раздела

        if(!empty($h1)){
            $DETAIL_TEXT = '<h1>'.$h1.'</h1>'.$DETAIL_TEXT;
        }


        $bs = new CIBlockSection;
        $arFields = Array(
            "ACTIVE" => 'Y',
            "IBLOCK_ID" => 52,
            "NAME" => $NAME,
            "UF_SECTION_VOP" => $section_vopros,
            "DESCRIPTION" => $DETAIL_TEXT,
            "DESCRIPTION_TYPE" => 'html',
            "CODE" => slugTranslit($NAME)
        );

        // seo метатеги
        $arFields["IPROPERTY_TEMPLATES"] = array(
            "SECTION_META_TITLE" => $TITLE,
            "SECTION_META_KEYWORDS" => $TAGS,
            "SECTION_META_DESCRIPTION" => $DESCRIPTION,
        );


        if($ID = $bs->Add($arFields)){
            $mas = array(
                'ACTIVE' => 'Y',
                'TEXT' => '<p>Раздел добавлен '.$NAME.' <br> Добавляем туда же еще один новый раздел</p>'
            );
        }else{
            $mas = array(
                'ACTIVE' => 'N',
                'TEXT' => $bs->LAST_ERROR
            );
        }

        echo json_encode($mas);

    }

}


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>