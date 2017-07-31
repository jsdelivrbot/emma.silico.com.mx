@extends('layout')

@section('title')
    Reportes {{$board->name}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-1">
               <img src="/images/{{$board->logo->first()->source}}" style="width: 100%;">
            </div>
            <div class="col-xs-10  text-left">
                    @foreach($exams as $exam)
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-primary text-center">
                                            Examen
                                            <div class="pull-right">
                                                <a href="{{--route('singleReport', ['exam' => $exam, 'user' => $exam->users->first()->id])--}}" class="btn btn-default"><i class="fa fa-file-word-o" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                        <div class="panel">
                                            {{$exam->annotation}}
                                        </div>
                                        <table class="table">
                                            <tr>
                                                <th>
                                                   Fecha de aplicación 
                                                </th>
                                                <th>
                                                    Duración
                                                    <small>minutos</small>
                                                </th>
                                                <th>
                                                    Hora de aplicación
                                                </th>
                                                <th>
                                                    Cantidad de alumnos
                                                </th>
                                                <th>
                                                    Cantidad de reactivos
                                                </th>
                                                <th>
                                                    Puntaje aprobatorio
                                                </th>
                                                <th>
                                                    Puntaje máximo
                                                </th>
                                                <th>
                                                    Puntaje mínimo
                                                </th>
                                                <th>
                                                    Confiabilidad
                                                </th>
                                            <th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{$exam->applicated_at->toDateString()}}
                                                </td>
                                                <td>
                                                    {{$exam->duration}}
                                                </td>
                                                <td>
                                                    {{$exam->applicated_at->toTimeString()}}
                                                </td>
                                                <td>
                                                    {{$grade->allStudents($exam)->count()}}
                                                </td>
                                                <td>
                                                    {{$exam->questions_count()}}
                                                </td>
                                                <td>
                                                    {{$exam->passing_grade}}
                                                </td>
                                                <td>
                                                    {{$grade->allStudents($exam)->max('points')}}
                                                </td>
                                                <td>
                                                    {{$grade->allStudents($exam)->min('points')}}
                                                </td>
                                                <td>
                                                    {{round($grade->alpha($exam), 4)}}
                                                </td>
                                        </table>
                                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#studentsInExam_{{$exam->id}}" aria-expanded="false" aria-controls="collapseExample">
                                            Reportes individuales
                                        </button>
                                        <div class="collapse" id="studentsInExam_{{$exam->id}}">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <table class="table">
                                                        <tr>
                                                            <th>Jerarquía</th>
                                                            <th>Nombre</th>
                                                            <th>Sede formativa</th>
                                                        </tr> 
                                                        @php
                                                            $hierachy = $grade->hierachy($exam)
                                                        @endphp
                                                        @foreach($exam->users->sortBy('id') as $student)
                                                <tr>
                                                    <td>{{$hierachy->where('id', $student->id)? $hierachy->where('id', $student->id)->first()['hierachy']: ""}}</td>
                                                    <td>{{$student->last_name}} {{$student->name}}</td>
                                                    <td>{{$student->center ? $student->center->name : ""}}</td>
                                                    <td>
                                                        <a href="{{route('singleReport', ['exam' => $exam, 'user' => $student])}}" class="btn btn-default">
                                                            <i class="fa fa-file-word-o" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr> 
                                            @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                    @endforeach
            </div>
        </div>
    </div>
@endsection
