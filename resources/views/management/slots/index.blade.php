@extends('layout')

@section('title')
    Distractors management
@stop
@section('content')
    <div class="container-fluid" style="padding-top: 70px;">
     @each('management.slots.slot_list_partial', $slots, 'slot')

        @foreach($slots as $slot)

            <div style="height: 100vh">
                <ul class="list-group question-group">
                    <li class="list-group-item">
                        <a href="{{ route('slots.show', $slot) }}">
                            <span class="glyphicon glyphicon-search"></span>
                        </a>
                    </li>
                    <li class="list-group-item">{{ $slot->subject->text }}</li>
                    @foreach($slot->vignettes as $vignette)
                        <div class="stuck">
                            <li class="">
                                <p class="vignete">
                                    <small class="badge">{{ $vignette->id }}</small>
                                    {!! $vignette->text  !!}
                                </p>
                            </li>
                        </div>
                    @endforeach
                    <div id="vignette_{{ $vignette->id }}" class="not-stuck">
                        @each('management.slots.image_thumb_partial', $vignette->images, 'image')
                        @foreach($slot->questions as $question)
                            @each('management.slots.image_thumb_partial', $question->images, 'image')
                            <li class="list-group-item question-li">
                                <div class="key">
                                    <div class="question-text">
                                        <div class="badge">{{ $question->id }}</div>
                                        <div class="badge distractor-badge">
                                            {{ $question->order + 1 }}
                                        </div> {{ $question->text }}
                                    </div>
                                </div>
                            </li>
                            @foreach($question->distractor as $distractor)
                                @each('management.slots.image_thumb_partial', $distractor->images, 'image')
                                <li class="list-group-item @if($distractor->correct) list-group-item-success @endif">
                                    <div class="key">
                                        <div class="badge"><small>id </small>{{ $distractor->id }}</div>
                                        <div class="badge distractor-badge">{{ $distractor->key }}.-</div>
                                        <p class="distractor-text">{{ $distractor->distractor }}</p>
                                    </div>
                                </li>
                            @endforeach
                    </div>
                    @endforeach

                </ul>
            </div>
    @endforeach

@stop
@section('footer')

@stop
