@extends('layout')
@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-10 col-md-offset-1">
              <div class="panel panel-default">
                  <div class="panel-heading">Creación de examen</div>
                  @role('admin')
                    <div class="panel-heading">Admin!!</div>
                  @endrole
                  <div class="panel-body">
                    <div class="row">
                        {{ Form::open(['url' => 'exam/upload', 'files'=>true, ]) }}
                      <div class="col-sm-5 form-group">
                        <table class="table">
                          <tr>
                            <td>Número de casos</td>
                            <td>
                              <input class="form-control" type="number" name="slots_number" min="1" placeholder="Casos" value="{{old('slots_number')}}">
                            </td>
                          </tr>
                          <tr>
                            <td>¿Contiene viñeta?</td>
                            <td>
                              <div class="checkbox">
                                <label><input type="checkbox" value="1" name="vignetteHas">Si</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Preguntas por caso</td>
                            <td>
                              <input class="form-control" type="number" name="questions_number" min="1" max="15" placeholder="Preguntas" value="{{old('questions_number')}}">
                            </td>
                          </tr>
                          <tr>
                            <td>Distractores por pregunta</td>
                            <td>
                              <input class="form-control" type="number" name="distractors_number" min="1" max="15" placeholder="Distractores" value="{{old('distractors_number')}}">
                            </td>
                          </tr>
                          <tr>
                            <td>Consejo</td>
                            <td>
                              {{ Form::select('board_id', $boards, null, array('placeholder' => 'Seleccione un consejo', 'class' => 'form-control', 'value' => old('board_id'))) }}
                            </td>
                          </tr>
                          <tr>
                            <td>Fecha y hora de aplicación</td>
                            <td>
                                <div class='input-group date' id='datetimepicker3' >
                    <input type='text' class="form-control" name="applicated_at" value="{{old('applicated_at')}}" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                              <small>Formato 24hrs.</small>
                            </td>
                          </tr>
                          <tr>
                            <td>Duración</td>
                            <td>
                              <input class="form-control" type="number" name="duration" min="0" value="{{old('duration')}}">
                            </td>
                          </tr>
                          <tr>
                            <td>Anotaciones (descripción)</td>
                            <td>
                              <input class="form-control" type="text" name="annotation" min="0" value="{{old('annotation')}}">
                            </td>
                          </tr>
                          <tr>
                            <td>Archivo</td>
                            <td>
                              {!! Form::file('exam_csv') !!}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" class="text-center">
                              <button class="btn btn-info" type="submit">
                                <i class="fa fa-file-text-o"></i>
                                Crear examen
                              </button>
                            </td>
                          </tr>
                        </table>
                      </div>
                        {{ Form::close() }}
                      <div class="col-sm-7">
                        <div class="doc-preview">

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
@endsection
@section('footer')

@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/locale/es.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
            $(function () {
                $('#datetimepicker3').datetimepicker({
                  inline: true,
                  locale: 'es',
                  stepping: 10,
                  format: 'YYYY-MM-DDThh:mm',
                  //format: 'd/mm/yyyy h:mm'
                //sideBySide: true,
                  //showMeridian: true,
                  showClose: true,
                  //todayBtn: true
                });
            });
        </script>
@endsection
