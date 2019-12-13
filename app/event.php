<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    public function user()
    {
        return $this->belongsToMany('App\User');
    }
    public function hall()
    {
        return $this->belongsTo('App\hall');
    }
}
