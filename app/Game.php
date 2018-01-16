<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $guarded = [];

    
    public function event()
    {
    	return $this->belongsTo(Event::class);
    }

    public function manager()
    {
         return $this->belongsToMany(Manager::class);
    }

    public function matches()
    {
        return $this->hasMany(Match::class);
    }



}
