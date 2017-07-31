@extends('layout')

@section('title')
    Administrar Exámenes
@stop

@section('content')
    <!--<link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>-->
    <div class="container-fluid">
        <div class="col-md-4"><!--Listado de examenes-->
            <ul id="exams_lists" class="list-group">
                <li class="list-group-item active">
                    Lista de examenes
                </li>
                @foreach($exams as $exam)
                    {{ Form::open(['action' => ['ExamController@users_exam', $exam->id]]) }}
                    {{ Form::hidden('exam_id', $exam->id) }}

                    <li class="list-group-item list-group-item-{{ $exam->active ? "success" : "danger"}}">
                        <p>{{ $exam->id }}</p>
                        <p>{{ $exam->board->name }}</p>
                        <p>{{ $exam->annotation }}</p>
                        <p>{{ $exam->questions_count() }} preguntas</p>
                        <p>{{ $exam->applicated_at }}</p>
                        <p>{{ $exam->duration/60}} horas de duración</p>
                        <a href="#!" id='exam_{{ $exam->id }}' class="btn btn-sm btn-info pull-right button-users">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('exams.show', ['id' => $exam->id])}}">Ver examen</a>
                    </li>

                    {{ Form::close() }}
                @endforeach
            </ul>
        </div><!--/Listado de examenes-->
        <div class="col-md-8"><!--Contenedor de datos de examen-->
            <div class="container-fluid">
                <div class="col-md-4">
                    <div style="height: 60vh; overflow-y: scroll;">
                        <ul id="users_list" class="list-group">
                            <li class="list-group-item active">
                                Lista de usuarios
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Buscar sustentante..." onkeyup="filter(this)">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default disabled" type="button">
                                            <span class="glyphicon glyphicon-filter" aria-hidden="true"></span>
                                        </button>
                                    </span>
                                </div><!-- /input-group -->
                            </li>
                            <li class="list-group-item">

                            </li>
                        </ul>
                    </div>
                </div><!--/col-md-4-->
                <div class="col-md-8" style="">
                    <div class="chart_display container-fluid">
                        <div class="container-fluid"><!-- 1/3 -->
                            <div class="col-md-2">
                                <div class="container-fluid">
                                    <h1 id="users_count"></h1>
                                    <h5>Sustentantes</h5>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div id="grades_chart" class="container-fluid">
                                </div>
                            </div>
                        </div><!-- / 1/3 -->
                        <div class="col-md-2">
                            <div id="high_scores" class="row">
                                <h3>Resultados altos</h3>
                                <div id="top_students"class="col-md-3">
                                    <div id="top_students" class="container-fluid">
                                    </div>
                                </div>
                                <h3>Resultados bajos</h3>
                                <div id="bottom_students" class="col-md-3">
                                    <div id="bottom_students" class="container-fluid">
                                        Test text to be deleted by JS
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/row-->
            </div><!--Contenedor de datos de examen-->
        </div>
    @stop
    @section('footer')

    @stop
