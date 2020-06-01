<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {die();}

use Bitrix\Main\Context,
    Bitrix\Main\Request;
$request = Context::getCurrent()->getRequest();

$this->setFrameMode(true);

if ($request->getPost("change")) {
    $APPLICATION->RestartBuffer();
    echo json_encode($arResult);
    die();
}
?>
<?php
global $USER;
if ($USER->IsAuthorized()):?>
<?if($arResult['isSub']):?>
    <span onclick="changeSub()">
        <i id="subs" class="fa fa-2x fa-star" aria-hidden="true"></i>
    </span>
<?else:?>
    <span onclick="changeSub()">
        <i id="subs" class="fa fa-2x fa-star-o" aria-hidden="true"></i>
    </span>
<?endif;?>
<script>
    function changeSub() {
        let str = new FormData();
        str.append('change', true);
        str.append('iblock_id', <?=$arParams['iblock_id']?>);
        str.append('section_id', <?=$arParams['section_id']?>);
        axios.post("<?=$componentPath?>/postChanges.php", str)
            .then((response) => {
                if (response.data.isSub){
                    subs.classList.remove('fa-star-o');
                    subs.classList.add('fa-star');
                }else{
                    subs.classList.remove('fa-star');
                    subs.classList.add('fa-star-o');
                }
            })
            .catch((error) => {
                console.log(error);
            });
    }
</script>
<?php
endif;
?>

