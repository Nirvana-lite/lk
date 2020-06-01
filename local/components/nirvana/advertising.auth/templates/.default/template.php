<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true); ?>
<div class="d-flex justify-content-center">
    <div class="card p-1 m-5  w-50" id="regForm" v-cloak>
        <div class="card-header d-flex justify-content-around">
            <h4 :class="[auth ? 'act' : '' ]" @click="changeView(true)">Вход</h4>
            <h4 :class="[!auth ? 'act' : '' ]" @click="changeView(false)">Регистрация</h4>
        </div>
        <div class="card-body">
            <form>
                <template v-if="auth">
                    <div class="form-group">
                        <label for="">Логин</label>
                        <input v-model="info.userLogin" type="text" class="form-control" placeholder="Логин">
                    </div>
                    <div class="form-group">
                        <label for="">Пароль</label>
                        <input v-model="info.userPassword" type="password" class="form-control" placeholder="Пароль">
                    </div>
                    <div class="form-group  d-flex justify-content-center">
                        <button class="btn act btn-lg btn-primary" @click.prevent.stop="authForm()">ВОЙТИ</button>
                    </div>
                </template>
                <template v-else>
                    <div class="form-group">
                        <label for="">Имя</label>
                        <input v-model="info.userName" type="text" class="form-control" placeholder="Имя">
                    </div>
                    <div class="form-group">
                        <label for="">Почта</label>
                        <input v-model="info.userMail" autocomplete="new-password" type="email" class="form-control" placeholder="Почта">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Пароль</label>
                                <input v-model="info.userPassword" type="password" class="form-control" minlength="6" placeholder="Пароль">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Повторите Пароль</label>
                                <input v-model="info.userPassword2" type="password" class="form-control" minlength="6" placeholder="Повторите Пароль">
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <button class="btn act btn-primary" @click.prevent.stop="registerForm()">РЕГИСТРАЦИЯ</button>
                    </div>
                </template>
                <div v-for="error in errors" class="alert alert-danger" role="alert">
                    {{error}}
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    new Vue({
        el: '#regForm',
        data: function () {
            return {
                auth: true,
                info:{
                    userLogin:<?=json_encode($arResult['user']['login'])?>,
                    userName:<?=json_encode($arResult['user']['name'])?>,
                    userMail:<?=json_encode($arResult['user']['mail'])?>,
                    userPassword:'',
                    userPassword2:'',
                },
                errors:[]
            }
        },
        methods:{
            changeView: function (e) {
                this.auth = (e);
                this.errors = []
            },
            authForm: function () {
                this.errors = [];
                let str = new FormData();
                str.append('info[login]', this.info.userLogin);
                str.append('info[password]', this.info.userPassword);
                str.append('info[change]', 'auth');
                axios.post("<?=$componentPath?>/getAuth.php", str)
                    .then((response) => {
                        if (response.data.error){
                            this.errors = response.data.error;
                        }
                        console.log(response.data)
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            registerForm: function () {
                this.errors = [];
                if (this.info.userPassword !== this.info.userPassword2){
                    this.errors.push('Пароли не совпадают')
                    return;
                }
                let str = new FormData();
                str.append('info[name]', this.info.userName);
                str.append('info[mail]', this.info.userMail);
                str.append('info[password]', this.info.userPassword);
                str.append('info[change]', 'reg');
                axios.post("<?=$componentPath?>/getAuth.php", str)
                    .then((response) => {
                        if (response.data.error){
                            this.errors = response.data.error;
                        }
                        console.log(response.data)
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    })
</script>