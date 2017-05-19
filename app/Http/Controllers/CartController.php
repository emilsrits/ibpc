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
    public function store(Request $request, $id)
    {
        $qty = $request->input('qty');
        if (!$qty) {
            $qty = 1;
        }

        $product = Product::find($id);
        if (!$product) {
            $request->session()->flash('message-danger', 'Product can not be added!');
            return redirect()->back();
        }

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id, $qty);

        Session::put('cart', $cart);

        $request->session()->flash('message-success', 'Product added to cart!');
        return redirect()->route('cart.index');
    }

    /**
     * Add a single product to cart from AJAX response
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeWithAjax(Request $request)
    {
        $qty = 1;

        $productId = $request['productId'];
        $product = Product::find($productId);

        if ($product) {
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $cart->add($product, $product->id, $qty);

            Session::put('cart', $cart);

            if (Session::has('cart')) {
                $items = Session::has('delivery') ? count(Session::get('cart')->items) - 1 : count(Session::get('cart')->items);
                $html = '(' . $items . ') ' . Session::get('cart')->getTotalCartPrice();
            } else {
                $html = 0;
            }

            return response()->json($html, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    /**
     * Remove product from cart
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->remove($id);

        Session::put('cart', $cart);

        $cart->isEmpty();

        return redirect()->route('cart.index');
    }

    /**
     * Update cart
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        $cartItemsQty = $request->input('cart');
        $cart->updateCart($request, $cartItemsQty);

        Session::put('cart', $cart);

        $cart->isEmpty();

        $request->session()->flash('message-success', 'Cart updated!');
        return redirect()->route('cart.index');
    }
}
