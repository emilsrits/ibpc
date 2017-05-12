<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
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
}
