<?php

namespace App\Models;

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
        return $this->belongsTo('App\Models\User');
    }

    /**
     * ManyToMany relationship with Product class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('order_id', 'user_id', 'product_id', 'quantity', 'price');
    }

    /**
     * Order filters
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
     * Query for active orders
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', config('constants.order_status_active'));
    }

    /**
     * Query for finished orders
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFinished($query)
    {
        return $query->whereIn('status', config('constants.order_status_finished'));
    }

    /**
     * Set order status
     *
     * @param mixed $ids
     * @param string $status
     * @return mixed
     */
    public function setStatus($ids, $status)
    {
        if (is_array($ids)) {
            foreach ($ids as $id => $value) {
                $order = Order::find($id);
                if (orderStatusFinished($order->status)) {
                    return false;
                }
                $order->status = $status;
                $order->save();
            }
        } else {
            $order = Order::findOrFail($ids);
            if (orderStatusFinished($order->status)) {
                return false;
            }
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
