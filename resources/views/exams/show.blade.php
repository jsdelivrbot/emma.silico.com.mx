@extends('layout')

@section('title')
        {{$slot->order}}
@stop
@section('content')
    {{--
            <div class="row">
                <div class="col-md-6 left-column" style="height: 75%; overflow:hidden;  ">
                        <div class="row ">
                                <div class="col-md-12 vignette-container" >
                                        @php($vignettes = $slot->vignettes /*Quiero poner esto en el controlador*/)
                                        @if(isset($vignettes))
                                            @each('exams.vignette_partial', $vignettes, 'vignette')
                                        @endif
                                </div>
                        </div>
                        <div class="row">
                                <div class="image-container">
                                    @include('exams.carousel_partial', ['images' => $slot->images])
                                </div>
                        </div>
                </div>
                <div class="col-md-6 questions-container">
                    <div class="row" style="height: 100%; overflow: scroll; position:fixed;">
                        <div class="col-md-12">
                    <!--Flash ajax <div>-->
                                <div id="alert-div"  class="alert alert-div nav-fixed-top">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <span id="alert_content"></span>
                                </div>
                                <!--/Flash ajax <div>-->
                                <!--Questions-->
                                @php($questions = $slot->questions)<!--Poner en el controlador-->
                                @foreach ($questions as $question)
                                        @include('exams.questions_partial', ['question' => $question/*, 'answers' => $answers*/])
                                        @foreach($question->videos as $video)
         <video width="320" height="240" controls>
             <source src="{{ asset('videos/'.$video->source) }}" type="video/{{pathinfo($video->source, PATHINFO_EXTENSION)}}">;
            Este navegador no es compatible con la reproducción de videos
        </video>
    @endforeach
                                        @each('exams.videos_partial', $question->videos, 'video')
                                @endforeach
                                <div class="panel" style="margin-bottom:100px;">
                                        @include('exams.buttons_partial', ['slot_id' => $slot->order, 'prev' => $previousSlot, 'next' => $nextSlot])
                                </div>
                                <!--/Questions-->
                        </div>
                </div>
                        </div>
            </div>
            --}}
                <!-- /Previous version -->
             <div class="Container">

        <div class="Middle">
          <div class="Images">
             @php($vignettes = $slot->vignettes /*Quiero poner esto en el controlador*/)
                @if(isset($vignettes))
                    @each('exams.vignette_partial', $vignettes, 'vignette')
                @endif
          </div>
          <div class="Bottom">
             @include('exams.carousel_partial', ['images' => $slot->images])
          </div>
        </div>
        <div class="Right">
             <!--Flash ajax <div>-->
            <div id="alert-div"  class="alert alert-div nav-fixed-top">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <span id="alert_content"></span>
            </div>
            <!--/Flash ajax <div>-->
            <!--Questions-->
            @php($questions = $slot->questions)<!--Poner en el controlador-->
            @foreach ($questions as $question)
                @each('exams.videos_partial', $question->videos, 'video')
                @include('exams.questions_partial', ['question' => $question/*, 'answers' => $answers*/])
            @endforeach
            <div class="panel" style="">
                @include('exams.buttons_partial', ['slot_id' => $slot->order, 'prev' => $previousSlot, 'next' => $nextSlot])
            </div>
                <!--/Questions-->
        </div>
            </div>
        </div>

        </div>
    </div>
@stop

@section('footer')
@stop
