<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;
use Helper as Helper;

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

    public function shortName()
    {
        if ($this->short_name == null) {
            return $this->short_name = Helper::createAcronym($this->name);
        } else {
            return $this->short_name;
        }
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
