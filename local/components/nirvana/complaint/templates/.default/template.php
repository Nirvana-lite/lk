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
<div id="alarms">
    <div class="row item" v-for="(item,key) in items">
        <div class="col-md-7">
            <h4>Коммент</h4>
            <div class="info_comm">
                <div :id=`txt${item.id}` v-html="item.text" class="text">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <h4>Жалоба</h4>
            <div v-html="item.complaint"></div>
        </div>
        <div class="col-md-2">
            <div class="btn-group-vertical" role="group">
                <template v-if="item.view">
                    <button v-if="item.view" class="btn btn-success" @click="saveItem(key)">Сохранить</button>
                </template>
                <template v-else>
                    <button class="btn btn-success" @click="changeView(key)">Редактировать Коммент</button>
                    <button class="btn btn-danger" @click="delItem(key)">Удалить Коммент</button>
                    <button class="btn btn-warning" @click="delComplaint(key)">Удалить Жалобу</button>
                </template>
            </div>
        </div>
    </div>
</div>
<script>
    new Vue({
        el: '#alarms',
        data: function () {
            return {
                items: <?=json_encode($arResult)?>,
            }
        },
        methods: {
            changeView: function (itemKey) {
                this.items[itemKey].view = !this.items[itemKey].view;
                if (this.items[itemKey].view) {
                    this.initredactor(itemKey);
                } else {
                    this.closeedit(itemKey)
                }
            },
            initredactor: function (itemKey) { // включение редактора и выключение
                var idtext = '#txt' + this.items[itemKey].id;
                var oldtext = $(idtext).html();
                $(idtext).attr('contenteditable', true);

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
            closeedit: function (itemKey) {
                tinymce.remove(`txt${this.items[itemKey].id}`);
                $('div.text').removeClass('trueedit').removeAttr('spellcheck').removeAttr('style').attr('contenteditable', false);
                $('.btn-control-ed').remove();
                this.items[itemKey].view = false;
            },
            preSave: function (itemKey) {
                this.items[itemKey].text = $('#txt' + this.items[itemKey].id).html();
                let str = new FormData();
                str.append('change', 'change');
                for (let item in this.items[itemKey]) {
                        str.append(`question[${item}]`, this.items[itemKey][item]);
                }
                this.sendInfo(str, 'presave', 'Коммент успешно сохранен');
                this.closeedit(itemKey);
            },
            saveItem: function (itemKey) {
                this.items[itemKey].text = $('#txt' + this.items[itemKey].id).html();
                let str = new FormData();
                str.append('change', 'save');
                for (let item in this.items[itemKey]) {
                    str.append(`question[${item}]`, this.items[itemKey][item]);
                }
                this.sendInfo(str, itemKey, 'Коммент успешно сохранен');
                this.closeedit(itemKey);
            },
            delItem: function (itemKey) {
                let str = new FormData();
                str.append('change', 'delItem');
                str.append(`question[id]`, this.items[itemKey].id);
                this.closeedit(itemKey);
                this.sendInfo(str, itemKey, 'Коммент успешно удален')
            },
            delComplaint: function (itemKey) {
                let str = new FormData();
                str.append('change', 'delComplaint');
                str.append(`question[id]`, this.items[itemKey].id);
                str.append(`question[iblock]`, this.items[itemKey].iblock);
                this.closeedit(itemKey);
                this.sendInfo(str, itemKey, 'Жалоба успешно удалена')
            },
            sendInfo: function (str, key, text = 'Ответ успешно активирован') {
                axios.post("<?=$componentPath?>/saveInfo.php", str)
                    .then((response) => {
                        if (response.data) {
                            this.createAnsw('done', text);
                            if (typeof key !== 'string') {
                                this.items.splice(key, 1);
                            }
                        } else {
                            this.createAnsw('false')
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            createAnsw: function (answ, text = 'Ответ успешно активирован') {

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
        }
    })
</script>