<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function addQuote(Quote $quote, $user_id)
    {
        $quote->user_id = $user_id;
        return $this->quotes()->save($quote);
    }
}
