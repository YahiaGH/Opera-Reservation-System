<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
    protected $fillable = [
        'name', 'descrition', 'image', 'event_Date', 'event_duration', 'hall_id',
    ];
    //
    protected $casts = [
        'Seat_numbers' => 'array'
    ];

    public function event()
    {
        return $this->hasMany('App\event');
    }
}
