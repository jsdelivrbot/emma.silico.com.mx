@extends('layout')
@section('content')
  <div class="container panel">
    <div class="panel-heading panel-primary">
      Avance de usuarios
    </div>
    <div class="row panel-body">
      <div class="col-sm-8">
        <table class="table table-responsive table-bordered">
          <tr>
            <th>Estado</th>
            <th>Id</th>
            <th>Folio</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Sede</th>
            <th>Avance</th>
            <th>Calificación</th>
          </tr>
          @foreach ($exam->users->sortByDesc('answers') as $user)
            <tr>
              <td class="text-center">
                <div class="pull-left">
                  @if ($exam->isExtemporaneous($user))
                    <i class="fa fa-hourglass-o" aria-hidden="true"></i>
                  @endif
                  @if ($user->pivot->ended_at)
                    <i class="fa fa-flag-checkered" aria-hidden="true"></i>
                  @endif
                </div>
                <div class="pull-left">
                        @php $filename = $stringy->create($user->name." ".$user->last_name)->toAscii()->toLowerCase()->replace(' ', '_') @endphp
                        <img src="/images/avatars/users/{{$user->board_id."/".$filename}}.jpg" style="width: 50px; " >
                <a href="/monitor/student/{{ $exam->id }}/{{$user->id}}">
                  <img src="{{ Avatar::create($user->name." ".$user->last_name)->toBase64() }}" width="24px" class=""/>
                </a>
              </div>
              </td>
              <td id="user_{{ $user->id  }}">
                      {{ $user->id }}
              </td>
              <td id="identifier_{{ $user->id }}" >
                      {{ $user->identifier }}
              </td>
              <td id="name_{{ $user->id }}">
                {{ $user->name }}
              </td>
              <td id="last_name_{{ $user->id }}">
                {{ $user->last_name }}
              </td>
              <td id="center__{{ $user->id }}">
              @if($user->center)
                {{ $user->center->name }}
              @endif
              </td>
              <td id="stats_{{ $user->id }}" class="text-center">
                <h3>

                  {{ $user->answers->count() }}/ 
                  @if (isset($questions_count))
                  	{{ $questions_count }}
                  @endif 
                </h3>
                @php
                  $grade = $grades->where('id', '=', $user->id)->pluck('points');
                  $points = $grade->get(0, 0);
                @endphp
                @php
                $percentageAnswers = ($user->answers->count() / $questions_count)*100
                @endphp

                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="70"
                  aria-valuemin="0" aria-valuemax="100" style="width:{{$percentageAnswers}}%; background-color: #669A66;">
                  <span class="" style="">
                    {{ $user->answers->count() }}/{{ $questions_count }}
                  </span>
                </div>
                <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{100-$percentageAnswers}}%; background-color: #C06D6B; ">
                </div>
                {{ $grade->get('points') }}
              </td>
              <td class="text-center">
                @php
                $percentageCorrect = round(($points / $questions_count)*100,2)
                @endphp
                <h3>{{ $percentageCorrect/10 }}/10</h3>
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="70"
                  aria-valuemin="0" aria-valuemax="100" style="width:{{$percentageCorrect}}%; background-color: #669A66;">
                  <span class="" style="">
                    {{ $points }}/{{ $questions_count }}
                  </span>
                </div>
                <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{100-$percentageCorrect}}%; background-color: #C06D6B; ">
                </div>
              </td>
          </tr>
        @endforeach
      </table>
    </div>
      <div class="col-sm-4">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">Línea corte</div>
            <div class="col-sm-6">{{ $exam->passing_grade}}</div>
          </div>
          <div class="row">
            <div class="col-sm-6">Media</div>
            <div class="col-sm-6">{{ round($stats->meanAllStudents($exam),2 )}}</div>
          </div>
          <div class="row">
            <div class="col-sm-6">Desviación estándar</div>
            <div class="col-sm-6">{{ round($stats->stdvAllStudents($exam), 2 )}}</div>
          </div>
          <div class="row">
            <div class="col-sm-6">Máximo</div>
            <div class="col-sm-6">{{ $stats->maxAllStudents($exam) }}</div>
          </div>
          <div class="row">
            <div class="col-sm-6">Mínimo</div>
            <div class="col-sm-6">{{ $stats->minAllStudents($exam) }}</div>
          </div>
          <div class="row">
            <div class="col-sm-6">Rango</div>
            <div class="col-sm-6">{{ $stats->rngAllStudents($exam) }}</div>
          </div>
          <div class="row">
            <div class="col-sm-6">Varianza</div>
            <div class="col-sm-6">{{ round($stats->varianceAllStudents($exam) ,2) }}</div>
          </div>
          <div class="row">
            <div class="col-sm-6">Índice de confiabilidad</div>
            <div class="col-sm-6">{{ round($stats->alpha($exam), 2 )}}</div>
            <!--<div>
              <code>numReact/(numReact-1)*1-sum(pq)/prom(varianzaExam)</code>
            </div>-->
          </div>
        </div>
      </div>
  </div>
</div>
@endsection
@section('footer')

@endsection
