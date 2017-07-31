<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['quote'];

    public function cat()
    {
        return $this->belongsTo(Cat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
