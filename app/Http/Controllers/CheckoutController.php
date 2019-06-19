<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Return checkout page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getDelivery(Request $request)
    {
        $user = Auth::user();

        if (!$user->address) {
            $request->session()->flash('message-warning', 'Please add your shipping address to your account!');
            return redirect()->back();
        }

        return view('cart.checkout.delivery');
    }
}
