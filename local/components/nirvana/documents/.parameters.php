<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
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