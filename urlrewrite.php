<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/personal/profile_urist/praktika/([0-9]+)/#",
		"RULE" => "ELEMENT_ID=\$1",
		"ID" => "",
		"PATH" => "/personal/profile_urist/praktika/detail.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/personal/profile_urist/nagrady/([0-9]+)/#",
		"RULE" => "ELEMENT_ID=\$1",
		"ID" => "",
		"PATH" => "/personal/profile_urist/nagrady/detail.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/personal/profile_urist/blog/([0-9]+)/#",
		"RULE" => "ELEMENT_ID=\$1",
		"ID" => "",
		"PATH" => "/personal/profile_urist/blog/detail.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/okruzhnye-i-flotskie-voennye-sudy/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/okruzhnye-i-flotskie-voennye-sudy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/arbitrazhnye-apellyatsionnye-sudy/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/arbitrazhnye-apellyatsionnye-sudy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/rayonnye-sudy-moskovskoy-oblasti/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/rayonnye-sudy-moskovskoy-oblasti/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/([a-z0-9_-]*)-th-([a-z0-9_-]*)/#",
		"RULE" => "CITY=\$1&SECTION_CODE=\$2",
		"ID" => "",
		"PATH" => "/theme/section_id.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/broker-and-brokers-company/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/broker-and-brokers-company/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/arbitrazhnye-sudy-subektov/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/arbitrazhnye-sudy-subektov/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/arbitrazhnye-sudy-okrugov/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/arbitrazhnye-sudy-okrugov/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/garnizonnye-voennye-sudy/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/garnizonnye-voennye-sudy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/konstitutsionnye-sudy/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/konstitutsionnye-sudy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/sotsialnye-programmy/#",
		"RULE" => "",
		"ID" => "mycomponents:catalog",
		"PATH" => "/sotsialnye-programmy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/vestnik-jur-portala/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/vestnik-jur-portala/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/theme-([a-z0-9_-]*)/#",
		"RULE" => "CITY=\$1",
		"ID" => "",
		"PATH" => "/theme/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/obraztsy-dokumentov/#",
		"RULE" => "",
		"ID" => "nirvana:documents",
		"PATH" => "/obraztsy-dokumentov/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/fdprofile/([0-9]+)/#",
		"RULE" => "USER_ID=\$1",
		"ID" => "",
		"PATH" => "/profile/user_po_id.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/yuristy-i-advokaty/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/yuristy-i-advokaty/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/populyarnye-temy/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/populyarnye-temy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/pravo-i-protsess/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/pravo-i-protsess/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/voprosy-yuristu/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/voprosy-yuristu/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/ugolovnye-dela/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/ugolovnye-dela/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/reshenie-sudov/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/reshenie-sudov/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/rayonnye-sudy/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/rayonnye-sudy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/mirovie-sudy/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/mirovie-sudy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/oblast-sudy/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/oblast-sudy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/discussions/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/discussions/index.php",
	),
	array(
		"CONDITION" => "#^/reestr-mfo/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/reestr-mfo/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/reestr-kpk/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/reestr-kpk/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/max/images/#",
		"RULE" => "",
		"ID" => "bitrix:photo",
		"PATH" => "/local/components/mycomponents/news/help/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/notariusy/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/notariusy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/gosorgany/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/gosorgany/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/personal/#",
		"RULE" => "",
		"ID" => "nirvana:office",
		"PATH" => "/personal/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/personal/#",
		"RULE" => "",
		"ID" => "nirvana:user",
		"PATH" => "/personal/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/personal/#",
		"RULE" => "",
		"ID" => "nirvana:urist",
		"PATH" => "/personal/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/advokaty/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/advokaty/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/personal/#",
		"RULE" => "",
		"ID" => "nirvana:admin",
		"PATH" => "/personal/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/koloniya/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/koloniya/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/profile/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/profile/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/kodeksy/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/kodeksy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/profile/#",
		"RULE" => "",
		"ID" => "mycomponents:profile",
		"PATH" => "/profile/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/zakony/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/zakony/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/forum/#",
		"RULE" => "",
		"ID" => "bitrix:forum",
		"PATH" => "/forum/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/news/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/sudy/#",
		"RULE" => "",
		"ID" => "mycomponents:news",
		"PATH" => "/sudy/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/test/#",
		"RULE" => "",
		"ID" => "d7:router",
		"PATH" => "/test/index.php",
	),
);

?>