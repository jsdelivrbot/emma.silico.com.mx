
<!-- Bootstrap -->
<link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
<!-- Fonts -->
<link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}">
@include('flash::message')

<div class="container-fluid">
    {{  Form::open(['action' => ['LocationsController@update', $location], 'class' => 'form-group']) }}
    {{ Form::hidden('_method', 'PUT') }}


    {{--  {!! Form::model($location, ['action' => ['LocationsController@update', $location], 'class' => 'form-group'] ) !!} --}}

    <div class="form-group">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', $location->name, ['class' => 'form-control', 'required' => true]) !!}
        {!! Form::label('capacity', 'Capacidad') !!}
        {!! Form::number('capacity', $location->capacity, ['class' => 'form-control', 'required' => true, 'min' => 1]) !!}
        <button class="btn btn-success btn-block" type="submit">Guardar</button>

    </div>

    {!! Form::close()!!}
</div>
