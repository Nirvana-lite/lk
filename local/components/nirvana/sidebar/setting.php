<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context,
    Bitrix\Main\Request;
$request = Context::getCurrent()->getRequest();
$value = $request->getPost("PAGE");
if($value == "setting"){
    $APPLICATION->IncludeComponent("nirvana:setting", ".default", array(), false);
}elseif ($value == 'articles1'){
    $APPLICATION->IncludeComponent("nirvana:articles", ".default", array("ARTICLES" => popular), false);
}elseif ($value == 'articles2'){
    $APPLICATION->IncludeComponent("nirvana:articles", ".default", array("ARTICLES" => vestnik), false);
}elseif ($value == 'articles3'){
    $APPLICATION->IncludeComponent("nirvana:articles", ".default", array("ARTICLES" => pravo), false);
}elseif ($value == 'articles4'){
    $APPLICATION->IncludeComponent("nirvana:articles", ".default", array("ARTICLES" => socprogram), false);
}