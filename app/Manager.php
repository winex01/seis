<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    //
    protected $guarded = [];

    public function getFullNameAttribute()
	{
	    return "{$this->firstname} {$this->middlename[0]}. {$this->lastname} {$this->suffix}";
	}

	public function games()
	{
		return $this->belongsToMany(Game::class);
	}
}
