<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    public function workshop(): HasOne
    {
        return $this->hasOne(Workshop::class);
    }
}
