<?php

namespace App\Http\Controllers;

use App\Order;
use App\Filters\OrderFilter;
use Illuminate\Http\Request;
use App\Actions\Order\OrderStoreAction;
use App\Actions\Order\OrderActionAction;
use App\Actions\Order\OrderUpdateAction;
use App\Http\Requests\Order\OrderActionRequest;
use App\Http\Requests\Order\OrderUpdateRequest;

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
     * @param \App\Http\Requests\Order\OrderActionRequest $request
     * @param \App\Actions\Order\OrderActionAction $action
     * @param OrderFilter $filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function action(OrderActionRequest $request, OrderActionAction $action, OrderFilter $filters)
    {
        $flash = $action->execute($request->all());
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $orders = Order::with('user')->filter($filters)->paginate(20);

        return view('admin.order.orders', ['orders' => $orders, 'request' => $request]);
    }

    /**
     * Create an order
     *
     * @param Request $request
     * @param \App\Actions\Order\OrderStoreAction $action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request, OrderStoreAction $action)
    {
        $flash = $action->execute();
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $request->session()->flash('message-success', 'Order successfully placed!');
        return redirect()->route('order.success', ['success' => true]);
    }

    /**
     * Return order edit view
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $order = Order::with('user')->findOrFail($id);
        $closed = in_array($order->status, config('constants.order_status_finished'));

        return view('admin.order.edit', ['order' => $order, 'closed' => $closed]);
    }

    /**
     * Update order
     *
     * @param \App\Http\Requests\Order\OrderUpdateRequest $request
     * @param \App\Actions\Order\OrderUpdateAction $action
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OrderUpdateRequest $request, OrderUpdateAction $action, $id)
    {
        $flash = $action->execute($request->all(), $id);
        if ($flash !== null) {
            $request->session()->flash($flash['type'], $flash['message']);
        }

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
}
