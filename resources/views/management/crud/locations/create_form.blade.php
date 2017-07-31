
<!-- Bootstrap -->
<link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
<!-- Fonts -->
<link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}">

<div class="container-fluid">
    {{--Form::open(['action' => 'LocationsController@store', 'class' => 'form-inline'])--}}

    {{-- Form::model($location, ['route' => ['locations.store', $location->id]]) --}}
    {!! Form::model($location, ['action' => 'LocationsController@store']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', '', ['class' => 'form-control', 'required' => true]) !!}
        {!! Form::label('capacity', 'Capacidad') !!}
        {!! Form::number('capacity', '', ['class' => 'form-control', 'required' => true, 'min' => 1]) !!}
        <button class="btn btn-success" type="submit">Guardar</button>

    </div>

    {!! Form::close()!!}
</div>
