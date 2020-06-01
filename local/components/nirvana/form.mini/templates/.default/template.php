<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);?>
<h2 class="main-title">Консультация по Вашему вопросу</h2>
<div class="content-text block-shadow bl_form_center">
    <div class="form-center-desc clearfix">
        <div class="col-md-4">
            <div class="fr_img">
                <div class="fr-center_img"></div>
                <p class="fr_phone">8 800 777 32 63</p>
            </div>
        </div>
        <div class="col-md-8">
            <form id="fr-center_desc" method="POST" action="/jurist-help/">
                <input type="text" name="form_title_test" autocomplete="off" class="form-control"
                       placeholder="Ваш вопрос">
                <textarea name="form_textarea_test" autocomplete="off" class="form-control form_textarea__test"
                          placeholder="Опишите вашу ситуацию"></textarea>
                <button class="form_slide_bottom-sumbit" type="submit">Спросить</button>
            </form>
        </div>
    </div>
</div>