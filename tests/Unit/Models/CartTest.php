<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->product = $this->createProductWithCategory([
            'stock' => 50,
        ]);
    }

    /** @test */
    public function it_can_add_item_to_cart()
    {
        $cart = new Cart();

        $cart->addItem($this->product, 2);

        $this->assertEquals(1, count($cart->items));
        $this->assertEquals(2, $cart->totalQty);
    }

    /** @test */
    public function it_can_remove_item_from_cart()
    {
        $cart = new Cart();

        $cart->addItem($this->product, 1);

        $this->assertEquals(1, count($cart->items));

        $cart->removeItem($this->product->id);

        $this->assertEquals(0, count($cart->items));
    }

    /** @test */
    public function it_can_update_items_in_cart()
    {
        $cart = new Cart();
        $newProduct = $this->createProductWithCategory([
            'stock' => 50,
        ]);

        $cart->addItem($this->product, 1);
        $cart->addItem($newProduct, 2);

        $this->assertEquals(2, count($cart->items));
        
        $cart->updateCart([
            $this->product->id => [
                'qty' => 2
            ],
            $newProduct->id => [
                'qty' => 1
            ]
        ]);

        $this->assertEquals(2, $cart->getItem($this->product->id)['qty']);
        $this->assertEquals(1, $cart->getItem($newProduct->id)['qty']);
    }

    /** @test */
    public function it_can_add_delivery_method()
    {
        $cart = new Cart();

        $cart->addItem($this->product, 1);
        $cart->addDelivery(Cart::DELIVERY_ADDRESS);

        $this->assertEquals(Cart::DELIVERY_ADDRESS, $cart->delivery['code']);
    }

    /** @test */
    public function it_can_delete_cart()
    {
        $cart = new Cart();

        $cart->addItem($this->product, 1);
        $cart->addDelivery(Cart::DELIVERY_ADDRESS);

        Session::put('cart', $cart);

        $this->assertNotEmpty(session('cart'));

        $cart->deleteCart();

        $this->assertEmpty(session('cart'));
    }
}
