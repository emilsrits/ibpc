<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
        $order->delivery_cost = $cart->deliveryPrice;
        $order->status = 'Processing';
        $order->save();

        foreach ($cart->items as $item) {
            if ($item['item']['id']) {
                $order->products()->attach(['order_id' => [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'product_id' => $item['item']['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price']
                ]]);
            }
        }

        $this->invoice($user, $order);

        $order->status = 'Processing';
        $order->save();

        $cart->deleteCart();
        Session::forget('delivery');

        $request->session()->flash('message-success', 'Order successfully placed!');
        return redirect()->route('order.success', ['success' => true]);
    }

    public function success(Request $request)
    {
        if ($request['success']) {
            return view('cart.checkout.success');
        }
        return redirect()->route('shop.index');
    }

    protected function invoice($user, $order)
    {
        $pdf = PDF::loadView('pdf.invoice', ['user' => $user, 'order' => $order]);
        $now = Carbon::now();
        Storage::put('orders/' . $now->year . '/' . $now->month . '/' . $order->id .'-invoice.pdf', $pdf->output());
    }
}
