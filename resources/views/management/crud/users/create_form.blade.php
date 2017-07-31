
<!-- Bootstrap -->
<link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
<!-- Fonts -->
<link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}">

<div class="container-fluid">
    {{--Form::open(['action' => 'LocationsController@store', 'class' => 'form-inline'])--}}

    {{-- Form::model($location, ['route' => ['locations.store', $location->id]]) --}}
    {!! Form::model($user, ['action' => 'UsersController@store']) !!}

    <div class="form-group">
        <div class="col-md-6">
            {!! Form::label('name', 'Nombre') !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        {!! Form::label('last_name', 'Apellidos') !!}
        {!! Form::text('last_name', '', ['class' => 'form-control', 'required' => true]) !!}

        <button class="btn btn-success" type="submit">Guardar</button>

    </div>

    {!! Form::close()!!}
</div>

