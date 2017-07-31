<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    //
    protected $fillable = ['id', 'name', 'short_name'];

    public function users()
    {
        return $this->hasMany('EMMA5\User');
    }

    public function exams()
    {
        return $this->hasMany('EMMA5\Exam');
    }

    public function image()
    {
        return $this->belongsTo('EMMA5\Image');
    }

    /*
    * Polymorphic realtion to images
    *
    */
    public function logo()
    {
        return $this->morphMany('EMMA5\Image', 'imageable');
    }
}
