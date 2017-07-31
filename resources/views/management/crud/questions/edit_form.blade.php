
<!-- Bootstrap -->
<link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
<!-- Fonts -->
<link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}">
@include('flash::message')

<div class="container-fluid">
{{--    {{  Form::open(['action' => ['QuestionController@updateDistractors', $question], 'class' => 'form-group']) }}--}}
    {{  Form::open(['route' => ['questionDistractors', $question], 'class' => 'form-group']) }}

    <div class="form-group">
        {!! Form::label('text', 'Texto '.$question->id) !!}
        {!! Form::textArea('text', $question->text, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
        @if ($errors->has('text'))
            <span class="help-block">
                    <strong>{{ $errors->first('text') }}</strong>
                </span>
        @endif
        <script>
            CKEDITOR.replace( 'text' );
        </script>
        {!! Form::label('order', 'Orden') !!}
        {!! Form::text('order', $question->order, ['class' => 'form-control', 'required' => true]) !!}
        @if ($errors->has('order'))
            <span class="help-block">
                <strong>{{ $errors->first('order') }}</strong>
            </span>
        @endif

    </div>
    <div class="form-group form-horizontal">
        @foreach($question->distractors as $distractor)
            <div class="row">
                <div class="col-sm-1">
                    {!! Form::radio('distractor_correct', $distractor->id, $distractor->correct) !!}
                </div>
                <div class="col-sm-1 container-fluid">
                    {{ $distractor->option}})
                </div>
                <div class="col-sm-10">
                     {!! Form::textArea('distractor_text['.$distractor->id.']', $distractor->distractor, ['class' => 'form-control', 'required' => true, 'id' => $distractor->id]) !!}
                     <script>
                        CKEDITOR.replace( 'distractor_text[{{$distractor->id}}]' );
                     </script>
                </div>
            </div>
        @endforeach
    </div>
        <button class="btn btn-success btn-block" type="submit">Guardar</button>

    {!! Form::close()!!}
</div>
