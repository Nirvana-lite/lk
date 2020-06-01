$(function () {
    var namelike = 'comment_like',
        namedislike = 'comment_dislike';

    $('.ratingstock').likeDislike({
        initialValue: 0,
        reverseMode: false,
        likeBtnClass: namelike,
        dislikeBtnClass: namedislike,
        disabledClass: 'disabled',
        click: function (value, l, d, event) {

            var idelement = parseInt($(this.element).attr("data-id")),
                idblock = parseInt($(this.element).attr("data-bl")),
                namepr = $(this.element).attr("data-namepr"),
                postfun = null,
                showbtn = null,
                parentclass = this,
                classelem = $(this.element);
            if ($(event.target).hasClass(namelike)) {
                postfun = 1;
                showbtn = "yes";
            }
            if ($(event.target).hasClass(namedislike)) {
                postfun = 2;
                showbtn = "no";
            }
            var likes = $(this.element).find('.comment_likes');
            var dislikes = $(this.element).find('.comment_dislikes');
            $.ajax({
                url: pathajaxlk + '/ajax.php',
                type: 'post',
                data: {idblock: parseInt(idblock), idelement: parseInt(idelement), postfun: parseInt(postfun), namepr: namepr},
                success: function (response) {
                    BX.setCookie('like_comment'+idelement, '1', {expires: 86400});
                    res = $.parseJSON(response);
                    likes.text(res.LIKE);
                    dislikes.text(res.DISLIKE);
                    classelem.find(".animatbl.comment_" + showbtn).addClass("fade");
                }
            });
            this.readOnly(true);
        }
    });
});