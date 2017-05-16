<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Return checkout page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            $request->session()->flash('message-info', 'Please login or register!');
            return redirect()->route('user.login');
        }

        $user = Auth::user();

        $cart = new Cart(null);
        $cart = $cart->getCart();

        return view('cart.checkout.index', ['user' => $user, 'cart' => $cart]);
    }

    /**
     * Return checkout confirmation page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        switch ($request['delivery']) {
            case 'storage':
                Session::put('delivery', 'storage');
                break;
            case 'address':
                Session::put('delivery', 'address');
                break;
        }

        if (!Session::get('delivery')) {
            $request->session()->flash('message-danger', 'Choose delivery option!');
            return view('cart.checkout.delivery');
        }

        $user = Auth::user();

        $cart = new Cart(null);
        $cart = $cart->getCart();
        $cart->addDelivery($request['delivery']);

        return view('cart.checkout.confirmation', ['user' => $user, 'cart' => $cart]);
    }

    /**
     * Return order checkout delivery page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDelivery()
    {
        return view('cart.checkout.delivery');
    }
}
