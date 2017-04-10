<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Session;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

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

        return redirect()->route('product.cart');
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
        $product = Product::with('specifications')->find($id);

        $specifications = new Collection;

        foreach($product->specifications as $specification) {
            if (!$specifications->has($specification->name)) {
                $currentSpecs = new Collection;
            } else {
                $currentSpecs = $specifications->get($specification->name);
            }
            $currentSpecs->put($specification->pivot->attribute, $specification->pivot->value);
            $specifications->put($specification->name, $currentSpecs);
        }

        return view('shop.product', ['product' => $product], ['specifications' => $specifications]);
    }
}
