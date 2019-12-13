<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hall extends Model
{
    //
    public function event()
    {
        return $this->hasMany('App\event');
    }
}
