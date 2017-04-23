<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * ManyToMany relationship with Product class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    /**
     * ManyToMany relationship with Specification class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'category_specification');
    }
}
