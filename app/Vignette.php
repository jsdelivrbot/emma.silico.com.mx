<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

class Vignette extends Model
{
    //

    protected $fillable = ['id', 'slot_id', 'order', 'text', 'instructions'];

    public function slot()
    {
        return $this->belongsTo(Slot::class);
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



    //    public function questions()
//    {
//        return $this->hasMany(Question::class);
//    }
}
