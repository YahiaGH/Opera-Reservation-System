<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hall extends Model
{
    //
    protected $fillable = [
        'no_rows', 'no_Seats',
    ];
    public function event()
    {
        return $this->hasMany('App\event');
    }
}
