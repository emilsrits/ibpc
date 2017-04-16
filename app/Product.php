<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'image_path', 'code', 'title', 'description', 'price',
        'price_old', 'stock', 'status', 'created_at', 'updated_at'
    ];

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'product_specification')->withPivot('attribute', 'value');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    /**
     * Get product old price attribute
     *
     * @return string
     */
    public function getOldPriceAttribute()
    {
    	if ($this->price_old != '')
    		return ($this->price_old) . ' €';
    	else 
    		return  '';
    }

    /**
     * Get product current price attribute
     *
     * @return string
     */
    public function getCurrentPriceAttribute()
    {
    	return ($this->price) . ' €';
    }
}
