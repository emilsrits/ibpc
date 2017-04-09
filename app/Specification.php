<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    public function products() {
        return $this->belongsToMany(Product::class, 'product_specification');
    }
}
