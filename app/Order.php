<?php

namespace App;

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
     * Get order price
     *
     * @return string
     */
    public function getTotalPriceAttribute()
    {
        if ($this->price)
            return ($this->price) . ' €';
        else
            return  '';
    }

    /**
     * Get order delivery cost
     *
     * @return string
     */
    public function getDeliveryPriceAttribute()
    {
        if ($this->delivery_cost)
            return ($this->delivery_cost) . ' €';
        else
            return  '';
    }
}
