<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
switch ($arResult['VARIABLES']['IBLOCK_ID']) {
    case 'vestnik':
       $iblockId = 29;
        break;
    case 'popular':
        $iblockId = 17;
        break;
    case 'pravo':
        $iblockId = 24;
        break;
    case 'socprogram':
        $iblockId = 21;
        break;
    case 'news':
        $iblockId = 2;
        break;
}
$elemID = $arResult['VARIABLES']['ELEMENT_ID'];
if (!intval($elemID) > 0 && $elemID !== 'new'){
    LocalRedirect("/personal/");
}
?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<div class="row">
    <main id="mainText" class="main col-md-9">
                <?
                $APPLICATION->IncludeComponent(
                    "nirvana:forms",
                    ".default",
                    Array(
                        'IBLOCK_ID' => $iblockId,
                        'ELEMENT_ID' => $elemID
                    ),
                    false
                );
                ?>
    </main>
    <?
    $APPLICATION->IncludeComponent(
        "nirvana:sidebar",
        "notMain",
        Array(),
        false
    );
    ?>
</div>
