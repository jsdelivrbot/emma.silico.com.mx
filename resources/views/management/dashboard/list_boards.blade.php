@extends('layout')

@section('title')
  Administrar Exámenes
@stop
@section('content')
  <div class="container">
    <div class="row">
      @role('admin')
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
            <img src="https://www.peppercarrot.com/extras/html/2016_cat-generator/avatar.php?seed={{ Auth::user()->username }}" alt="{{ Auth::user()->username }}" height="65px">
            {{Auth::user()->username}}
            <span class="fa-stack fa-3x pull-right">
              <i class="fa fa-calendar-o fa-stack-2x"></i>
              <strong class="fa-stack-1x calendar-text">{{ Carbon::now()->day }}</strong>
            </span>
            <span class="fa-stack fa-2x">
              <i class="fa fa-clock-o fa-stack-2x"></i>
            </span>
            <span>{{ Carbon::now()->hour }}:{{ Carbon::now()->minute }}</span>
            <div>
            </div>
          </div>

          <div class="panel-body text-left">
            @foreach ($boards as $board)
              <div class="row">
                <div class="col-sm-1">
                  {{ $board->short_name }}
                </div>
                <div class="col-sm-9">
                  {{ $board->name }}
                </div>
                <div class="col-sm-2 btn-group btn-group-xs">
                  <a href="/uploadUsers/{{ $board->id }}" class="btn btn-default btn-xs">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                  </a>
                  <a href="{{ route('monitorExams', ['board' => $board->id]) }}" class="btn btn-default">
                    <i class="fa fa-file"></i>
                  </a>
                  <a href="{{ route('userslist', ['board' => $board->id]) }}" class="btn btn-default">
                    <i class="fa fa-cloud-download" aria-hidden="true"></i>
                  </a>
                    {{-- <a href="{{ route('usersAvatars', ['board' => $board->id]) }}" class="btn btn-default">
                      <i class="fa fa-cloud-download" aria-hidden="true"></i>
                    </a> --}}
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      @endrole
    </div>
  </div>
@endsection
@section('footer')

@stop
