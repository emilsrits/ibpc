<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    /**
     * ManyToMany relationship with User class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
   	public function users() {
   	    return $this->belongsToMany('App\Models\User');
    }
}
