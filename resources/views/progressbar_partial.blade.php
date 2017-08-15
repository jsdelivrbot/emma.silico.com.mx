<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="70"
          aria-valuemin="0" aria-valuemax="100" style="width:{{ $width }}%; background-color: #669A66;">
    <span class="" style="">
    {{--  $with and $text--}}
    @if($text != null)
      {{ $text }}
      @endif
    </span>
  </div>
  <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{ 100-$width }}%; background-color: #C06D6B; ">
</div>