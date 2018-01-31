<ul class="list-group" style="margin-top: -5px; margin-bottom: -5px;">
        {{ Form::open(['action' => ['AnswersController@store', $question->id]]) }}
        {{ Form::hidden('question_id', $question->id) }}
        {{ Form::hidden('exam_id', session('exam_id')) }}
        @if (isset($answers))
            @foreach($answers as $answer)
                {{ Form::hidden('id', isset($answer)? $answer->id : '') }}
            @endforeach
        @endif

        <li id="question_{{$question->id}}"class="list-group-item question-li" >
          {!! $question->text !!}
            @if($question->images->first() != NULL)
                <img  src="{{ asset('images/exams/'.$slot->exam_id.'/'.$question->images->first()->source) }}  " alt="" style="width: 100%;">              @endif
          @php
            isset($question->answers->last()->answer) ? $answer = $question->answers->last()->answer : $answer = NULL
          @endphp
        </li>
        <li class="list-group-item">
            <ul class="list-group distractor-list">
                @foreach($question->distractors as $distractor)
                    <li name="answer_key" class="list-group-item" >
                        <div class="radio">
                            <label>
                                <div class="radio">
                                    {{ Form::radio('answer' , $distractor->option, (isset($answer) ? $distractor->option == $answer? true : false : false) ) }}
                                </div>
                                <span class="distractor-badge label">
                                    {{$distractor->option}}
                                </span>

                                <span class="" id="distractor_{{ $distractor->id }}" >
                                    {!! $distractor->distractor !!}
                                </span>
                            </label>
                        </div>
                    </li>
                @endforeach
                {{ Form::close() }}
            </ul>
        </li>
</ul>
        {{--
        --}}
