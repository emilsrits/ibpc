<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    /**
     * OneToMany relationship with Attribute class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_specification');
    }
}
