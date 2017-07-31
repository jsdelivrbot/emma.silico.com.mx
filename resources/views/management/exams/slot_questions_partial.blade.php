<div class="">
    <span class="badge">{{ $question->id }}</span>
    <span class="badge">{!! $question->order !!}</span>{!! $question->text !!}
    <div class="">
            @foreach($question->images as $image)
                    <img src="{{ asset('images/exams/'.$question->slot->exam_id.'/'.$image->source) }}" class="img-thumbnail" width="65px" alt=""> 
            @endforeach

    </div>
    <div class="panel" style="">
        @include('management.exams.dz_question_image_form')
    </div>
    <div class="panel">
        @each('management.exams.question_distractors_partial', $question->distractors, 'distractor')
    </div>
    <div class="btn-group form-inline">
        <a id="questions_{{$question->id}}" href="#!" class="btn btn-xs btn-info edit_button"><span class="glyphicon glyphicon-pencil"></span></a>
        {{ Form::open(array('route' => array('questions.destroy', $question), 'method' => 'delete')) }}
        <button type="submit" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></button>
        {{ Form::close() }}
    </div>
</div>
<hr>
