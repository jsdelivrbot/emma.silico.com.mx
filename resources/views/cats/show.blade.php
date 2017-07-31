@extends('layout')

@section('title')
    Cat number {{ $cat->id }}
@stop
@section('content')
    <div class="nav navbar-fixed-top panel description_panel">
        This cat name is: {{ $cat->name }}
        <img class="kitten-profile-image"  src="http://loremflickr.com/320/240?random={{ $cat->id }}">
        <div class="pull-right">
            <a href="{{ url('/cats') }}" class="btn btn-info">Cat index</a>
        </div>
            <div id="flash" class="alert alert-dismissible hidden" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Warning!</strong> Better check yourself, you're not looking too good.
            </div>
    </div>
    <ul id="items-list"  class="list-group">
        <li class="list-group-item  list-group-item-info">
            Kitty Quotes
        </li>
        @foreach($cat->quotes as $quote)
            <li data-id="{!! $quote->id !!}" class="list-group-item" style="padding-bottom: 10px; transition:.3s ease-in-out;">
                {{ $quote->quote }}
                <div class="clearfix">
                    <a class="btn btn-sm btn-primary pull-right" href="{{ url('/quotes/'. $quote->id .'/edit') }}">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    <a href="#!" id='delete-button_{!! $quote->id !!}' class="btn btn-sm btn-danger pull-right button-delete">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                    <a href="#" class="badge pull-right hidden-lg">
                        <small>{!! createAcronym($quote->user->name) !!}</small>
                    </a>
                    <a href="#" class="badge pull-right hidden-xs hidden-md">
                        <small>{!! $quote->user->name !!}</small>
                    </a>
                </div>
                {!! Form::open(['route' => ['quotes.destroy', ':QUOTE_ID'], 'method' => 'DELETE', 'id' => 'form-delete'])!!}
                {!! Form::close() !!}
            </li>
        @endforeach
    </ul>

    <hr color="black">
    <form method="POST" action="/cats/{{ $cat->id }}/quotes" id="quote-create">
        <div id="quote-form-group" class="form-group form-inline">
            <label class="control-label" style="background-color: white;" for="quote-textarea"></label>
            <textarea class="form-control" name="quote" placeholder="AJAX Cat Quote" required id="quote-textarea" data-validation="length alphanumeric" data-validation-length="min10" data-validation-length="3-200"></textarea>
            {{--<button type="submit" class="btn btn-success">Create Cat Quote</button>--}}
        </div>
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    </form>
    <button type="" class="btn btn-success button-create" onclick="createQuote()">Create AJAX Cat Quote</button>

    {{--{!! Form::open( ['route' => ['quotes.create', $cat->id], 'method' => 'CREATE', 'id' => 'quote-create']) !!}--}}
    {{--<div id="quote-form-group"  class="form-group">--}}
        {{--<label class="control-label" style="background-color: white;" for="quote-textarea"></label>--}}
        {{--<textarea class="form-control" name="quote" placeholder="AJAX Cat Quote" required id="quote-textarea"></textarea>--}}
    {{--</div>--}}
    {{--{!! Form::close() !!}--}}

@stop
@section('scripts')
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

