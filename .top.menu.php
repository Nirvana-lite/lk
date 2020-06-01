<?$aMenuLinks = Array(
    Array(
        "ГЛАВНАЯ",
        "/",
        Array(),
        Array("ICON_FILE" => "home"),
        ""
    ),
    Array(
        "НОВОСТИ",
        "/news/",
        Array(),
        Array("ICON_FILE" => "news"),
        ""
    ),
    Array(
        "ФОРУМ",
        "/forum/",
        Array(),
        Array("ICON_FILE" => "forum"),
        ""
    ),
    Array(
        "СУДЫ",
        "/sudy/",
        Array(),
        Array("ICON_FILE" => "suds"),
        ""
    ),
    Array(
        "ЗАКОНЫ",
        "/zakony/",
        Array(),
        Array("ICON_FILE" => "zakons"),
        ""
    ),
    Array(
        "КОДЕКСЫ",
        "/kodeksy/",
        Array(),
        Array("ICON_FILE" => "zakons"),
        ""
    ),
    Array(
        "ГОСОРГАНЫ",
        "/gosorgany/",
        Array(),
        Array("ICON_FILE" => "gosorgans"),
        ""
    ),
    Array(
        "ВОПРОС И ОТВЕТ",
        "/voprosy-yuristu/",
        Array(),
        Array("ICON_FILE" => "vopros"),
        ""
    ),
    Array(
        "ПОПУЛЯРНЫЕ ТЕМЫ",
        "/populyarnye-temy/",
        Array(),
        Array("ICON_FILE" => "poptheme"),
        ""
    ),
    Array(
        "ЮРИСТЫ И АДВОКАТЫ",
        "/yuristy-i-advokaty/",
        Array(),
        Array("ICON_FILE" => "juradvokat"),
        ""
    ),
    Array(
        "ДОКУМЕНТЫ",
        "/obraztsy-dokumentov/",
        Array(),
        Array("ICON_FILE" => "dokuments"),
        ""
    )
);
if ($_POST['val'] === 'getmenu'){
    echo json_encode($aMenuLinks);
}
?>