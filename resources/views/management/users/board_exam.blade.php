@extends('layout')
@section('title')
  Seleccion de exámenes para monitorear
@endsection
@section('content')
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panel-heading">
          <img src="https://www.peppercarrot.com/extras/html/2016_cat-generator/avatar.php?seed={{ Auth::user()->username }}"  height="65px">
          {{Auth::user()->username}}
          <span class="fa-stack fa-3x pull-right">
            <i class="fa fa-calendar-o fa-stack-2x"></i>
            <strong class="fa-stack-1x calendar-text">{{ Carbon::now()->day }}</strong>
          </span>
          <span class="fa-stack fa-2x">
            <i class="fa fa-clock-o fa-stack-2x"></i>
          </span>
          <span>{{ Carbon::now()->hour }}:{{ Carbon::now()->minute }}</span>
          @php
            $source = "/images/".$board->logo()->first()->source ;
          @endphp
          <span><img src="{{ $source }}" alt="" width="65px">{{ $board->name }}</span>
        </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-4">
          <div class="container-fluid">
            @foreach ($board->exams as $exam)
              <div class="col-sm-3 text-center">
                <div class="panel">
                <span class="fa-stack fa-3x pull-right">
                  <i class="fa fa-user-o fa-stack-2x"></i>
                  <strong class="fa-stack-1x calendar-text">

                  </strong>
                </span>
                <a href="{{ route('passwordsPdf', ['exam' => $exam->id]) }}" target="_blank">{{ $exam->applicated_at }}</a>
              </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <div class="panel-footer">
      </div>

      </div>
    </div>
  </div>
@endsection
