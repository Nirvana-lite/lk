let arr_li = new Array();
let isOpen = false;


function created_UserMenu(div_UserMenu) {
    let d = $.Deferred();
    setTimeout(function () {
        document.body.appendChild(div_UserMenu);
        d.resolve();
    }, 2);
    return d.promise();
}

function Open_User_Menu(n) {

    document.body.setAttribute('style', (isOpen ? 'overflow-y:scroll;' : 'overflow:hidden!important;'));
    document.body.setAttribute('scroll', (isOpen ? 'yes' : 'no'));
    isOpen = !isOpen;

    if ($('#op-uwser-menu').length > 0) {
        $('#op-uwser-menu').slideToggle("fast");
        return false;
    }

    var div_UserMenu = document.createElement('div');
    div_UserMenu.setAttribute('id', 'op-uwser-menu');
    let end_arr = arr_li.slice(n, arr_li.length);


    var list = $('<ul></ul>');
    list.append(end_arr);
    $(div_UserMenu).append(list);

    var div_ReklamaMenu = document.createElement('div');
    div_ReklamaMenu.setAttribute('id', 'UserMenuOne');
    div_UserMenu.appendChild(div_ReklamaMenu);


    created_UserMenu(div_UserMenu).done(function () {
        $('#op-uwser-menu').slideToggle("fast");

        $('#op-uwser-menu').swipe({
            swipeDown: function (event, direction, distance, duration, fingerCount) {
                $('#op-uwser-menu').slideToggle("fast");
                isOpen = !isOpen;
                while (document.body.attributes.length > 0) {
                    document.body.removeAttribute(document.body.attributes[0].name);
                }
            }
        });
    });
}

function exitLk() {
    fixMenu.exitLk();
}

var getBrowserWidth = function () {
    $("#fixed-user-menu").css("opacity", 1);
    if ($('#fixed-user-menu').length == 0) {
        return false;
    }

    var ul = $('#fixed-user-menu ul').first();
    var li = ul.find('li');
    var n;

    if (innerWidth < 860) {
        // Small Device - xs
        n = 4;
        if (arr_li.length == 0) {
            li.each(function (i) {
               if(i >= n && li[i].querySelector('a')) li[i].querySelector('a').insertAdjacentHTML('beforeend',li[i].querySelector('a').dataset.description);
                arr_li.push(
                    li[i].outerHTML
                );
            });
        }
    } else {
        // Large Device - lg
        $('#op-uwser-menu').remove();
        if (arr_li.length == 0) {
            li.each(function (i) {
                arr_li.push(
                    li[i].outerHTML
                );
            });
        }
        n = arr_li.length;
    }
    var start_arr = arr_li.slice(0, n);
    let html = '';
    if (n < 7) {
        html = "<li><a onclick='Open_User_Menu(" + n + "); return false;' href='javascript:void(0)'><svg class=\"ham hamRotate ham4\" viewBox=\"0 0 100 100\" width=\"42\">\n" +
            "                        <path class=\"line top\" d=\"m 70,33 h -40 c 0,0 -8.5,-0.149796 -8.5,8.5 0,8.649796 8.5,8.5 8.5,8.5 h 20 v -20\"></path>\n" +
            "                        <path class=\"line middle\" d=\"m 70,50 h -40\"></path>\n" +
            "                        <path class=\"line bottom\" d=\"m 30,67 h 40 c 0,0 8.5,0.149796 8.5,-8.5 0,-8.649796 -8.5,-8.5 -8.5,-8.5 h -20 v 20\"></path>\n" +
            "                    </svg></a></li>";
    }

    ul.html(start_arr);
    ul.append(html);
};


window.addEventListener('resize', getBrowserWidth, false);


$(function () {

    getBrowserWidth();
});