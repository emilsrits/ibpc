<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Return cart view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (!Session::has('cart')) {
            return view('cart.index');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        return view('cart.index', ['cart' => $cart, 'products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    /**
     * Adds product to cart and redirects to main shop view
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCart(Request $request, $id)
    {
        if ($request->input('qty')) {
            $qty = $request->input('qty');
        } else {
            $qty = 1;
        }

        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id, $qty);

        Session::put('cart', $cart);

        return redirect()->route('cart.index');
    }

    /**
     * Remove product from cart
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFromCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->remove($id);

        Session::put('cart', $cart);

        $cart->isCartEmpty();

        return redirect()->route('cart.index');
    }


}
