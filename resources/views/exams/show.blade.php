@extends('layout')

@section('title')

@stop
@section('content')
    <div class="container-fluid ">
            <div class="row">
            <div class="col-xs-6 col-lg-6" style="height: 100%; width:50%">
                {{--Vigenttes--}}
                @each('exams.videos_partial', $slot->videos, 'video')
                
                @php($vignettes = $slot->vignettes /*Quiero poner esto en el controlador*/)
                @if(isset($vignettes))
                    @each('exams.vignette_partial', $vignettes, 'vignette')
                @endif
                {{--//Vignette--}}
                {{--Videos --}}

                {{--//Videos--}}

                {{--Carousel--}}
                {{-- <div class="row"> --}}
                    <div class="" style="height: 100%; overflow:scroll;">
                        @include('exams.carousel_partial', ['images' => $slot->images])
                    </div>

                {{-- </div> --}}
                {{--/Carousel--}}

            </div>
            </div><!--end of first row -->
            <div class="col-xs-6">
                <div class="" style="height: 100%; overflow: scroll; position:fixed;">
                    <div class="pull-right">
                        {{--Flash ajax <div>--}}
                        <div id="alert-div"  class="alert alert-div nav-fixed-top">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button>
                            <span id="alert_content"></span>
                        </div>
                        {{--/Flash ajax <div>--}}
                        {{--Questions--}}

                        @php($questions = $slot->questions){{--Poner en el controlador--}}
                            @foreach ($questions as $question)
                                @include('exams.questions_partial', ['question' => $question/*, 'answers' => $answers*/])
                                @each('exams.videos_partial', $question->videos, 'video')
                            @endforeach
                            <div class="panel" style="margin-bottom:100px;">
                              @include('exams.buttons_partial', ['slot_id' => $slot->order, 'prev' => $previousSlot, 'next' => $nextSlot])
                            </div>
                            {{--/Questions--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
@stop
