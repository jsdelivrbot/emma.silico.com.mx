
<!-- Bootstrap -->
<link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
<!-- Fonts -->
<link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}">
@include('flash::message')

<div class="container-fluid">
    {{  Form::open(['action' => ['VignettesController@update', $vignette], 'class' => 'form-group']) }}
    {{ Form::hidden('_method', 'PUT') }}


    {{--  {!! Form::model($vignette, ['action' => ['VignettesController@update', $vignette], 'class' => 'form-group'] ) !!} --}}

    <div class="form-group">
        {!! Form::label('text', 'Texto') !!}
        {!! Form::textArea('name', $vignette->text, ['class' => 'form-control', 'required' => true, 'name' => 'text']) !!}
        <script>
            CKEDITOR.replace( 'text' );
        </script>
        <button class="btn btn-success btn-block" type="submit">Guardar</button>

    </div>

    {!! Form::close()!!}
</div>

