@extends('layout')
@section('content')
  <div class="container">
    <div class="panel-heading panel-primary">
      Avance de usuarios
    </div>
    <div class="panel">
            <a href="{{ route('gradesSpreadsheet', ['exam' => $exam->id]) }}" class="btn btn-sm btn-primary">
                    Descargar archivo de calificaciones.
                    <i class="fa fa-table" aria-hidden="true"></i>
            </a>
    </div>
        <table id="myTable" class="table table-bordered">
        <thead>
          <tr>
            <th>Estado</th>
            <th>Turno</turno>
            <th>Id</th>
            <th>Folio</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Sede</th>
            <th>Respuestas correctas</th>
            <th>Respuestas entregadas <small>(Avance)</small> </th>
            <th>Porcentaje de acierto</th>
            <th>Porcentaje de avance</th>
          </tr>
          </thead>
          <tbody>
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
                <a href="/monitor/student/{{ $exam->id }}/{{$user->id}}">
                  <img src="{{$user->photo()}}" height="125px" />
                </a>
              </div>
              </td>
              <td>
                {{$user->pivot->turn}}
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
              @php
                  $grade = $grades->where('id', '=', $user->id)->pluck('points');
                  $points = $grade->get(0, 0);
                @endphp
              <td id="stats_{{ $user->id }}" class="text-center"><!-- Respuestas correctas  -->
                  {{ $points }}
              </td>
               @php
                  $percentageAnswers = Helper::percentage($questions_count, $user->answers->count());
                @endphp
                
              <td class="text-center">
                @php
                $percentageCorrect = Helper::percentage($questions_count, $points);
                @endphp
                {{ $user->answers->count() }}
              </td>
              <td>
                {{ $percentageCorrect }}
              </td>
              <td><!-- Porcentaje de avance --> 
              
                {{ $percentageAnswers }}
              </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>

      {{--  <div class="col-sm-4">
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
      </div>  --}}
  </div>
</div>
@endsection
@section('footer')

@endsection
