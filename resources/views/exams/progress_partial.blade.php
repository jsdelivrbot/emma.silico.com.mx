@php
  $questionsCount =$slot->questions->count()
@endphp
@php
  $answersCount=0
@endphp
@foreach ($slot->questions as $question)
  @php
    ($question->answers->count()) ? $answersCount++ : NULL
  @endphp
@endforeach
@php
  $percentage = ($answersCount / $questionsCount)*100
@endphp
<div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="70"
    aria-valuemin="0" aria-valuemax="100" style="width:{{$percentage}}%; background-color: #669A66;">
      <span class="" style="">
        {{$percentage}}% Completo
      </span>
    </div>
  <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{100-$percentage}}%; background-color: #C06D6B; ">
    {{100-$percentage}}% falta
  </div>
</div>
