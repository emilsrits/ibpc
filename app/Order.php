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
     * Return price with currency symbol
     *
     * @param $price
     * @return string
     */
    public function getPriceCurrency($price)
    {
        switch ($price) {
            case 'total':
                return $this->price . ' €';
                break;
            case 'delivery':
                return $this->delivery_cost . ' €';
                break;
        }
    }
}
