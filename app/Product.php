<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'image_path', 'code', 'title', 'description', 'price', 'price_old', 'storage', 'status', 'created_at', 'updated_at'];

    public function getOldPriceAttribute ($value) {
    	if ($this->price_old != '')
    		return '€'.($this->price_old);
    	else 
    		return  '';
    }

    public function getCurrentPriceAttribute ($value) {
    	return '€'.($this->price);
    }
}
