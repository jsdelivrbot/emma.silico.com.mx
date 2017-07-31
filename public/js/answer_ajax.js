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

    $('input').click(function () {
        var form = $(this).closest("form");
        console.log(form);
        data = form.serialize();
        var url = form.attr('action');
        //alert(url);
        //alert(form.serialize());
        console.log(url);

        $.post('/answers/'+form.find('answer_id'), data, function (result) {
            console.log(result);
            console.log(result.id);
            $('#alert-div').fadeOut();
            $('#alert-div #alert_content').html("Procesando respuesta");
            $('#alert-div').addClass('alert-info')
            if (result.id){
                $('#alert-div').fadeIn(1500);
                //$('.alert-div').append("respuestas");
                $('#alert-div #alert_content').html("Respuesta guardada: "+result.key);
                $('#alert-div').fadeOut('slow');
            }
        } );

        $('input:not(:checked)').parentsUntil('.list-group-item').removeClass("list-group-item-info").css('border-radius', '10px');
        $('input:checked').parentsUntil('.list-group-item').addClass("list-group-item-info").css('border-radius', '10px');
    });
});
//comentario de prueba
