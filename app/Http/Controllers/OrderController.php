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
     * Return orders page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::with('user')->paginate(20);

        return view('admin.order.orders', ['orders' => $orders, 'request' => null]);
    }

    /**
     * Order mass action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(Request $request)
    {
        $orderIds = $request->input('orders');
        $order = new Order();

        if ($orderIds) {
            switch ($request->input('mass-action')) {
                case 1:
                    $order->setStatus($orderIds, 'canceled');
                    $request->session()->flash('message-success', 'Order(s) canceled!');
                    return redirect()->back();
                case 2:
                    $order->setStatus($orderIds, 'pending');
                    $request->session()->flash('message-success', 'Order(s) pending!');
                    return redirect()->back();
                case 3:
                    $order->setStatus($orderIds, 'invoiced');
                    $request->session()->flash('message-success', 'Order(s) invoiced!');
                    return redirect()->back();
                case 4:
                    $order->setStatus($orderIds, 'shipped');
                    $request->session()->flash('message-success', 'Order(s) shipped!');
                    return redirect()->back();
                case 5:
                    $order->setStatus($orderIds, 'completed');
                    $request->session()->flash('message-success', 'Order(s) completed!');
                    return redirect()->back();
            }
        }

        if ($request->has('searchId')) {
            $order = Order::where('id', $request['searchId'])->paginate(20);

            return view('admin.order.orders', ['orders' => $order, 'request' => $request ]);
        }

        return redirect()->back();
    }

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
        $order->status = 'pending';

        foreach ($cart->items as $item) {
            $productId = $item['item']['id'];
            if ($productId) {
                $product = Product::find($productId);
                if (!$product->checkStock(-1 * abs($item['qty']))) {
                    $request->session()->flash('message-danger', 'Not enough of product ' . $product->title . ' in stock!');
                    return redirect()->back();
                }
            }
        }

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
                    $order->status = 'canceled';
                    $order->save();
                    return redirect()->back();
                }
            }
        }

        $this->invoice($user, $order);

        $order->status = 'invoiced';
        $order->save();

        $cart->deleteCart();
        Session::forget('delivery');

        $request->session()->flash('message-success', 'Order successfully placed!');
        return redirect()->route('order.success', ['success' => true]);
    }

    /**
     * Return order edit view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $order = Order::with('user')->find($id);

        return view('admin.order.edit', [
            'order' => $order
        ]);
    }

    /**
     * Update order
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if ($request['submit'] === 'save') {
            $order = Order::find($id);
            $status = $request['status'];

            if (!in_array($status, array('canceled','pending', 'invoiced', 'shipped', 'completed'), true )) {
                $request->session()->flash('message-danger', 'Invalid order status!');
                return redirect()->back();
            }

            $order->status = $status;
            $order->save();

            $request->session()->flash('message-success', 'Order successfully updated!');
            return redirect()->back();
        }

        $request->session()->flash('message-danger', 'Invalid form action!');
        return redirect()->back();
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
        Storage::put('orders/' . $now->year . '/' . $now->month . '/' . $order->id .'-invoice-' . str_random(2) . '.pdf', $pdf->output());

        Mail::send('emails.invoice', ['user' => $user, 'order' => $order], function($message) use($pdf, $user, $order)
        {
            $message->from('noreply@ibpc.dev', 'IBPC.dev');

            $message->to($user->email)->subject('Invoice for order #' . $order->id);

            $message->attachData($pdf->output(), $order->id .'-invoice.pdf');
        });
    }
}
