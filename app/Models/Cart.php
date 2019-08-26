<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Mpociot\VatCalculator\Facades\VatCalculator;

class Cart extends Model
{
    const DELIVERY_ADDRESS = 'address';
    const DELIVERY_STORAGE = 'storage';

    public $items = null;
    public $totalQty = 0;
    public $delivery = ['code' => null, 'cost' => null];
    public $vat = 0;
    public $totalPrice = 0;

    /**
     * Cart constructor
     * @param array $oldCart
     */
    public function __construct($oldCart = null)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->delivery = $oldCart->delivery;
            $this->vat = $oldCart->vat;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    /**
     * Update quantity of cart items
     *
     * @param array $cartItemsQty
     * @return bool
     */
    public function updateCart($cartItemsQty)
    {
        $oldTotalQty = $this->totalQty;
        $oldTotalPrice = $this->totalPrice;
        $this->totalQty = 0;
        $this->totalPrice = 0;

        foreach ($cartItemsQty as $item => $qty) {
            if ((int)$qty['qty'] > 0) {
                $this->items[$item]['qty'] = $qty['qty'];
                $this->totalQty += $qty['qty'];
                $this->totalPrice += $this->items[$item]['price'] * $qty['qty'];
            } else {
                $this->totalQty = $oldTotalQty;
                $this->totalPrice = $oldTotalPrice;
                return false;
            }
        }

        return true;
    }

    /**
     * Delete the cart from session
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
     * Check if cart is empty then destroy it
     *
     * @return mixed
     */
    public function destroyIfEmpty()
    {
        if (!$this->items) {
            $this->deleteCart();

            return true;
        }
        
        return null;
    }

    /**
     * Set VAT based on total price of all items with delivery
     */
    public function setVat()
    {
        $user = Auth::user();
        if (VatCalculator::shouldCollectVAT($user->country)) {
            $totalPriceWithDelivery = $this->totalPrice + $this->delivery['cost'];
            $grossPrice = VatCalculator::calculate($totalPriceWithDelivery, $user->country, $user->postcode); // required for $taxValue
            $taxValue = round(VatCalculator::getTaxValue(), 0);

            $this->vat = $taxValue;
        }
    }

    /**
     * Setup delivery for checkout
     *
     * @param string $deliveryMethod
     * @return string
     */
    public function setUpDelivery($deliveryMethod)
    {
        switch ($deliveryMethod) {
            case self::DELIVERY_STORAGE:
                Session::put('delivery', self::DELIVERY_STORAGE);
                break;
            case self::DELIVERY_ADDRESS:
                Session::put('delivery', self::DELIVERY_ADDRESS);
                break;
        }

        $this->addDelivery($deliveryMethod);
    }

    /**
     * Add delivery cost to cart
     *
     * @param string $deliveryMethod
     * @return mixed
     */
    public function addDelivery($deliveryMethod)
    {
        switch ($deliveryMethod) {
            case self::DELIVERY_STORAGE:
                $this->delivery['code'] = self::DELIVERY_STORAGE;
                $this->delivery['cost'] = config('constants.delivery_cost.storage');
                break;
            case self::DELIVERY_ADDRESS:
                $this->delivery['code'] = self::DELIVERY_ADDRESS;
                $this->delivery['cost'] = config('constants.delivery_cost.address');
                break;
        }

        return $this->delivery;
    }

    /**
     * Add an item to cart
     *
     * @param Product $item
     * @param integer $qty
     */
    public function addItem($item, $qty)
    {
        $cartItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($item->id, $this->items)) {
                $cartItem = $this->items[$item->id];
            }
        }
        $cartItem['qty'] += $qty;
        $this->items[$item->id] = $cartItem;
        $this->totalQty += $qty;
        $this->totalPrice += $item->price * $qty;
    }

    /**
     * Remove item from cart
     *
     * @param integer $id
     */
    public function removeItem($id)
    {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'] * $this->items[$id]['qty'];
        unset($this->items[$id]);
    }

    /**
     * Get specific item from cart
     *
     * @param $id
     * @return mixed
     */
    public function getItem($id)
    {
        if (array_key_exists($id, $this->items)) {
            return $this->items[$id];
        }

        return null;
    }

    /**
     * Get quantity of specific item from cart
     *
     * @param $id
     * @return integer
     */
    public function getItemQuantity($id)
    {
        return $this->items[$id]['qty'];
    }

    /**
     * Return total price with delivery and VAT
     * 
     * @return float
     */
    public function getTotalPriceWithVat()
    {
        return $this->totalPrice + $this->delivery['cost'] + $this->vat;
    }

    /**
     * Return total price with delivery price
     *
     * @return float
     */
    public function getTotalPriceWithDelivery()
    {
        return $this->totalPrice + $this->delivery['cost'];
    }

    /**
     * Get total price of a product
     *
     * @param string $id
     * @return integer
     */
    public function getItemTotalPrice($id)
    {
        return $this->items[$id]['price'] * $this->items[$id]['qty'];
    }

    /**
     * Get price of a product
     *
     * @param string $id
     * @return integer
     */
    public function getItemPrice($id)
    {
        return  $this->items[$id]['price'];
    }

    /**
     * Get VAT with two decimal places
     * 
     * @return mixed
     */
    public function getVat()
    {
        if ($this->vat > 0) {
            return $this->vat;
        }
        
        return false;
    }

    /**
     * Accessor for cart delivery cost
     *
     * @return string
     */
    public function getDeliveryCostAttribute()
    {
        return $this->delivery['cost'];
    }

    /**
     * Accessor for cart delivery code
     *
     * @return string
     */
    public function getDeliveryCodeAttribute()
    {
        return $this->delivery['code'];
    }
}
