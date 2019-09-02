<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $cart = session('cart');
        $cart->setVat();

        return view('pages.checkout.index', compact('user', 'cart'));
    }

    /**
     * Return checkout confirmation page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $cart = session('cart');
        $cart->setUpDelivery($request->delivery);
        $cart->setVat();

        if (!session('delivery')) {
            return view('pages.checkout.delivery');
        }

        return view('pages.checkout.confirmation', compact('user', 'cart'));
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

        if (!$user->canMakeOrder()) {
            flashMessage('message-warning', 'Please fill in missing shipping address information!');
            return redirect()->back();
        }

        return view('pages.checkout.delivery');
    }
}
