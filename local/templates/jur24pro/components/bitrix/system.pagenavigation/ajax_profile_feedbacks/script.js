$(document).ready(function(){

    $(document).on('click', '.load_more', function(){

        var targetContainer = $('ul.comments'),          //  Контейнер, в котором хранятся элементы
            url =  $('.load_more').attr('data-url');    //  URL, из которого будем брать элементы

        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function(data){

                    //  Удаляем старую навигацию
                    $('.load_more').remove();

                    var elements = $(data).find('ul.comments > li'),  //  Ищем элементы
                        pagination = $(data).find('.load_more');//  Ищем навигацию

                    targetContainer.append(elements);   //  Добавляем посты в конец контейнера
                    $(targetContainer).parent().find('.nav:first').html('').append(pagination); //  добавляем навигацию следом

                }
            })
        }

    });

});