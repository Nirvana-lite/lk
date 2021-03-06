<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
$APPLICATION->SetAdditionalCSS("{$templateFolder}/smile.css");
$APPLICATION->IncludeComponent(
    "nirvana:tinymce.nuledit",
    "",
    Array(
        "INIT_ID" => "txtcontent",
        "SHOW_TEXTAREA" => "SHOW_2",
        "TEXT" => "",
        "TEXTAREA_ID" => "content",
        "TEXTAREA_NAME" => "content",
        "TYPE_EDITOR" => "TYPE_2",
        "CACHE_TYPE" => "N"
    )
);
?>
<div id="questions">
    <div class="lists" v-for="(item,key) in items" :key="item.id">
        <div class="form-group">
            <label for="">Обьект комментирования:</label>
            <h5 v-html="item.letter"></h5>
        </div>
        <div class="form-group">
            <label for="">Комментарий:</label>
            <div class="info_comm">
                <div :id=`txt${item.id}` v-html="item.text" class="text">
                </div>
            </div>
        </div>
        <div class="buttons form-group">
            <template v-if="item.view">
                <button class="btn btn-primary" @click.prevent="saveInfo(key,item.id)">Активировать</button>
                <button class="btn btn-warning" @click.prevent="editInfo(key,item.id)">Редактировать</button>
            </template>
            <template v-else>
                <button class="btn btn-primary" @click.prevent="preSave(key,item.id)">Сохранить</button>
                <button class="btn btn-warning" @click.prevent="closeedit(key,item.id)">Предпросмотр</button>
            </template>
            <button class="btn btn-danger" @click.prevent="delItem(key)">Удалить</button>
        </div>
    </div>
</div>

<script>
    new Vue({
        el: '#questions',
        data: function () {
            return {
                items: <?=json_encode($arResult)?>,
            }
        },
        methods: {
            createAnsw: function (answ, text = 'Комментарий успешно активирован') {

                let div = document.createElement('div');

                if (answ === 'done') {
                    div.className = 'answer done';
                    div.innerHTML = text;
                } else {
                    div.className = 'answer error';
                    div.innerHTML = answ;
                }
                document.body.append(div);
                setTimeout(() => div.remove(), 2000);

            },
            preSave: function (key, id_textarea) {
                this.items[key].text = $('#txt' + id_textarea).html();
                let str = new FormData();
                str.append('change', 'change');
                for (let item in this.items[key]) {
                    if (item !== 'answer') {
                        str.append(`question[${item}]`, this.items[key][item]);
                    }
                }
                this.sendInfo(str,'presave','Комментарий успешно сохранен');
                this.closeedit(key, id_textarea);
            },
            saveInfo: function (key, id_textarea) {
                this.items[key].text = $('#txt' + id_textarea).html();
                let str = new FormData();
                str.append('change', 'save');
                for (let item in this.items[key]) {
                    if (item !== 'answer') {
                        str.append(`question[${item}]`, this.items[key][item]);
                    }
                }
                this.sendInfo(str,key);
            },
            editInfo: function (key, itemId) {
                this.items[key].view = !this.items[key].view;
                this.initredactor(itemId);
            },
            closeedit: function (key,id_textarea) {
                tinymce.remove(`txt${id_textarea}`);
                $('div.text').removeClass('trueedit').removeAttr('spellcheck').removeAttr('style').attr('contenteditable',false);
                $('.btn-control-ed').remove();
                this.items[key].view = !this.items[key].view;
            },
            initredactor: function (id_text_redactor) { // включение редактора и выключение
                var idtext = '#txt' + id_text_redactor;
                var oldtext = $('#txt' + id_text_redactor).html();

                $(idtext).attr('contenteditable',true);

                var text = "<div id='getcon290s'>" + oldtext + "</div>";

                var textdom = $.parseHTML(text);

                var arr = ["gif", "pngstick", "emoji"];

                $(textdom).find('span').each(function (index, texts) {
                    var classelement = $(this).attr('class').split(' ');


                    if ($.inArray($.trim(classelement[0]), arr) > -1) {

                        var srcimg = $('span.' + classelement[0] + '.' + classelement[1]).css('background-image');
                        srcimg = srcimg.replace(/url\(("|')(.+)("|')\)/gi, '$2');

                        var dubclass = 'wysiwyg_smile';
                        if ($.trim(classelement[0]) == 'emoji') {
                            dubclass = 'wysiwyg_smile wysiwyg_emoji';
                        }

                        var x = document.createElement("IMG");
                        x.setAttribute("src", srcimg);
                        x.setAttribute("class", dubclass);
                        x.setAttribute("unselectable", "on");
                        x.setAttribute("title", $.trim(classelement[0]) + ' ' + $.trim(classelement[1]));

                        return texts.replaceWith(x);
                    }


                });
                $(idtext).html(textdom[0].innerHTML);

                $(idtext).addClass("trueedit");
                tinymce.init({
                    selector: idtext,
                    theme: false,
                    inline: true,
                    plugins: false,
                    toolbar: false,
                    menubar: false,
                    formats: false,
                    extended_valid_elements: 'span[*],a[*],div[*]',
                    valid_children: 'a[div|img]',
                    force_br_newlines: true,
                    force_p_newlines: false,
                    forced_root_block: '',
                    cleanup: false,
                    relative_urls: false,
                    convert_urls: false,
                    remove_script_host: false,
                    entity_encoding: 'raw', // remove &nbsp;
                    setup: function (editor) {

                        editor.on('init', function () {
                            editor.focus();
                            editor.selection.select(editor.getBody(), true);
                            editor.selection.collapse(false);
                        });
                        editor.on('keydown', function (e) {
                            if ((e.keyCode == 8 || e.keyCode == 46) && editor.selection) { // button backspace-8 or delete-46
                                var selectedNode = tinymce.activeEditor.selection.getNode(); // get the selected node (element) in the editor

                                if (selectedNode && selectedNode.nodeName == 'IMG') {
                                    var pr = $(selectedNode).parents('a');
                                    if (pr.hasClass("video")) {
                                        $(pr).remove();
                                    }
                                } else if (selectedNode && selectedNode.nodeName == 'DIV') {
                                    // remove quote'
                                    if ($(selectedNode).hasClass("quote") && $(selectedNode).text().trim() === '') {
                                        $(selectedNode).remove();
                                    }
                                    // remove video backspace
                                    if ($(selectedNode).hasClass("media") && $(selectedNode).parents('a').hasClass("video")) {
                                        $(selectedNode).parents('a.video').remove();
                                    }
                                }
                            }

                        });
                    }
                });

                return false;

            },
            delItem: function (key) {
                let str = new FormData();
                let ansId = this.items[key].id;
                str.append('change', 'del');
                str.append('question[id]', ansId);
                this.sendInfo(str,key, 'Комментарий успешно удален')
            },
            sendInfo: function (str,key, text = 'Комментарий успешно активирован') {
                axios.post("<?=$componentPath?>/saveInfo.php", str)
                    .then((response) => {
                        if (response.data) {
                            this.createAnsw('done',text);
                            if (typeof key !== 'string'){
                                this.items.splice(key, 1);
                            }
                        } else {
                            this.createAnsw('Что-то пошло не так...')
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }

    })
</script>

