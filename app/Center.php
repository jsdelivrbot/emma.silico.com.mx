<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    //
    protected $fillable = [ 'name', 'short_name'];

    public function users()
    {
        return $this->hasMany('EMMA5\User');
    }
}
