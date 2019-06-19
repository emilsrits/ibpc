<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Actions\Cart\CartStoreAction;
use App\Actions\Cart\CartDeleteAction;
use App\Actions\Cart\CartUpdateAction;
use Illuminate\Support\Facades\Session;
use App\Actions\Cart\CartStoreAjaxAction;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartDeleteRequest;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Http\Requests\Cart\CartStoreAjaxRequest;

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
     * @param CartStoreRequest $request
     * @param CartStoreAction $action
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CartStoreRequest $request, CartStoreAction $action, $id)
    {
        $flash = $action->execute($request->all(), $id);
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->route('cart.index');
        }

        $request->session()->flash('message-warning', 'Product could not get added.');
        return redirect()->back();
    }

    /**
     * Add a single product to cart from AJAX response
     *
     * @param CartStoreAjaxRequest $request,
     * @param CartStoreAjaxAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeWithAjax(CartStoreAjaxRequest $request, CartStoreAjaxAction $action)
    {
        $response = $action->execute($request->all());
        if ($response !== null) {
            return response()->json($response, 200);
        } else {
            return response()->json($response, 400);
        }
    }

    /**
     * Remove product from cart
     *
     * @param CartDeleteRequest $request
     * @param CartDeleteAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(CartDeleteRequest $request, CartDeleteAction $action)
    {
        $response = $action->execute($request->all());
        if ($response !== null) {
            return response()->json($response, 200);
        } else {
            return response()->json($response , 400);
        }
    }

    /**
     * Update cart
     *
     * @param CartUpdateRequest $request
     * @param CartUpdateAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CartUpdateRequest $request, CartUpdateAction $action)
    {
        $flash = $action->execute($request->all());

        $request->session()->flash($flash['type'], $flash['message']);
        return redirect()->route('cart.index');
    }
}
