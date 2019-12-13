<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
    //
    protected $casts = [
        'Seat_numbers' => 'array'
    ];
}
