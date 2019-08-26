<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use Mockery;
use App\Services\OrderService;
use App\Models\Cart;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'RolesTableSeeder']);
        $this->createOrder();

        $this->be($this->createAdmin());
    }
    
    /** @test */
    public function index_method_returns_paginated_orders()
    {
        $response = $this->get(route('order.index'));

        $response->assertSuccessful();
        $response->assertViewIs('admin.order.orders');
        $response->assertViewHas('orders');
    }

    /** @test */
    public function action_method_updates_orders_status()
    {
        $status = config('constants.order_status.completed');

        $response = $this->post(route('order.action', [
            '_token' => csrf_token(),
            'mass-action' => $status,
            'order' => [
                1 => [
                    'id' => 1
                ]
            ]
        ]));

        $order = Order::find(1);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertEquals($order->status, $status);
    }

    /** @test */
    public function action_method_filters_orders()
    {
        $response = $this->post(route('order.action', [
            '_token' => csrf_token(),
            'id' => 1
        ]));

        $response->assertSuccessful();
        $response->assertViewIs('admin.order.orders');
        $response->assertViewHas('orders');
    }

    /** @test */
    public function store_method_returns_success_page_after_successful_order()
    {
        $mock = Mockery::mock(OrderService::class);
        $mock->message = [
            'type' => 'message-success',
            'content' => 'Order successfully placed!'
        ];
        
        $mock->shouldReceive('store')
            ->once()
            ->andReturn(true);

        $this->app->instance(OrderService::class, $mock);

        $response = $this->withSession(['cart' => new Cart()])->post(route('order.store', [
            '_token' => csrf_token()
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }
}
