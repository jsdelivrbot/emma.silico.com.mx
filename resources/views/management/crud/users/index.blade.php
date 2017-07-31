@extends('layout')

@section('title')

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
                        <div class="well panel">
                            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#createUser">Crear nuevo usuario</button>
                        </div>
                        <div class="panel">
{{--                            {{ $users->links() }}--}}
                        </div>
                        <table id="myTable" class="table table-bordered">
                            <tr>
                                    <th>Foto</th>
                                    <th>ID</th>
                                    <th>Folio</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Sede formativa</th>
                                    <th>Consejo</th>
                                    <th>Acciones</th>
                            </tr>
                            @foreach($users as $user)
                                    <tr class="text-left">
                                            <td>
                                                    @if($user->avatar->first())
                                                            <img style="height: 50px;" src="{{ asset('images/avatars/users/'.$user->board_id."/".$user->avatar->first()->source) }}">
                                                    @endif
                                            </td>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->identifier }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->last_name }}</td>
                                            <td>
                                            @if(isset($user->center))
                                                    {{ $user->center->name }}
                                            @endif
                                            </td>
                                            <td>
                                                    @if(isset($user->board))
                                                            {{ $user->board->name }}
                                                    @endif
                                            </td>
                                            <td>
                                                    <a id="users_{{$user->id}}" href="#!" class="btn btn-block btn-sm btn-info edit_button">Editar</a>
                                                    {{ Form::open(array('route' => array('users.destroy', $user), 'method' => 'delete')) }}
                                                    <button type="submit" class="btn btn-danger btn-sm btn-block">Borrar</button>
                                                    {{ Form::close() }}
                                            </td>

                                    </tr>
                            @endforeach
                        </table>
                        <div class="well">
                                {{--                            {{ $users->links() }}--}}
                        </div>
                    </div>
                    <!-- Modal -->
                    <div id="createUser" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                            <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Crear usuario</h4>
                                            </div>
                                            <div class="modal-body">
                                                    @include('management.crud.users.create_form')
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
