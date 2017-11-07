<div class="panel" id="slider-thumbs">
      <!-- thumb navigation items -->
      <ul class="list-inline list-group" style="overflow-scrolling: ">
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
  <div id="image-container-{{ $slot->id }}" class="panel"> 

    @php
      $display = ""
    @endphp
    @foreach($slot->images as $image)
      <div id="image-slide-{{ $image->id }}" class="polaroid" style="display:{{ $display }};">
          <div class="">
              <p>{{ $image->caption }}</p>
          </div>
        <a href="{{ asset('images/exams/'.$slot->exam_id.'/'.$image->source) }}" class="zoomple">
                  <img  src="{{ asset('images/exams/'.$slot->exam_id.'/'.$image->source) }}  " alt="" style="width: 100%;">
        </a>
      </div>
      @php
        $display = "none"
      @endphp
    @endforeach
  </div>
