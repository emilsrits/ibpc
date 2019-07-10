<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartStoreAjaxAction
{
    /**
     * Process the cart store ajax action
     * 
     * @param array $data
     * @return mixed
     */
    public function execute(array $data)
    {
        $qty = 1;

        $productId = $data['productId'];
        $product = Product::findOrFail($productId);

        if ($product) {
            // Create a new cart instance
            $oldCart = sessionOldCart();
            $cart = new Cart($oldCart);

            // Add product to the cart
            $cart->add($product, $product->id, $qty);

            // Add the new cart to session
            Session::put('cart', $cart);

            // Update displayed number of items in cart
            if (Session::has('cart')) {
                $items = count(Session::get('cart')->items);
                $html = '(' . $items . ') ' . money(session('cart')->totalPrice);
            } else {
                $html = 0;
            }

            return $html;
        } else {
            return null;
        }
    }
}