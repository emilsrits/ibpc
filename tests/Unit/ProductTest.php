<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        
        $this->product = $this->createProduct();
    }

    /** @test */
    public function it_can_create_product()
    {
        $data = [
            'code' => 'TEST-PRODUCT',
            'title' => 'Test Product',
            'description' => 'Test',
            'price' => 200000,
            'stock' => 25,
            'status' => 1,
        ];
        $product = Product::create($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($data['code'], $product->code);
        $this->assertEquals($data['title'], $product->title);
        $this->assertEquals($data['description'], $product->description);
        $this->assertEquals($data['price'], $product->price);
        $this->assertEquals($data['stock'], $product->stock);
        $this->assertEquals($data['status'], $product->status);
    }

    /** @test */
    public function it_can_show_product()
    {
        $found = Product::find($this->product->id);

        $this->assertInstanceOf(Product::class, $found);
        $this->assertEquals($found->code, $this->product->code);
        $this->assertEquals($found->title, $this->product->title);
    }

    /** @test */
    public function it_can_update_product()
    {
        $data = [
            'code' => 'ANOTHER-TEST-PRODUCT',
            'title' => 'Another Test Product',
            'stock' => 30,
        ];

        $updated = $this->product->update($data);

        $this->assertTrue($updated);
        $this->assertEquals($data['code'], $this->product->code);
        $this->assertEquals($data['title'], $this->product->title);
        $this->assertEquals($data['stock'], $this->product->stock);
    }

    /** @test */
    public function it_can_delete_product()
    {
        $product = $this->createProduct();

        $deleted = $product->delete();

        $this->assertTrue($deleted);
    }

    /** @test */
    public function it_can_have_categories()
    {
        $category = $this->createCategory();

        $this->product->categories()->attach($category);

        $this->assertEquals(1, $this->product->categories->count());
    }

    /** @test */
    public function it_has_old_price_attribute()
    {
        $this->product->price = 200000;
        $this->product->price = 150000;

        $this->assertEquals(200000, $this->product->price_old);
        $this->assertEquals(150000, $this->product->price);

        $this->product->price = 200000;

        $this->assertEquals(null, $this->product->price_old);
        $this->assertEquals(200000, $this->product->price);
    }

    /** @test */
    public function it_can_have_properties()
    {
        $specification = $this->createSpecification();

        $property = $this->createProperty([
            'specification_id' => $specification->id
        ]);

        $this->product->setProperties([
            $specification->id => [
                $property->id => $value = 'Test Value'
            ]
        ]);

        $this->assertEquals(1, $this->product->properties->count());
        $this->assertEquals($value, $this->product->properties()->first()->pivot->value);
    }
}
