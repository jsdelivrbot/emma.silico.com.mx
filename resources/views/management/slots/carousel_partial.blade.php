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
                        <a href="http://placeskull.com/1000/1000/800517/1" class="zoomple">
                            <img src="{{ asset('images/'.$image->source) }}  " alt="">
                        </a>

                    </div>
                @endforeach

            </div>
        </div>
    </div>

</div>
<!--/main slider carousel-->
