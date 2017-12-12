<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $guarded = [];

    public function matches()
    {
    	return $this->hasMany(Matches::class);
    }

    public function event()
    {
    	return $this->belongsTo(Event::class);
    }

    public function sportManagers()
    {
        return $this->hasMany(SportManger::class);
    }

}
