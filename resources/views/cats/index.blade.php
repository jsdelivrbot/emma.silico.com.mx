@extends('layout')

@section('title')
    Cat Index
@stop
@section('content')
   <!-- <img src="http://lorempixel.com/600/800/cats">
    <img src="http://placebear.com/300/200">
    <img src="http://placeskull.com/170/170">
     <img class="img-circle kitten-profile-image" src="http://placekitten.com/500/500">
-->
   <div class="row">
   @foreach($cats as $cat)
    <div class="col-md-6">
        <div class="panel panel-default kitten_title">
            <div class="panel-heading">
                <h1 class="panel-title"><small>Cat name: </small>{{ $cat->name }}</h1>
                <h3 class="panel-title"><small>Quote count: </small>{{ $cat->quotes->count() }}</h3>
            </div>
            <div class="panel-body">
                <a href="/cats/{{ $cat->id }}">  <img class="kitten-profile-image"  src="http://placeskull.com/170/170"></a>
            </div>
        </div>
    </div>
    @endforeach
   </div>
    <div class="panel">
            <p>Total kitten count {{ $cats->count() }}</p>
        </div>
    </div>
@stop
@section('footer')

@stop
