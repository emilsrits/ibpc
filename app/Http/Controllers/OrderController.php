<?php

namespace App\Http\Controllers;

use App\Admin\Tables\OrderTable;
use App\Models\Order;
use App\Filters\OrderFilter;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Order\OrderActionRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    /**
     * OrderController constructor
     *
     * @param OrderService $orderService
     * @param OrderRepository $orderRepository
     * @param OrderTable $orderTable
     */
    public function __construct(
        OrderService $orderService,
        OrderRepository $orderRepository,
        OrderTable $orderTable
    ) {
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
        $this->orderTable = $orderTable;
    }

    /**
     * Return orders page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orders = $this->orderRepository->paginate();

        return view('admin.order.orders', [
            'orders' => $orders,
            'table' => $this->orderTable
        ]);
    }

    /**
     * Order mass action
     *
     * @param \App\Http\Requests\Order\OrderActionRequest $request
     * @param OrderFilter $filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function action(OrderActionRequest $request, OrderFilter $filters)
    {
        $action = $this->orderService->action($request->validated());
        if ($action) {
            return redirect()->back();
        }

        $orders = $this->orderRepository->with('user')->filter($filters)->paginate();
        $table = $this->orderTable;

        return view('admin.order.orders', compact('orders', 'table', 'request'));
    }

    /**
     * Create an order
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $action = $this->orderService->store(Auth::user(), session('cart'));
        if (!$action) {
            return redirect()->back();
        }

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
        $order = $this->orderRepository->with('user')->find($id);
        $closed = in_array($order->status, config('constants.order_status_finished'));

        return view('admin.order.edit', compact('order', 'closed'));
    }

    /**
     * Update order
     *
     * @param \App\Http\Requests\Order\OrderUpdateRequest $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        $this->orderService->update($request->validated(), $order);

        return redirect()->back();
    }

    /**
     * Invoice order
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invoice(Order $order)
    {
        $this->orderService->invoice($order);

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
            return view('checkout.success');
        }
        
        return redirect()->route('shop.index');
    }
}
