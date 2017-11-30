<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $guarded = [];

    public function games()
    {
    	return $this->hasMany(Game::class);
    }

}
