<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule("iblock"))
    return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$rsIBlock = CIBlock::GetList(Array("SORT" => "ASC"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE" => "Y"));
while ($arr = $rsIBlock->Fetch()) {
    $arIBlock[$arr["ID"]] = "[" . $arr["ID"] . "] " . $arr["NAME"];
}

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(Array("sort" => "asc", "name" => "asc"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"]));
while ($arr = $rsProp->Fetch()) {
    $arProperty[$arr["CODE"]] = "[" . $arr["CODE"] . "] " . $arr["NAME"];
    if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "E"))) {
        $arProperty_LNS[$arr["CODE"]] = "[" . $arr["CODE"] . "] " . $arr["NAME"];
    }
}


$arComponentParameters = array(

    "GROUPS" => array(
        "LIKE_DIS" => array(
            "NAME" => GetMessage("LIKE_DIS"),
            "SORT" => 150,
        ),
    ),

    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("BN_P_IBLOCK_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlockType,
            "REFRESH" => "Y",
        ),

        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("BN_P_IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y",
            "ADDITIONAL_VALUES" => "Y",
        ),

        "ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("ID"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),

        "OTHER" => Array(
            "PARENT" => "LIKE_DIS",
            "NAME" => GetMessage("TYPE_DOP_SAVE"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "Y",
        ),

        "CACHE_TIME" => Array("DEFAULT" => 36000),
        "CACHE_GROUPS" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CACHE_GROUPS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "D",
        ),

    ),
);

if ($arCurrentValues['OTHER']) {

    if ($arCurrentValues['OTHER'] == 'Y') {

        $arComponentParameters['PARAMETERS']['MY_PROP'] = array(
            "PARENT" => "LIKE_DIS",
            "NAME" => GetMessage("DOP_PROP"),
            "TYPE" => "LIST",
            "MULTIPLE" => "N",
            "VALUES" => $arProperty_LNS,
            "ADDITIONAL_VALUES" => "N",
        );
    }
}
?>
