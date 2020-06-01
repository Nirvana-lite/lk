<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = array(
    "PARAMETERS" => array(
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "ID игфоблока",
            "TYPE" => "STRING",
            "DEFAULT" => ""
        ),

        "TEMPLATE_DETAIL" => array(
            "PARENT" => "BASE",
            "NAME" => "шаблон деталаьки",
            "TYPE" => "STRING",
            "DEFAULT" => "default"
        ),

        "TEMPLATE_LIST" => array(
            "PARENT" => "BASE",
            "NAME" => "шаблон списка",
            "TYPE" => "STRING",
            "DEFAULT" => "default"
        ),

        "COUNT" => array(
            "PARENT" => "BASE",
            "NAME" => "количество в списке",
            "TYPE" => "STRING",
            "DEFAULT" => "10"
        ),

        "VARIABLE_ALIASES" => Array(
            "ELEMENT_CODE" => Array("NAME" => 'CODE element'),
        ),
        "SEF_MODE" => Array(
            "news" => array(
                "NAME" => 'list',
                "DEFAULT" => "",
                "VARIABLES" => array(),
            ),
            "detail" => array(
                "NAME" => 'detail',
                "DEFAULT" => "#ELEMENT_CODE#/",
                "VARIABLES" => array("ELEMENT_CODE"),
            ),
        ),
    ),
);