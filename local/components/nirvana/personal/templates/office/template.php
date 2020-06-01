<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$APPLICATION->IncludeComponent(
    "nirvana:questions",
    ".default",
    Array('URIST' => 'office'),
    false
);
?>