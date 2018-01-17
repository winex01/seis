<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    //
    protected $guarded = [];

    
    public function game()
    {
    	return $this->belongsTo(Game::class);
    }

    public function team1()
    {
    	return $this->hasMany(Team::class, 'id', 'team1_id');
    }

    public function team2()
    {
    	return $this->hasMany(Team::class, 'id', 'team2_id');
    }

    public function winner()
    {
        return $this->hasMany(Team::class, 'id', 'winner_team_id');
    }

}
