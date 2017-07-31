<div class="col-md-12" id="slider-thumbs">
    <!-- thumb navigation items -->
    <ul class="list-inline">
      @php
        $selected = "selected"
      @endphp
        @foreach($slot->images as $image)
            <li id="image-selector-{{ $image->id }}" class="{{$selected}}">
                <a>
                    <img src="{{ asset('images/exams/'.$slot->exam_id.'/'.$image->source) }}" class="img-thumbnail" width="65px" alt="">
                </a>
            </li>
            @php
              $selected = "idle"
            @endphp
        @endforeach
    </ul>
</div>
<div id="image-container-{{ $slot->id }}" class="" style="height: auto; width:100%; overflow: scroll;">
  @php
    $display = ""
  @endphp
  @foreach($slot->images as $image)
    <div id="image-slide-{{ $image->id }}" class="" style="display:{{ $display }};">
      <a href="{{ asset('images/exams/'.$slot->exam_id.'/'.$image->source) }}" class="zoomple">
                <img  src="{{ asset('images/exams/'.$slot->exam_id.'/'.$image->source) }}  " alt="" style="width: 100%;">
      </a>
    </div>
    @php
      $display = "none"
    @endphp
  @endforeach
</div>
{{--
<script src="{{ asset('js/all.js') }}"></script>
<!-- thumb navigation carousel -->
<div class="col-md-12 hidden-sm hidden-xs" id="slider-thumbs">

    <!-- thumb navigation carousel items -->
    <ul class="list-inline">
      @php
        $selected = "selected"
      @endphp
      @php
        $imageCounter = 0;
      @endphp
        @foreach($slot->images as $image)
            <li>
                <a data-slide-to="{{ $imageCounter }}" id="carousel-selector-{{ $imageCounter }}" class="{{$selected}}">
                    <img src="{{ asset('images/exams/'.$image->source) }}" class="img-thumbnail" width="65px" alt="">
                </a>
            </li>
            @php
              $imageCounter++
            @endphp
            @php
              $selected = ""
            @endphp
        @endforeach
    </ul>

</div>
<!-- main slider carousel -->
<div class="col-md-12" id="slider">

    <div class="col-md-12" id="carousel-bounding-box">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- main slider carousel items -->
            <div class="carousel-inner">
              @php
                $imageCounter = 0
              @endphp
              @php
                $active = "active"
              @endphp
                @foreach($slot->images as $image)
                    <div class="item {{$active}}" data-slide-number="{{$imageCounter}}" style="height:auto;">
                        <a href="{{ asset('images/exams/'.$image->source) }}" class="zoomple">
                            <img src="{{ asset('images/exams/'.$image->source) }}  " alt="" style="width: 100%;">
                        </a>

                    </div>
                    @php
                      $imageCounter++
                    @endphp
                    @php
                      $active = ""
                    @endphp
                @endforeach

            </div>
        </div>
    </div>

</div>

<!--/main slider carousel-->


<script>

    </script>
{{--
<!-- thumb navigation carousel -->
<div class="col-md-12 hidden-sm hidden-xs" id="slider-thumbs">

    <!-- thumb navigation carousel items -->
    <ul class="list-inline">
      @php
          $imageCounter = 0
      @endphp
      @php
        $selected = "selected"
      @endphp



        @foreach($slot->images as $image)
            <li>
                <a id="carousel-selector-{{ $imageCounter }}" class="{{$selected}}">
                    <img src="{{ asset('images/exams/'.$image->source) }}" class="img-thumbnail" width="65px" alt="">
                </a>
            </li>
            @php
              $selected = ""
            @endphp
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
                    <div class="item active" data-slide-number="{{ $imageCounter }}" style="height:auto;">
                        <a href="{{ asset('images/exams/'.$image->source) }}" class="zoomple">
                            <img src="{{ asset('images/exams/'.$image->source) }}  " alt="" style="width: 100%;">
                        </a>

                    </div>
                    @php
                        $imageCounter++
                    @endphp
                @endforeach

            </div>
        </div>
    </div>

</div>
--}}
{{--
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
{{-- <script src="{{ asset('js/all.js') }}"></script> --}}

{{-- <div id='carousel-custom' class='carousel' data-ride='carousel'>
    <div class='carousel-outer'>
        <!-- Wrapper for slides -->
        <div class='carousel-inner'>
            @php
                $active = "active"
            @endphp
            @foreach($images as $image)
                <div class='item {{$active}}'>
                    <a href="{{ asset('images/exams/'.$image->source) }}" class="zoomple">
                      <img src="{{ asset('images/exams/'.$image->source) }}  " alt="" style="width: 100%">
                    </a>
                </div>
                @php
                    $active = ""
                @endphp
            @endforeach
        </div>

      </div>

    <!-- Indicators -->
    <ol class='carousel-indicators mCustomScrollbar'>
        @php
            $active = "active"
        @endphp
        @php
            $imageCounter = 0
        @endphp
        @foreach($images as $image)
            <li data-target='#carousel-custom' data-slide-to='{{$imageCounter}}' class='active'>
                <img src="{{ asset('images/exams/'.$image->source) }}" class="img-thumbnail" width="65px" alt="">
            </li>
            @php
                $active = ""
            @endphp
            @php
                $imageCounter++
            @endphp
        @endforeach
    </ol>
</div> --}}
