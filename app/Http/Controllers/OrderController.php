<?php

namespace App\Http\Controllers;

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
     */
    public function __construct(OrderService $orderService, OrderRepository $orderRepository)
    {
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Return orders page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orders = $this->orderRepository->paginate();

        return view('admin.order.orders', ['orders' => $orders, 'request' => null]);
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
            $request->session()->flash($this->orderService->message['type'], $this->orderService->message['content']);
            return redirect()->back();
        }

        $orders = $this->orderRepository->with('user')->filter($filters)->paginate();

        return view('admin.order.orders', compact('orders', 'request'));
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
            $request->session()->flash($this->orderService->message['type'], $this->orderService->message['content']);
            return redirect()->back();
        }

        $request->session()->flash($this->orderService->message['type'], $this->orderService->message['content']);
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

        $request->session()->flash($this->orderService->message['type'], $this->orderService->message['content']);
        return redirect()->back();
    }

    /**
     * Invoice order
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invoice(Request $request, Order $order)
    {
        $this->orderService->invoice($order);

        $request->session()->flash($this->orderService->message['type'], $this->orderService->message['content']);
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
