<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    const STORAGE_PRODUCT_IMAGE_PATH = '/storage/images/products/';
    const DEFAULT_PRODUCT_IMAGE_PATH = '/images/products/default.png';

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
     * @param $ids
     */
    public function deleteProduct($ids)
    {
        if (is_array($ids)) {
            foreach ($ids as $id => $value) {
                $product = Product::find($id);
                $this->deleteImage($id);
                $product->destroy($id);
            }
        } else {
            $product = Product::findOrFail($ids);
            $this->deleteImage($ids);
            $product->destroy($ids);
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

    public function deleteImage($id)
    {
        $product = Product::find($id);
        $productImage = str_replace('/storage', '', $product->image_path);
        if ($productImage) {
            Storage::delete('/public' . $productImage);
        } else {
            return null;
        }
    }

    /**
     * Get product attribute by id
     *
     * @param $id
     * @return null
     */
    public function getAttributeById($id)
    {
        $attribute = $this->attributes()->find($id);
        if ($attribute) {
            $value = $attribute->pivot->value;
        } else {
            $value = null;
        }

        return $value;
    }

    /**
     * Get related category ids
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCategoryId()
    {
        return $this->categories()->getRelatedIds();
    }

    /**
     * Get product image attribute
     *
     * @return mixed|string
     */
    public function getImageAttribute()
    {
        $imagePath = $this->image_path;
        if ($imagePath && File::exists(public_path($imagePath))) {
            return $imagePath;
        } else {
            return self::DEFAULT_PRODUCT_IMAGE_PATH;
        }
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
