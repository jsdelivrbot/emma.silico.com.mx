
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

// Vue.component('example', require('./components/Example.vue'));

// const app = new Vue({
//     el: 'body'
// });

function flash(level, text, fadeout) {
    $('#flash').removeClass('hidden').fadeIn(1600).text(text).addClass('alert-'+level);
    if (fadeout){
        $('#flash').fadeOut(6400);
    }
}

/**
 * Created by marcosantana on 15/02/16
 * Creates a twitter/bootstrap modal for editing standar CRUD model
 */
$( document ).ready(function() {
    $( ".edit_button" ).click(function() {
        var arr = $(this).attr('id').split('_');
        var id = arr[1];
        var model = arr[0];
        var loadGif = "<img src='/images/loader.gif'>";

        $('#editModal').modal('show');
        console.log(model+"/"+id);
        $('#editModalBody').html(loadGif);
        $.ajax({
            url: "/"+model+"/"+id+"/edit",
            type: 'GET'
        })
            .done(function( data ) {
                $('#editModalBody').html(data);
            });
    });
});


$(document).ready(function(){
            $('#myTable').DataTable();

});




