<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products', 'categories', 'category_product')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /** @test */
    public function store_shows_products()
    {
        $product = $this->createProduct([
            'title' => 'Example Product Title',
        ]);

        $response = $this->get('/');
        $response->assertSee($product->title);
    }

    /** @test */
    public function store_paginates_products()
    {
        $this->createProduct([], 50);

        $response = $this->get('/');
        $response->assertSee('?page=2');
    }

    /** @test */
    public function store_can_search_products()
    {
        $this->createProduct([
            'title' => 'Covfefe',
        ]);
        $this->createProduct([
            'title' => 'Is Fefe product',
        ]);

        $response = $this->get('/search?search=fefe');
        $response->assertSessionHasNoErrors();
        $response->assertSee('Covfefe');
        $response->assertSee('Is Fefe product');
    }

    /** @test */
    public function store_shows_categories()
    {
        $this->createCategory([
            'title' => 'Category Parent',
        ]);
        $this->createCategory([
            'title' => 'Category Child',
            'parent' => 0,
            'parent_id' => 1,
        ]);

        $response = $this->get('/');
        $response->assertSessionHasNoErrors();
        $response->assertSee('Category Parent');
        $response->assertSee('Category Child');
    }

    /** @test*/
    public function store_shows_single_product()
    {
        $product = $this->createProduct([
            'title' => 'Test Product 123',
        ]);

        $response = $this->get('/p/' . $product->code);
        $response->assertStatus(200);
        $response->assertSee('Test Product 123');
    }
}
