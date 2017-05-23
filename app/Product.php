<?php

namespace App;

use App\Filters\QueryFilter;
use Dompdf\Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * ManyToMany relationship with Order class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order')->withPivot('order_id', 'user_id', 'product_id', 'quantity', 'price');
    }

    /**
     * Product filters
     *
     * @param $query
     * @param QueryFilter $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setStatus($id, $status)
    {
        if (is_array($id)) {
            foreach ($id as $productId => $value) {
                $product = Product::find($value['id']);
                $product->status = $status;
                $product->save();
            }
        }
        if (!$id) {
            try {
                $product = Product::findOrFail($id);
                $product->status = $status;
                $product->save();
            } catch (ModelNotFoundException $e) {
                return redirect()->back();
            }
        }
    }

    /**
     * Delete product image
     *
     * @param $id
     * @return null
     */
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
     * Check if product has sufficient stock
     *
     * @param $qty
     * @return bool
     */
    public function checkStock($qty)
    {
        $stockLeft = $this->stock + $qty;
        if ($stockLeft < 0) {
            return false;
        }

        return true;
    }

    /**
     * Update product stock
     *
     * @param $qty
     * @return bool
     */
    public function updateStock($qty)
    {
        $this->stock += $qty;
        if ($this->stock <= 0) {
            $this->status = 0;
            if ($this->stock < 0) {
                $this->stock = 0;
                return false;
            }
        }
        $this->save();

        return true;
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
     * Return price with currency
     *
     * @param $price
     * @param null $orderId
     * @param null $productId
     * @return null|string
     */
    public function getPriceCurrency($price, $orderId = null, $productId = null)
    {
        switch ($price) {
            case 'old':
                if ($this->price_old) {
                    return $this->price_old . ' €';
                } else {
                    return null;
                }
            case 'current':
                return $this->price . ' €';
            case 'order':
                return $this->getOrderPriceById($orderId, $productId, 1);
            case 'order_total':
                return $this->getOrderTotalPriceById($orderId, $productId, 1);
        }
    }

    /**
     * Get product old price attribute
     *
     * @return string
     */
    public function getOldPriceAttribute()
    {
    	if ($this->price_old)
    		return ($this->price_old);
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
    	return ($this->price);
    }

    /**
     * Get product price from a order
     *
     * @param $orderId
     * @param $productId
     * @param null $currency
     * @return null|string
     */
    public function getOrderPriceById($orderId, $productId, $currency = null)
    {
        $order = $this->orders()->where([
            ['order_id', '=', $orderId],
            ['product_id', '=', $productId]
        ])->first();

        if ($order) {
            if ($currency) {
                $price = $order->pivot->price . ' €';
            } else {
                $price = $order->pivot->price;
            }
        } else {
            $price = null;
        }

        return $price;
    }

    /**
     * Get product total price from a order
     *
     * @param $orderId
     * @param $productId
     * @param null $currency
     * @return null|string
     */
    public function getOrderTotalPriceById($orderId, $productId, $currency = null)
    {
        $order = $this->orders()->where([
            ['order_id', '=', $orderId],
            ['product_id', '=', $productId]
        ])->first();

        if ($order) {
            if ($currency) {
                $price = ($order->pivot->price * $order->pivot->quantity) . ' €';
            } else {
                $price = ($order->pivot->price * $order->pivot->quantity);
            }
        } else {
            $price = null;
        }

        return $price;
    }
}
