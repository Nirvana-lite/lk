<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);

if ($_POST['page'] == 'next') {
    $APPLICATION->RestartBuffer();
    echo json_encode($arResult);
    die();
}
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
if ($arParams['ALL'] == true):
?>
    <div class="container" id="questions">
        <div class="row lists" v-for="(item,key) in items" :key="item.id">
            <div class="col-md-12 answ">
                <div class="form-group"><h2>Вопрос</h2></div>
                <div class="form-group">
                    <label for="">Название вопроса:</label>
                    <template v-if="item.view">
                        <div class="info_comm" v-html="item.name"></div>
                    </template>
                    <template v-else>
                        <div class="info_comm">
                            <input  class="form-control" type="text" v-model="item.name">
                        </div>
                    </template>
                </div>
                <div class="form-group">
                    <label for="">Текст вопроса:</label>
                    <div class="info_comm">
                        <div :id=`txt${item.id}` v-html="item.text" class="text">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Раздел вопросы:</label>
                    <div class="info_comm">
                        <template  v-if="item.view">
                            <div v-html="item.section"></div>
                        </template>
                        <template v-else>
                            <select v-model="item.section" class="form-control">
                                <option v-for="section in sections" :selected="item.section == section" v-html="section"></option>
                            </select>
                        </template>
                    </div>
                </div>
                <div class="buttons form-group">
                    <template v-if="item.view">
                        <button class="btn btn-primary" @click.prevent="saveInfo(key)">Активировать</button>
                        <button class="btn btn-warning" @click.prevent="editInfo(key)">Редактировать</button>
                    </template>
                    <template v-else>
                        <button class="btn btn-primary" @click.prevent="preSave(key)">Сохранить</button>
                        <button class="btn btn-warning" @click.prevent="closeedit(key)">Предпросмотр</button>
                    </template>
                    <button class="btn btn-danger" @click.prevent="delItem(key)">Удалить</button>
                </div>
            </div>
        </div>
        <div class="pages" v-html="pages"></div>
        <div class="loading"><div class='spinner-wrapper'><img  class='loadimgfr' src='/local/loading.gif'></div></div>
    </div>
    <script>
        new Vue({
            el: '#questions',
            data: function () {
                return {
                    items: <?=json_encode($arResult['items'],true)?>,
                    sections:<?=json_encode($arResult['sections'])?>,
                    pages: <?=json_encode($arResult['pages'])?>
                }
            },
            methods: {
                clc: function(){
                    let urlMore = document.querySelector('.load_more').dataset.url;
                    BX.ajax({
                        url: urlMore,
                        data: {'page': 'next'},
                        method: 'POST',
                        dataType: 'json',
                        timeout: 1,
                        async: false,
                        processData: true,
                        scriptsRunFirst: false,
                        emulateOnload: true,
                        start: true,
                        cache: false,
                        onsuccess: (data => this.addItem(data)),
                        onfailure: function () {
                        }
                    });
                },
                createAnsw: function (answ, text = 'Вопрос успешно активирован') {

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
                preSave: function (key) {
                    this.items[key].text = $('#txt' + this.items[key].id).html();
                    let str = new FormData();
                    str.append('change', 'change');
                    for (let item in this.items[key]) {
                        if (item !== 'answer') {
                            str.append(`question[${item}]`, this.items[key][item]);
                        }
                    }
                    this.sendInfo(str, 'presave', 'Вопрос успешно сохранен');
                    this.closeedit(key);
                },
                saveInfo: function (key) {
                    this.items[key].text = $('#txt' + this.items[key].id).html();
                    let str = new FormData();
                    str.append('change', 'save');
                    for (let item in this.items[key]) {
                        if (item !== 'answer') {
                            str.append(`question[${item}]`, this.items[key][item]);
                        }
                    }
                    this.sendInfo(str, key);
                },
                editInfo: function (key) {
                    this.items[key].view = !this.items[key].view;
                    this.initredactor(key);
                },
                delItem: function (key) {
                    let str = new FormData();
                    let ansId = this.items[key].id;
                    str.append('change', 'del');
                    str.append('question[id]', ansId);
                    this.sendInfo(str, +key, 'Ответ успешно удален')
                },
                sendInfo: function (str, key, text = 'Вопрос успешно активирован') {
                    axios.post("<?=$componentPath?>/saveInfoQuestion.php", str)
                        .then((response) => {
                            console.log(response.data);
                            if (response.data) {

                                this.createAnsw('done', text);
                                if (typeof key !== 'string') {
                                    // console.log(typeof this.items);
                                    // this.items.splice(key, 1);
                                    Vue.delete(this.items, key);
                                }
                            } else {
                                this.createAnsw('false')
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                },
                initredactor: function (key) { // включение редактора и выключение
                    var idtext = '#txt' + this.items[key].id;
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
                        gecko_spellcheck:true,
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
                closeedit: function (key) {
                    tinymce.remove(`txt${this.items[key].id}`);
                    $('div.text').removeClass('trueedit').removeAttr('spellcheck').removeAttr('style').attr('contenteditable', false);
                    $('.btn-control-ed').remove();
                    this.items[key].view = !this.items[key].view;
                },
                getNextPage: function(urlMore){
                    BX.ajax({
                        url: urlMore,
                        data: {'page': 'next'},
                        method: 'POST',
                        dataType: 'json',
                        timeout: 1,
                        async: false,
                        processData: true,
                        scriptsRunFirst: false,
                        emulateOnload: true,
                        start: true,
                        cache: false,
                        onsuccess: (data => this.addItem(data)),
                        onfailure: function () {
                        }
                    });
                },
                scroll(person) {
                    let loadingImage = "";
                    let loadingClass = document.querySelector(".loading");
                    window.onscroll = () => {
                        let tp = window.pageYOffset + loadingClass.getBoundingClientRect().top;
                        let wp = window.pageYOffset + document.documentElement.clientHeight;
                        if (tp < wp) {
                            loadingClass.className = 'loading hideMore';
                            let urlMore = document.querySelector('.load_more').dataset.url;
                            this.getNextPage(urlMore);
                            this.$nextTick(function () {
                                loadingClass.className = 'loading';
                            })
                        } else {
                            return false;
                        }

                    };
                },
                addItem: function (arr) {
                    this.pages = arr.pages;
                    for (let itm in arr.items) {
                        this.items.push(arr.items[itm])
                    }
                },
            },
            mounted() {
                this.scroll(this.items);
            }
        });
    </script>
<?php
else:
?>
<div class="container" id="questions">


    <div class="row card mb-3" v-for="(item,key) in items" :key="item.id">
        <div class="col-md-12 answ">
            <div class="form-group"><h2>Вопрос</h2></div>
            <div class="form-group">
                <label for="">Название вопроса:</label>
                <input spellcheck="true" class="form-control" type="text" v-model="item.name">
            </div>
            <div class="form-group">
                <label for="">Текст вопроса:</label>
                <div v-if="item.view" v-html="item.text" class="text"></div>
                <textarea spellcheck="true" v-else v-model="item.text" class="form-control" cols="30" rows="5"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <h2>Ответ</h2>
            </div>
            <div class="answers card mb-3" v-for="(answer,index) in item.answer">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">ФИО:</label>
                            <input class="form-control" type="text" v-model="answer.user.name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Должность:</label>
                            <input class="form-control" type="text" v-model="answer.user.prop">
                        </div>
                    </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Текст ответа:</label>
                        <div class="info_comm">
                            <div :id=`txt${answer.id}` v-html="answer.text" class="text">
                            </div>
                        </div>
                    </div>
                    <div class="buttons form-group">
                        <template v-if="item.view">
                            <button class="btn btn-primary" @click.prevent="saveInfo(key,index)">Активировать</button>
                            <button class="btn btn-warning" @click.prevent="editInfo(key,index)">Редактировать</button>
                        </template>
                        <template v-else>
                            <button class="btn btn-primary" @click.prevent="preSave(key,index)">Сохранить</button>
                            <button class="btn btn-warning" @click.prevent="closeedit(key,index)">Предпросмотр</button>
                        </template>
                        <button class="btn btn-danger" @click.prevent="delItem(key,index)">Удалить</button>
                    </div>
                </div>
            </div>
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
            preSave: function (key, ansIndex) {
                this.items[key].answer[ansIndex].text = $('#txt' + this.items[key].answer[ansIndex].id).html();
                let str = new FormData();
                str.append('change', 'change');
                for (let item in this.items[key]) {
                    if (item !== 'answer') {
                        str.append(`question[${item}]`, this.items[key][item]);
                    }
                }
                for (let answer in this.items[key].answer[ansIndex]) {
                    str.append(`answer[${answer}]`, this.items[key].answer[ansIndex][answer]);
                    if (typeof this.items[key].answer[ansIndex][answer] == 'object') {
                        for (let usr in this.items[key].answer[ansIndex][answer]) {
                            str.append(`answer[${answer}][${usr}]`, this.items[key].answer[ansIndex][answer][usr]);
                        }
                    }
                }
                this.sendInfo(str, 'presave', 'Ответ успешно сохранен');
                this.closeedit(key, ansIndex);
            },
            saveInfo: function (key, ansIndex) {
                this.items[key].answer[ansIndex].text = $('#txt' + this.items[key].answer[ansIndex].id).html();
                let str = new FormData();
                str.append('change', 'save');
                for (let item in this.items[key]) {
                    if (item !== 'answer') {
                        str.append(`question[${item}]`, this.items[key][item]);
                    } 
                }
                for (let answer in this.items[key].answer[ansIndex]) {
                    str.append(`answer[${answer}]`, this.items[key].answer[ansIndex][answer]);
                    if (typeof this.items[key].answer[ansIndex][answer] == 'object') {
                        for (let usr in this.items[key].answer[ansIndex][answer]) {
                            str.append(`answer[${answer}][${usr}]`, this.items[key].answer[ansIndex][answer][usr]);
                        }
                    }
                }
                this.sendInfo(str, [key, ansIndex]);
            },
            editInfo: function (key, ansIndex) {
                this.items[key].view = !this.items[key].view;
                this.items[key].answer[ansIndex].view = !this.items[key].answer[ansIndex].view;
                this.initredactor(key, ansIndex);
            },
            delItem: function (key, ansIndex) {
                let str = new FormData();
                let ansId = this.items[key].answer[ansIndex].id;
                str.append('change', 'del');
                str.append('answer', ansId);
                this.sendInfo(str, [key, ansIndex], 'Ответ успешно удален')
            },
            sendInfo: function (str, key, text = 'Ответ успешно активирован') {
                axios.post("<?=$componentPath?>/saveInfo.php", str)
                    .then((response) => {
                        if (response.data[0] && response.data[1]) {
                            this.createAnsw('done', text);
                            if (typeof key !== 'string') {
                                this.items[key[0]].answer.splice(key[1], 1);
                                if (this.items[key[0]].answer.length === 0) {
                                    this.items.splice(key[0], 1)
                                }
                            }
                        } else {
                            this.createAnsw('false')
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            initredactor: function (key, ansIndex) { // включение редактора и выключение
                var idtext = '#txt' + this.items[key].answer[ansIndex].id;
                var oldtext = $(idtext).html();
                $(idtext).attr('contenteditable', true);
                $(idtext).attr('spellcheck', true);

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
                    spellcheck: true,
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
                $(idtext).attr('spellcheck', true);
                return false;

            },
            closeedit: function (key, ansIndex) {
                tinymce.remove(`txt${this.items[key].answer[ansIndex].id}`);
                $('div.text').removeClass('trueedit').removeAttr('spellcheck').removeAttr('style').attr('contenteditable', false);
                $('.btn-control-ed').remove();
                this.items[key].view = !this.items[key].view;
                this.items[key].answer[ansIndex].view = !this.items[key].answer[ansIndex].view;
            },
        }
    });
</script>
<?php endif; ?>