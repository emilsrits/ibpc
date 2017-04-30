<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    /**
     * Cart constructor
     * @param array $oldCart
     */
    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    /**
     * Add an item to cart
     *
     * @param $item
     * @param $id
     * @param $qty
     */
    public function add($item, $id, $qty)
    {
        $cartItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $cartItem = $this->items[$id];
            }
        }
        $cartItem['qty'] += $qty;
        $this->items[$id] = $cartItem;
        $this->totalQty += $qty;
        $this->totalPrice += $item->price * $qty;
    }

    /**
     * Remove an item from cart
     *
     * @param $id
     */
    public function remove($id)
    {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'] * $this->items[$id]['qty'];
        unset($this->items[$id]);
    }

    /**
     * Delete the cart from session
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteCart()
    {
        if (!Session::has('cart')) {
            return view('cart.index');
        }
        Session::forget('cart');
        return view('cart.index');
    }

    /**
     * Update quantity of cart items
     *
     * @param $request
     * @param $cartItemsQty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCart($request, $cartItemsQty)
    {
        $oldTotalQty = $this->totalQty;
        $oldTotalPrice = $this->totalPrice;
        $this->totalQty = 0;
        $this->totalPrice = 0;

        foreach ($cartItemsQty as $item => $qty) {
            if ($qty['qty']) {
                $this->items[$item]['qty'] = $qty['qty'];
                $this->totalQty += $qty['qty'];
                $this->totalPrice += $this->items[$item]['price'] * $qty['qty'];
            } else {
                $this->totalQty = $oldTotalQty;
                $this->totalPrice = $oldTotalPrice;
                $request->session()->flash('message-warning', 'Invalid product quantity!');
                return redirect()->back();
            }
        }
    }

    /**
     * Check if cart is empty
     *
     * @return null
     */
    public function isEmpty()
    {
        if (!$this->items) {
            $this->deleteCart();
        }  else {
            return null;
        }
    }

    /**
     * Return price of all items in cart
     *
     * @return string
     */
    public function getTotalCartPrice()
    {
        return $this->totalPrice . ' €';
    }

    /**
     * Get total price of a product
     *
     * @param $id
     * @return string
     */
    public function getItemTotalPrice($id)
    {
        return $this->items[$id]['price'] * $this->items[$id]['qty'] . ' €';
    }

    /**
     * Get price of a product
     *
     * @param $id
     * @return string
     */
    public function getItemPrice($id)
    {
        return  $this->items[$id]['price'] . ' €';
    }
}
