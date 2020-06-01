<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

//ob_start();

$colorSchemes = array(
	"green" => "bx-green",
	"yellow" => "bx-yellow",
	"red" => "bx-red",
	"blue" => "bx-blue",
);
if(isset($colorSchemes[$arParams["TEMPLATE_THEME"]]))
{
	$colorScheme = $colorSchemes[$arParams["TEMPLATE_THEME"]];
}
else
{
	$colorScheme = "";
}
?>
<div class="bx-pagination <?=$colorScheme?>">
	<div class="bx-pagination-container row">
		<ul>
<?if($arResult["bDescPageNumbering"] === true):?>

	<?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<?if($arResult["bSavePage"]):?>
			<li class="bx-pag-prev"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
			<li class=""><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span>1</span></a></li>
		<?else:?>
			<?if (($arResult["NavPageNomer"]+1) == $arResult["NavPageCount"]):?>
				<li class="bx-pag-prev"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
			<?else:?>
				<li class="bx-pag-prev"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
			<?endif?>
			<li class=""><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span>1</span></a></li>
		<?endif?>
	<?else:?>
			<li class="bx-pag-prev"><span><?echo GetMessage("round_nav_back")?></span></li>
			<li class="bx-active"><span>1</span></li>
	<?endif?>

	<?
	$arResult["nStartPage"]--;
	while($arResult["nStartPage"] >= $arResult["nEndPage"]+1):
	?>
		<?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<li class="bx-active"><span><?=$NavRecordGroupPrint?></span></li>
		<?else:?>
			<li class=""><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><span><?=$NavRecordGroupPrint?></span></a></li>
		<?endif?>

		<?$arResult["nStartPage"]--?>
	<?endwhile?>

	<?if ($arResult["NavPageNomer"] > 1):?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class=""><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><span><?=$arResult["NavPageCount"]?></span></a></li>
		<?endif?>
			<li class="bx-pag-next"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><span><?echo GetMessage("round_nav_forward")?></span></a></li>
	<?else:?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class="bx-active"><span><?=$arResult["NavPageCount"]?></span></li>
		<?endif?>
			<li class="bx-pag-next"><span><?echo GetMessage("round_nav_forward")?></span></li>
	<?endif?>

<?else:?>

	<?if ($arResult["NavPageNomer"] > 1):?>
		<?if($arResult["bSavePage"]):?>
			<li class="bx-pag-prev"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
			<li class=""><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><span>1</span></a></li>
		<?else:?>
			<?if ($arResult["NavPageNomer"] > 2):?>
				<li class="bx-pag-prev"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
			<?else:?>
				<li class="bx-pag-prev"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
			<?endif?>
			<li class=""><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span>1</span></a></li>
		<?endif?>
	<?else:?>
			<li class="bx-pag-prev"><span><?echo GetMessage("round_nav_back")?></span></li>
			<li class="bx-active"><span>1</span></li>
	<?endif?>

	<?
	$arResult["nStartPage"]++;
	while($arResult["nStartPage"] <= $arResult["nEndPage"]-1):
	?>
		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<li class="bx-active"><span><?=$arResult["nStartPage"]?></span></li>
		<?else:?>
			<li class=""><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><span><?=$arResult["nStartPage"]?></span></a></li>
		<?endif?>
		<?$arResult["nStartPage"]++?>
	<?endwhile?>

	<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class=""><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><span><?=$arResult["NavPageCount"]?></span></a></li>
		<?endif?>
			<li class="bx-pag-next"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span><?echo GetMessage("round_nav_forward")?></span></a></li>
	<?else:?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class="bx-active"><span><?=$arResult["NavPageCount"]?></span></li>
		<?endif?>
			<li class="bx-pag-next"><span><?echo GetMessage("round_nav_forward")?></span></li>
	<?endif?>
<?endif?>
		</ul>
		<div style="clear:both"></div>
	</div>
</div>
<?php
/*
$paging = ob_get_contents();
$paging = preg_replace_callback('/href="([^"]+)"/is', function($matches) {
    $url = $matches[1];
    $newUrl = '';
    if ($arUrl = parse_url($url)) {
        $newUrl = isset($_SERVER['REAL_FILE_PATH'])&&strlen($_SERVER['REAL_FILE_PATH']) ? $_SERVER['REAL_FILE_PATH'] : $_SERVER['SCRIPT_NAME'];
        $newUrl = str_replace(array('index.php', 'index.html'), '', $newUrl);
        ///$newUrl .= $arUrl['path'];
      //  if (substr($newUrl, -1) != '/') {
      //      $newUrl .= '/';
      //  }
       // $newUrl = preg_replace('#(pagen[\d]+/)#is', '', $newUrl);
        parse_str(htmlspecialcharsback($arUrl['query']), $arQuery);
        foreach ($arQuery as $k => $v) {
            if (in_array($k, array('SECTION_CODE'))) {
                unset($arQuery[$k]);
            } elseif (substr($k, 0, 5)=='PAGEN') {
                $newUrl .= 'pagen-'.intval($v).'/';
                unset($arQuery[$k]);
            }
        }
        $buildQuery = http_build_query($arQuery, '', '&amp;');
        if (strlen($buildQuery)) {
            $newUrl .= '?'.$buildQuery;
        }
    }
    return 'href="'.$newUrl.'"';
}, $paging);
ob_end_clean();
echo $paging;
*/

/*$paging = ob_get_contents();
$paging = preg_replace_callback('/href="([^"]+)"/is', function($matches) {
    $url = $matches[1];
    $newUrl = '';
    if ($arUrl = parse_url($url)) {
        $newUrl = isset($_SERVER['REAL_FILE_PATH'])&&strlen($_SERVER['REAL_FILE_PATH']) ? $_SERVER['REAL_FILE_PATH'] : $_SERVER['SCRIPT_NAME'];
        $newUrl = str_replace(array('index.php', 'index.html'), '', $newUrl);
        parse_str(htmlspecialcharsback($arUrl['query']), $arQuery);
        foreach ($arQuery as $k => $v) {
            if (in_array($k, array('SECTION_CODE'))) {
                unset($arQuery[$k]);
            } elseif (substr($k, 0, 5)=='PAGEN') {
                $newUrl .= 'page-'.intval($v).'/';
                unset($arQuery[$k]);
            }
        }
        $buildQuery = http_build_query($arQuery, '', '&amp;');
        if (strlen($buildQuery)) {
            $newUrl .= '?'.$buildQuery;
        }
    }
    return 'href="'.$newUrl.'"';
}, $paging);
ob_end_clean();
echo $paging;*/
