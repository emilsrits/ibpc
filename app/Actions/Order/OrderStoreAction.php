<?php

namespace App\Actions\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Events\OrderCreated;

class OrderStoreAction
{
    /**
     * Process the order store action
     *
     * @param array $data
     * @return mixed
     */
    public function execute()
    {
        $user = Auth::user();
        
        if (!$user->canMakeOrder()) {
            $flash = [
                'type' => 'message-warning',
                'message' => 'Please fill in missing shipping address information!'
            ];

            return $flash;
        }

        $cart = session('cart');
        $order = new Order();

        $order->setUpOrder($cart, $user->id);
        $attached = $order->addItems($cart->items, $user->id);

        if ($attached === false) {
            $flash = [
                'type' => 'message-danger',
                'message' => 'Not enough of products in stock!'
            ];

            return $flash;
        }

        event(new OrderCreated($order, $user));

        $cart->deleteCart();

        return;
    }
}
