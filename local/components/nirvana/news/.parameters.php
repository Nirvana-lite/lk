<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"VARIABLE_ALIASES" => Array(
			"ELEMENT_ID" => Array("NAME" => 'id element'),
		),
		"SEF_MODE" => Array(
			"news" => array(
				"NAME" => 'list',
				"DEFAULT" => "",
				"VARIABLES" => array(),
			),
			"detail" => array(
				"NAME" => 'detail',
				"DEFAULT" => "#ELEMENT_ID#/",
				"VARIABLES" => array("ELEMENT_ID"),
			),
		),
        "IBLOCK_ID_QUESTION" => array(
            "NAME" => "iblock id question",
            "VALUE" => 15
        ),
        "IBLOCK_ID_ANSWER" => array(
            "NAME" => "iblock id answer",
            "VALUE" => 18
        ),
	),
);