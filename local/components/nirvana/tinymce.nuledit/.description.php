<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => "Настраиваемый tinymce 4",
    "DESCRIPTION" => "Настраиваемый tinymce 4",
    "CACHE_PATH" => "N",
    "SORT" => 10,
    "PATH" => array(
        "ID" => "mycomp",
        "NAME" => "Мои компоненты",
        "CHILD" => array(
            "ID" => "mycomp-utilities",
            "NAME" => "Утилиты",
            "SORT" => 120,
        )
    ),
);
?>