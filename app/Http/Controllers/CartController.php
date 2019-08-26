<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartDeleteAsyncRequest;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Http\Requests\Cart\CartStoreAsyncRequest;
use App\Services\CartService;

class CartController extends Controller
{
    /**
     * CartController constructor
     *
     * @param CartService $userService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Return cart view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (!Session::has('cart')) {
            return view('cart.index', ['cart' => null, 'products' => null]);
        }

        $cart = new Cart(session('cart'));

        return view('cart.index', ['cart' => $cart, 'products' => $cart->items]);
    }

    /**
     * Adds product to cart and redirects to main shop view
     *
     * @param CartStoreRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CartStoreRequest $request, Product $product)
    {
        $this->cartService->store($request->validated(), $product);

        return redirect()->back();
    }

    /**
     * Add a single product to cart from AJAX response
     *
     * @param CartStoreAsyncRequest $request,
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAsync(CartStoreAsyncRequest $request)
    {
        $response = $this->cartService->storeAsync($request->validated());
        if ($response !== null) {
            return response()->json($response, 200);
        } else {
            return response()->json($response, 400);
        }
    }

    /**
     * Remove product from cart
     *
     * @param CartDeleteAsyncRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAsync(CartDeleteAsyncRequest $request)
    {
        $response = $this->cartService->deleteAsync($request->validated());
        if ($response !== false) {
            return response()->json($response, 200);
        } else {
            return response()->json($response , 400);
        }
    }

    /**
     * Update cart
     *
     * @param CartUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CartUpdateRequest $request)
    {
        $this->cartService->update($request->validated());

        return redirect()->route('cart.index');
    }
}
