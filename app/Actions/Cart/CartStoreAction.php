<?php

namespace App\Actions\Cart;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class CartStoreAction
{
    /**
     * Process the cart store action
     * 
     * @param array $data
     * @param string $id
     * @return void|array
     */
    public function execute(array $data, $id)
    {
        // Create a new cart instance
        $oldCart = sessionOldCart();
        $cart = new Cart($oldCart);

        $product = Product::find($id);
        if  ($product) {
            $qty = $data['qty'];
            // Add product to the cart
            $cart->add($product, $product->id, $qty);

            // Add the new cart to session
            Session::put('cart', $cart);

            $flash = [
                'type' => 'message-success',
                'message' => 'Product added to cart!'
            ];

            return $flash;
        } else {
            return;
        }
    }
}