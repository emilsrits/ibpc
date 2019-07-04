<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Mpociot\VatCalculator\Facades\VatCalculator;

class Cart extends Model
{
    public $items = null;
    public $totalQty = 0;
    public $delivery = [];
    public $deliveryCost = 0;
    public $vat = 0;
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
            $this->delivery = $oldCart->delivery;
            $this->deliveryCost = $oldCart->deliveryCost;
            $this->vat = $oldCart->vat;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    /**
     * Add an item to cart
     *
     * @param Product $item
     * @param string $id
     * @param integer $qty
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
     * Remove item from cart
     *
     * @param string $id
     */
    public function remove($id)
    {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'] * $this->items[$id]['qty'];
        unset($this->items[$id]);
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
     * Set VAT based on total price of all items with delivery
     */
    public function setVat()
    {
        $user = Auth::user();
        if (VatCalculator::shouldCollectVAT($user->country)) {
            $totalPriceWithDelivery = $this->totalPrice + $this->deliveryCost;
            $grossPrice = VatCalculator::calculate($totalPriceWithDelivery, $user->country, $user->postcode); // required for $taxValue
            $taxValue   = VatCalculator::getTaxValue();

            $this->vat = $taxValue;
        }
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
            case 'storage':
                $this->delivery['code'] = 'storage';
                $this->delivery['cost'] = config('constants.delivery_cost.storage');
                break;
            case 'address':
                $this->delivery['code'] = 'address';
                $this->delivery['cost'] = config('constants.delivery_cost.address');
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
        return Session::get('cart');
    }

    /**
     * Check if cart is empty, delete it if it is empty
     *
     * @return mixed
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
     * @param string $price
     * @return mixed
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
            case 'vat':
                return $this->getVat() . ' €';
            case 'with_vat':
                return $this->getTotalPriceWithVat() . ' €';
        }
    }

    /**
     * Return total price with delivery and VAT
     * 
     * @return float
     */
    public function getTotalPriceWithVat()
    {
        $total = $this->totalPrice + $this->deliveryCost + $this->vat;
        return number_format((float)$total, 2, '.', '');
    }

    /**
     * Return total price with delivery price
     *
     * @return float
     */
    public function getTotalPriceWithDelivery()
    {
        return $this->totalPrice + $this->deliveryCost;
    }

    /**
     * Get total price of a product
     *
     * @param string $id
     * @param mixed $currency
     * @return mixed
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
     * @param string $id
     * @param mixed $currency
     * @return mixed
     */
    public function getItemPrice($id, $currency = null)
    {
        if ($currency) {
            return  $this->items[$id]['price'] . ' €';
        } else {
            return  $this->items[$id]['price'];
        }
    }

    /**
     * Get VAT with two decimal places
     * 
     * @return mixed
     */
    public function getVat()
    {
        if ($this->vat > 0) {
            return number_format((float)$this->vat, 2, '.', '');
        }
        
        return false;
    }
}
