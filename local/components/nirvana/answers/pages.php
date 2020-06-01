<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->IncludeComponent(
    "nirvana:answers",
    "",
    Array(
        'QUESTIONS_ID' => 15,
        'ANSWERS_ID' => 18,
        'ALL' => true
    )
);
