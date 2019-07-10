<?php

namespace App\Models;

use App\Models\Media;
use App\Filters\QueryFilter;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'code', 'title', 'description', 'price',
        'price_old', 'stock', 'status', 'created_at', 'updated_at'
    ];

    /**
     * ManyToMany relationship with Attribute class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_product')->withPivot('attribute_id', 'value')->withTimestamps();
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
        return $this->belongsToMany('App\Models\Order')->withPivot('order_id', 'user_id', 'product_id', 'quantity', 'price');
    }

    /**
     * OneToMany relationship with Media class
     */
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Product filters
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param QueryFilter $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Query to only include active products
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', '=' , 1);
    }

    /**
     * Query to only include stocked products
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStocked($query)
    {
        return $query->where('stock', '>', 0);
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
                $product->deleteMedia();
                $product->destroy($id);
                return true;
            }
        } else {
            $product = Product::findOrFail($ids);
            if ($product->orders()->first()) {
                return false;
            }
            $product->deleteMedia();
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
        $arr = $this->collectAttributes($data);
        $this->attributes()->attach(intermediateSyncArray($arr));
    }

    /**
     * Update product attributes
     * 
     * @param array $data
     */
    public function updateAttributes(array $data)
    {
        $arr = $this->collectAttributes($data);
        $this->attributes()->sync(intermediateSyncArray($arr));
    }

    /**
     * Collect attributes from an array of specifications and their attributes
     *
     * @param array $data
     * @return array
     */
    private function collectAttributes(array $data)
    {
        $arr = [];
        foreach ($data as $key => $attributes) {
            foreach ($attributes as $attribute => $value) {
                if (!ctype_space($value) && !$value == "") {
                    array_push($arr, [$attribute => $value]);
                }
            }
        }

        return $arr;
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
     * Delete product media
     *
     * @return void
     */
    protected function deleteMedia()
    {
        foreach($this->media as $media) {
            $file = str_replace('/storage', '', $media->path);
            if ($file && Storage::exists('/public' . $file)) {
                Storage::delete('/public' . $file);
            }
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
     * Return product attribute group names
     *
     * @return mixed
     */
    public function getAttributeGroupNames()
    {
        if ($this->attributes()->first()) {
            $arr = [];
            foreach ($this->attributes as $attribute) {
                array_push($arr, $attribute->specification->name);
            }
            return array_unique($arr);
        }

        return null;
    }

    /**
     * Get products which title or code match the input
     *
     * @param string $input
     * @return Product
     */
    public function getByTitleAndCode($input)
    {
        return $this->active()->where(function ($query) use ($input) {
            $query->where('title', 'like', '%'.$input.'%')
                ->orWhere('code', 'like', '%'.$input.'%');
        });
    }

    public function getWithSpecificationsByCode($code)
    {
        return $this->with('attributes.specification')->where('code', $code)->first();
    }

    /**
     * Get products under specific category
     *
     * @param integer $categoryId
     * @return Product
     */
    public function getByCategoryId($categoryId)
    {
        return $this->active()->whereHas('categories', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        });
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
     * Get product media attribute
     *
     * @return mixed
     */
    public function getImageAttribute()
    {
        if ($this->media()->first()) {
            $mediaPath = $this->media()->first()->path;
            if ($mediaPath && File::exists(public_path($mediaPath))) {
                return $mediaPath;
            } else {
                return Media::DEFAULT_PRODUCT_MEDIA_PATH;
            }
        } else {
            return Media::DEFAULT_PRODUCT_MEDIA_PATH;
        }
    }

    /**
     * Get specific amount of media items
     * 
     * @param integer $count
     * @param integer $index
     * @return Collection
     */
    public function getImages($count = 1, $index = null)
    {
        if ($index) {
            $items = $this->media->take($count);
            $items = $items->slice($index);
        } else {
            $items = $this->media->take($count);
        }

        return $items;
    }

    /**
     * Return price with currency
     *
     * @param $price
     * @param null $orderId
     * @param null $productId
     * @return mixed
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
    	return $this->price;
    }

    /**
     * Get product price from a order
     *
     * @param $orderId
     * @param $productId
     * @param null $currency
     * @return mixed
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
     * @return mixed
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

    public function setPriceAttribute($price)
    {
        if ($price !== $this->price_old) {
            $this->attributes['price_old'] = $this->price;
        }
        if ($price >= $this->price_old) {
            $this->attributes['price_old'] = null;
        }
        $this->attributes['price'] = $price;
    }
}
