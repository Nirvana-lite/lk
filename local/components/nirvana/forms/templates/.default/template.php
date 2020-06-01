<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
?>
<div class="row">
    <div class="btns">
        <button type="button" class="btn btn-info" onclick="changeTab(1)">Редактировать</button>
        <button type="button" class="btn btn-info" onclick="changeTab(2)">Предпросмотр</button>
        <? if ($USER->isAdmin() && is_array($arResult['item'])):?>
            <button type="button" class="pull-right btn btn-danger" onclick="ascDel()">Удалить</button>
        <?endif;?>
    </div>
</div>
<div class="tab-content" id="tab1">
    <form id="form_res" class="form-horizontal">
        <div class="form-group">
            <label for="title">Title (заголовок который в коде)</label>
            <input name="title" type="text" class="form-control" id="title" value="<?= $arResult['item']['name'] ?>"
                   placeholder="Title статьи" required>
        </div>
        <div class="form-group">
            <label for="name">Название статьи - в списке ( ссылка тоже создается )</label>
            <input name="name" type="text" class="form-control" id="name" value="<?= $arResult['item']['name'] ?>"
                   placeholder="Заголовок статьи" required>
        </div>
        <div class="form-group">
            <label for="preview">Анонс статьи и Description</label>
            <textarea name="description" id="preview" class="form-control"
                      rows="5" required><?= $arResult['item']['preview'] ?></textarea>
        </div>
        <?if(intval($arParams['IBLOCK_ID']) !== 2):?>
        <div class="form-group">
            <label for="section">Раздел</label>
            <select class="form-control" name="section" id="section" required>
                <? foreach ($arResult['sections'] as $key => $section) {?>
                    <option <?= ($section['id'] === $arResult['item']['section']) ? 'selected' : ''; ?>
                            value="<?= $section['id'] ?>"><?= $section['name'] ?></option>
                <? } ?>
            </select>
        </div>
        <?endif;?>
        <div class="form-group">
            <label for="image">Фото статьи</label>
            <img class="image form-control" <?= (is_array($arResult['item'])) ? "src='{$arResult['item']['picture']}'" : ''; ?>>
            <input onchange="previewFile()" name="image" type="file" class="form-control" id="image" <?=(is_array($arResult['item'])) ? '' : 'required';?>>
        </div>
        <div class="form-group">
            <label for="h1-element">h1 - видимый заголовок</label>
            <input id="h1" name="h1" value="<?= $arResult['item']['name'] ?>" type="text" class="form-control" placeholder="h1" required>
        </div>
        <div class="form-group">
            <label for="text">Текст статьи</label>
            <?php
            $APPLICATION->IncludeComponent(
                "componentmanager:editor.tiny.mce",
                "",
                array(
                    "TEXT" => $arResult['item']['text'],
                    "TEXTAREA_NAME" => "more-text",
                    "TEXTAREA_ID" => "detail_text",
                    "TEXTAREA_WIDTH" => "99.9%",  //
                    "TEXTAREA_HEIGHT" => "300",    //
                    "INIT_ID" => "detail_ID", //
                    "PATH_SAVE_PHOTO" => "/temps",
                    "TYPE_EDITOR" => "TYPE_1"
                ),
                false
            );
            ?>
        </div>
        <? if ($USER->isAdmin()): ?>
            <div class="form-group">
                <label for="urist">Выбор юриста</label>
                <div id="selectUrist"></div>
            </div>
        <? endif; ?>
        <input name="urist" type="hidden"
               value="<?= (!$USER->isAdmin()) ? $USER->GetID() : $arResult['item']['urist'] ?>">
        <input name="elem" type="hidden" value="<?= $arResult['item']['id'] ?>">
        <input name="iblock" type="hidden" value="<?= $arResult['iblock_id'] ?>">
        <div class="form-group">
            <label for="image">Теги через запятую</label>
            <input type="text" name="tags" class="form-control" id="tags" value="<?= $arResult['item']['tags'] ?>"
                   required>
        </div>
        <div class="form-group">
            <? if ($USER->isAdmin()): ?>
                <button class="sbmt btn btn-success btn-lg">Опубликовать</button>
            <? else: ?>
                <button class="sbmt btn btn-success btn-lg">Отправить на модерацию</button>
            <? endif; ?>
        </div>

    </form>
</div>
<div class="hide tab-content" id="tab2">
    <article class="article">
        <header>
            <h1 id="tab_name" class="article_title"><?= $arResult['item']["name"]; ?></h1>
        </header>
        <div class="content-text block-shadow">
            <div class="articles-info">
                <span class="datePublished"><?= (isset($arResult['item']['date'])) ? $arResult['item']['date'] : date('d m Y') ?></span>
                <span class="author">
                    <?
                    if ($USER->isAdmin()):?>
                        <img src="<?= $arResult['selectedUrist']['imageSrc']; ?>"/>
                        <span><?= $arResult['selectedUrist']['text']; ?></span>
                    <?else:?>
                        <img src="<?= $arResult['self']['photo']; ?>"/>
                        <span><?= $arResult['self']['name']; ?></span>
                    <?endif;?>
                </span>
                <a target="_blank" class="info-author link-comment"
                   href="<?= $arResult['jurist_feedbacks']; ?>">Отзывы</a>
                <a target="_blank" class="info-author link-author"
                   href="<?= $arResult['jurist_profile']; ?>">Профиль</a>
            </div>

            <div class="description">
                <p id="tab_preview"><?= $arResult["item"]['preview']; ?></p>
                <img class="detail_picture" src="<?= $arResult["item"]["picture"] ?>"/>
            </div>
            <div id="tab_more-text" class="article_main-content_text">
                <?= $arResult['item']["text"]; ?>
            </div>

            <div id="tab_tags" class="list-articles_tags">
                <?
                $tag_full = explode(",", $arResult['item']["tags"]);
                foreach ($tag_full as $item_tags) { ?>
                    <a>
                        <? echo trim($item_tags); ?>
                    </a>
                <? } ?>
            </div>
        </div>
    </article>
</div>
<script>
    BX.message({
        componentPath: '<?=$componentPath?>'
    });
</script>
<? if ($USER->isAdmin()): ?>
    <script>
        BX.message({
            element: '<?=$arResult['item']['id']?>'
        });
    </script>
    <script>
        var ddData = <?=json_encode($arResult['urists'])?>;

        $('#selectUrist').ddslick({
            data: ddData,
            width: 500,
            height: 500,
            selectText: "Юрист не выбран",
            imagePosition: "left",
            onSelected: function (selectedData) {
                $("input[name='urist']").val(selectedData.selectedData.value)
            }
        });
    </script>
<? endif; ?>
