<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //

    public $fillable = ['text'];

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }
}
