jQuery.exists = function(selector) {
    return ($(selector).length > 0);
}

function CloseMobMenu() {
    while(document.body.attributes.length > 0) {
        document.body.removeAttribute(document.body.attributes[0].name);
    }
    var element=document.getElementById('mob-menu');
    if(element){
        element.remove();
    }
}

function OpenMobMenu() {
    CloseMobMenu();

        var arraySocial = {
            'mob-menu-vk': '#',       // вконтакте
            'mob-menu-facebook': '#', // facebook
            'mob-menu-ok': '#',      // одноклассники
            'mob-menu-twitter': '#',  // twitter
        };
        var menu = mobMenuArray;

        var link_Mobmenu = {
            'phone': ['tel:+78007773263', 'Позвонить'],
            'massege': ['/jurist-help/', 'Задать вопрос'],
            'reg': ['/auth/registration.php', 'Регистрация'],
            'inreg': ['/auth/', 'Войти'],
        }

        var div_Mobmenu = document.createElement('div');
        div_Mobmenu.setAttribute('id', 'mob-menu');

        // white line + phone + close button menu
        var div_MobPhoneClose = document.createElement('div');
        div_MobPhoneClose.setAttribute('class', 'mob-phone');
        div_MobPhoneClose.innerHTML = '8 800 777 32 63<svg class="ham hamRotate ham4 active" viewBox="0 0 100 100" width="42" onclick="CloseMobMenu(); return false;"><path class="line top" d="m 70,33 h -40 c 0,0 -8.5,-0.149796 -8.5,8.5 0,8.649796 8.5,8.5 8.5,8.5 h 20 v -20" /><path class="line middle" d="m 70,50 h -40" /><path class="line bottom" d="m 30,67 h 40 c 0,0 8.5,0.149796 8.5,-8.5 0,-8.649796 -8.5,-8.5 -8.5,-8.5 h -20 v 20" /></svg>';
        div_Mobmenu.appendChild(div_MobPhoneClose);


        // navbar mob menu
        var div_MobNavbar = document.createElement('div');
        div_MobNavbar.setAttribute('class', 'mob-navbar');


        $.each(link_Mobmenu, function (key, value) {
            let linkdop_Mobmenu = document.createElement('a');
            linkdop_Mobmenu.setAttribute('class', 'topbtn-mobmenu mobmenu-' + key);
            linkdop_Mobmenu.setAttribute('href', value[0]);
            linkdop_Mobmenu.innerText = value[1];
            div_MobNavbar.appendChild(linkdop_Mobmenu);
        });

        div_Mobmenu.appendChild(div_MobNavbar);


        // text and menu link
        var div_MobPmenu = document.createElement('p');
        div_MobPmenu.innerText = 'Меню';
        div_Mobmenu.appendChild(div_MobPmenu);

        var div_MobListmenu = document.createElement('div');
        div_MobListmenu.setAttribute('class', 'mob-list-menu');
       // div_MobListmenu.innerHTML = '<ul><li><a href="/"><strong>Главная страница</strong></a></li></ul>';
        div_Mobmenu.appendChild(div_MobListmenu);

        var list = $('<ul></ul>');
        $.each(mobMenuArray, function (key, item) {
            list.append('<li><a href="' + item['link'] + '">' + item['text'] + '</a></li>');
        });

        $(div_MobListmenu).append(list);


        // text and social button
        var div_MobPsocial = document.createElement('p');
        div_MobPsocial.innerText = 'Мы в соц. сетях';
        div_Mobmenu.appendChild(div_MobPsocial);

        var div_MobSocial = document.createElement('div');
        div_MobSocial.setAttribute('class', 'mob-social');

        $.each(arraySocial, function (key, value) {
            let SocLink = document.createElement('a');
            SocLink.setAttribute('class', 'btn-mob-social ' + key);
            SocLink.setAttribute('href', value);
            div_MobSocial.appendChild(SocLink);
        });

        div_Mobmenu.appendChild(div_MobSocial);

        var div_MobClose = document.createElement('div');
        div_MobClose.setAttribute('class', 'mob-close');
        div_MobClose.innerHTML = '<a href="#" onclick="CloseMobMenu(); return false;">Закрыть</a>';
        div_Mobmenu.appendChild(div_MobClose);

        document.body.setAttribute('scroll', 'no');
        document.body.setAttribute('style', 'overflow:hidden!important;');
        setTimeout(function () {
            document.body.appendChild(div_Mobmenu);

        }, 2);

        return false;
}

$(function () {

    CloseMobMenu();
    if(oprisMobile()) {
        $("body").swipe({

            swipeLeft:function(event, direction, distance, duration, fingerCount) {
                if ($.exists('#mob-menu')) {
                    CloseMobMenu();
                }
            },
            swipeRight:function(event, direction, distance, duration, fingerCount) {
                if (!$.exists('#mob-menu')) {
                    OpenMobMenu();
                }
            },
            preventDefaultEvents:false,
            threshold: 100

        });
    }
});