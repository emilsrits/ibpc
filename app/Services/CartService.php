<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * @var array
     */
    public $message;
    
    /**
     * Create a new service instance.
     */
    public function __construct()
    {
        $this->message = [
            'type' => null,
            'content' => null
        ];
    }

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

            $this->message = [
                'type' => 'message-success',
                'content' => 'Product added to cart!'
            ];

            return true;
        } else {
            $this->message = [
                'type' => 'message-warning',
                'content' => 'Product could not get added.'
            ];

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
        $qty = 1;

        $productId = $data['productId'];
        $product = Product::findOrFail($productId);

        if ($product) {
            $cart = new Cart(sessionOldCart());
            $cart->addItem($product, $qty);

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

            $cart->isEmpty();

            return array('redirectUrl'=> '/cart');
        } else {
            return null;
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
            $this->message = [
                'type' => 'message-warning',
                'content' => 'Invalid product quantity!'
            ];
        } else {
            $this->message = [
                'type' => 'message-success',
                'content' => 'Cart updated!'
            ];
        }

        Session::put('cart', $cart);

        $cart->isEmpty();
    }
}
