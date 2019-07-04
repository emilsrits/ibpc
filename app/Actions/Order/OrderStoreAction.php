<?php

namespace App\Actions\Order;

use App\Order;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderStoreAction
{
    /**
     * Process the order store action
     *
     * @param array $data
     * @return void|array
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

        $cart = Session::get('cart');
        $order = new Order();
        $order->user_id = $user->id;
        $order->price = $cart->getTotalPriceWithVat();
        $order->delivery = Session::get('delivery');
        $order->delivery_cost = $cart->deliveryCost;
        $order->status = config('constants.order_status.pending');

        // Check for item stock
        foreach ($cart->items as $item) {
            $productId = $item['item']['id'];

            if ($productId) {
                $product = Product::find($productId);

                if (!$product->checkStock(-1 * abs($item['qty']))) {
                    $flash = [
                        'type' => 'message-danger',
                        'message' => 'Not enough of product ' . $product->title . ' in stock!'
                    ];

                    return $flash;
                }
            }
        }

        $order->save();

        // Attach items to order and update their stock
        foreach ($cart->items as $item) {
            $productId = $item['item']['id'];
            
            if ($productId) {
                $order->products()->attach([
                    'order_id' => [
                        'order_id' => $order->id,
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'quantity' => $item['qty'],
                        'price' => $item['price']
                    ]
                ]);

                $product = Product::find($productId);

                if (!$product->updateStock(-1 * abs($item['qty']))) {
                    $flash = [
                        'type' => 'message-danger',
                        'message' => 'Not enough of product ' . $product->title . ' in stock!'
                    ];
                    $order->status = config('constants.order_status.canceled');
                    $order->save();

                    return $flash;
                }
            }
        }

        $order->status = config('constants.order_status.invoiced');
        $user->invoice($user, $order);

        $order->save();

        $cart->deleteCart();

        return;
    }
}
