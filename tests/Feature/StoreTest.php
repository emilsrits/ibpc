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
        $product = $this->createProductWithCategory([
            'title' => 'Example Product Title',
        ]);

        $response = $this->get('/');
        $response->assertSee($product->title);
    }

    /** @test */
    public function store_paginates_products()
    {
        $this->createProductWithCategory([], 50);

        $response = $this->get('/');
        $response->assertSee('?page=2');
    }

    /** @test */
    public function store_can_search_products()
    {
        $this->createProductWithCategory([
            'title' => 'Covfefe',
        ]);
        $this->createProductWithCategory([
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
        $parent = $this->createCategory([
            'title' => 'Category Parent',
            'slug' => 'category-parent',
        ]);
        $child = $this->createCategory([
            'title' => 'Category Child',
            'slug' => 'category-child',
            'top_level' => 0,
            'parent_id' => $parent->id,
        ]);

        $response = $this->get('/');
        $response->assertSessionHasNoErrors();
        $response->assertSee($parent->title);
        $response->assertSee($child->title);
    }

    /** @test*/
    public function store_shows_single_product()
    {
        $product = $this->createProductWithCategory([
            'title' => 'Test Product 123',
        ]);

        $response = $this->get('/p/' . $product->code);
        $response->assertStatus(200);
        $response->assertSee('Test Product 123');
    }
}
