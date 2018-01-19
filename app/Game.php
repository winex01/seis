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

    public function goldWinner()
    {
        return $this->hasOne(Team::class, 'id', 'gold_team_id');
    }

    public function silverWinner()
    {
        return $this->hasOne(Team::class, 'id', 'silver_team_id');
    }

    public function bronzeWinner()
    {
        return $this->hasOne(Team::class, 'id', 'bronze_team_id');
    }



}
