<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        if ($order->status === config('constants.order_status.canceled')) {
            $products = $order->products()->get();
            foreach ($products as $product) {
                $product->updateStock($product->pivot->quantity);
            }
        }
    }
}
