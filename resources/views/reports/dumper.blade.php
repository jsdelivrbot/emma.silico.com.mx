@extends('layout')

@section('title')
    Prueba de salida de dump
@stop
@section('content')
<table class="table table-bordered table-stripped">
<tr>
    <!-- Row with the question id -->
    <td>Pregunta</td>
    @foreach ($stats->examKey() as $questionId => $questionOption)
        <td>
            {{ $questionId }}
        </td>
    @endforeach
</tr>

<tr>
    <!-- Row with the question id -->
    <td>Distractores</td>
    @foreach ($questions as $question)
        <td>
            {{ $question->distractors->count() }}
        </td>
    @endforeach
</tr>
<tr>
<td>Clave</td>
@foreach ($questions as $question)    
        <td>
            {{$question->distractors->where('correct', 1)->pluck('option')->first() }}
        </td>
        @endforeach
</tr>

        <?php start_measure('render', 'Recorrido de usuarios'); ?>
@foreach ($exam->users as $user)
    <?php $userAnswers = $user->answers->where('exam_id', $exam->id); ?>
    <tr>
        <td>{{ $user->identifier }} </td>
        @foreach($stats->examKey() as $questionId => $questionOption)
                {{ dd($userAnswers) }}
           <td> {{ $userAnswers->where('question_id', $questionId)->first()->answer  }} </td> 

        @endforeach
    </tr>
@endforeach

        <?php stop_measure('render') ?>
</table>        
@stop
