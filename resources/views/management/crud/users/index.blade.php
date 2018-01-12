@extends('layout')
@section('title')
Listado general de usuarios
@stop
@section('content')
<div class="container">
        <div class="panel panel-default">
          @include('admin_header_partial')
          <div class="panel-body">
                <div class="row">
                        <div class="col-sm-12">
                                <div class="well panel">
                                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#createUser">Crear nuevo usuario</button>
                                </div>
                        <table id="myTable" class="table table-bordered">
                                <thead>
                                        <tr>
                                                <th>Foto</th>
                                                <th>ID</th>
                                                <th>Folio</th>
                                                <th>Nombre</th>
                                                <th>Apellidos</th>
                                                <th>Sede formativa</th>
                                                <th>Consejo</th>
                                                <th></th>
                                        </tr>
                                </thead>
                                <tbody>
                            @foreach($users as $user)
                                    <tr class="text-left">
                                            <td>
                                                    <img src="{{$user->photo()}}" width="50px"  alt="avatar{{$user->id}}"/>
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
                                </tbody>
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
                @yield('scripts')
                  @yield('adminScripts')
