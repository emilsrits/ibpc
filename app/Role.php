<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	public $timestamps = false;

    /**
     * ManyToMany relationship with User class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
   	public function users() {
   	    return $this->belongsToMany('App\User');
    }
}
