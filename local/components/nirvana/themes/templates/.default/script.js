$(function () {

    let componentPath = BX.message('componentPath');

    $('.add-text-city').on('click', function () {
        var btncity = this,
            TextInsertCity = ' {city} ';
        var inserelement = $(btncity).parent().find('input,textarea');
        if (inserelement.is("input")) {
            $(inserelement).focus().val($(inserelement).val() + TextInsertCity);
        } else if (inserelement.is("textarea")) {
            if(inserelement.attr('id') == 'text-element') {
                tinymce.activeEditor.insertContent(TextInsertCity);
            } else {
                $(inserelement).focus().val($(inserelement).val() + TextInsertCity);
            }
        }
    });


    $("#form_add_section").off();
    $("#form_add_section").submit(function(e) {
        e.preventDefault();
        var formtg = this;
        var form_data = new FormData(this);

        $.ajax({
            url : `${componentPath}/saveInfo.php`,
            type: 'POST',
            data : form_data,
            contentType: false,
            cache: false,
            processData:false
        }).done(function(response){
            var ajdata = $.parseJSON(response);
            var message = ajdata.TEXT;
            if (ajdata.ACTIVE == 'N'){
                $('.messages').addClass('error');
            }else if (ajdata.ACTIVE == 'Y'){
                $('p.counter .col_simvol').html('0');
                $(formtg).trigger('reset');
                $('.messages').addClass('success');
            }else{
                $('.messages').addClass('error');
                message ='<p>Произошла ошибка</p>';
            }
            $('.messages').show();
            $('.messages .show_text').html(message);


        });
    });

    $('#description-section').on('blur, keyup', function() {
        $('p.counter .col_simvol').html( $(this).val().length );
    });

    $("#title-section").bind("paste", function(e){
        // access the clipboard using the api
        var pastedData = e.originalEvent.clipboardData.getData('text');

        $("#h1-section").val(pastedData);
        $("#tags-section").val(pastedData);

        pastedData = pastedData.replace('{city}',' ');
        $.trim(pastedData);
        $("#name-section").val(pastedData);

    } );

});