<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
    "PARAMETERS" => array(
        "VARIABLE_ALIASES" => Array(
            'IBLOCK_ID' => array('NAME' => 'iblock id'),
            'ELEMENT_ID' => array('NAME' => 'element id')
        ),
        "SEF_MODE" => Array(
            "news" => array(
                "NAME" => 'index',
                "DEFAULT" => "",
                "VARIABLES" => array(),
            ),
            "list" => array(
                "NAME" => 'list',
                "DEFAULT" => "#IBLOCK_ID#/",
                "VARIABLES" => array("IBLOCK_ID"),
            ),
            "detail" => array(
                "NAME" => 'detail',
                "DEFAULT" => "#IBLOCK_ID#/#ELEMENT_ID#/",
                "VARIABLES" => array("ELEMENT_ID"),
            ),
        ),
        "IBLOCK_ID" => array(
            "NAME" => "iblock id",
        ),
    ),
);