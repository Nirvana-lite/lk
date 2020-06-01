<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule("iblock"))
    return;

$arComponentParameters = array(

    "GROUPS" => array(
        "LIST"    =>  array(
            "NAME"  =>  "Списки",
            "SORT"  =>  "300",
        ),
    ),

    "PARAMETERS" => array(

        "TYPE_EDITOR" => Array(
            "PARENT" => "BASE",
            "NAME" => "Режим редактора",
            "TYPE" => "LIST",
            "VALUES" => array(
                'TYPE_1' => 'С настройками по умолчанию',
                'TYPE_2' => 'Без настроек'
            ),
        ),

        "SHOW_TEXTAREA" => Array(
            "PARENT" => "BASE",
            "NAME" => "Использовать textarea",
            "TYPE" => "LIST",
            "VALUES" => array(
                'SHOW_1' => 'Да',
                'SHOW_2' => 'Нет'
            ),
        ),

        'TEXT' => array(
            "PARENT" => "BASE",
            "NAME" => "Контент который нужно вставить в редактор",
            "TYPE" => "STRING",
            "DEFAULT" => '',
        ),


        'INIT_ID' => array(
            "PARENT" => "BASE",
            "NAME" => "class textarea",
            "TYPE" => "STRING",
            "DEFAULT" => 'txtcontent',
        ),

        'TEXTAREA_NAME' => array(
            "PARENT" => "BASE",
            "NAME" => "Имя поля TEXTAREA",
            "TYPE" => "STRING",
            "DEFAULT" => 'content',
        ),

        'TEXTAREA_ID' => array(
            "PARENT" => "BASE",
            "NAME" => "ID редатора (уникальный)",
            "TYPE" => "STRING",
            "DEFAULT" => 'content',
        ),

        "CACHE_TYPE"  =>  array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("COMP_PROP_CACHE_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => array("A" => GetMessage("COMP_PROP_CACHE_TYPE_AUTO")." ".GetMessage("COMP_PARAM_CACHE_MAN"), "Y" => GetMessage("COMP_PROP_CACHE_TYPE_YES"), "N" => GetMessage("COMP_PROP_CACHE_TYPE_NO")),
            "DEFAULT" => "N",
            "ADDITIONAL_VALUES" => "N",
            "REFRESH" => "Y" // параметр cache_time добавится, только если значение cache_type не = N
        ),
    )
);

if (isset($arCurrentValues["CACHE_TYPE"]) && 'N' !== $arCurrentValues["CACHE_TYPE"])
{
    $arComponentParameters['PARAMETERS']['CACHE_TIME'] =  array(
        "DEFAULT"=>3600
    );
}

?>