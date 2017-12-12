<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SportManager extends Model
{
    //
    protected $guarded = [];

    public function getFullNameAttribute()
	{
	    return "{$this->firstname} {$this->middlename[0]}. {$this->lastname} {$this->suffix}";
	}
}
