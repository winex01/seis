<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Match;

class Team extends Model
{
    //
    protected $guarded = [];

    public function matches()
    {
    	return $this->hasMany(Match::class);
    }
}
