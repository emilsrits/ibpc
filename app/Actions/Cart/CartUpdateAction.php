<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\Session;

class CartUpdateAction
{
    /**
     * Process the cart update action
     * 
     * @param array $data
     * @param string $id
     * @return mixed
     */
    public function execute(array $data)
    {
        // Create a new cart instance
        $oldCart = sessionOldCart();
        $cart = new Cart($oldCart);

        $cartItemsQty = $data['cart'];

        if ($cart->updateCart($cartItemsQty) === false) {
            $flash = [
                'type' => 'message-warning',
                'message' => 'Invalid product quantity!'
            ];
        } else {
            $flash = [
                'type' => 'message-success',
                'message' => 'Cart updated!'
            ];
        }

        Session::put('cart', $cart);
        $cart->isEmpty();

        return $flash;
    }
}