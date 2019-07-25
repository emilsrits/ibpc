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
    /**
     * The properties that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'code', 'title', 'description', 'price',
        'price_old', 'stock', 'status', 'created_at', 'updated_at'
    ];

    /**
     * ManyToMany relationship with Property class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'product_property')->withPivot('property_id', 'value')->withTimestamps();
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
     * Query to only include products matched by code
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $code
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCode($query, $code)
    {
        return $query->where('code', '=' , $code);
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
     * @param mixed $ids
     * @return bool
     */
    public function deleteProduct($ids = null)
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
            if ($this->orders()->first()) {
                return false;
            }
            $this->deleteMedia();
            $this->destroy($this->id);
            return true;
        }
    }

    /**
     * Set product properties
     * 
     * @param array $data
     */
    public function setProperties(array $data)
    {
        $arr = $this->collectProperties($data);
        $this->properties()->attach(intermediateSyncArray($arr));
    }

    /**
     * Update product properties
     * 
     * @param array $data
     */
    public function updateProperties(array $data)
    {
        $arr = $this->collectProperties($data);
        $this->properties()->sync(intermediateSyncArray($arr));
    }

    /**
     * Collect properties from an array of specifications and their properties
     *
     * @param array $data
     * @return array
     */
    private function collectProperties(array $data)
    {
        $arr = [];
        foreach ($data as $key => $properties) {
            foreach ($properties as $property => $value) {
                if (!ctype_space($value) && !$value == "") {
                    array_push($arr, [$property => $value]);
                }
            }
        }

        return $arr;
    }

    /**
     * Change product status
     *
     * @param mixed $id
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
     * @param mixed $qty
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
     * @param mixed $qty
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
     * Return product property group names
     *
     * @return mixed
     */
    public function getPropertyGroupNames()
    {
        if ($this->properties()->first()) {
            $arr = [];
            foreach ($this->properties as $property) {
                array_push($arr, $property->specification->name);
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

    /**
     * Group product properties by their specifications
     * 
     * @return array
     */
    public function groupPropertiesBySpecification()
    {
        $grouped = $this->properties->mapToGroups(function ($item, $key) {
            return [
                $item->specification->name => [
                    'name' => $item['name'],
                    'value' => $item->pivot->value
                ]
            ];
        });

        return $grouped->toArray();
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
     * Get product property by id
     *
     * @param string $id
     * @return null
     */
    public function getPropertyById($id)
    {
        $property = $this->properties()->find($id);
        if ($property) {
            $value = $property->pivot->value;
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
     * Get product category title attribute
     *
     * @return mixed
     */
    public function getCategoryTitleAttribute()
    {
        $category = $this->categories()->first();
        return ($category) ? $category->title : null;
    }

    /**
     * Get product price from a order
     *
     * @param $orderId
     * @param $productId
     * @return mixed
     */
    public function getOrderPriceById($orderId, $productId)
    {
        $order = $this->orders()->where([
            ['order_id', '=', $orderId],
            ['product_id', '=', $productId]
        ])->first();

        if ($order) {
            $price = $order->pivot->price;
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
     * @return mixed
     */
    public function getOrderTotalPriceById($orderId, $productId)
    {
        $order = $this->orders()->where([
            ['order_id', '=', $orderId],
            ['product_id', '=', $productId]
        ])->first();

        if ($order) {
            $price = ($order->pivot->price * $order->pivot->quantity);
        } else {
            $price = null;
        }

        return $price;
    }

    /**
     * Mutator for price attribute
     *
     * @param string $price
     */
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
