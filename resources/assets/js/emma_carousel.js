$(document).ready( function () {

  $('[id^=image-selector-]').click( function() {

    var id_image = $(this).attr("id");
    var id = id_image.match(/\d+/);

    $('#image-slide-'+id).siblings().fadeOut("slow");
    $('#image-slide-'+id).fadeIn("slow");

    $("#image-selector-"+id).siblings().addClass("idle").removeClass("selected");

    $("#image-selector-"+id).addClass("selected");
    $("#image-selector-"+id).removeClass("idle");

  });

});
