@extends('layout')

@section('title')
Administrar Exámenes
@stop
@section('content')
  <div class="container">
      <div class="row">
        @role('admin')
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                @include('admin_header_partial')
                  <div class="panel-heading"><h1>Dashboard</h1></div>

                  <div class="panel-body">
                    <div class="row">
                      <div class="col-sm-4 ">
                        <a href="{{ route('boards') }}" class="btn-lg">
                          <div class="clearfix">
                            <i class="fa fa-university fa-5x" aria-hidden="true"></i>
                            <p>Consejos</p>
                          </div>
                        </a>
                      </div>
                        <div class="col-sm-4 ">
                          <a href="{{ url('/exam/upload') }}" class="btn-lg">
                            <div class="clearfix">
                            <i class="fa fa-file-text-o fa-5x"></i>
                              <p>Crear examen</p>
                            </div>
                          </a>
                        </div>
                        <div class="col-sm-4 ">
                          <a href="{{ url('/users') }}" class="btn-lg">
                            <div class="clearfix">
                              <i class="fa fa-user fa-5x"></i>
                              <p>Usuarios</p>
                            </div>
                          </a>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4 ">
                        <a href="{{ url('/admin') }}" class="btn-lg">
                          <div class="clearfix">
                            <i class="fa fa-area-chart fa-5x"></i>
                              <p>Monitoreo de examenes</p>
                          </div>
                        </a>
                      </div>
                      <div class="col-sm-4 ">
                        <a href="{{ url('/reports/') }}" class="btn-lg">
                          <div class="clearfix">
                            <i class="fa fa-archive fa-5x"></i>
                            <p> Archivo de reportes</p>
                          </div>
                        </a>
                      </div>
                      <div class="col-sm-4 ">
                        <a href="{{ url('/exams') }}" class="btn-lg">
                          <div class="clearfix">
                            <i class="fa fa-files-o fa-5x"></i>
                            <p>Exámenes</p>
                          </div>
                        </a>
                      </div>
                      <div class="col-sm-4 ">
                        <a href="{{ url('/locations') }}" class="btn-lg">
                          <div class="clearfix">
                            <i class="fa fa-map-marker fa-5x"></i>
                            <p>Locaciones</p>
                          </div>
                        </a>
                      </div>
                      <div class="col-sm-4 ">
                        <a href="{{ url('/centers') }}" class="btn-lg">
                          <div class="clearfix">
                            <i class="fa fa-map-marker fa-5x"></i>
                            <p>Centros académicos</p>
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
          @endrole
      </div>
  </div>
@endsection
@section('footer')

@stop
