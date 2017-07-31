<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * @property mixed stats
 * @property mixed options
 * @property mixed distractors
 */
class Question extends Model
{
    //

    protected $fillable = ['id', 'slot_id', 'order', 'text'];

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }


    public function distractors()
    {
        return $this->hasMany(Distractor::class)->orderBy('option');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    public function addQuestion(Question $question)
    {
        if ($this->save($question)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Polymorphic realtion to images
     *
     */
    public function images()
    {
        return $this->morphMany('EMMA5\Image', 'imageable');
    }

    /*
    * Polymorphic realtion to videos
    *
    */
    public function videos()
    {
        return $this->morphMany('EMMA5\Video', 'videoable');
    }

    public function difficulty()
    {
        $slot = $this->slot();

        $exam = \EMMA5\Exam::find($this->slot->exam_id);
        $difficulty = DB::table('questions')
            ->select('questions.id', DB::raw('count(answers.id) as points'))
            ->leftJoin('slots', 'questions.slot_id', '=', 'slots.id')
            ->leftJoin('answers', 'questions.id', '=', 'answers.question_id')
            ->leftJoin('distractors', 'questions.id', '=', 'distractors.question_id')
            ->where('answers.exam_id', $exam->id)
            ->where('distractors.correct', 1)
            ->where('questions.id', $this->id)
            ->whereRaw('answers.answer = distractors.option')
            ->groupBy('questions.id')
            ->orderBy('questions.id')
            ->get();
        return $difficulty;
    }
}
