<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SoftDeletes;
class Exam extends Model
{
    //

    protected $dates = ['created_at', 'updated_at', 'applicated_at'];

    protected $fillable = [
        'applicated_at',
        'duration',
        'board_id',
        'passing_grade',
        'annotation'
   ];


    public function board()
    {
        return $this->belongsTo('EMMA5\Board');
    }

    public function users()
    {
        return $this->belongsToMany('EMMA5\User')->withPivot('active', 'started_at', 'ended_at', 'seat', 'location_id');
    }

    public function locations()
    {
        return $this->belongsToMany('EMMA5\Location', 'exam_user')->withPivot('location_id', 'seat');
    }

    public function slots()
    {
        // return $this->belongsToMany('EMMA5\Slot');
        return $this->hasMany('EMMA5\Slot');
    }

    public function subjects()
    {
        //returns the subjects asociated
        return DB::table('subjects')
            ->join('slots', 'slots.subject_id', '=', 'subjects.id')
            ->join('exams', 'exams.id', '=', 'slots.exam_id')
            ->join('questions', 'questions.slot_id', '=', 'slots.id')
            ->select('subjects.*')
            ->where('exams.id', $this->id)
            ->orderBy('subjects.text')
            ->groupBy('subjects.id')
            ->get();
        //TODO add the ammount of questions for a given subject
        //Maybe ask in stackoverflow
    }

    public function questions()
    {
        return $this->hasManyThrough('EMMA5\Question', 'EMMA5\Slot');
    }

    public function answers()
    {
        return $this->hasMany('EMMA5\Answer');
    }

    /**
     * This is to be used to generate the answers dump
     *
     * @return void
     */
    public function answersRaw()
    {
            return DB::table('answers')
                    ->join('exams', 'answers.exam_id', '=', 'exams.id')
                    ->where('exam.id', '=', $this->id)
                    ->get();
    }
    

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param type var Description
     * @return return type
     */
    public function questions_count()
    {
        // $count = 0;
        // foreach ($this->slots as $slot )
        // {
        //   $count = $count + $slot->questions->count();
        // }
        // return $count;
        return $this->questions->count();
    }

    /**
     * Returns a collection with the question count by subject for the given exam
     *
     * @return collect
     * @author msantana
     */
    public function questionsBySubject()
    {
        /*return DB::table('subjects')
            ->join('slots', 'slots.subject_id', '=', 'subjects.id')
            ->join('exams', 'exams.id', '=', 'slots.exam_id')
            ->join('questions', 'questions.slot_id', '=', 'slots.id')
            ->join('distractors', 'distractors.question_id', '=', 'questions.id')
            ->select('subjects.text', DB::raw('count(questions.id) as questionsNumber'))
            ->where('exams.id', $this->id)
//            ->select('subjects.text')
            ->groupBy('subjects.id')
            //->orderBy('questions.id')
            ->get();*/
        return DB::table('subjects')
            ->join('slots', 'slots.subject_id', '=', 'subjects.id')
            ->join('exams', 'exams.id', '=', 'slots.exam_id')
            ->join('questions', 'questions.slot_id', '=', 'slots.id')
            ->where('exams.id', $this->id)
            ->select('subjects.text', DB::raw('count(questions.id) as questionsNumber'))
            ->groupBy('exams.id', 'subjects.id')
            ->get();
    }
   

    public function isExtemporaneous(User $user)
    {
        if ($this->applicated_at->year != $user->completion_year) {
            return true;
        }
        return false;
    }

    /**
     *Scope a query to only return extemporaneous users
     *
     *@return \Illuminate\Database\Eloquent\Builder
     */
     public function scopeExtemporaneous()
     {
         
     }

    public function key()
    {
            return DB::table('questions')
                    ->select(
                            'questions.id',
                            'questions.order',
                            'distractors.option'
                    )
                    ->join('slots', 'questions.slot_id', '=', 'slots.id')
                    ->join('distractors', 'questions.id', '=', 'distractors.question_id')
                    ->where('slots.exam_id', '=', $this->id)
                    ->where('distractors.correct', '=', 1)
                    ->get();
    }
    
    //TODO get all active users

    //TODO get all present users

    //TODO get all missing users

    //TODO something to validate the exam i.e. check for missing correct discractors(option)
}
