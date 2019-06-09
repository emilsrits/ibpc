<?php

namespace App;

use App\Filters\QueryFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * OneToMany inverse relationship with User class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * ManyToMany relationship with Product class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('order_id', 'user_id', 'product_id', 'quantity', 'price');
    }

    /**
     * Order filters
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
     * Set order status
     *
     * @param array|int $ids
     * @param string $status
     */
    public function setStatus($ids, $status)
    {
        if (is_array($ids)) {
            foreach ($ids as $id => $value) {
                $order = Order::find($id);
                $order->status = $status;
                $order->save();
            }
        } else {
            $order = Order::findOrFail($ids);
            $order->status = $status;
            $order->save();
        }
    }

    /**
     * Return price with currency symbol
     *
     * @param $price
     * @return string
     */
    public function getPriceCurrency($price)
    {
        switch ($price) {
            case 'price':
                return $this->price . ' €';
            case 'delivery':
                return $this->delivery_cost . ' €';
        }
    }

    /**
     * Get formatted order creation date
     *
     * @return string
     */
    public function getCreatedAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d');
    }

    /**
     * Get formatted order update date
     *
     * @return string
     */
    public function getUpdatedAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('Y-m-d');
    }
}
