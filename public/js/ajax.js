/**
 * Created by marcosantana on 29/09/16.
 */
/**
 * Esta función proveé el funcionamiento básico de ajax para borrar un "cat quote".
 * Afecta al docuemto completo $(document) y a partir de ahí obtiene la clase del botón que fue presionado para obtener el id del elemento padre
 * Busca el formulario oculto #form-delete para hacer la petición de borrar al controlador
 * Manda data serializado como parte del formulario
 * Solicita confirmación de borrado via js
 * Altera el css y el html del documento
 * Hace la solicitud enviando el url que armamos y los datos serializados
 */
$(document).ready(function () {
        $('#quotes-list').on('click', ".button-delete", function () {
        var row = $(this).parents('li');
        var id = row.data('id');
        var form = $('#form-delete');
        var url = form.attr('action').replace(':QUOTE_ID', id);
        var data = form.serialize();
        row.addClass("list-group-item-danger");
        if (confirm("Are you sure you want to delete this quote?")) {
            $.post(url, data, function (result) {
                row.removeClass("list-group-item-danger");
                row.addClass("list-group-item-info");
                row.fadeOut(6400);
                row.text(result);
            })
        }
        else {
            alert('Operation cancelled!');
        }


    })


})
function createQuote() {
    var form = $('#quote-create');
    var data = form.serialize();
    var quote_label =  $("label[for='quote-textarea']");
    var quote_ta = $('#quote-create textarea'); //Quote textarea (ta)
    var form_group = $('#quote-form-group');
    var crfs_token = $('form input:hidden[name="_token"]').val();
    var host_url = location.protocol + '//' + location.host;
    var new_list_item = '<li data-id=":quote_id" class="list-group-item list-group-item-success" style="padding-bottom: 10px; transition:.3s ease-in-out;">'+
        ':quote_text' +
        '<div class="clearfix">'+
            '<a class="btn btn-sm btn-primary pull-right" href="/quotes/:quote_id/edit">'+
                '<span class="glyphicon glyphicon-pencil"></span>'+
            '</a>'+
            '<a href="#!" class="btn btn-sm btn-danger pull-right button-delete">'+
                '<span class="glyphicon glyphicon-trash"></span>'+
            '</a>'+
            '<a href="#" class="badge pull-right hidden-lg">'+
            '</a>'+
        '</div>'+
        '<form method="POST" action="'+host_url+'/quotes/:QUOTE_ID" accept-charset="UTF-8" id="form-delete"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="'+crfs_token+'">'+
        '</form>'+
        '</li>';

    form.addClass("has-info");
    //Validation
    // if (!quote_ta.val()>10){
    //     form_group.addClass('has-error');
    //     quote_label.text('The quote must be 10 characters long at least');
    //     quote_label.addClass('has-danger');
    //     flash('danger', 'The quote must be 10 characters long at least', true);
    // }
    var url = form.attr('action');
    console.log(url);
    $.post(url, data,  function (result) {
        new_list_item = new_list_item.replace(/:quote_id/g, result);
        new_list_item = new_list_item.replace(':quote_text', quote_ta.val());
        console.log(new_list_item);
        $('.list-group').append(new_list_item);
        form_group.removeClass('has-error');
        form_group.addClass('has-success');
        quote_label.text(result);
        flash('info', result, true);
        quote_ta.val('');
        console.log(result);
        setTimeout(function() {
            form_group.removeClass('has-success');
            quote_label.fadeOut();
            $( "li" ).last().removeClass('list-group-item-success');
        }, 1600);
    })
    // $.post(url, data, function (result) {
    //     form.addClass("has-warning");
    // })
    // $('#quote-create textarea').val('Blah');

}

$(document).ready(function () {
    var navbar_height = $('.description_panel').height();
    console.log(navbar_height);
    $('#items-list').css("padding-top", +navbar_height+"px");
})

