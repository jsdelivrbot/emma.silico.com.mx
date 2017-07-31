@extends('layout')

@section('title')
    Análisis de rectvos
@stop
@section('content')
    <div class="content">
        <h2>
            Análisis de rectivos para el examen
        </h2>
        <div>
            <table class="table-responsive table-bordered table-stripped">

                <thead class="">
                <td >{{ $exam->board->name}}</td>
                </thead>
                <tr class="">
                    <td>Fecha de aplicación</td> <td>{{ $exam->applicated_at }}</td>
                </tr>
                <tr class="">
                    <td>Cantidad de preguntas</td> <td>{{  $exam->questions_count() }}</td>
                </tr>
                <tr class="">
                    <td>Cantidad de sustentantes evaluados</td> <td>{{ $exam->users->count() }}</td>
                </tr>
            </table>
            <div class="well">
                <div class="jumbotron   ">
                    <h2>Iteman testing</h2>
                </div>
                <div class="panel">
                    Discriminación
                    {{ round($iteman->difficultyGeneral($exam), 2) }}
                </div>
                <div class="panel">
                    Promedio de grupo alto
                    {{ round($iteman->avgTop($exam), 2) }}
                </div>
                <div class="panel">
                    Promedio de grupo bajo
                    {{ round($iteman->avgBottom($exam), 2) }}
                </div>

                <div class="panel">
                    <table class="table-bordered table-responsive">
                    {{ dd($iteman->grade->avgSubject($exam)) }}
                    Promedio general por tema
                    @foreach($iteman->grade->avgSubject($exam) as $key => $value)
                        <tr>

                            <td>
                            {!!  $key !!}
                        </td>
                            <td>
                                {{ round($value, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>

            </div>
        </div>
    </div>
@stop
@section('footer')

@stop
