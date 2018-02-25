{!! Form::open(['url' => 'exam/uploadimage', 'method' => 'POST', 'files'=>'true', 'id' => 'my-dropzone' , 'class' => 'dropzone']) !!}
  {!! Form::hidden('exam_id', $slot->exam_id) !!}
  {!! Form::hidden('imageable_id', $slot->id) !!}
  {!! Form::hidden('order', $slot->order + 1) !!}
  <div class="dz-message" style="height:30px;">
    Arrastre sus imágenes aquí
  </div>
  <div id="dropzone-previews" class="dropzone-previews"></div>
  {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.js"></script>  --}}
{!! Form::close() !!}
