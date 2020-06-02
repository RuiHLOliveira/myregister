<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function situation()
    {
        return $this->belongsTo('App\Situation');
    }
}
