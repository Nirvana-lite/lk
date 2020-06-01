<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
CJSCore::Init(array('ajax'));
global $USER;
if ($USER->IsAuthorized()) {
    if (inGroup(admin)) {
        $APPLICATION->IncludeComponent(
            "nirvana:admin",
            "",
            Array(
                "IBLOCK_ID" => "",
                "SEF_FOLDER" => "/personal/",
                "SEF_MODE" => "Y",
                "SEF_URL_TEMPLATES" => Array("detail"=>"#IBLOCK_ID#/#ELEMENT_ID#/","list"=>"#IBLOCK_ID#/","news"=>"")
            )
        );
    } elseif (inGroup(office)) {
        $APPLICATION->IncludeComponent(
            "nirvana:office",
            "",
            Array(
                "IBLOCK_ID" => "",
                "SEF_FOLDER" => "/personal/",
                "SEF_MODE" => "Y",
                "SEF_URL_TEMPLATES" => Array("detail"=>"#IBLOCK_ID#/#ELEMENT_ID#/","list"=>"#IBLOCK_ID#/","news"=>"")
            )
        );
    } elseif (inGroup(urist)) {
        $APPLICATION->IncludeComponent(
            "nirvana:urist",
            "",
            Array(
                "IBLOCK_ID" => "",
                "SEF_FOLDER" => "/personal/",
                "SEF_MODE" => "Y",
                "SEF_URL_TEMPLATES" => Array('detail'=>'#IBLOCK_ID#/#ELEMENT_ID#/' ,"list"=>"#IBLOCK_ID#/","news"=>"")
            )
        );
    } else {
        $APPLICATION->IncludeComponent(
            "nirvana:user",
            "",
            Array(
                "IBLOCK_ID" => "",
                "SEF_FOLDER" => "/personal/",
                "SEF_MODE" => "Y",
                "SEF_URL_TEMPLATES" => Array('detail'=>'#IBLOCK_ID#/#ELEMENT_ID#/' ,"list"=>"#IBLOCK_ID#/","news"=>"")
            )
        );
    }
}else{
    LocalRedirect('/');
}
 require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>