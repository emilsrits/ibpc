<?php

namespace App;

use App\Filters\QueryFilter;
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
     * @param array|string $ids
     * @return bool
     */
    public function deleteProduct($ids)
    {
        if (is_array($ids)) {
            foreach ($ids as $id => $value) {
                $product = Product::find($id);
                if ($product->orders()->first()) {
                    return false;
                }
                $this->deleteImage($id);
                $product->destroy($id);
                return true;
            }
        } else {
            $product = Product::findOrFail($ids);
            if ($product->orders()->first()) {
                return false;
            }
            $this->deleteImage($ids);
            $product->destroy($ids);
            return true;
        }
    }

    /**
     * Set product attributes
     * 
     * @param array $data
     */
    public function setAttributes(array $data)
    {
        $specifications = collect($data);

        // If the product has any attributes attached
        if ($this->attributes()->first()) {
            foreach ($specifications as $category => $attributes) {
                foreach ($attributes as $attribute => $value) {
                    $productAttr = $this->attributes->find($attribute);
                    if ($productAttr) {
                        if (!ctype_space($value) && !$value == "") {
                            // Update attribute
                            $this->attributes()->detach(['attribute_id' => ['attribute_id' => $attribute, 'value' => $value]]);
                            $this->attributes()->attach(['attribute_id' => ['attribute_id' => $attribute, 'value' => $value]]);
                        } else {
                            // Remove attribute
                            $this->attributes()->detach(['attribute_id' => ['attribute_id' => $attribute, 'value' => $value]]);
                        }
                    } else {
                        if (!ctype_space($value) && !$value == "") {
                            // Add attribute
                            $this->attributes()->attach(['attribute_id' => ['attribute_id' => $attribute, 'value' => $value]]);
                        }
                    }
                }
            }
        } else {
            foreach ($specifications as $category => $attributes) {
                foreach ($attributes as $attribute => $value) {
                    if ($value) {
                        $this->attributes()->attach(['attribute_id' => ['attribute_id' => $attribute, 'value' => $value]]);
                    }
                }
            }
        }
    }

    /**
     * Change product status
     *
     * @param array|string $id
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
     * Store product image
     * 
     * @param $img
     * @param $code
     * @param $category
     * @return null|string
     */
    public function storeImage($img, $code, $category)
    {
        if ($img) {
            $imgExt =  $img->guessClientExtension();
            $imgName = $code . str_random(10) . '.' . $imgExt;
            $img->storeAs('/public/images/products/' . $category . '/' , $imgName);
            // Return image path
            return Product::STORAGE_PRODUCT_IMAGE_PATH . $category . '/' . $imgName;
        } else {
            return null;
        }
    }

    /**
     * Delete product image
     *
     * @return void|null
     */
    public function deleteImage()
    {
        $productImage = str_replace('/storage', '', $this->image_path);
        if ($productImage) {
            Storage::delete('/public' . $productImage);
        } else {
            return null;
        }
    }

    /**
     * Check if product has sufficient stock
     *
     * @param float|int $qty
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
     * @param float|int $qty
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
     * @param string $id
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
        return $this->categories()->allRelatedIds();
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
                if ($this->price_old > $this->price) {
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
