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
          @include('admin_header_partial')

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
