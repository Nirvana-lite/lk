<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<div id="app2">
    <form action="">
        <select class="form-control" v-model="forms.prof">
            <option v-for="prof in profs" :value="prof" v-html="prof"></option>
        </select>
        <select class="form-control" v-model="forms.city">
            <option v-for="city in citys" :value="city.NAME" v-html="city.NAME"></option>
        </select>
        <input class="form-control" v-model="forms.name" autocomplete="off" type="text">
        <input class="form-control" v-model="forms.pass" autocomplete="off" type="text">
        <input class="form-control" v-model="forms.confPass" autocomplete="off" type="text">
        <input class="form-control" v-model="forms.mail" autocomplete="off" type="email">
        <button class="form-control"> registration</button>
    </form>
</div>
<script>
   new Vue({
        el: '#app2',
        data: function () {
            return {
                profs:<?=json_encode($arResult['prof'])?>,
                citys:<?=json_encode($arResult['city'])?>,
                forms:{
                    prof: '',
                    city: '',
                    name:'',
                    pass:'',
                    confPass:'',
                    mail:''
                }
            }
        },
       computed:{
            selected: function () {
return{
    text: 'asdasd'
}
            }
       }

    })
</script>

<!--<form method="post">
    <select name="GROUP_USER" id="groupuser" class="select_grop form-control">
        <option value="1"<?/*echo (intval($_REQUEST["GROUP_USER"])==1 ? " selected" : "")*/?>>Пользователь</option>
        <option value="2"<?/*echo (intval($_REQUEST["GROUP_USER"])==2 ? " selected" : "")*/?>>Юрист</option>
        <option value="3"<?/*echo (intval($_REQUEST["GROUP_USER"])==3 ? " selected" : "")*/?>>Юридическая компания</option>
    </select>
    <?/*

    foreach ($arResult["SHOW_FIELDS"] as $FIELD) {
        $placeholder = 'placeholder="' . $array_placeholder[$FIELD] . '"';

        switch ($FIELD) {
            // пароль
        case "PASSWORD":
            */?>
        <input size="30"
               class="form-control<?/*= (!empty($arResult["ERRORS"][$FIELD]) ? " error" : "") */?>" <?/*= $placeholder; */?>
               type="password" name="REGISTER[<?/*= $FIELD */?>]"
               value="<?/*= $arResult["VALUES"][$FIELD] */?>" autocomplete="off" class="bx-auth-input"/>
        <?/*
        if ($arResult["SECURE_AUTH"]): */?>
            <span class="bx-auth-secure" id="bx_auth_secure" title="<?/*
            echo GetMessage("AUTH_SECURE_NOTE") */?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
            <noscript>
				<span class="bx-auth-secure" title="<?/*
                echo GetMessage("AUTH_NONSECURE_NOTE") */?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
            </noscript>
            <script type="text/javascript">
                document.getElementById('bx_auth_secure').style.display = 'inline-block';
            </script>
        <?/* endif */?>
        <?/*
        break;
        // подтверждение пароля
        case "CONFIRM_PASSWORD":
        */?>
        <input size="30"
               class="form-control<?/*= (!empty($arResult["ERRORS"][$FIELD]) ? " error" : "") */?>" <?/*= $placeholder; */?>
               type="password" name="REGISTER[<?/*= $FIELD */?>]"
               value="<?/*= $arResult["VALUES"][$FIELD] */?>" autocomplete="off"/>
        <?/*
        break;
        case "UF_REGION": */?>

            <?/*

            if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):
                $arResult["USER_PROPERTIES"]["DATA"]["UF_REGION"]["SETTINGS"]["LIST_HEIGHT"] = 1;

                if (!empty($arResult["ERRORS"][$FIELD])) { $error = " error";} else {$error = "";}
                $hidestyle ='none';
                if ($arResult["hideinput"]>0) {
                    $hidestyle = 'block';
                }

                foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):
                    $APPLICATION->IncludeComponent(
                        "bitrix:system.field.edit",
                        'my_iblock_element',
                        array(
                            "bVarsFromForm" => $arResult["bVarsFromForm"],
                            "arUserField" => $arUserField,
                            "styleList" => $hidestyle,
                            "classerror" => $error,
                            "form_name" => "regform"),
                        null,
                        array("HIDE_ICONS" => "Y"));

                endforeach;

            endif; */?>
            <?/*
            break;
        default:

        $hidestyle = '';
        if ($arResult["hideinput"]==0) {
            if (in_array($FIELD, $array_hide)) {
                $hidestyle = 'style="display: none;"';
            }

        } else if ($arResult["hideinput"] == 2) {

            if ($FIELD == $array_hide[1]){
                $hidestyle = 'style="display: none;"';
            }

        } else {
            $hidestyle = '';
        }

        */?>
        <input size="30"
               class="form-control<?/*= (!empty($arResult["ERRORS"][$FIELD]) ? " error" : "") */?>" <?/*= $placeholder; */?>
               type="text" <?/*= $hidestyle; */?>
               name="REGISTER[<?/*= $FIELD */?>]"
               value="<?/*= $arResult["VALUES"][$FIELD] */?>"/>


        <?/* } */?>
    <?/* } */?>
    <p>На указанный e-mail придет запрос на подтверждение регистрации</p>
    <input type="hidden" name="g_recaptcha_token" value="">
    <input class="form-control" name="register_submit_button" type="submit"
           onclick="this.form.g_recaptcha_token.value = window.RecObj.getToken();" value="ЗАРЕГИСТРИРОВАТЬСЯ">
</form>
-->