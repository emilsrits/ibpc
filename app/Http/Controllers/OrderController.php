<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Create an order
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $cart = Session::get('cart');
        $order = new Order();
        $order->user_id = $user->id;
        $order->price = $cart->totalPrice + $cart->deliveryPrice;
        $order->discount = null;
        $order->delivery = Session::get('delivery');
        $order->status = 'Processing';
        $order->save();

        foreach ($cart->items as $item) {
            if ($item['item']['id']) {
                $order->products()->attach(['order_id' => [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'product_id' => $item['item']['id'],
                    'quantity' => $item['qty']
                ]]);
            }
        }

        $cart->deleteCart();
        Session::forget('delivery');

        $request->session()->flash('message-success', 'Order successfully placed!');
        return view('cart.checkout.success');
    }
}
