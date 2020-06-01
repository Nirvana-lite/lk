<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);

use Bitrix\Main\Page\Asset,
    Bitrix\Main\Context,
    Bitrix\Main\Request;

$request = Context::getCurrent()->getRequest();
if($request->getPost("change") == 'Y'){
    echo json_encode($_REQUEST);
    die();
}

Asset::getInstance()->addString("<script src='https://cdn.jsdelivr.net/npm/vue/dist/vue.js'></script>");
Asset::getInstance()->addString("<script src='https://unpkg.com/axios/dist/axios.min.js'></script>");
Asset::getInstance()->addString("<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>");
Asset::getInstance()->addString("<script src=\"//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js\"></script>");
Asset::getInstance()->addString("<link href=\"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\" rel=\"stylesheet\"
      integrity=\"sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN\" crossorigin=\"anonymous\">");
?>
<div class="newsletter-subscribe mt-5" id="subscribe">
    <div class="">
        <div class="intro">
            <h2 class="text-center newsletter">Подписка на рассылку
                <div class="count">{{subCount}} подписчика</div>
            </h2>
            <p class="text-center">Подпишись и будь в курсе самых новых <b>статей</b> и свежих <b>новостей</b> на нашем
                портале</p>
        </div>
        <template v-if="isSub == 'Y'">
            <div class="alert alert-primary" role="alert">
                <h3>Вы подписаны на рассылку!</h3>
            </div>
        </template>
        <template v-else>
            <form class="form-inline">
                <div class="form-group"><input class="form-control" type="email" v-model="userMail"
                                               placeholder="Ваша почта" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="button" @click="addSub()">Подписаться</button>
                </div>
            </form>
        </template>
        <div v-for="item in items">
            <p><small>{{item.section}} || </small>{{item.name}}</p>
            <hr>
        </div>
    </div>
</div>
<script>
    new Vue({
        el: '#subscribe',
        data: function () {
            return {
                isSub: <?=json_encode($arResult['isSub'])?>,
                userMail: <?=json_encode($arResult['userMail'])?>,
                subCount: <?=json_encode($arResult['subCount'])?>,
                items:<?=json_encode($arResult['items'])?>
            }
        },
        methods: {
            cnt: function(){
                let str = new FormData();
                str.append('count', 'Y');
                axios.post("<?=$componentPath?>/sendClass.php", str)
                    .then((response) => {
                        console.log(response.data)
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            addSub: function () {
                if (this.userMail == ''){
                    return false;
                }
                let str = new FormData();
                str.append('change', 'Y');
                str.append('user_mail', this.userMail);
                axios.post("<?=$componentPath?>/sendClass.php", str)
                    .then((response) => {
                        this.isSub = "Y";
                        // this.isSub = response.data.sub;
                        this.subCount = response.data.cnt;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    })
</script>

