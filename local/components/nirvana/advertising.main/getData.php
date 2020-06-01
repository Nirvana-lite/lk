<? require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context,
    Bitrix\Main\Request;

global $USER;
$request = Context::getCurrent()->getRequest();
$info = $request->getPost("info");

$APPLICATION->IncludeComponent(
    "nirvana:advertising.main",
    "{$info['view']}",
    Array(
        'VIEW'=> $info['view'],
        'TYPE' =>$info['type']
    )
);