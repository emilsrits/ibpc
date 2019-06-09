<?php

namespace App\Http\Controllers;

use App\Filters\OrderFilter;
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
     * @param OrderFilter $filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function action(Request $request, OrderFilter $filters)
    {
        $orderIds = $request->input('orders');
        $status = $request->input('mass-action');
        $order = new Order();

        if ($orderIds && validStatus($status)) {
            $flash = $this->checkStatus($orderIds, $status);
            if ($flash === null) {
                $order->setStatus($orderIds, $status);
                $request->session()->flash('message-success', 'Order(s) ' . $status . '!');
                return redirect()->back();
            } else {
                $request->session()->flash($flash['type'], $flash['message']);
                return redirect()->back();
            }
        }

        $orders = Order::with('user')->filter($filters)->paginate(20);

        return view('admin.order.orders', ['orders' => $orders, 'request' => $request ]);
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
        $order->price = $cart->totalPrice + $cart->deliveryCost;
        $order->delivery = Session::get('delivery');
        $order->delivery_cost = $cart->deliveryCost;
        $order->status = config('constants.order_status.pending');

        // Check for item stock
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

        // Attach items to order and update their stock
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
                    $order->status = config('constants.order_status.canceled');
                    $order->save();
                    return redirect()->back();
                }
            }
        }

        $order->status = config('constants.order_status.invoiced');
        $this->invoice($user, $order);

        $order->save();

        $cart->deleteCart();

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
        if ($request['submit'] === 'invoice') {
            $order = Order::with('user')->find($id);
            $user = User::find($order->user->id);

            $this->invoice($user, $order);

            if ($order->status === config('constants.order_status.pending')) {
                $order->status = config('constants.order_status.invoiced');
            }
            $order->save();

            $request->session()->flash('message-success', 'Invoice successfully sent!');
            return redirect()->back();
        }

        if ($request['submit'] === 'save') {
            $order = Order::find($id);
            $status = $request['status'];

            // Cancel update if there is nothing to update
            if (!$status) {
                $request->session()->flash('message-warning', 'Nothing to update.');
                return redirect()->back();
            }

            $flash = $this->checkStatus($id, $status);
            if ($flash != null) {
                $request->session()->flash($flash['type'], $flash['message']);
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
     * Check if order status can be updated
     *
     * @param array|int $id
     * @param string $status
     * @return null|array
     */
    protected function checkStatus($id, string $status)
    {
        $flash = null;

        if (is_array($id)) {
            // Check if status is valid
            if (!validStatus($status)) {
                $flash = array(
                    'type'      => 'message-danger',
                    'message'   => 'Invalid order status!'
                );
                return $flash;
            }

            // Check if order is finished
            foreach ($id as $key => $value) {
                $order = Order::find($key);
                if (in_array($order->status, config('constants.order_status_finished'))) {
                    $flash = array(
                        'type'      => 'message-danger',
                        'message'   => 'Can not change status of a finished order!'
                    );
                    return $flash;
                }
            }

            return $flash;
        }

        $order = Order::find($id);

        // Check if status is valid
        if (!validStatus($status)) {
            $flash = array(
                'type'      => 'message-danger',
                'message'   => 'Invalid order status!'
            );
            return $flash;
        }

        // Check if order is finished
        if (in_array($order->status, config('constants.order_status_finished'))) {
            $flash = array(
                'type'      => 'message-danger',
                'message'   => 'Can not change status of a finished order!'
            );
            return $flash;
        }

        return $flash;
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

        Mail::send('emails.invoice', ['user' => $user, 'order' => $order], function($message) use($pdf, $user, $order)
        {
            $message->to($user->email)->subject('Invoice for order #' . $order->id);

            $message->attachData($pdf->output(), $order->id .'-invoice.pdf');
        });


        if (config('constants.invoice_storage')) {
            $now = Carbon::now();
            Storage::put('orders/' . $now->year . '/' . $now->month . '/' . $order->id .'-invoice-' . str_random(2) . '.pdf', $pdf->output());
        }
    }
}
