<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule("iblock")) {
    return;
}

global $USER;

if(!isset($arParams["CACHE_TIME"])) {
    $arParams["CACHE_TIME"] = 36000;
}


if(IntVal($arParams['ID']) > 0 ) {
//[ID]
//[IBLOCK_ID]
//[MY_PROP][0]
//[OTHER]==Y
// $cache_id = md5(serialize($arParams));

    $cache_id = SITE_ID."|".$componentName."|".md5(serialize($arParams));
    if( ( $tzOffset = CTimeZone::GetOffset() ) <> 0 ) {
        $cache_id .= "|" . $tzOffset;
    }

    $cache_dir = "/tagged_post_likes/post".$arParams["ID"];
    //$cache_dir = SITE_ID.CComponentEngine::MakeComponentPath( $componentName );

    $obCache = new CPHPCache;

    if($obCache->InitCache($arParams["CACHE_TIME"], $cache_id, $cache_dir))
    {
        $cacheArrayCache = $obCache->GetVars();
        $cacheArray = $cacheArrayCache['arResult'];
        $bVarsFromCache = true;

    } elseif(CModule::IncludeModule("iblock") && $obCache->StartDataCache())
    {
        global $CACHE_MANAGER;
        $CACHE_MANAGER->StartTagCache($cache_dir);

        $cacheArray['ID'] = $arParams['ID'];
        $cacheArray['IBLOCK_ID'] = $arParams['IBLOCK_ID'];
        $cacheArray['MY_PROP'] = $arParams['MY_PROP'];

        $db_props = CIBlockElement::GetProperty($arParams['IBLOCK_ID'], $arParams['ID'], Array("sort"=>"asc"), Array("CODE"=>$arParams['MY_PROP']));
        $ob = $db_props->Fetch();

        if (!$ob) {
            $this->abortResultCache();
            Iblock\Component\Tools::process404(
                trim($arParams["MESSAGE_404"]) ?: GetMessage("T_NEWS_NEWS_NA")
                ,true
                ,$arParams["SET_STATUS_404"] === "Y"
                ,$arParams["SHOW_404"] === "Y"
                ,$arParams["FILE_404"]
            );
            return;
        }else {


            $CACHE_MANAGER->RegisterTag("post_likes_" . $arParams['ID']);

            $arrLD = json_decode($ob['VALUE'], true);

            if (is_array($arrLD)) {
                $cacheArray['VALUE_MY_PROP']=array('LIKE'=>$arrLD[0], 'DISLIKE' =>$arrLD[1]);
            } else {
                $cacheArray['VALUE_MY_PROP']=array('LIKE'=>0, 'DISLIKE' =>0);
            }

            $CACHE_MANAGER->EndTagCache();

            $obCache->EndDataCache(
                    array(
                        "arResult" => $cacheArray
                    )
            );

        }
    }
    else
    {
        $cacheArray = array();
    }

    $arResult = $cacheArray;
    $this->IncludeComponentTemplate();

} else{
    $this->AbortResultCache();
    echo "<p>Не задан параметр ID (элемента) при вызове компонента</p>";
}


?>