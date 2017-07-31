@extends('layout')

@section('title')
    Editing quote #{{$quote->id}}
@stop
@section('content')
    <div class="panel-body kitten_description_panel">
        <h1 class="">
            Editing Quote
        </h1>

        {!! Form::open(array('url' => "/quotes/$quote->id", 'method' => 'patch')) !!}
        <div class="form-group form-inline">
            <textarea class="form-control" name="quote" placeholder="Cat Quote">{{ $quote->quote }}</textarea>
            <button type="submit" class="btn btn-success">Update Quote</button>
            <a href="{{ url('/quotes/'.$quote->id.'/delete') }}" onclick="return ConfirmDelete()">
                <span class="glyphicon glyphicon-trash"></span>
                Delete quote
            </a>
            <script>

                function ConfirmDelete()
                {
                    var x = confirm("Are you sure you want to delete?");
                    if (x)
                        return true;
                    else
                        return false;
                }

            </script>
        </div>
        {!! Form::close() !!}
        <a href="/cats/{{ $quote->cat->id }}" class="btn btn-success btn-sm">Return</a>
    </div>
@stop
@section('footer')

@stop
