@extends('layout')

@section('title')
    Questions Index
@stop
@section('content')
    <div class="row">
        @foreach($questions as $question)
            <div class="col-md-6">
                <div class="panel panel-default kitten_title">
                    <div class="panel-heading">
                        <h1 class="panel-title"><small>Question: </small>{{ $question->question }}</h1>
                        <h3 class="panel-title"><small>Elements count: </small></h3>
                    </div>
                    <div class="panel-body">
                        <a href="{!! route('questions.show', $question->id) !!}"><button class="btn btn-info">{!! route('questions.show', $question->id) !!}</button> </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="panel">
        <p>Total questions count {{ $questions->count() }}</p>
    </div>
    </div>
@stop
@section('footer')

@stop
