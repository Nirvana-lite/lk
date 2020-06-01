<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
    return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
/*$css = $APPLICATION->GetCSSArray();
if(!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css))
{
    $strReturn .= '<link href="'.CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css").'" type="text/css" rel="stylesheet" />'."\n";
}*/

$strReturn .= '<div class="breadcrumbs" itemscope="" itemtype="http://schema.org/BreadcrumbList">';
$strReturn .='
			<div class="bx-breadcrumb-item" id="bx_breadcrumb_1" itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
				<a rel="nofollow" href="/" title="Главная" itemprop="item">
					<span itemprop="name">Главная</span>
				</a>
				<meta itemprop="position" content="1" />
			</div>

';

$itemSize = count($arResult);
$current_link  = $APPLICATION->GetCurPage();

if ($current_link == $arResult[$itemSize-1]['LINK']) {
    $itcon = 1;
}else{
    $itcon = 0;
}

for($index = 0; $index < $itemSize; $index++)
{
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    $arrow = ($index > -1? '/' : '');

    if($arResult[$index]["LINK"] <> "" && $index != $itemSize-$itcon)
    {
        $strReturn .= '
			<div class="bx-breadcrumb-item" id="bx_breadcrumb_'.($index+2).'" itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
				'.$arrow.'
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">
					<span itemprop="name">'.$title.'</span>
				</a>
				<meta itemprop="position" content="'.($index + 2).'" />
			</div>';
    }
    else
    {
        $strReturn .= '
			<div class="hidden-text" >
				'.$arrow.'
				<span >'.$title.'</span>
				
			</div>';
    }
}

$strReturn .= '</div>';

return $strReturn;
