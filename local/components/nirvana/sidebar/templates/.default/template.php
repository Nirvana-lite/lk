<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
?>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
      integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>

<script>
    Vue.component('sidebar', {
        data: function () {
            return {
                file: '',
                userinfo: <?=json_encode($arResult['user'])?>,
                sidebar: <?=json_encode($arResult['sidebar'])?>,
                adm:<?=json_encode($arResult['adm'])?>,
                avatars:<?=json_encode($arResult['my_avatars'])?>,
                openBlock: false,
                usr: <?=json_encode($arResult['usr'])?>,
                test: <?=json_encode($arResult['test'])?>
            }
        },
        template: `<nav id="sidebar" class="sidebar">
    <div class="sidebar-content">
        <div v-if="!adm" class="sidebar-user">

            <div class="card mb-2">
                <img class="card-img-top" :src="userinfo.photo" alt="Card image cap">
                <div class="card-header">
                    <h3>{{userinfo.name}} {{userinfo.lastName}}</h3>
                </div>
                <div class="card-footer text-muted">
                    <label class="changePhoto">
                        <small><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Изменить фото</small>
                        <input class="hidden" type="file" ref="file" @change="handleFileUpload()"/>
                    </label>
                    <div v-if="usr" class="btn btn-info" @click="openAvas()">Выбрать аватар</div>
                    <div v-if='openBlock' id="openselectava" class="real-hint">
                        <div class="top-hint">
                            <div class="prm-cross"></div>
                        </div>
                        <span  class="hint-caption"><strong>Выберите аватарку</strong></span><br/>
                        <div class="editor_avatars">
                            <div class="avatar" v-for="(imgavatar,keyval) in avatars">
                                <label @click="changeAvas(imgavatar)">
                                    <img class="lazy" :src="imgavatar">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="sidebar-nav">
            <li v-for="item in sidebar" :class="[item.main ? 'sidebar-header' : 'sidebar-item']">
                <template v-if="item.main">
                    <hr>
                    <i v-if='item.class' :class="[item.class ? item.class : '']" aria-hidden="true"></i>
                    {{item.name}}
                </template>
                <template v-else>
                    <a target="_blank" :disabled="item.disabled" class="sidebar-link" :href='item.url'>
                        <i v-if='item.class' :class="[item.class ? item.class : '']" aria-hidden="true"></i>
                        <span class="align-middle">{{item.name}}</span> <span v-if="item.cnt > 0" class="badge badge-secondary">{{item.cnt}}</span>
                    </a>
                </template>
            </li>
            <li class="sidebar-header">
                <button type="button" class="btn-block btn btn-primary" @click="exitLk"><i class="fa fa-sign-out" aria-hidden="true"></i> Выйти</button>
            </li>
        </ul>
    </div>
</nav>`,
        methods: {
            openAvas: function () {
                this.openBlock = !this.openBlock;
            },
            changeAvas: function (urls) {
                this.userinfo.photo = urls;
                event.preventDefault();
                event.stopPropagation();
                let formData = new FormData();
                formData.append('ava', urls);
                axios.post("<?=$this->__component->__path?>/saveAvatar.php", formData);
                this.openAvas();
            },
            viewSetting: function (e) {
                let str = new FormData();
                str.append('PAGE', e);
                axios.post("<?=$this->__component->__path?>/setting.php", str)
                    .then((response) => {
                        $('#mainText').html(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            handleFileUpload: function () {
                this.file = this.$refs.file.files[0];
                let formData = new FormData();
                formData.append('file', this.file);
                axios.post("<?=$this->__component->__path?>/photo.php",
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                    .then(function (response) {
                        console.log(response.data)
                        if (response.data.done === true) {
                            app.userInfo.photo = response.data.photo;
                        }
                    })
                    .catch(function () {
                        console.log('FAILURE!!');
                    });
            },
            exitLk: function () {
                axios.get("<?=$this->__component->__path?>/exitLk.php")
                    .then((response) => {
                        window.location.replace("/");
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
    })

</script>
