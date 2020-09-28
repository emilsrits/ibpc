<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Filters\OrderFilter;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'RolesTableSeeder']);

        $this->user = $this->createUser();
        $this->cart = new Cart();

        $this->createProductWithCategory([
            'stock' => 20,
        ], 3);

        foreach (Product::all() as $product) {
            $this->cart->addItem($product, 1);
        }

        $this->cart->addDelivery(Cart::DELIVERY_STORAGE);
    }

    /** @test */
    public function it_can_set_up_order()
    {
        $order = new Order();
        $order->setUpOrder($this->cart, $this->user->id);

        $this->assertEquals($order->user_id, $this->user->id);
        $this->assertEquals($order->delivery, Cart::DELIVERY_STORAGE);
        $this->assertEquals($order->delivery_cost, config('constants.delivery_cost.storage'));
        $this->assertEquals($order->status, config('constants.order_status.pending'));
    }

    /** @test */
    public function it_can_add_items_to_order()
    {
        $order = new Order();
        $order->setUpOrder($this->cart, $this->user->id);
        $attached = $order->addItems($this->cart->items, $this->user->id);

        $this->assertTrue($attached);
    }

    /** @test */
    public function it_can_update_order_status()
    {
        $order = new Order();
        $order->setUpOrder($this->cart, $this->user->id);
        $order->addItems($this->cart->items, $this->user->id);

        $order->setStatus(config('constants.order_status.completed'));

        $this->assertEquals($order->status, config('constants.order_status.completed'));
    }

    /** @test */
    public function it_can_filter_by_id()
    {
        $order = $this->createOrder();

        $request = Request::create('/orders', 'POST', [
            'id' => $order->id
        ]);
        $filter = new OrderFilter($request);
        $orders = Order::filter($filter)->get();

        $this->assertEquals(true, count($orders) === 1);
    }

    /** @test */
    public function it_can_filter_by_user()
    {
        $user = $this->createUser([
            'first_name' => 'Bob',
        ]);
        $this->createOrder($user);

        $request = Request::create('/orders', 'POST', [
            'user' => 'bob'
        ]);
        $filter = new OrderFilter($request);
        $orders = Order::filter($filter)->get();

        $this->assertEquals(true, count($orders) >= 1);
    }

    /** @test */
    public function it_can_filter_by_status()
    {
        $order = $this->createOrder();
        $status = config('constants.order_status.completed');
        $order->setStatus($status);

        $request = Request::create('/orders', 'POST', [
            'status' => $status
        ]);
        $filter = new OrderFilter($request);
        $orders = Order::filter($filter)->get();

        $this->assertEquals(true, count($orders) >= 1);
    }

    /** @test */
    public function it_can_filter_by_created_at()
    {
        $this->createOrder();

        $request = Request::create('/orders', 'POST', [
            'createdAt' => Carbon::now()->format('Y-m-d')
        ]);
        $filter = new OrderFilter($request);
        $orders = Order::filter($filter)->get();

        $this->assertEquals(true, count($orders) >= 1);
    }

    /** @test */
    public function it_can_filter_by_updated_at()
    {
        $order = $this->createOrder();
        $order->update();

        $request = Request::create('/orders', 'POST', [
            'updatedAt' => Carbon::now()->format('Y-m-d')
        ]);
        $filter = new OrderFilter($request);
        $orders = Order::filter($filter)->get();

        $this->assertEquals(true, count($orders) >= 1);
    }
}
