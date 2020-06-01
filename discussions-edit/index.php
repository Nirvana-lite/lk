<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
    global $USER;
    if($USER->IsAdmin()) { ?>

    <script>
        var txt, numberpagin;

        var isEmpty = function(data) {
            if(typeof(data) === 'object'){
                if(JSON.stringify(data) === '{}' || JSON.stringify(data) === '[]'){
                    return true;
                }else if(!data){
                    return true;
                }
                return false;
            }else if(typeof(data) === 'string'){
                if(!data.trim()){
                    return true;
                }
                return false;
            }else if(typeof(data) === 'undefined'){
                return true;
            }else{
                return false;
            }
        }

        function showresalt(pageNumber=1){
            txt = $('input.srdisc').val();
            $(window).unbind('scroll');

            if (pageNumber == 1){$('#ajax_dt').html('');}
            if(!isEmpty(txt)) {
                $.ajax({
                    url: '/local/components/d7/discussions/ajax_dt.php',
                    dataType: "json", // Для использования JSON формата получаемых данных
                    method: "POST", // Что бы воспользоваться POST методом, меняем данную строку на POST
                    data: {"txt": txt, "checkdb": 'ert!sd42', 'pageNumber': pageNumber},
                    success: function (data) {
                        if (data['elements'].length > 0) {
                            numberpagin = data['pagin']['pageNumber'];
                            $('.count_elem').html('Найдено: ' + data['pagin']['count']);
                            // console.log(data);
                            $.each(data['elements'], function (key, value) {
                                $('#ajax_dt').append("<li id='res" + value['ID'] + "'><span>" + value['NAME'] + "</span> <button onclick='edit_dt(" + value['ID'] + ");'>Удалить</button></li>")
                            });

                            $(window).bind('scroll', scrollFunction);
                        }

                        /*else {
                            $('.count_elem').html('Найдено: 0');
                            $('#ajax_dt').html('');
                        }*/
                    }
                });
            } else{
                $('.count_elem').html('Найдено: 0');
                $('#ajax_dt').html('');
            }
            return false;
        }

        function edit_dt(el_id){
            var eltxt = $('li#' + el_id + ' span').text();

            var result = confirm("Удалить?\r\n id: " + el_id + "\r\n" + eltxt);
            if (result == true) {
                $.ajax({
                    url: '/local/components/d7/discussions/ajax_dt.php',
                    //dataType: "json", // Для использования JSON формата получаемых данных
                    method: "POST", // Что бы воспользоваться POST методом, меняем данную строку на POST
                    data: {"id_elem": el_id, "fndelem": 'a1@erd#rfs'},
                    success: function (data) {
                        $('#res' + el_id).remove();
                        //console.log(data);
                    }
                });
            }
            return false;
        }

        var scrollFunction = function scrollStuff() {

            var scroll = $(window).scrollTop() + $(window).height();
            var offset = $('#loader').offset().top;

            if (scroll >= offset-500) {
                showresalt(numberpagin);
            }
        }
        
        $(document).ready(function(){
                $(window).scroll(scrollFunction);
        });
    </script>

    <div class="inelem">
        <input class="srdisc" type="text">
        <button onclick="showresalt();">Найти</button>
    </div>
     <div>
         <p class="count_elem"></p>
     </div>
     <ul id="ajax_dt"></ul>
     <div id="loader"></div>

        <style>
            .inelem input{padding: 5px 15px; width: 50%;}
            #ajax_dt {padding: 0 0 0 40px; list-style: decimal;}
            #ajax_dt li {
                border: 1px solid #57729b;
                padding: 10px;
                margin: 5px 0;
            }
            #ajax_dt button, .inelem button{
                padding: 5px 15px;
            }
        </style>

<? }

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
