<!-- thumb navigation carousel -->
<div class="col-md-12 hidden-sm hidden-xs" id="slider-thumbs">

    <!-- thumb navigation carousel items -->
    <ul class="list-inline">
        @foreach($slot->images as $image)
            <li>
                <a id="carousel-selector-0" class="selected">
                    <img src="{{ asset('images/'.$image->source) }}" class="img-thumbnail" width="65px" alt="">
                </a>
            </li>
        @endforeach
    </ul>

</div>
<!-- main slider carousel -->
<div class="col-md-12" id="slider">

    <div class="col-md-12" id="carousel-bounding-box">
        <div id="myCarousel" class="carousel">
            <!-- main slider carousel items -->
            <div class="carousel-inner">
                @foreach($slot->images as $image)
                    <div class="item active" data-slide-number="0" style="height:auto;">
                        <a href="{{ asset('images/'.$image->source) }}" class="zoomple">
                            <img src="{{ asset('images/'.$image->source) }}  " alt="" style="width: 100%;">
                        </a>

                    </div>
                @endforeach

            </div>
        </div>
    </div>

</div>

<!--/main slider carousel-->
<script>
        $('#myCarousel').carousel({
    interval: 4000,
    pause: true,
    interval: false
});

// handles the carousel thumbnails
$('[id^=carousel-selector-]').click( function(){
  var id_selector = $(this).attr("id");
  var id = id_selector.substr(id_selector.length -1);
  id = parseInt(id);
  $('#myCarousel').carousel(id);
  $('[id^=carousel-selector-]').removeClass('selected');
  $(this).addClass('selected');
});

// when the carousel slides, auto update
$('#myCarousel').on('slid', function (e) {
  var id = $('.item.active').data('slide-number');
  id = parseInt(id);
  $('[id^=carousel-selector-]').removeClass('selected');
  $('[id=carousel-selector-'+id+']').addClass('selected');
});

    </script>