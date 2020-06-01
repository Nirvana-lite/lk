<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<div class="col-lg-12">
    <? if (!$_REQUEST['section_id']) {
    $arr = [];

    $arFilter = Array(
        'IBLOCK_ID' => 15,
        'GLOBAL_ACTIVE' => 'Y'
    );
    $arSort = ['NAME' => 'asc'];
    $arSelect = ['ID', 'NAME'];
    $res = CIBlockSection::GetList($arSort, $arFilter, false, $arSelect);
    while ($arSection = $res->fetch()) {
        $sn = substr($arSection['NAME'], 0, 1);
        $arr['list'][$sn][] = $arSection['ID'];
        $arr['themes'][] = $arSection;
    }
    foreach ($arr['list'] as $key => $list) {
        ?>
        <a href="?theme=<?= $key ?>"><?= $key ?></a>
    <? }?>
    <a class="clear_btn" href="/personal/themes/">Все</a>
    <?
    if ($_REQUEST['theme']){
        $arr['themes'] = [];
        $arFilter = Array(
            'IBLOCK_ID' => 15,
            'GLOBAL_ACTIVE' => 'Y',
            'ID' => $arr['list'][$_REQUEST['theme']]
        );
        $arSort = ['NAME' => 'asc'];
        $arSelect = ['ID', 'NAME'];
        $res = CIBlockSection::GetList($arSort, $arFilter, false, $arSelect);
        while ($arSection = $res->fetch()) {
            $sn = substr($arSection['NAME'], 0, 1);
            $arr['themes'][] = $arSection;
        }
    }
    ?>

    <div class="list_razdel_btn">
        <?foreach ($arr['themes'] as $theme) {
            ?>
            <a class="btn btn-default razdel_btn"
               href="?section_id=<?= $theme['ID']; ?>&section_name=<?= $theme['NAME']; ?>">
                <? echo trim($theme['NAME']); ?>
            </a>
        <? } ?>
    </div>
</div>
<? } else {
    $section_id = IntVal(htmlspecialchars($_REQUEST['section_id']));
    ?>
    <h2><?= $_REQUEST['section_name'] ?></h2>
    <form class="add_section" id="form_add_section" action="" method="post">
        <div class="form-group messages">
            <div class="show_text"></div>
        </div>

        <div class="form-group">
            <label for="title-section">Title</label>
            <button type="button" class="btn add-text-city">Добавить город -> в Москве</button>
            <input type="text" name="TITLE" class="form-control" id="title-section">
        </div>

        <div class="form-group">
            <label for="name-section">Название раздела в списке</label>
            <input type="text" name="NAME" class="form-control" id="name-section">
        </div>

        <div class="form-group">
            <label for="description-section">Description раздела</label>
            <button type="button" class="btn add-text-city">Добавить город -> в Москве</button>
            <textarea name="DESCRIPTION" id="description-section" class="form-control" rows="5"
                      placeholder="Текст в Description"></textarea>
            <p class="counter">Количество символов <span class="col_simvol">0</span></p>
        </div>
        <div class="form-group">
            <label for="h1-section">Добавить к полному тексту h1 ( поле:&nbsp;&nbsp;&nbsp;&nbsp;пустое - не добавит;
                &nbsp;&nbsp;&nbsp;&nbsp; заполнили - добавит )</label>
            <input type="text" name="h1" class="form-control" id="h1-section">
        </div>
        <div class="form-group">
            <label for="previewtxt-section">Полный текст раздела</label>
            <?php
            $APPLICATION->IncludeComponent(
                "componentmanager:editor.tiny.mce",
                "",
                array(
                    "TEXT" => "",
                    "TEXTAREA_NAME" => "DETAIL_TEXT",
                    "TEXTAREA_ID" => "previewtxt-section",
                    "TEXTAREA_WIDTH" => "100%",  //
                    "TEXTAREA_HEIGHT" => "300",    //
                    "INIT_ID" => "ID", //
                    "TYPE_EDITOR" => "TYPE_1"
                ),
                false
            );
            ?>
        </div>
        <div class="form-group">
            <label for="tags-section">Теги раздела раздела - keywords</label>
            <input type="text" name="TAGS" class="form-control" id="tags-section">
        </div>
        <input type="hidden" name="section_vopros" value="<?= $section_id; ?>">
        <input type="hidden" name="type_action" value="ADD">
        <input type="submit" class="btn btn-success" value="Создать раздел">
    </form>
<? } ?>
<script>
    BX.message({
        componentPath: '<?=$componentPath?>'
    });
</script>
<style>
    .clear_btn{
        margin-left: 20px;
        font-size: 18px;
        text-transform: uppercase;
    }
</style>