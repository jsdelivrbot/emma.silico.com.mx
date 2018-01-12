@extends('layout')
@section('title')
  Listado general de examen
@endsection
@section('content')

    <div class="row">
      <div class="col-sm-4" style="overflow: scroll; height: 90vh;">
        @foreach ($exam as $set)
        @endforeach
        {{-- {{ dd($set) }} --}}
        @php
          $exam = $set
        @endphp
        @foreach ($exam->slots as $slot)
          <div class="col-sm-1">
            <a href="#slot_{{ $slot->order }}">
              <div class="badge">
                {{ str_pad($slot->order, 3, "0", STR_PAD_LEFT) }}
              </div>
            </a>
          </div>
          <div class="row panel" style="margin: 0px;">
          @foreach ($slot->questions as $question)
            <a href="{{ route('exams.slot', ['slot' => $slot->id]) }}#question_{{ $question->id  }}">
            <div class="col-sm-2 text-center">
              @if ($question->answers->last()['answer'])
                <div class="alert-success">
                  {{ $question->answers->last()['answer'] }}
                </div>
              @else
                <div class="alert-danger">
                  <i id="icon_{{ $question->id}}" class="fa fa-times fa-lg"></i>
                </div>
              @endif
            </div>
            </a>
          @endforeach
        </div>
        @endforeach
        <div class="panel btn-group-justified text-center">
          {{ Form::open(['route' => 'exams.finish', null, 'onsubmit' => "return confirm('¿Seguro que desea terminar su examen?')"]) }}
            {{ Form::hidden('exam_id', $exam->id) }}
            <button type="submit" class="btn btn-info"><strong>Terminar examen</strong></button>
          {{ Form::close() }}
        </div>
      </div>
      <div class="col-xs-8" style="overflow: scroll; height: 90vh;">
        @foreach ($exam->slots as $slot)
          <div id="slot_{{ $slot->order }}" class="row panel">
            @foreach ($slot->vignettes as $vignette)
              <div class="col-xs-9">
                  <div class="badge pull-left">
                    {{ str_pad($slot->order, 3, "0", STR_PAD_LEFT) }}
                  </div>
                  <div class="" style="white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;">
                    {!! $vignette->text !!}
                  </div>
              </div>
              <div class="col-xs-1">
                <a href="{{ route('exams.slot', ['slot' => $slot->id]) }}" class="btn btn-sm btn-info">Abrir</a>
              </div>
              <div class="col-xs-2">
                @include('exams.progress_partial', ['slot' => $slot])
              </div>
            @endforeach
          </div>
        @endforeach
      </div>
    </div>
@endsection
@section('adminScripts')
  @parent
@stop
