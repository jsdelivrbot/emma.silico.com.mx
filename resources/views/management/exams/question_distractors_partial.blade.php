<div class="clearfix">
	<div class="col-sm-12 @if($distractor->correct) bg-danger @endif">
		<span class="">
			{!! $distractor->option !!})
		</span>
		{!! $distractor->distractor !!}
	</div>
</div>
