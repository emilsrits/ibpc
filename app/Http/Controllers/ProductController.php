<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Session;

class ProductController extends Controller
{
    /**
     * Returns main shop view with all products
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
    	$products = Product::paginate(12);

    	return view('shop.index', ['products' => $products]);
    }

    /**
     * Return cart view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart()
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
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCart($id)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        Session::put('cart', $cart);

        return redirect()->route('shop.index');
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

        return redirect()->route('product.cart');
    }

    /**
     * Return product view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewProduct($id)
    {
        $product = Product::find($id);
        return view('shop.product', ['product' => $product]);
    }
}
