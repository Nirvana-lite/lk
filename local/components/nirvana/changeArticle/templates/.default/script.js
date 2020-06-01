$(function () {

    $('form.addform').off();
    $("form.addform").submit(function (e) {
        e.preventDefault();
        var form_data = new FormData(this),
            formreset = this;

        $.ajax({
            url: '/local/ajax/ajax_manager/ajax_manager.php',
            type: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false
        }).done(function (response) { //
            var data = $.parseJSON(response);
            if (data.ACTIVE == 'Y') {
                $("form.addform .massege").addClass('suc');
                $(formreset).trigger("reset");
            } else {
                $("form.addform .massege").addClass('error');
            }
            $("form.addform .massege").html(data.MASSEGE);

            setTimeout(function () {
                $("form.addform .massege").removeClass().addClass('massege');
            }, 5000);


        });
    });


    $('#description-element').on('blur, keyup', function () {
        $('p.counter .col_simvol').html($(this).val().length);
    });

    $("#title-element").bind("paste", function (e) {
        // access the clipboard using the api
        var pastedData = e.originalEvent.clipboardData.getData('text');
        $("#name-element").val(pastedData);
        $("#h1-element").val(pastedData);
        $("#tags-element").val(pastedData);
    });

});