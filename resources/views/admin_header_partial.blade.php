<div class="panel-heading">
  <img src="https://www.peppercarrot.com/extras/html/2016_cat-generator/avatar.php?seed={{ Auth::user()->username }}" alt="{{ Auth::user()->username }}" height="65px">
  {{Auth::user()->username}}
  {{-- Here I want to put the title--}}
  {{-- <span class="fa-stack fa-3x pull-right">
    <i class="fa fa-calendar-o fa-stack-2x"></i>
    <strong class="fa-stack-1x calendar-text">{{ Carbon::now()->day }}</strong>
  </span> --}}
  {{-- <span class="fa-stack fa-2x">
    <i class="fa fa-clock-o fa-stack-2x"></i>
  </span>
  <span>{{ Carbon::now()->toTimeString() }}</span> --}}
</div>
