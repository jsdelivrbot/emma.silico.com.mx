<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    //

    protected $fillable = ['id', 'subject_id', 'order', 'instructions'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }


    public function vignettes()
    {
        return $this->hasMany(Vignette::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
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

    public function Exams()
    {
        // return $this->belongsToMany('EMMA5\Exam');
        return $this->belongsTo('EMMA5\Exam');
    }

    public static function byExamOrder($examId, $slotOrder)
    {
        return Slot::where('exam_id', $examId)
                        ->where('order', $slotOrder)
                        ->get()
                        ->first();
    }
}
