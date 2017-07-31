@extends('layout')

@section('title')
    <div class="jumbotron">
        Cats!!
    </div>
@stop
@section('content')

    @foreach($cats as $cat)
        <p>{{ $cat }}</p>
    @endforeach
@stop
