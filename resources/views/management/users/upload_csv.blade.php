@extends('layout')

@section('title')
    Administrar Exámenes
@stop
@section('content')
    <div class="container">
        @role('admin')
        <div class="row">
      <div class="col-md-1">
       <img src="/images/{{$board->logo->first()->source }}" style="width: 100%;">
       {{$board->name}}
      </div>
            <div class="col-md-9 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="https://www.peppercarrot.com/extras/html/2016_cat-generator/avatar.php?seed={{ Auth::user()->username }}" alt="{{ Auth::user()->username }}" height="65px">
                        {{Auth::user()->username}}
                        <span class="fa-stack fa-3x pull-right">
                            <i class="fa fa-calendar-o fa-stack-2x"></i>
                            <strong class="fa-stack-1x calendar-text">{{ Carbon::now()->day }}</strong>
                        </span>
                        <span class="fa-stack fa-2x">
                            <i class="fa fa-clock-o fa-stack-2x"></i>
                        </span>
                        <span>{{ Carbon::now()->hour }}:{{ Carbon::now()->minute }}</span>
                    </div>
                    <hr>
                    <div class="panel panel-primary">
                    <div class="panel-heading">
                        Cargar archivo de Excel (inlcuye columna de nombre de imagen)
                    </div>
                    <div class="panel-body">
                        {{ Form::open(['action' => 'UploadController@usersExcel', 'files' => true]) }}
                        {{ Form::file('users_excel', ['class' => 'form-control']) }}
                    </div>
                    </div>

                    <div class="panel-body">
                        {{  Form::open(['action' => 'UploadController@users_csv','files'=>true]) }}
                        {{ Form::hidden('board_id', $board->id) }}
                        <div class="panel panel-primary">
                            <div class="panel-heading">Carga de archivo de usuarios</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        {{ Form::select('exam_id', $exams, null, array('placeholder' => 'Seleccione un examen', 'class' => 'form-control')) }}
                                    </div>
                                    <div class="col-sm-6">
                                        {{ Form::file('users_csv', ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-info pull-right" type="submit">
                                            <i class="fa fa-file-text-o"></i>
                                            Cargar lista de usuarios
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="panel panel-primary">
                            <div class="panel-heading">Añadir fotografías de usuario</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        {{ Form::open(['action' => 'UploadController@pictures', 'files' => true])}}
                                        {{ Form::label('file','Lista de usuarios',array('id'=>'','class'=>''))  }}
                                          {{ Form::file('zipFile','',array('id'=>'','class'=>''))  }}
                                        <button class="btn btn-info" type="submit">
                                            <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                                            <span>Cargar</span>
                                        </button>
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="clearfix">
                                            @foreach ($exams as $exam)
                                                <div class="col-sm-6">
                                                    <a href="#" class="btn btn-primary">
                                                        {{ $exam }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endrole
    </div>
@endsection
@section('footer')

@stop
