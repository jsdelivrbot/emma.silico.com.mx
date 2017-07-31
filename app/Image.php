<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['source', 'imageable_id', 'imageable_type'];

    /*
     * Get all the imageable tables
     */

    public function imageable()
    {
        return $this->morphTo();
    }
}
