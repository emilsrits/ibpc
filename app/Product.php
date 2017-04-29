<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'image_path', 'code', 'title', 'description', 'price',
        'price_old', 'stock', 'status', 'created_at', 'updated_at'
    ];

    /**
     * ManyToMany relationship with Attribute class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_product')->withPivot('attribute_id', 'value');
    }

    /**
     * ManyToMany relationship with Category class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    /**
     * Delete a product
     *
     * @param $id
     */
    public function deleteProduct($id)
    {
        if (is_array($id)) {
            Product::destroy($id);
        } else {
            Product::findOrFail($id)->delete();
        }
    }

    /**
     * Change product status
     *
     * @param $id
     * @param $status
     */
    public function setStatus($id, $status)
    {
        if (is_array($id)) {
            foreach ($id as $productId => $value) {
                $product = Product::find($value['id']);
                $product->status = $status;
                $product->save();
            }
        } else {
            $product = Product::findOrFail($id);
            $product->status = $status;
            $product->save();
        }
    }

    public function getCategoryId()
    {
        return $this->categories()->getRelatedIds();
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
