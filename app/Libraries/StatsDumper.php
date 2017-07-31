<?php
namespace EMMA5\Libraries;

use \EMMA5\Exam as Exam;

/**
   * This creates the Collect object with the proper dataset of an answered exam
   */
class StatsDumper
{
    public function __construct($exam_id)
    {
        // $this->exam_id = $exam_id;
        // $exam = Exam::find($exam_id)
        $this->exam  = Exam::find($exam_id);
    }

    public function examKey()
    {
        $questions = $this->exam->questions;
        foreach ($questions as $question) {
            $distractors[$question->id] = $question->distractors->where('correct', 1)->pluck('option')->first();
        }
        return $distractors;
    }
}
