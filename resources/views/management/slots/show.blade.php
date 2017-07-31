@extends('layout')

@section('title')

@stop
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6" style="overflow: scroll; height: 100vh;">
                {{--Vigenttes--}}
                @php($vignettes = $slot->vignettes /*Quiero poner esto en el controlador*/)
                @if(isset($vignettes))
                    @each('management.slots.vignette_partial', $vignettes, 'vignette')
                @endif
                {{--//Vignette--}}

                {{--Carousel--}}
                {{--TODO Load related images to this--}}
                <div class="row" style="height: 80vh; overflow: scroll;">
                    <div class="col-md-12">
                        @include('management.slots.carousel_partial')
                    </div>
                </div>
                {{--/Carousel--}}
            </div>
            <div class="col-xs-6">
                <div class="row" style="height: 100vh; overflow: scroll; position:fixed;">
                    <div class="col-md-12">
                        {{--Flash ajax <div>--}}
                        <div id="alert-div"  class="alert alert-div nav-fixed-top">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button>
                            <span id="alert_content"></span>
                        </div>
                        {{--/Flash ajax <div>--}}
                        {{--Questions--}}
                        @php($questions = $slot->questions){{--Poner en el controlador--}}
                        @if(isset($questions))
                            @each('management.slots.questions_partial', $questions, 'question')
                            @include('management.slots.buttons_partial')
                        @endif
                            {{--/Questions--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/all.js') }}"></script>
    {{--<script src="{{ asset('js/answer_ajax.js') }}"></script>--}}
    {{--<script src="{{ asset('js/emma_carousel.js') }}"></script>--}}

@stop

@section('footer')

@stop
