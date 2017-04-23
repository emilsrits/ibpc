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
    public function getCart()
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
    public function postAddToCart(Request $request, $id)
    {
        $qty = $request->input('qty');
        if ($qty) {
            $request->session()->flash('message-success', 'Product added to cart!');
        } else {
            $request->session()->flash('message-danger', 'Product can not be added!');
            return redirect()->back();
        }

        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id, $qty);

        Session::put('cart', $cart);

        return redirect()->route('cart.getCart');
    }

    /**
     * Remove product from cart
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRemoveFromCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->remove($id);

        Session::put('cart', $cart);

        $cart->isCartEmpty();

        return redirect()->route('cart.getCart');
    }

    /**
     * Update cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdateCart(Request $request)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        $cartItemsQty = $request->input('cart');
        $cart->updateCartItems($request, $cartItemsQty);

        Session::put('cart', $cart);

        $cart->isCartEmpty();

        return redirect()->route('cart.getCart');
    }
}
