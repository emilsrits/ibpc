<?php

namespace App\Http\Controllers;

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

        return view('cart.checkout.index');
    }
}
