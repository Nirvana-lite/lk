<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule("iblock")) { die();}

use Bitrix\Main\Page\Asset;
Asset::getInstance()->addJs($componentPath ."/tinymce/tinymce.js?".(rand(1,10)));
Asset::getInstance()->addJs($componentPath ."/tinymce/html-formatting.min.js");


$arParams['INIT_ID'];
$arParams['SHOW_TEXTAREA'];

// подключаем сам tinymce



// подключаем настройки tinymce script



// использовать textarea

if($arParams['SHOW_TEXTAREA'] == 'SHOW_1') {

    // подключаем шаблон где встроен texarea
    $this->IncludeComponentTemplate();

}


if($arParams['TYPE_EDITOR'] == 'TYPE_1') {

    // настройки по умолчанию
    ?>
    <script>

        function my_cleanup_callback(type,value) {
            switch (type) {
                case 'get_from_editor':
                    // Remove &nbsp; characters
                    value = value.replace(/&nbsp;/ig, ' ');
                    break;
                case 'insert_to_editor':
                case 'submit_content':
                case 'get_from_editor_dom':
                case 'insert_to_editor_dom':
                case 'setup_content_dom':
                case 'submit_content_dom':
                default:
                    break;
            }
            return value;
        }

        function buttoninit( namecommand, editor, _this ) {
            editor.execCommand(namecommand);
            var state = editor.queryCommandState(namecommand);
            if (state) {
                _this.active(true);
            } else {
                _this.active(false);
            }

            editor.on('NodeChange', function (e) {
                var state = editor.queryCommandState(namecommand);
                if (state) {
                    _this.active(true);
                } else {
                    _this.active(false);
                }
            });
        }

        function buttontwoinit( doublecommand, namecommand, editor, _this ) {
            editor.execCommand(doublecommand, false, namecommand);
            editor.formatter.formatChanged( namecommand, function(state) {
                _this.active(state);
            });
        }


        tinymce.baseURL = "<?=$componentPath.'/tinymce'?>";
        tinymce.init({
            selector: '#content',
            height: 500,
            theme: 'modern',
            menubar:false,
            language: 'ru',
            resize: false,
            statusbar: false,
            elementpath: false,
            branding: false,
            image_advtab: true,
            relative_urls:false,
            remove_script_host : true,
            uploadimage_default_img_class:'picture-discussion',
            object_resizing : false,
            uploadimage_figure:false,
            uploadimage_form_url: '<? echo $componentPath.'/uploadimg.php';?>',
            csrftoken: BX.bitrix_sessid(),
            plugins: [
                "paste,preview,uploadimage,lists"
            ],
            paste_auto_cleanup_on_paste : true,
            paste_postprocess : function(pl, o) {
                var headerRule = {
                    'br': {
                        process: function (node) {
                            var parent = node.parentNode,
                                space = document.createTextNode(' ');

                            parent.replaceChild(space, node);
                        }
                    }
                };

                var valid_elements = {
                    'h1': {
                        convert_to: 'h2',
                        valid_styles: '',
                        valid_classes: '',
                        no_empty: true,
                        valid_elements: headerRule
                    },
                    'h2,h3,h4': {
                        valid_styles: '',
                        valid_classes: '',
                        no_empty: true,
                        valid_elements: headerRule
                    },
                    'p': {
                        valid_styles: 'text-align',
                        valid_classes: '',
                        no_empty: true
                    },
                    /*   a: {
                           valid_styles: '',
                           valid_classes: '',
                           no_empty: true,

                           process: function (node) {
                               var host = 'http://' + window.location.host + '/';
                               if (node.href.indexOf(host) !== 0) {
                                   node.target = '_blank';
                               }
                           }
                       },*/
                    'br': {
                        valid_styles: '',
                        valid_classes: ''
                    },
                    'blockquote,b,strong,i,em,s,strike,sub,sup,kbd,ul,ol,li,dl,dt,dd,time,address,thead,tbody,tfoot': {
                        valid_styles: '',
                        valid_classes: '',
                        no_empty: true
                    },
                    'table,tr,th,td': {
                        valid_styles: 'text-align,vertical-align',
                        valid_classes: '',
                        no_empty: true
                    },
                    'embed,iframe': {
                        valid_classes: ''
                    }
                };

                htmlFormatting(o.node, valid_elements);
            },
            toolbar: 'mybold myitalic myunderline myh2 myblockquote uploadimage numlist preview',
            inline_styles: false,
            entity_encoding : 'raw',
            browser_spellcheck: true,
            gecko_spellcheck: false,
            formats: {
                bold: { inline: 'strong', exact : true },
                italic: { inline: 'em', exact: true },
                underline: { inline: 'u', exact : true },
                h2: { block: 'h2', exact: true }
            },
            content_style: "blockquote { border-left: 2px solid #0000ff54; background: #87cefa38; padding: 5px 5px 5px 10px; margin-left: 20px;}",
            setup: function(editor) {

                editor.on('init', function (evt) {
                  $(evt.target.editorContainer).addClass('redactordiscussion');
                });

                editor.addButton('mybold', {
                    text: 'Жирный',
                    tooltip: 'Жирный текст',
                    subtype: 'myclassbold',
                    icon: false,
                    onclick: function (e) {
                        var _this = this;
                        buttoninit('bold', editor, _this);

                    }
                });

                editor.addButton('myitalic', {
                    text: 'Курсив',
                    tooltip: 'Курсивный текст',
                    subtype: 'myclassitalic',
                    icon: false,
                    onclick: function (e) {
                        var _this = this;
                        buttoninit('Italic', editor, _this);
                    }
                });

                editor.addButton('myunderline', {
                    text: 'Подчеркивание',
                    tooltip: 'Подчеркивание текста',
                    subtype: 'myclassunderline',
                    icon: false,
                    onclick: function (e) {
                        var _this = this;
                        buttoninit('Underline', editor, _this);
                    }
                });

                editor.addButton('myh2', {
                    text: 'Подзаголовок',
                    tooltip: 'Подзаголовок',
                    subtype: 'myclass',
                    icon: false,
                    onclick: function (e) {
                        var _this = this;
                        buttontwoinit( "mceToggleFormat", "h2", editor, _this );
                    }
                });

               editor.addButton('myblockquote', {
                   text: 'Цитата',
                   tooltip: 'Цитата',
                   subtype: 'myclass',
                   icon: false,
                   onclick: function (e) {
                       var _this = this;
                       buttontwoinit( "formatBlock", "blockquote", editor, _this );
                   }
               });
            },
            cleanup_callback: 'my_cleanup_callback'
        });

    </script>

<? } ?>