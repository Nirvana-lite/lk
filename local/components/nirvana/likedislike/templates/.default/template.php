<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
//$vrema_gizni = time() + 3600 * 24;
//setcookie("like_comment" . $arResult["ID"], 0, $vrema_gizni);
?>
<!--googleoff: all-->
<!--noindex-->
<?php
?>
<div class="bl_rat_stock ratingstock<?= $arResult["add_claas"] ?>" data-bl="<?= $arResult["IBLOCK_ID"] ?>" data-id="<?= $arResult["ID"] ?>" data-namepr = "<?= trim($arResult["MY_PROP"]) ?>">
    <span class="animatbl comment_yes"></span>
    <div class="bl_ratingstock comment_like"></div>
    <span class="comment_likes"><?= $arResult["VALUE_MY_PROP"]["LIKE"]; ?></span>
    <span class="animatbl comment_no"></span>
    <div class="bl_ratingstock comment_dislike"></div>
    <span class="comment_dislikes"><?= $arResult["VALUE_MY_PROP"]["DISLIKE"]; ?></span>
</div>
<!--/noindex-->
<!--/googleoff: all-->
