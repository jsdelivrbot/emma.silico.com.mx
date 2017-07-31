<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-10">
					<ul class="list-group slot_li">
						@foreach($slot->vignettes as $vignette)
						<li class="list-group-item">
							<div class="badge pull-left">
								<a href="{{ route('slots.show', $slot) }}">
						<span class="glyphicon glyphicon-search"></span>
					</a>
							</div>
							<p class="vignete">
								{!! $vignette->text  !!}
							</p>
							<button data-toggle="collapse" data-target="#{{ $slot->id }}">
								<span class="glyphicon glyphicon-plus"></span>
								{{ $slot->questions->count()}}
							</button>
							<ul class="list-group collapse" id="{{ $slot->id }}">
								@foreach($slot->questions as $question)
									<li class="list-group-item">
										{!! $question->text !!}
									</li>
									<ul class="list-group">
										@foreach($question->distractor as $distractor)
										<li class="list-group-item">
											<div class="badge distractor-badge pull-left">{{$distractor}}</div>{!! $distractor->distractor !!}
										</li>
										@endforeach
									</ul>

								@endforeach
							</ul>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
