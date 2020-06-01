<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset,
    Bitrix\Main\Context,
    Bitrix\Main\Request,
    DiDom\Document,
    DiDom\Query;

global $USER;
CModule::IncludeModule('iblock');
require($_SERVER["DOCUMENT_ROOT"] . "/local/include/didom/includ_didom.php");

function changeDetail($text)
{
    preg_match_all('/<p[^>]*?>(.*?)<\/p>/si', $text, $arrs);
    preg_match_all('#<p>(.+?)</p>#is', $arrs[0][0], $arr);
    $arFields['preview'] = trim($arr[1][0]);
    return $arFields;
}

function previewdetailtext($dettext)
{
    $document = new Document(trim($dettext));

    $p = $document->find('p')[0];
    $document = null;
    return array('preview' => $p->text());
}

$request = Context::getCurrent()->getRequest();
if ($USER->IsAdmin()){
    /**
     * admin
     */

    $arSelect = Array("ID","IBLOCK_ID", "NAME","PREVIEW_TEXT" ,"DATE_CREATE","PROPERTY_urist");
    $arFilter = Array("IBLOCK_ID"=>IntVal($arParams['ARTICLES']), "ACTIVE"=>"N");
    $res = CIBlockElement::GetList(Array('DATE_CREATE' => 'DESC'), $arFilter, false, Array("nPageSize"=>10), $arSelect);
    while($ob = $res->fetch())
    {
        $rsUser = CUser::GetByID($ob['PROPERTY_URIST_VALUE']);
        $autor = $rsUser->Fetch();
        $arResult['all'][] = [
            'id' => $ob['ID'],
            'name' => $ob['NAME'],
            'preview' => TruncateText($ob['PREVIEW_TEXT'], 150),
            'date' => date('d / m / Y', strtotime($ob['DATE_CREATE'])),
            'autor' =>[
                'name' => $autor['NAME'],
                'lastName' => $autor['LAST_NAME'],
                'fullName' => "{$autor['LAST_NAME']} {$autor['NAME']}",
                'photo' => CFile::GetPath($autor['PERSONAL_PHOTO'])
            ]
        ];
    }
    $arResult['pages'] = $res->GetPageNavStringEx($navComponentObject, "Страницы:", "myround");
}
else {
    if ($request->getPost("ajax")) {
        if ($request->getPost("ajax") == 2) {

            $filter = Array("IBLOCK_ID" => IntVal($arParams['ARTICLES']), "ACTIVE" => "Y", "=CREATED_BY" => $USER->GetID());

            $myNav = new \Bitrix\Main\UI\PageNavigation("nav-more-news");
            $myNav->allowAllRecords(true)
                ->setPageSize(10)
                ->initFromUri();
            $myNavOffset = $request->getPost("pageCount") + $myNav->getPageSize();
            $newsList = \Bitrix\Iblock\ElementTable::getList(
                array(
                    "filter" => $filter,
                    'order' => array('ID' => 'DESC'),
                    'select' => ($arParams['ARTICLES'] === 29) ? array('ID', 'NAME', "DATE_CREATE", "DETAIL_PICTURE", 'PREVIEW_TEXT', 'SHOW_COUNTER') : array('ID', 'NAME', "DATE_CREATE", "DETAIL_PICTURE", 'DETAIL_TEXT', 'SHOW_COUNTER'),
                    "count_total" => true,
                    "offset" => $myNavOffset,
                    "limit" => $myNav->getLimit(),
                )
            );

            $myNav->setRecordCount($newsList->getCount());

            while ($ob = $newsList->fetch()) {
                if ($arParams['ARTICLES'] === 29) {
                    $text = previewdetailtext($ob['PREVIEW_TEXT']);
                } else {
                    $text = previewdetailtext($ob['DETAIL_TEXT']);
                }
                $arResult['my'][] = [
                    'id' => $ob['ID'],
                    'name' => $ob['NAME'],
                    'date' => date('d/m', strtotime($ob['DATE_CREATE'])),
                    'picture' => CFile::ResizeImageGet(
                        $ob['DETAIL_PICTURE'],
                        array('width' => 150, 'height' => 150),
                        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                        true
                    ),
                    'view' => $ob['SHOW_COUNTER'],
                    'preview' => TruncateText($text['preview'], 300),
                    'open' => false,
                    'detail' => '',
                    'detailComment' => ''
                ];
            }
        } else if ($request->getPost("ajax") == 1) {
            $allFilter = Array("IBLOCK_ID" => IntVal($arParams['ARTICLES']), "ACTIVE" => "Y");

            $allNav = new \Bitrix\Main\UI\PageNavigation("nav-more-news");
            $allNav->allowAllRecords(true)
                ->setPageSize(10)
                ->initFromUri();

            $allNavOffset = $request->getPost("pageCount") + $allNav->getPageSize();
            $allNewsList = \Bitrix\Iblock\ElementTable::getList(
                array(
                    "filter" => $allFilter,
                    'order' => array('ID' => 'DESC'),
                    'select' => ($arParams['ARTICLES'] === 29) ? array('ID', 'NAME', "DATE_CREATE", "DETAIL_PICTURE", 'PREVIEW_TEXT', 'SHOW_COUNTER') : array('ID', 'NAME', "DATE_CREATE", "DETAIL_PICTURE", 'DETAIL_TEXT', 'SHOW_COUNTER'),
                    "count_total" => true,
                    "offset" => $allNavOffset,
                    "limit" => $allNav->getLimit(),
                )
            );

            $allNav->setRecordCount($allNewsList->getCount());

            while ($all = $allNewsList->fetch()) {
                if ($arParams['ARTICLES'] === 29) {
                    $text = previewdetailtext($all['PREVIEW_TEXT']);
                } else {
                    $text = previewdetailtext($all['DETAIL_TEXT']);
                }
                $arResult['all'][] = [
                    'id' => $all['ID'],
                    'name' => $all['NAME'],
                    'date' => date('d/m', strtotime($all['DATE_CREATE'])),
                    'picture' => CFile::ResizeImageGet(
                        $all['DETAIL_PICTURE'],
                        array('width' => 150, 'height' => 150),
                        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                        true
                    ),
                    'preview' => TruncateText($text['preview'], 300),
                    'open' => false,
                    'detail' => '',
                    'detailComment' => ''
                ];
            }
        }
    }
    elseif ($request->getPost("detail")) {
        $arSelect = Array("ID", "IBLOCK_ID", 'DETAIL_TEXT');
        $arFilter = Array("IBLOCK_ID" => IntVal($arParams['ARTICLES']), "ACTIVE" => "Y", "=ID" => $request->getPost("detail"));
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount" => 1), $arSelect);
        if ($ob = $res->fetch()) {
            $arResult['detail'] = $ob['DETAIL_TEXT'];
        } else {
            $arResult['detail'] = '';
        }

        echo json_encode($arResult);
    }
    else {


        /**
         * my news
         */


        $filter = Array("IBLOCK_ID" => IntVal($arParams['ARTICLES']), "ACTIVE" => "Y", "CREATED_BY" => intval($USER->GetID()));
        $select = array('ID', 'IBLOCK_ID','NAME', "DATE_CREATE", "DETAIL_PICTURE",'PREVIEW_TEXT', 'SHOW_COUNTER');
        $newsList = CIBlockElement::GetList(Array('ID' => 'DESC'), $filter, false, Array("nPageSize"=>10), $select);
        if (intval($newsList->SelectedRowsCount())>0){
            while ($tmp = $newsList->GetNextElement()) {
                $ob = $tmp->GetFields();
                $arResult['my'][] = [
                    'id' => $ob['ID'],
                    'name' => $ob['NAME'],
                    'date' => date('d/m', strtotime($ob['DATE_CREATE'])),
                    'picture' => CFile::ResizeImageGet(
                        $ob['DETAIL_PICTURE'],
                        array('width' => 150, 'height' => 150),
                        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                        true
                    ),
                    'view' => $ob['SHOW_COUNTER'],
                    'preview' => TruncateText($ob['PREVIEW_TEXT'], 300),
                    'open' => false,
                    'detail' => '',
                    'detailComment' => ''
                ];
            }
        }


        /**
         * all news
         */

        $filter = Array("IBLOCK_ID" => IntVal($arParams['ARTICLES']), "ACTIVE" => "Y");
        $select = array('ID', 'IBLOCK_ID','NAME', "DATE_CREATE", "DETAIL_PICTURE",'PREVIEW_TEXT', 'SHOW_COUNTER');
        $allNewsList = CIBlockElement::GetList(Array('ID' => 'DESC'), $filter, false, Array("nPageSize"=>10), $select);

        if (intval($allNewsList->SelectedRowsCount())>0){
            while ($tmp = $allNewsList->GetNextElement()) {
                $all = $tmp->GetFields();
                $arResult['all'][] = [
                    'id' => $all['ID'],
                    'name' => $all['NAME'],
                    'date' => date('d/m', strtotime($all['DATE_CREATE'])),
                    'picture' => CFile::ResizeImageGet(
                        $all['DETAIL_PICTURE'],
                        array('width' => 150, 'height' => 150),
                        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                        true
                    ),
                    'preview' => TruncateText($all['PREVIEW_TEXT'], 300),
                    'open' => false,
                    'detail' => '',
                    'detailComment' => ''
                ];
            }
        }

    }
}
$this->IncludeComponentTemplate();
?>
