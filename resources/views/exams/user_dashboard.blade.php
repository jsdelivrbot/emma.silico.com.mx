@extends('layout')
@section('title')
{{ $user->name }}
@endsection
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          @php
            $source = "images/".$user->board->logo()->first()->source ;
          @endphp
          <img src="{{ $source }}" class="thumbnail kitten-profile-image" alt="{{ Helper::createAcronym($user->board->name) }}">
            <div class="panel-heading text-center">{{ $user->board->name }}</div>
        </div>
      </div>
    </div>
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                      <div class="panel-body">
                        <div class="row">
                          <div class="row">
                            <div class="col-sm-4">
                              <img src="{{$user->photo()}}" class="thumbnail kitten-profile-image" />
                            </div>
                            <div class="col-sm-8">
                                    <div class="panel">
                                            <h3>{{ $user->name }} {{ $user->last_name }}<small>{{ $user->birth }}</small></h3>
                                    </div>
                            </div>
                          </div>
                          <div class="clearfix">
                                  <div class="col-sm-6 text-left">
                                          <div class="panel panel-default">
                                                  <div class="panel-heading">
                                                          <h3 class="panel-title">Datos de examen</h3>
                                                  </div>
                                                  <div class="panel-body">
                                                          <table class="table">
                                                                  @foreach ($user->exams as $exam)
                                                                          @if ($exam)
                                                                                <tr>
                                                                                        <td>Consejo</td>
                                                                                        <td>{{$exam->board->name}}</td>
                                                                                </tr>
                                                                                  <tr>
                                                                                          <td>Fecha de aplicación</td>
                                                                                          <td>{{ Carbon::createFromFormat('Y-m-d H:i:s', $exam->applicated_at)->format('Y-m-d') }}</td>
                                                                                  </tr>
                                                                                  <tr>
                                                                                          <td>Hora de aplicación</td>
                                                                                          <td>{{ Carbon::createFromFormat('Y-m-d H:i:s', $exam->applicated_at)->format('H:i:s') }}</td>
                                                                                  </tr>
                                                                                  @php
                                                                                          $status = $user->exams->find($exam->id)->pivot;
                                                                                  @endphp
                                                                                  @if ($status->started_at)
                                                                                          <tr>
                                                                                                  <td>Hora de inicio</td>
                                                                                                  <td>{{ Carbon::createFromFormat('Y-m-d H:i:s', $status->started_at)->format('H:i:s') }}</td>
                                                                                          </tr>
                                                                                  @endif
                                                                                  <tr>
                                                                                          <td>Duración</td>
                                                                                          <td> {{ $exam->duration }} minutos</td>
                                                                                  </tr>
                                                                                  <tr>
                                                                                          <td>Elementos</td>
                                                                                          <td>{{ $exam->slots->count() }}</td>
                                                                                  </tr>
                                                                                  <tr>
                                                                                          <td>Preguntas</td>
                                                                                          <td>
                                                                                                  {{ $exam->questions_count() }}
                                                                                          </td>
                                                                                  </tr>
                                                                                  <tr>
                                                                                          {{ Form::open(['url' => '/exams/start']) }}
                                                                                          {{ Form::hidden('exam_id', $exam->id) }}
                                                                                          {{ Form::hidden('user_id', $user->id) }}
                                                                                          <label for="seat" class="pull-left">
                                                                                                  Número de equipo/asiento
                                                                                          </label>
                                                                                          <td colspan="2">
                                                                                                  <div class="panel panel-footer">
                                                                                                          {{--<input class="form-control pull-right" type="number" name="seat" min="1" max="300" placeholder="Número de asiento/computadora" value="{{old('seat')}}">--}}

                                                                                                          <button type="submit" class="btn btn-info"><strong>Comenzar examen</strong></button>
                                                                                                          {{ Form::close() }}
                                                                                                  </div>
                                                                                          </td>
                                                                                  </tr>
                                                                          @endif
                                                                  @endforeach
                                                          </table>
                                                  </div>

                                          </div>
                                  </div>
                                  <div class="col-sm-6 panel" style="overflow: scroll; height: 50vh;">
                                          <div class="panel panel-heading">
                                                  Instrucciones del examen
                                          </div>
                                          <div class="panel panel-body">
                                                  <p><strong>Al dar click en "Comenzar examen" acepto los términos y condiciones de este examen.</strong></p>

                                          </div>
                                  </div>
                          </div>
                        </div>
                      </div>
              </div>
          </div>
      </div>
  </div>
  </div>
@endsection
