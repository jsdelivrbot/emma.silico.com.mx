/**
 * Created by marcosantana on 01/12/16
 */
 $( document ).ready(function() {
 	$( ".button-users" ).click(function() {
 		var exam_id = $(this).attr('id');
 		var form = $(this).closest("form");
 		var data = form.serialize();
 		$('#users_list li:not(:first)').remove();
 		$.post( "/exams/users", data,  function(result) {
 			$.each(result, function(key, value){
 				$("#users_list").append('<li class="list-group-item">'+value.last_name+' '+value.name+'</li>');
 			});
    console.log(result.length);
        $('#users_count').text(result.length);
 		});
    $('#grades_chart').empty();

    console.log("grade_chart/"+exam_id.split("_").pop());
    $.ajax({
           url: "exams/grade_chart/"+exam_id.split("_").pop(),
           type: 'GET'
       })
       .done(function( data ) {
           $('#grades_chart').html(data);
      });

      $.ajax({
             url: "exams/top_students/"+exam_id.split("_").pop()+'/5',
             type: 'GET'
         })
         .done(function( data ) {
             $('#top_students').html(data);
        });

        $.ajax({
               url: "exams/bottom_students/"+exam_id.split("_").pop()+'/5',
               type: 'GET'
           })
           .done(function( data ) {
               $('#bottom_students').html(data);
          });

 	});

});
