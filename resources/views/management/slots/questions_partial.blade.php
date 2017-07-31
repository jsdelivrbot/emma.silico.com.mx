<ul class="list-group" style="margin-top: -5px; margin-bottom: -5px;">
        {{ Form::open(['action' => ['AnswersController@store', $question->id]]) }}
        {{ Form::hidden('question_id', $question->id) }}
        {{ Form::hidden('exam_id', '1') }}
        @php($answers = $question->answers)
        @foreach($answers as $answer)
            {{ Form::hidden('id', isset($answer)? $answer->id : '') }}
        @endforeach
        <li class="list-group-item question-li" >
            {{$question->text}}
        </li>
        <li class="list-group-item">
            <ul class="list-group distractor-list">
                @foreach($question->distractor as $distractor)
                    <li name="answer_key" class="list-group-item" >
                        <div class="radio">
                            <label>
                                <div class="radio">
                                    {{ Form::radio('answer' , $distractor->option, (isset($answer) ? $distractor->option == $answer->answer ? true : false : false) ) }}
                                </div>
                                <div class="distractor-badge label pull-left">
                                    {{ $distractor->option }}
                                </div>

                                <div class="pull-right" id="distractor_{{ $distractor->id }}" >
                                    {!! $distractor->distractor !!}
                                </div>
                            </label>
                        </div>
                    </li>
                @endforeach
                {{ Form::close() }}
            </ul>
        </li>
</ul>
