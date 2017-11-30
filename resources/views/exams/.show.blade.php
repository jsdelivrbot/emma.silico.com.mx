@extends('layout')

@section('title')

@stop
@section('content')
	<div class="row" style="height: 100vh; position: fixed;">
		<div class="col-md-6 left-column">
			<div class="row">
                                @php($vignettes = $slot->vignettes /*Quiero poner esto en el controlador*/)
                                @if(isset($vignettes))
                                    @each('exams.vignette_partial', $vignettes, 'vignette')
                                @endif
			</div>
			<div class="row">
				<div class="col-md-12">
                  
<div class="container  image-container">
	<div class="span8">
	<div id="myCarousel" class="carousel slide">
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class=""></li>
			<li data-target="#myCarousel" data-slide-to="1" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="2" class=""></li>
		</ol>
		<div class="carousel-inner">
			<div class="item">
<img src="http://placeskull.com/170/172">
				<div class="carousel-caption">
					<h4>First Thumbnail label</h4>
					<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
				</div>
			</div>
			<div class="item active">
<img src="http://placeskull.com/170/171">
				<div class="carousel-caption">
					<h4>Second Thumbnail label</h4>
					<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
				</div>
			</div>
			<div class="item">
				<img src="http://placeskull.com/170/170">

				<div class="carousel-caption">
					<h4>Third Thumbnail label</h4>
					<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
				</div>
			</div>
		</div>
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
	</div>
	</div>
</div>

				</div>
			</div>
		</div>
		<div class="col-md-6 questions-container">
			<div class="list-group">
				 <a href="#" class="list-group-item active">Home</a>
				<div class="list-group-item">
					List header
				</div>
				<div class="list-group-item">
					<h4 class="list-group-item-heading">
						List group item heading
					</h4>
					<p class="list-group-item-text">
						...
					</p>
				</div>
				<div class="list-group-item">
					<span class="badge">14</span>Help
				</div> <a class="list-group-item active"><span class="badge">14</span>Help</a>
			</div>
          <div class="list-group">
				 <a href="#" class="list-group-item active">Home</a>
				<div class="list-group-item">
					List header
				</div>
				<div class="list-group-item">
					<h4 class="list-group-item-heading">
						List group item heading
					</h4>
					<p class="list-group-item-text">
						...
					</p>
				</div>
				<div class="list-group-item">
					<span class="badge">14</span>Help
				</div> <a class="list-group-item active"><span class="badge">14</span>Help</a>
			</div>
          <div class="list-group">
				 <a href="#" class="list-group-item active">Home</a>
				<div class="list-group-item">
					List header
				</div>
				<div class="list-group-item">
					<h4 class="list-group-item-heading">
						List group item heading
					</h4>
					<p class="list-group-item-text">
						...
					</p>
				</div>
				<div class="list-group-item">
					<span class="badge">14</span>Help
				</div> <a class="list-group-item active"><span class="badge">14</span>Help</a>
			</div>
          <div class="list-group">
				 <a href="#" class="list-group-item active">Home</a>
				<div class="list-group-item">
					List header
				</div>
				<div class="list-group-item">
					<h4 class="list-group-item-heading">
						List group item heading
					</h4>
					<p class="list-group-item-text">
						...
					</p>
				</div>
				<div class="list-group-item">
					<span class="badge">14</span>Help
				</div> <a class="list-group-item active"><span class="badge">14</span>Help</a>
			</div>
          <div class="list-group">
				 <a href="#" class="list-group-item active">Home</a>
				<div class="list-group-item">
					List header
				</div>
				<div class="list-group-item">
					<h4 class="list-group-item-heading">
						List group item heading
					</h4>
					<p class="list-group-item-text">
						...
					</p>
				</div>
				<div class="list-group-item">
					<span class="badge">14</span>Help
				</div> <a class="list-group-item active"><span class="badge">14</span>Help</a>
			</div>
		</div>
	</div>
@stop

@section('footer')
@stop
