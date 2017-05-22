<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $delivery = [];
    public $deliveryCost = 0;

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
            $this->delivery = $oldCart->delivery;
            $this->deliveryCost = $oldCart->deliveryCost;
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
        if (Session::has('delivery')) {
            Session::forget('delivery');
        }
        if (Session::has('cart')) {
            Session::forget('cart');
        }
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
     * Add delivery cost to cart
     *
     * @param $deliveryMethod
     * @return mixed
     */
    public function addDelivery($deliveryMethod)
    {
        switch ($deliveryMethod) {
            case 'storage':
                $this->delivery['code'] = 'storage';
                $this->delivery['cost'] = 0.00;
                break;
            case 'address':
                $this->delivery['code'] = 'address';
                $this->delivery['cost'] = 2.99;
                break;
        }
        $this->deliveryCost = $this->delivery['cost'];

        return $this->delivery;
    }

    /**
     * Returns session cart
     *
     * @return mixed
     */
    public function getCart()
    {
        return $cart = Session::get('cart');
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
            return true;
        }  else {
            return null;
        }
    }

    /**
     * Return a price with currency symbol
     *
     * @param $price
     * @return string
     */
    public function getPriceCurrency($price)
    {
        switch ($price) {
            case 'total':
                return $this->totalPrice . ' €';
            case 'delivery':
                return $this->deliveryCost . ' €';
            case 'with_delivery':
                return $this->totalPrice + $this->deliveryCost . ' €';
            case 'item_total':
                return $this->items[$id]['price'] * $this->items[$id]['qty'] . ' €';
        }
    }

    /**
     * Return total price with delivery price
     *
     * @param null $currency
     * @return int|string
     */
    public function getPriceWithDelivery($currency = null)
    {
        if ($currency) {
            return $this->totalPrice + $this->deliveryCost . ' €';
        } else {
            return $this->totalPrice + $this->deliveryCost;
        }
    }

    /**
     * Get total price of a product
     *
     * @param $id
     * @param null $currency
     * @return string
     */
    public function getItemTotalPrice($id, $currency = null)
    {
        if ($currency) {
            return $this->items[$id]['price'] * $this->items[$id]['qty'] . ' €';
        } else {
            return $this->items[$id]['price'] * $this->items[$id]['qty'];
        }
    }

    /**
     * Get price of a product
     *
     * @param $id
     * @param null $currency
     * @return string
     */
    public function getItemPrice($id, $currency = null)
    {
        if ($currency) {
            return  $this->items[$id]['price'] . ' €';
        } else {
            return  $this->items[$id]['price'];
        }
    }
}
