/**
 * Created by marcosantana on 02/11/16.
 */


function save_ajax() {
    $('li[name=answer_key]').click(function(event) {
        alert(event.target.id);
    });
}


$(document).ready(function() {
    //alert('Done');

    $('input:checked').parentsUntil('.list-group-item').addClass("list-group-item-info").css('border-radius', '10px');
    //$('.list-group input').addClass('disabled');

    $('input').click(function () {
        var form = $(this).closest("form");
        console.log(form);
        console.log(form.find('answer_id'));
        data = form.serialize();
        var url = form.attr('action');
        //alert(url);
        //alert(form.serialize());
        console.log(url);

        $.post('/answers/store', data, function (result) {
            console.log(result);
            console.log(result.id);
            $('#alert-div').fadeOut('slow');
            $('#alert-div #alert_content').html("Procesando respuesta");
            $('#alert-div').addClass('alert-info')
            if (result.id){
                $('#alert-div').fadeIn('slow');
                //$('.alert-div').append("respuestas");
                $('#alert-div #alert_content').html("Respuesta guardada: "+result.answer);
                $('#alert-div').fadeOut('slow');
                $('input:not(:checked)').parentsUntil('.list-group-item').removeClass("list-group-item-info").css('border-radius', '10px');
                $('input:checked').parentsUntil('.list-group-item').addClass("list-group-item-info").css('border-radius', '10px');
            }
            else{
              $('#alert-div').fadeIn(3000);
              //$('.alert-div').append("respuestas");
              $('#alert-div #alert_content').html("Error almacenando respuesta ");
              $('#alert-div').fadeOut('slow');
            }
        } );


    });
});
