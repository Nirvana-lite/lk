<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
    Bitrix\Main,
    Bitrix\Iblock;

global $NavNum, $APPLICATION;

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

class FirstComponent extends CBitrixComponent
{

    // Обработка параметров
  /*  function onPrepareComponentParams($arParams)
    {


        if ($arParams['CACHE_TYPE'] == 'Y' || $arParams['CACHE_TYPE'] == 'A') {
            $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);
        } else {
            $arParams['CACHE_TIME'] = 10;
        }

        #проверка входных параметров
        $arParams['IBLOCK_ID'] = isset($arParams['IBLOCK_ID']) && intval($arParams['IBLOCK_ID']) > 0 ? intval($arParams['IBLOCK_ID']) : 0;
        return $arParams;
    }*/

    public function executeComponent()
    {
        try {
            //StartResultCache return true, если кэш недействительный
            //StartResultCache return false и $arResult - если действителен


            $Num = intval($NavNum) + 1;

            $context = \Bitrix\Main\Application::getInstance()->getContext();
            $request = $context->getRequest();
            $method = $request->getRequestMethod();
            $pageNumber = $request->getQuery('PAGEN_' . $Num);

            if (intval($pageNumber) < 0) {
                Bitrix\Iblock\Component\Tools::process404(null, true, true, true, '/404.php');
                return;
            }

            $limit = array(
                'nPageSize' => $this->arParams['COUNT'], // Укажем количество выводимых элементов
                "bDescPageNumbering" => false, // Обратная навигация или прямая
                'iNumPage' => ($pageNumber ? $pageNumber : 1),
                'bShowAll' => false // тут как вам нравится если надо можно показывать ссылку все
            );

            $navigation = \CDBResult::GetNavParams($limit);

            if ($this->startResultCache(3600, false)) {  //Берем из кэша или формируем заного результат, если нет кэша

                $this->checkModules();
                $this->prepareData();
                $this->doAction($navigation,$limit);

                $this->includeComponentTemplate();

            }
        } catch (Exception $e) {         //Если произошла к-л ошибка, выводим ошибку
            $this->AbortResultCache();
            $this->arResult['ERROR'] = $e->getMessage();
        }

    }

    protected function checkModules()
    {
        #подключаем нужные модули
        if (!Loader::includeModule('iblock'))
            throw new Exception('Модуль "Инфоблоки" не установлен');
    }

    protected function prepareData()
    {
        #проверки на существования
        $this->arResult['IBLOCK'] = [];
        if ($this->arParams['IBLOCK_ID']) {
            $this->arResult['IBLOCK'] = CIBlock::GetByID($this->arParams['IBLOCK_ID'])->Fetch();
        }
        if (!$this->arResult['IBLOCK']) {
            throw new Exception('Инфоблок не найден');
        }

        if(!empty($this->arParams['SECTION_CODE'])) {
            $this->arResult['SECTION'] = [];
            $this->arResult['SECTION'] = \Bitrix\Iblock\SectionTable::getList(
                array(
                    'filter' => array(
                        '=IBLOCK_ID' => $this->arResult['IBLOCK']['ID'],
                        '=CODE' => $this->arParams['SECTION_CODE'],
                    )
                )
            )->fetch();
        }

    }

    protected function doAction($navigation,$limit)
    {
        $this->actionView($navigation,$limit);
    }

    protected function actionView($navigation,$limit)
    {
        $this->arResult['ITEMS'] = [];

        $res = \Bitrix\Iblock\ElementTable::getList(
            array(
                'order' => array('ID' => 'DESC'), // сортировка
                'select' => array(
                    'ID', 'NAME', 'CODE', 'IBLOCK_ID',
                    'DETAIL_PICTURE', 'DATE_CREATE', 'TAGS',
                    //'DETAIL_TEXT'
                ),
                'filter' => array(
                    "=IBLOCK_ID" => $this->arResult['IBLOCK']['ID'],
                    "ACTIVE" => "Y"
                ),
                'count_total' => true,
                'offset' => ($limit['iNumPage'] - 1) * $limit['nPageSize'],
                'limit' => $limit['nPageSize'],
               /* 'cache' => array(
                    'ttl' => 36000,
                    'cache_joins' => true
                )*/
            )
        );
        while ($ob = $res->Fetch()) {
            $this->arResult['ITEMS'][] = $ob;
        }


        $nav = new \CDBResult();
        $nav->NavStart($navigation, false, true); // page_size; show_all; NumPage
        $nav->NavPageCount = ceil($res->getCount() / $limit['nPageSize']); // общее количество страниц
        $nav->NavPageNomer = $limit['iNumPage']; // PAGEN_1 номер
        $nav->NavRecordCount = $res->getCount();

        $navString = $nav->GetPageNavStringEx($navComponentObject, "Страницы:", "round", false, $this);

        $this->arResult["NAV_STRING"] = $navString;

       // $this->arResult['pagination'] = $res->GetPageNavStringEx($navComponentObject, "Страницы:", "round");


        /* while ($ob = $rs->GetNextElement()) {
             $arItem = $ob->GetFields();
             $arItem['PROPERTIES'] = $ob->GetProperties();

             $arItem['DISPLAY_PROPERTIES'] = [];
             foreach ($arItem['PROPERTIES'] as $code => $arProp) {
                 $prop = $arItem['PROPERTIES'][$code];
                 if (
                     (is_array($prop['VALUE']) && count($prop['VALUE']))
                     || (!is_array($prop['VALUE']) && strlen($prop['VALUE']))
                 ) {
                     $arItem['DISPLAY_PROPERTIES'][$code] = CIBlockFormatProperties::GetDisplayValue($arItem, $prop, 'app_banner');
                 }
             }

            // Iblock\Component\Tools::getFieldImageData(
            //     $arItem,
            //     ['PREVIEW_PICTURE', 'DETAIL_PICTURE'],
           //      Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
           //      'IPROPERTY_VALUES'
          //   );

             $this->arResult['ITEMS'][] = $arItem;
         }*/


        if (!$this->arResult['ITEMS']) {
            $this->AbortResultCache();
        }
    }
}