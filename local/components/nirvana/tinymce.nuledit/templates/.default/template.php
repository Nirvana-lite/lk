<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$sText 			 =  (isset($arParams['TEXT']) 			 == false) ? ''       	 : $arParams['TEXT'];
$sClassTextArea   =  (isset($arParams['INIT_ID'])   == false) ? 'txtcontent'   : $arParams['INIT_ID'];
$sNameTextArea   =  (isset($arParams['TEXTAREA_NAME'])   == false) ? 'content'   : $arParams['TEXTAREA_NAME'];
$sIdTextArea   	 =  (isset($arParams['TEXTAREA_ID'])     == false) ? 'content' 		 : $arParams['TEXTAREA_ID'];
?>

<textarea id="<?=$sIdTextArea?>" class="<?=$sEditorID?>"  name="<?=$sNameTextArea?>" style="width:100%;"><?=$sText?></textarea>