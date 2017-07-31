<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed text
 */
class Distractor extends Model
{
    protected $fillable = ['id', 'question_id', 'option', 'distractor', 'correct'];
    //This is the abstraction of the distractors part of a test item. Ergo belongs to a item (question)
    public function question()
    {
        return $this->belongsTo(Question::class);
    }




    /*
  * Polymorphic realtion to images
  *
  */
    public function images()
    {
        return $this->morphMany('EMMA5\Image', 'imageable');
    }
}
