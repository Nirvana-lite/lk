<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Application;

metatagrazdel(
    'discussions', // link
    'Дискуссии на Российском Юридическом портале', // title
    '',//SetTitle
    '', // tags
    '', // keywords
    'Дискуссии юристов и адвокатов на Российском Юридическом портале', // description
    'Дискуссии' // h1
);


$APPLICATION->IncludeComponent(
	"d7:discussions",
	"",
	Array(
		"COUNT" => "100",
		"SEF_FOLDER" => "/discussions/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array(
			"detail" => "#SECTION_CODE#/#ELEMENT_CODE#/",
			"news" => ""
		),
		"TEMPLATE_DETAIL" => "default",
		"TEMPLATE_LIST" => "default"
	)
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
