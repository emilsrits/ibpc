<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;

class AdminController extends Controller
{
    /**
     * AdminController constructor
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Return admin panel view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orders = $this->orderRepository->active()->orderBy('created_at', 'desc')->take(5)->get();

        return view('pages.admin.index', compact('orders'));
    }
}
