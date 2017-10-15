
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

 Vue.component('example', require('./components/Example.vue'));

 const app = new Vue({
     el: 'body'
 });
var Vue = require('vue');
var validator = require('vue-validator');
var resource = require('vue-resource');
window.Vue = Vue;

Vue.use(validator);
Vue.use(resource);


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

$(document).ready(function()
    {
        $('th').click(function(){
            var table = $(this).parents('table').eq(0)
            var rows = table.find("tr:not(:has('th'))").toArray().sort(comparer($(this).index()))
            this.asc = !this.asc
            if (!this.asc){rows = rows.reverse()}
            for (var i = 0; i < rows.length; i++){table.append(rows[i])}
        })
        function comparer(index) {
            return function(a, b) {
                var valA = getCellValue(a, index), valB = getCellValue(b, index)
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
            }
        }
        function getCellValue(row, index){ return $(row).children('td').eq(index).html() }

// additional code to apply a filter
        $('table').each(function(){
            var table = $(this)
            var headers = table.find('th').length
            var filterrow = $('<tr>').insertAfter($(this).find('th:last()').parent())
            for (var i = 0; i < headers; i++){
                filterrow.append($('<th>').append($('<input class="form-control form-horizontal">').attr('type','text').keyup(function(){
                    table.find('tr').show()
                    filterrow.find('input[type=text]').each(function(){
                        var index = $(this).parent().index() + 1
                        var filter = $(this).val() != ''
                        $(this).toggleClass('filtered', filter)
                        if (filter){
                            var el = 'td:nth-child('+index+')'
                            var criteria = ":contains('"+$(this).val()+"')"
                            table.find(el+':not('+criteria+')').parent().hide()
                        }
                    })
                })))
            }
            filterrow.append($('<th>').append($('<input>').attr('type','button').val('Limpiar filtro').click(function(){
                $(this).parent().parent().find('input[type=text]').val('').toggleClass('filtered', false)
                table.find('tr').show()
            })))
        })
    }
);
