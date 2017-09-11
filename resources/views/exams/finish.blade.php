@extends('layout')
@section('title')

@endsection
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-4">
            <img src="{{Auth::user()->photo()}}" class="thumbnail kitten-profile-image" />
          </div>
          <div class="col-sm-8">
                  <div class="panel">
                          <h3>{{ Auth::user()->name }} {{ Auth::user()->last_name }}<small>{{ Auth::user()->birth }}</small></h3>
                          <h3><small>{{-- Auth::user()->center->name --}}</small></h3>
                          @php
                                  $percentage = round(($answersCount / $questionsCount)*100, 2)
                          @endphp
                  </div>

          </div>
        </div>
      </div>
      <div class="col-sm-6">
              <div class="container-fluid jumbotron" style="background-color: #D9EDF7">
                      <div class="alert-info">
                              <h1>
                                      @if ((Carbon::parse($examUser->ended_at)->diffInMinutes(Carbon::parse($examUser->started_at)))< $exam->duration)
                                              <h2 class="text-success">Terminó su examen en tiempo reglamentario</h2>
                                      @elseif((Carbon::parse($examUser->ended_at)->diffInMinutes(Carbon::parse($examUser->started_at)))< $exam->duration)
                                              <h2 class="text-danger">Terminó su examen fuera del tiempo reglamentario</h2>
                              </h1>
                      @endif
                      @php
                              $grade = new EMMA5\Grade;
$user = Auth::user();
              @endphp
              @if ($grade->passed($exam,$user) && $exam->passing_grade != 0)
                      <h2 class="text-success">Examen acreditado</h2>
              @elseif ($grade->passed($exam,$user) && $exam->passing_grade != 0)
                      <h2 class="text-warning">Examen no acreditado</h2>
              @endif
              Diríjase a nuestro personal para más instrucciones
                      </div>
                      <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                                           aria-valuemin="0" aria-valuemax="100" style="width:{{$percentage}}%; background-color: #669A66;">
                                      <span class="" style="">{{$percentage}}% Completo</span>
                              </div>
                              <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{100-$percentage}}%; background-color: #C06D6B; ">
                                      {{100-$percentage}}% falta
                              </div>
                      </div>
                      <h3>
                              {{ $answersCount }} de {{ $questionsCount }} preguntas
                      </h3>
                      <p>
                      Examen iniciado a las: {{  Carbon::parse($examUser->started_at)->toTimeString() }}
                      </p>
                      <p>
                      Examen terminado a las: {{ Carbon::parse($examUser->ended_at)->toTimeString() }}
                      </p>
                      <h2>
                              Usó {{ Carbon::parse($examUser->ended_at)->diffInMinutes(Carbon::parse($examUser->started_at)) }} minutos de los {{ $exam->duration }} para terminar su examen.
                      </h2>
              </div>
      </div>
    </div>
  </div>
@endsection
@section('footer')

@endsection
