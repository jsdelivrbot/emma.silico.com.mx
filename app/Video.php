<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['source', 'videoable_id', 'videoable_type'];

    /*
     * Get all the videoable tables
     */

    public function videoable()
    {
        return $this->morphTo();
    }
}
