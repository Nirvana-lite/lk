<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");?><?$APPLICATION->IncludeComponent(
	"mycomponents:profile",
	"",
	Array(
		"CHANGE_NAME" => "feedbacks",
		"SEF_FOLDER" => "/profile/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array("detail"=>"#ELEMENT_ID#/","feedbacks"=>"#ELEMENT_ID#/#CHANGE_NAME#/","news"=>"")
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>