<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true); ?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<div id="fixed-user-menu">
    <ul>
        <li v-if="!item.main && item.fixed" v-for="item in sidebar"
            :class="[item.main ? 'sidebar-header' : 'sidebar-item']">
            <a class="sidebar-link" :href='item.url'
               :data-description="item.name">
                <i v-if='item.class' :class="[item.class ? item.class : '','fa-2x li_items']"
                   aria-hidden="true"></i>
            </a>
        </li>
        <li class="sidebar-header" onclick="exitLk()">
            <button type="button" class="btn-block close_btn btn btn-primary">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                Выйти
            </button>
        </li>
    </ul>
</div>
<script>
    let fixMenu = new Vue({
        el: '#fixed-user-menu',
        data: function () {
            return {
                file: '',
                userinfo: <?=json_encode($arResult['user'])?>,
                sidebar: <?=json_encode($arResult['sidebar'])?>,
            }
        },
        methods: {
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
        created() {
            for (let item in this.sidebar) {
                this.sidebar[item].name = (this.sidebar[item].changeName) ? this.sidebar[item].changeName : this.sidebar[item].name
            }
        }
    })

</script>
