<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
            $productId = $item['item']['id'];
            if ($productId) {
                $order->products()->attach(['order_id' => [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'quantity' => $item['qty'],
                    'price' => $item['price']
                ]]);
                $product = Product::find($productId);
                if (!$product->updateStock(-1 * abs($item['qty']))) {
                    $request->session()->flash('message-danger', 'Not enough of product ' . $product->title . ' in stock!');
                    return redirect()->back();
                }
            }
        }

        $this->invoice($user, $order);

        $order->status = 'Pending';
        $order->save();

        $cart->deleteCart();
        Session::forget('delivery');

        $request->session()->flash('message-success', 'Order successfully placed!');
        return redirect()->route('order.success', ['success' => true]);
    }

    /**
     * Return success page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function success(Request $request)
    {
        if ($request['success']) {
            return view('cart.checkout.success');
        }
        return redirect()->route('shop.index');
    }

    /**
     * Create invoice file and send email to user
     *
     * @param $user
     * @param $order
     */
    protected function invoice($user, $order)
    {
        $pdf = PDF::loadView('pdf.invoice', ['user' => $user, 'order' => $order]);
        $now = Carbon::now();
        Storage::put('orders/' . $now->year . '/' . $now->month . '/' . $order->id .'-invoice.pdf', $pdf->output());

        Mail::send('emails.invoice', ['user' => $user, 'order' => $order], function($message) use($pdf, $user, $order)
        {
            $message->from('noreply@ibpc.dev', 'IBPC.dev');

            $message->to($user->email)->subject('Invoice for order #' . $order->id);

            $message->attachData($pdf->output(), $order->id .'-invoice.pdf');
        });
    }
}
