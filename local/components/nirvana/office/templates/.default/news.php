<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$APPLICATION->IncludeComponent(
    "nirvana:questions",
    ".default",
    Array('URIST' => 'office'),
    false
);

$this->setFrameMode(true);
?>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<div class="row" id="lk" v-cloak>
    <main id="mainText" class="main col-md-12">
        <myquestions></myquestions>
    </main>
</div>
<script>
    var app = new Vue({
        el: '#lk',
        data: function () {
            return {
                userInfo: <?=json_encode($arResult['user'])?>,
            }
        },

    })
</script>