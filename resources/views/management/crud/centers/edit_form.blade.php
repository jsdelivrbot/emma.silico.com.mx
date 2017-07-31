<!-- Bootstrap -->
<link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
<!-- Fonts -->
<link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}">
@include('flash::message')

<div class="container-fluid">
    {{  Form::open(['action' => ['CentersController@update', $center], 'class' => 'form-group']) }}
    {{ Form::hidden('_method', 'PUT') }}
    <div class="form-group">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', $center->name, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
        {!! Form::label('short_name', 'Nombre corto') !!}
        {!! Form::text('short_name', $center->short_name, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
        <button class="btn btn-success btn-block" type="submit">Guardar</button>

    </div>
</div>