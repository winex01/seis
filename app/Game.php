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

    public function sportManager()
    {
        return $this->belongsTo(SportManager::class);
    }

}
