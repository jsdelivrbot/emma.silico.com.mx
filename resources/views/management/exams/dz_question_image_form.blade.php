{!! Form::open(['url' => 'exam/uploadimage', 'method' => 'POST', 'files'=>'true', 'id' => 'my-dropzone' , 'class' => 'dropzone']) !!}
  {!! Form::hidden('imageable_id', $question->id) !!}
  {!! Form::hidden('order', $question->order) !!}
  <div class="dz-message" style="height:30px;">
    Arrastre sus imágenes aquí
  </div>
  <div id="dropzone-previews" class="dropzone-previews"></div>
{!! Form::close() !!}
