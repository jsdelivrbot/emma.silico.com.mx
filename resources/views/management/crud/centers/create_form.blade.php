<!-- Bootstrap -->
<link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
<!-- Fonts -->
<link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}">
@include('flash::message')

<div class="container-fluid">
{{--    {{  Form::open(['action' => ['CentersController@store'], 'method' => 'patch', 'class' => 'form-group']) }}--}}
    {{ Form::open(array('url' => 'centers')) }}
    <div class="form-group">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', '', ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
        @if ($errors->has('name'))
            <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
        @endif
        {!! Form::label('short_name', 'Nombre corto') !!}
        {!! Form::text('short_name', '', ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
        @if ($errors->has('name'))
            <span class="help-block">
                    <strong>{{ $errors->first('short_name') }}</strong>
            </span>
        @endif
        <button class="btn btn-success btn-block" type="submit">Guardar</button>

    </div>
</div>
