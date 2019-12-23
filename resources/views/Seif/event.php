<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    protected $fillable = [
        'name', 'descrition', 'image', 'event_Date', 'event_duration', 'hall_id',
    ];
    public function user()
    {
        return $this->belongsToMany('App\User');
    }
    public function hall()
    {
        return $this->belongsTo('App\hall');
    }
}
