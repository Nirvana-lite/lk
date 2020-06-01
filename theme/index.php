<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$link = preg_replace('/[^a-zA-Z0-9-]/i', '', ToLower($_REQUEST['CITY']));
$link = strtok($link, '?');

$path = $_SERVER["DOCUMENT_ROOT"] . "/local/datagorod/";
$fileCity = file_get_contents($path . "datacity.json"); // отсюда можно кешировать
$taskListCity = json_decode($fileCity, TRUE);


if (CSite::InDir('/theme/')) {
    $link = 'moskva';
    $section_url = 'theme';
} else {
    $section_url = 'theme-' . $link;
}


if (array_key_exists($link, $taskListCity)) {

    $city = $taskListCity[$link];
    $fileOblast = file_get_contents($path . "dataoblast.json");
    $taskListOblast = json_decode($fileOblast, TRUE);
    $oblast = $taskListOblast[$city['region_id']];

    // дописывание в название раздела
    if ($section_url == 'theme') {
        $podezh = ' ';
        $robots_mt = 'noindex, follow';
    } else {
        $podezh = ' ' . (trim($city['podezh'])) . ' ';
        $robots_mt = 'all';
    }

} else { // выводим 404 города не существует
    error404();
}


metatagrazdel(
    $section_url, // link
    'Актуальные темы и вопросы' . (rtrim($podezh)), // title
    'Актуальные темы и вопросы' . (rtrim($podezh)),//SetTitle
    'задать вопрос юристу, спросить у юриста, помощь юриста, консультация юриста, помощь адвоката, вопрос адвокату, задать вопрос адвокату, защита прав потребителей, помощь автовладельцам, споры с застройщиками, возврат товара, возврат техники, возврат мебели', // tags
    '', // keywords
    'Актуальные темы и вопросы' . $podezh . 'Российского Юридического портала jur24pro', // description
    'Актуальные темы и вопросы' . (rtrim($podezh)), // h1
    $robots_mt
);

?>

    <div class="content-text block-shadow index-list-radel">
        <div class="row">
            <?

            function index_theme23()
            {

                $name_url_razdel = 'th-';

                if (CModule::IncludeModule('iblock')) {
                    $arFilter = Array(
                        'IBLOCK_ID' => 15,
                        'GLOBAL_ACTIVE' => 'Y');
                    $arSelect = array('ID', 'NAME', 'IBLOCK_ID', 'SECTION_PAGE_URL', 'DEPTH_LEVEL');

                    $res = CIBlockSection::GetTreeList($arFilter, $arSelect);


                    while ($arSection = $res->GetNext()) {

                        $prop_section[] = $arSection['ID'];

                        if ($arSection['DEPTH_LEVEL'] == 1) {
                            $id_first = $arSection['ID'];
                            $name_section[$arSection['ID']] = array('name' => $arSection['NAME'], 'url' => $arSection['SECTION_PAGE_URL']);
                            $name_section[$arSection['ID']]['class'] = ' class="ind-list iconrzd-' . $arSection['ID'] . '"';
                        } else {
                            $name_section[$id_first]['array'][] = array(
                                'id' => $arSection['ID'],
                                'name' => $arSection['NAME'],
                                'url' => $arSection['SECTION_PAGE_URL']
                            );
                        }

                    }

                    if ($prop_section) {

                        $dbItem = CIBlockSection::GetList(
                            array(
                                'ID' => 'ASC',
                            ),
                            array(
                                'IBLOCK_ID' => 52,
                                'ACTIVE' => 'Y',
                                'UF_SECTION_VOP' => $prop_section,
                            ),
                            false,
                            array(
                                'NAME',
                                'ID',
                                'IBLOCK_ID',
                                'SECTION_PAGE_URL',
                                'UF_SECTION_VOP'
                            ),
                            false
                        );
                        $i = 0;
                        while ($arItem = $dbItem->GetNext()) {
                            $mas2[$arItem['UF_SECTION_VOP']][$i]['NAME'] = $arItem['NAME'];
                            $mas2[$arItem['UF_SECTION_VOP']][$i]['URL'] = '/{city}-' . $name_url_razdel . $arItem['CODE'] . '/';
                            $i++;
                        }

                    }

                    return array(
                        'name_section' => $name_section,
                        'mas2' => $mas2,
                    );
                }
            }

            $cachedDatasas = returnResultCache(3600000, 'index_theme/th-code', 'index_theme23');

            $mas2 = $cachedDatasas['mas2'];
            $name_section = $cachedDatasas['name_section'];
            $html_ulli = '';

            function masstwo($mas2, $keymass, $h2_name = '', $h2_url = '', $ct)
            {

                if (!empty($h2_name)) {
                    $html_ulli .= "<h2><a target='_blank' href='" . $h2_url . "'>" . $h2_name . "</a></h2>";
                }

                if ($mas2[$keymass]) {
                    $html_ulli .= "<ul>";

                    //pre($mas2[$keymass]);
                    foreach ($mas2[$keymass] as $keynm => $value2) {
                        // подставляем город
                        $value2['URL'] = str_replace("{city}", $ct, $value2['URL']);
                        $html_ulli .= "<li><a href='" . $value2['URL'] . "'>" . $value2['NAME'] . "</a></li>";
                    }
                    $html_ulli .= "</ul>";
                }

                return $html_ulli;
            }


            foreach ($name_section as $key => $value) {
                if (isset($value['class'])) {
                    $rzdclass = $value['class'];
                } else {
                    $rzdclass = '';
                }
                $html_ulli .= "<div class='col-sm-4 col-md-4'><h2" . $rzdclass . "><a target='_blank' href='" . $value['url'] . "'>" . $value['name'] . "</a></h2>";


                $html_ulli .= masstwo($mas2, $key, '','', $city['alias']);

                // второй уровень
                if ($value['array']) {
                    foreach ($value['array'] as $key2 => $value) {
                        $html_ulli .= masstwo($mas2, $value['id'], $value['name'], $value['url'], $city['alias']);
                    }
                    $html_ulli .= "</ul>";
                }
                $html_ulli .= "</div>";
            }
            echo $html_ulli;
            ?>
        </div>
    </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>