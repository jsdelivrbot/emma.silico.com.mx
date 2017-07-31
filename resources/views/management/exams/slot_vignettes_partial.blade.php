<div id="vignette_{{ $vignette->id }}" class="">
  <span class="badge">{{ $vignette->id}}</span>
	{!! $vignette->text !!}
    <div>
        <a id="vignettes_{{$vignette->id}}" href="#!" class="btn btn-block btn-sm btn-info edit_button">Editar</a>
        {{ Form::open(array('route' => array('vignettes.destroy', $vignette), 'method' => 'delete')) }}
        <button type="submit" class="btn btn-danger btn-sm btn-block">Borrar</button>
        {{ Form::close() }}
    </div>
</div>
<hr>
