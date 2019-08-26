<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Cart store action
     *
     * @param array $data
     * @param Product $product
     * @return bool
     */
    public function store(array $data, Product $product)
    {
        $cart = new Cart(sessionOldCart());

        if ($product) {
            $qty = $data['qty'];
            $cart->addItem($product, $qty);

            Session::put('cart', $cart);

            flashMessage('message-success', 'Product added to cart!');

            return true;
        } else {
            flashMessage('message-warning', 'Product could not get added.');

            return false;
        }
    }

    /**
     * Cart async store action
     *
     * @param array $data
     * @return mixed
     */
    public function storeAsync(array $data)
    {
        isset($data['qty']) ? $qty = $data['qty'] : $qty = 1;

        $productId = $data['productId'];
        $product = Product::findOrFail($productId);

        if ($product) {
            $cart = new Cart(sessionOldCart());
            $cart->addItem($product, $qty);

            Session::put('cart', $cart);

            // Update displayed number of items in cart
            if (Session::has('cart')) {
                $itemCount = count(Session::get('cart')->items);

                $response['cart'] = [
                    'itemCount' => $itemCount,
                    'price' => money(session('cart')->totalPrice)->format()
                ];
            } else {
                $response = null;
            }

            return $response;
        } else {
            return null;
        }
    }

    /**
     * Cart async delete action
     *
     * @param array $data
     * @return mixed
     */
    public function deleteAsync(array $data)
    {
        $productId = $data['productId'];
        $cart = new Cart(sessionOldCart());

        if ($cart->items[$productId]) {
            $cart->removeItem($productId);

            Session::put('cart', $cart);

            if ($cart->destroyIfEmpty()) {
                $response = [
                    'itemCount' => 0,
                    'price' => null
                ];
            } else {
                $itemCount = count(Session::get('cart')->items);

                $response = [
                    'itemCount' => $itemCount,
                    'price' => money(session('cart')->totalPrice)->format()
                ];
            }

            return $response;
        } else {
            return false;
        }
    }

    /**
     * Cart update action
     *
     * @param array $data
     */
    public function update(array $data)
    {
        $cart = new Cart(sessionOldCart());

        $cartItemsQty = $data['cart'];

        if ($cart->updateCart($cartItemsQty) === false) {
            flashMessage('message-warning', 'Invalid product quantity!');
        } else {
            flashMessage('message-success', 'Cart updated!');
        }

        Session::put('cart', $cart);

        $cart->destroyIfEmpty();
    }
}
