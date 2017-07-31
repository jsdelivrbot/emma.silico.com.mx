@extends('layout')

@section('title')
Locaciones
@stop
@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
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
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="container-fluid">
                            <table class="table table-bordered table-stripped">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Capacidad</th>
                                    <th>Acciones</th>
                                </tr>
                                @foreach($locations as $location)
                                    <tr>
                                        <td><p class="badge">{{$location->id}}</p></td>
                                        <td>{{ $location->name}}</td>

                                        <td>{{ $location->capacity }}</td>
                                        <td>
                                            {{--<a class="btn btn-block btn-sm btn-info" href="{{  URL::route('locations.edit', ['location' => $location]) }}">Editar</a>--}}
                                            <a id="locations_{{$location->id}}" href="#!" class="btn btn-block btn-sm btn-info edit_button">Editar</a>
                                            {{ Form::open(array('route' => array('locations.destroy', $location), 'method' => 'delete')) }}
                                            <button type="submit" class="btn btn-danger btn-sm btn-block">Borrar</button>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>


                            <div class="well-sm">
                                <!-- Trigger the modal with a button -->
                                <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#createLocation">Crear nueva locación</button>

                                {{-- link_to_action('LocationsController@create','Crear nueva locación',[],['class' => 'btn btn-lg btn-success']) --}}
                            </div>
                        </div>
                        <!-- Modal -->
                        <div id="createLocation" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Crear locación</h4>
                                    </div>
                                    <div class="modal-body">
                                        @include('management.crud.locations.create_form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @include('management.crud.modal_partial')

@stop
@section('footer')

@stop
