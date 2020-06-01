<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$rsSites = CSite::GetByID(SITE_ID);
$arSite = $rsSites->Fetch();
$serverName = $arSite['SERVER_NAME'];
$siteName = $arSite['SITE_NAME'];
$siteMail = $arSite['EMAIL'];

include(__DIR__ ."/local/components/nirvana/subs.mail/sendClass.php");

$normalName = [
    2 => 'Новости',
    pravo => 'Право и Процесс',
    popular => 'Популярные Темы',
    socprogram => 'Соц. программы',
];

$arSelect = array("ID", 'IBLOCK_ID', "NAME", "DETAIL_PICTURE","DETAIL_PAGE_URL");
$arFilter = array("IBLOCK_ID" => [2, popular, pravo, socprogram], "ACTIVE" => "Y");
$res = CIBlockElement::GetList(array('RAND' => 'asc'), $arFilter, false, array("nTopCount" => 20), $arSelect);
while ($ob = $res->GetNextElement()) {
    $tmp = $ob->GetFields();
    $item = [
        'section' => $normalName[$tmp['IBLOCK_ID']],
        'name' => TruncateText($tmp['NAME'], 100),
        'img' => CFile::GetPath($tmp['DETAIL_PICTURE']),
        'url' => $tmp['DETAIL_PAGE_URL']
    ];
    $elems[] = "<td>
    <table cellspacing='2' cellpadding='10'>
        <tbody>
        <tr>
            <td>
                <table style='height:400px; border-color: #e6dbcd; border-style: solid; border-width: 1px; background-position: left top; background-repeat: no-repeat;' width='100%' cellspacing='0' cellpadding='0'>
                    <tbody>
                    <tr>
                        <td style='padding: 10px;'>
                            <small>Раздел: </small><b style='color: royalblue;'>{$item['section']}</b>
                        </td>
                    </tr>
                    <tr>
                        <td align='center' style='font-size:0'>
                            <a target='_blank'>
                                <img src='{$item['img']}' style='display: block;height:150px' width='248'></a></td>
                    </tr>
                    <tr>
                        <td align='center' style='padding:0 10px;'>
                            <p><strong>
                                    <span>{$item['name']}</span></strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td align='center' style='padding: 0 10px'>
                            <p style='color: #666666;word-break: break-all;'>
                                <span>
                                {$item['text']}
                                </span>
                                <br>
                                </p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#f0f0f0' align='center' style='height: 35px;'><span style='border-style: solid; border-radius: 0px; background: #f0f0f0 none repeat scroll 0% 0%; border-color: #bbbbdb; border-width: 0px;'><a href='https://jur24pro.ru{$item['url']}' class='es-button' target='_blank' style='border-radius: 0px; font-weight: bold; font-size: 16px; border-width: 5px 0px; background: #f0f0f0 none repeat scroll 0% 0%; border-color: #f0f0f0; color: #233a7d;'>Подробнее</a></span></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</td>";
}
$items = "<tr>";


foreach ($elems as $key => $elem) {
    $key++;
    if (($key % 2) == 0 && $key !=20) {
        $items .= "$elem</tr><tr>";
    } else {
        $items .= $elem;
    }
}
$items .= "</tr>";


foreach ($sendClass->getAllSubs() as $mail){

    $arFields = array(
        "MAIL" => $mail,
        'DEFAULT_EMAIL_FROM' => $siteMail,
        'SERVER_NAME' => $serverName,
        'SITE_NAME' => $siteName,
        "CONTENT" => $items,
    );

    CEvent::Send("SEND_SUBS_MAIL", array('s1','s2'), $arFields, "N", 52);
}
