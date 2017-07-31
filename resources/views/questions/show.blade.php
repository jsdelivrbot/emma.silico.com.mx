@extends('layout')

@section('title')
    Cat number {{ $question->id }}
@stop
@section('content')
    <div class="nav navbar-fixed-top panel description_panel">
        <h1>{{ $question->question }}</h1>
        <div class="pull-right">
            <a href="{{ route('questions.index') }}" class="btn btn-info">Questions index</a>
        </div>
        <div id="flash" class="alert alert-dismissible hidden" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Warning!</strong> Better check yourself, you're not looking too good.
        </div>
    </div>
    <ul id="items-list"  class="list-group">
        <li class="list-group-item  list-group-item-info">
            elements
        </li>
            <li data-id="{!! $question->id !!}" class="list-group-item" style="padding-bottom: 10px; transition:.3s ease-in-out;">
                {{ $question->question }}
                <div class="panel clearfix">
                    {{--<ul class="list-group">--}}
{{--                        {{ var_dump($options) }}--}}
                        {{--@foreach($options as $option)--}}
                            {{--{{ print_r($option) }}--}}
                        {{--@endforeach--}}
                        {{--{{$options['a'][0]['text']}}--}}
{{--                        {{ $options[0][0]['text'] }}--}}


                    {{--</ul>--}}
                </div>
                <div class="panel clearfix">
                    <ul class="list-group">
                  tras--}}
                    </ul>
                </div>
                <div class="clearfix">
                    <a class="btn btn-sm btn-primary pull-right" href="{{ url('/questions/'. $question->id .'/edit') }}">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    <a href="#!" id='delete-button_{!! $question->id !!}' class="btn btn-sm btn-danger pull-right button-delete">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                    <a href="#" class="badge pull-right hidden-lg">
                        <small>Acronym user</small>
                    </a>
                    <a href="#" class="badge pull-right hidden-xs hidden-md">
                    </a>
                </div>
                {!! Form::open(['route' => ['questions.destroy', ':QUOTE_ID'], 'method' => 'DELETE', 'id' => 'form-delete'])!!}
                {!! Form::close() !!}
            </li>
    </ul>

    <hr color="black">
    <form method="POST" action="/questions/{{ $question->id }}/questions" id="question-create">
        <div id="question-form-group" class="form-group form-inline">
            <label class="control-label" style="background-color: white;" for="question-textarea"></label>
            <textarea class="form-control" name="question" placeholder="AJAX Cat Quote" required id="question-textarea" data-validation="length alphanumeric" data-validation-length="min10" data-validation-length="3-200"></textarea>
            {{--<button type="submit" class="btn btn-success">Create Cat Quote</button>--}}
        </div>
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    </form>
    <button type="" class="btn btn-success button-create" onclick="createQuote()">Create AJAX Cat Quote</button>

    {{--{!! Form::open( ['route' => ['questions.create', $question->id], 'method' => 'CREATE', 'id' => 'question-create']) !!}--}}
    {{--<div id="question-form-group"  class="form-group">--}}
    {{--<label class="control-label" style="background-color: white;" for="question-textarea"></label>--}}
    {{--<textarea class="form-control" name="question" placeholder="AJAX Cat Quote" required id="question-textarea"></textarea>--}}
    {{--</div>--}}
    {{--{!! Form::close() !!}--}}

@stop
@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/ajax.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/ajax.js') }}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script>
        $.validate({
            lang: 'es',
            errorMessagePosition : 'top' // Instead of 'inline' which is default

        });
    </script>
@endsection
@section('footer')

@stop

