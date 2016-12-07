<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Illuminate\Http\Request;
use Session;

class ProductController extends Controller
{
    public function index()
    {
    	$products = Product::all();
    	return view('shop.index', ['products' => $products]);
    }

    public function addToCart(Request $request, $id) {
    	$product = Product::find($id);
    	$oldCart = Session::has('cart') ? Session::get('cart') : null;
    	$cart = new Cart($oldCart);
    	$cart->add($product, $product->id);

    	Session::put('cart', $cart);
    	return redirect()->route('shop.index');
    }

    public function cart() {
    	if (!Session::has('cart')) {
    		return view('shop.cart');
    	}
    	$oldCart = Session::get('cart');
    	$cart = new Cart($oldCart);
    	return view('shop.cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }
}
