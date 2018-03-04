
<!-- Bootstrap -->
<link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
<!-- Fonts -->
<link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}">
@include('flash::message')

<div class="container-fluid">
        {{  Form::open(['action' => ['UsersController@update', $user], 'files' => true, 'class' => 'form-group']) }}
    {{ Form::hidden('_method', 'PUT') }}


    {{--  {!! Form::model($location, ['action' => ['UsersController@update', $location], 'class' => 'form-group'] ) !!} --}}

    <div class="form-group">
        {!! Form::label('identifier', 'Folio') !!}
        {!! Form::text('identifier', $user->identifier, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
        @if ($errors->has('identifier'))
            <span class="help-block">
                    <strong>{{ $errors->first('identifier') }}</strong>
                </span>
        @endif
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', $user->name, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
        @if ($errors->has('name'))
            <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
        @endif
        {!! Form::label('last_name', 'Apellidos') !!}
        {!! Form::text('last_name',$user->last_name, ['class' => 'form-control', 'required' => true]) !!}
        @if ($errors->has('last_name'))
            <span class="help-block">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
        @endif
        {!! Form::label('completion_year', 'Año de egreso') !!}
        {!! Form::text('completion_year',$user->completion_year, ['class' => 'form-control', 'required' => true]) !!}
        @if ($errors->has('completion_year'))
            <span class="help-block">
                    <strong>{{ $errors->first('completion_year') }}</strong>
                </span>
        @endif
        @if ($errors->has('avatar'))
                <span class="help-block">
                        <strong>{{ $errors->first('avatar') }}</strong>
                </span>
        @endif
        {!! Form::label('avatar','Fotografía') !!}
        <div class="panel">
                @if($user->avatar->first())
                        <img style="height: 150px;" src="{{ asset('images/avatars/users/'.$user->board_id."/".$user->avatar->first()->source) }}">
                @endif
        </div>
        {!! Form::file('avatar') !!}
        <hr>
        {!! Form::select('board_id', \EMMA5\Board::all()->pluck('name', 'id'), $user->board->id, ['class' => 'form-control', 'required' => true]) !!}
        @if ($errors->has('board'))
                <span class="help-block">
                        <strong>{{ $errors->first('board') }}</strong>
                </span>
        @endif
        <hr>
        {!! Form::label('center', 'Sede formativa') !!}
        {!! Form::select('center_id', \EMMA5\Center::orderBy('name')->get()->pluck('name', 'id'), $user->center->id, ['class' => 'form-control', 'required' => true]) !!}
        @if ($errors->has('center'))
                <span class="help-block">
                        <strong>{{ $errors->first('center') }}</strong>
                </span>
        @endif
        <button class="btn btn-success btn-block" type="submit">Guardar</button>

    </div>

    {!! Form::close()!!}
</div>
