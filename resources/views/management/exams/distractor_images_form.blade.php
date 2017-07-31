<!-- Bootstrap -->
<link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
<!-- Fonts -->
<link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}">
@include('flash::message')
{!! Form::open(['url' => 'exam/upload/images', 'method' => 'POST', 'files'=>'true']) !!}
{!! Form::file('images[]', array('multiple'=>true)) !!}
{!! Form::hidden('exam_id', $exam->id) !!}
{!! Form::hidden('model_type', $exam->id) !!}
<button class="btn btn-success btn-block btn-xs" type="submit">Añadir imágenes a la pregunta</button>


{!! Form::close() !!}
