<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        "ID" => array(
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "user ID",
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
        ),
    ),
);
?>