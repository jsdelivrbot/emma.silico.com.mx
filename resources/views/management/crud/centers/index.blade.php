@extends('layout') @section('title') @stop @section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-heading">
				<img src="https://www.peppercarrot.com/extras/html/2016_cat-generator/avatar.php?seed={{ Auth::user()->centername }}" alt="{{ Auth::user()->username }}"
				 height="65px"> {{Auth::user()->centername}}
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
						<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#createCenter">Crear nuevo centro</button>
					</div>
					<table id="myTable" class="table table-bordered">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nombre</th>
								<th>Nombre corto</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($centers as $center)
							<tr class="text-left">
								<td>{{ $center->id }}</td>
								<td>{{ $center->name }}</td>
								<td>{{ $center->short_name }}</td>
								<td>
									<a id="centers_{{$center->id}}" href="#!" class="btn btn-block btn-sm btn-info edit_button">Editar</a>
									{{ Form::open(array('route' => array('centers.destroy', $center), 'method' => 'delete')) }}
									<button type="submit" class="btn btn-danger btn-sm btn-block">Borrar</button>
									{{ Form::close() }}
								</td>

							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- Modal -->
				<div id="createCenter" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Crear centro académico</h4>
							</div>
							<div class="modal-body">
								@include('management.crud.centers.create_form')
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							</div>
						</div>

					</div>
				</div>


				@include('management.crud.modal_partial') @stop @section('footer') @stop
