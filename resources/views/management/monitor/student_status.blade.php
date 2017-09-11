@extends('layout')
@section('content')
  <div class="container">
    <div class="panel-heading panel-primary">
      Avance de usuario
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="col-sm-4">
          <div class="pull-left">
            <a id="users_{{$user->id}}" href="#!" class="btn btn-block btn-sm btn-info edit_button">Editar</a>
            <a href="/monitor/student/{{ $exam->id }}/{{$user->id}}">
              <img src="{{ $user->photo() }}" width="100px" class=""/>
            </a>
          </div>
        </div>
        <div class="col-sm-8">
            <p><h1 class="text-left">{{ $user->full_name() }}</h1></p>
            <p><h3 class="text-left"><small>{{ $user->center ? $user->center->name : "" }}</small></h3></p>
            <p><h3 class="text-left">Año de egreso: <small>{{ $user->completion_year }}</small>
                @if ($exam->isExtemporaneous($user))
                    <i class="fa fa-hourglass-o" aria-hidden="true"></i>
                @endif</h3>
            </p>
        </div>
      </div>
    <div class="col-sm-6">
        @php
            $percentageAnswers = round(($user->answers->count() / $questions_count)*100,2)
        @endphp
        <h2 class="text-left">Avance:</h2>
        <h3 class="text-left"><small>{{ $user->answers->count() }} contestadas / {{ $questions_count }} preguntas</small></h3>
        <!-- Progress progress-bar duh! -->
        <div class="progress">
          <div class="progress-bar" role="progressbar" aria-valuenow="70"
          aria-valuemin="0" aria-valuemax="100" style="width:{{$percentageAnswers}}%; background-color: #669A66;">
          <span class="" style="">
            {{ $percentageAnswers }}%
          </span>
        </div>
        <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{100-$percentageAnswers}}%; background-color: #C06D6B; ">
          {{ $user->answers->count() }}/{{ $questions_count }}
        </div>
    </div>
      <!-- end Progress progress-bar -->
      <hr>
      @php
      $percentageGrade = round(($grade / $questions_count)*100,2)
      @endphp
        <h2 class="text-left">Calificación:</h2>
        <h3 class="text-left"><small>{{ $grade }} correctas / {{ $questions_count }} preguntas</small></h3>
        <!-- Grade progress_bar -->
      <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="70"
        aria-valuemin="0" aria-valuemax="100" style="width:{{$percentageGrade}}%; background-color: #669A66;">
        <span class="" style="">
          {{ round( ($grade / $questions_count)*100, 2) }} %
        </span>
      </div>
      <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{100-$percentageGrade}}%; background-color: #C06D6B; ">
        {{100-$percentageGrade}}%
      </div>
    </div>
        <!-- end Grade progress_bar -->
    <div class="">
      <h2 class="text-left">Tiempo:</h2>
      <h3 class="text-left"><small>{{ $examTime  }}' empleados / {{ $exam->duration }}' total</small></h3>
    </div>
    @php
      $percentageTime = round(($examTime / $exam->duration)*100,2)
    @endphp
    <div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="70"
      aria-valuemin="0" aria-valuemax="100" style="width:{{$percentageTime}}%; background-color: #C06D6B;">
      <span class="" style="">
      {{ $percentageTime }}%
      </span>
    </div>
    <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{100-$percentageTime}}%; background-color: #669A66; ">
      {{  100-$percentageTime }}%
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6 panel text-justify">
    <h3>Hora de inicio:
      <small class="pull-right">{{ Carbon::parse($status->started_at)->toTimeString() }}<br><small>({{ Carbon::parse($status->ended_at)->toDateString() }})</small></small>
    </h3>
    <h3>Respuesta más reciente:
            <small class:"pull-right">{{ Carbon::parse($latestAnswer)->toTimeString() }}</small>
    </h3>
    @if ($status->ended_at != null )
        <h3>Hora de término:
          <i class="fa fa-flag-checkered" aria-hidden="true"></i>
          <small class="pull-right">{{ Carbon::parse($status->ended_at)->toTimeString() }}<br><small>({{ Carbon::parse($status->ended_at)->toDateString() }})</small></small>
        </h3>
          @if ($exam->passing_grade != NULL)
            @if ($grade >= $exam->passing_grade )
              <div class="alert-success">
                <h1>Aprobado</h1>{{ $grade -$exam->passing_grade }} puntos sobre la línea de corte
              </div>
            @elseif ($grade < $exam->passing_grade )
              <div class="alert-danger">
                <h1>Reprobado</h1>{{ $exam->passing_grade -  $grade }} puntos debajo de la línea de corte
              </div>
            @endif
          @endif
        @endif
        <div class="alert-{{ $examTime > $exam->duration ? "danger" : "success" }}">

        <h3>Tiempo consumido:
            <small class="pull-right">{{ $examTime }} minutos </small>
        </h3>
          </div>

    </div>
          <div class="col-sm-6">
            <div class="text-left" >
              <table class="table table-condensed table-bordered table-stripped">
                  <thead>
                    <th>Tema</th>
                    <th>Preguntas</th>
                    <th>Aciertos</th>
                    <th>Fallos</th>
                  </thead>
              @foreach($subjectsScore as $subjectScore)
                  {{--Must create a callback to print teh result for the given subject 
                    don't forget to print the amount of questions vs the amount of anwers given and the % of success --}}
                    @php
                        $questionsInSubject = $questionsInExam->where('text', $subjectScore->text)->first();
                    @endphp
                    <tr>
                        <td>
                            {{ $subjectScore->text }}
                        </td> 
                        <td>
                            {{ $questionsInSubject->questionsNumber }}
                        </td>
                        <td>
                            {{ $subjectScore->points }}
                        </td>
                        @php
                            //dd($questionsInExam->where('text', $subjectScore->text)->first()->questionsNumber);
                        @endphp
                        <td> 
                            {{ $questionsInExam->where('text', $subjectScore->text)->first()->questionsNumber - $subjectScore->points }}
                        </td>
                    </tr>
              @endforeach
              <tr class="info">
                  <td>Total</td>
                <td>{{ $exam->questionsBySubject()->sum('questionsNumber') }}</td>
                <td>{{ $grade }}</td>
                <td>{{ $exam->questionsBySubject()->sum('questionsNumber') - $grade }}</td>
              </tr>
              </table>
              <!-- end subjects table -->
            </div>
          </div>
    </div>
      @include('management.crud.modal_partial')

    </div>
