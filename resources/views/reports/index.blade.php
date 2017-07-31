@extends('layout');

@section('title')
    Reportes de examen
@stop
@section('content')
    <div class="container"> 
        <div class="row">
           <div class="col-xs-10 col-xs-offset-1">
               <ul class="list-group text-left">
                   <li class="list-group-item active text-center">
                       <h3>Reportes por Consejo de especialidad</h3>
                   </li>
                   @foreach($boards->sortBy('name') as $board) 
                       @if($board->logo->first())
                           <a href="/reports/board/{{$board->id}}">
                           <li class="list-group-item">
                               <div class="row">
                                   <div class="col-xs-8 ">
                                       {{$board->name}}
                                   </div>
                                   <div class="col-xs-2 text-center">
                                           <img src="images/{{$board->logo->first()->source}}" style="height:35px;">
                                   </div>
                                   <div class="col-xs-2 text-center">
                                   </div>
                               </div>
                           </li>
                           </a>
                       @endif
                   @endforeach
               </ul>
           </div>
        </div>
    </div>
@endsection

