<?php

namespace App\Actions\Cart;

use App\Cart;
use Illuminate\Support\Facades\Session;

class CartDeleteAction
{
    /**
     * Process the cart delete action
     * 
     * @param array $data
     * @return mixed
     */
    public function execute(array $data)
    {
        $productId = $data['productId'];
        $oldCart = sessionOldCart();
        $cart = new Cart($oldCart);

        if ($cart->items[$productId]) {
            $cart->remove($productId);

            Session::put('cart', $cart);

            $cart->isEmpty();

            return array('redirectUrl'=> '/cart');
        } else {
            return null;
        }
    }
}