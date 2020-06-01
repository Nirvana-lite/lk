<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->ShowAjaxHead();
$APPLICATION->RestartBuffer();
$APPLICATION->ShowHeadScripts();
$APPLICATION->ShowCSS();

$APPLICATION->IncludeComponent(
    "khayr:answers",
    "comment_editor_emoji",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADDITIONAL" => array(""),
        "ALLOW_RATING" => "Y",
        "AUTH_PATH" => "/auth/",
        "CAN_MODIFY" => "N",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "COUNT" => "10",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "JQUERY" => "Y",
        "LEGAL" => "N",
        "LEGAL_TEXT" => "Я согласен с правилами размещения сообщений на сайте.",
        "LOAD_AVATAR" => "Y",
        "LOAD_DIGNITY" => "Y",
        "LOAD_FAULT" => "Y",
        "LOAD_MARK" => "Y",
        "MAX_DEPTH" => "5",
        "MODERATE" => "N",
        "NON_AUTHORIZED_USER_CAN_COMMENT" => "Y",
        "OBJECT_ID" => intval($_POST['id']),
        "PAGER_DESC_NUMBERING" => "Y",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "ajax_comments",
        "PAGER_TITLE" => "",
        "REQUIRE_EMAIL" => "Y",
        "USE_CAPTCHA" => "N"
    )
);