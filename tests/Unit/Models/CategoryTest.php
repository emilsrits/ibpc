<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->category = $this->createCategory();
    }

    /** @test */
    public function it_can_create_category()
    {
        $data = [
            'title' => 'Test Category',
            'slug' => 'test-category',
            'top_level' => 1,
            'parent_id' => null,
            'status' => 1,
        ];
        $category = Category::create($data);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals($data['title'], $category->title);
    }

    /** @test */
    public function it_can_show_category()
    {
        $found = Category::find($this->category->id);

        $this->assertInstanceOf(Category::class, $found);
        $this->assertEquals($found->title, $this->category->title);
        $this->assertEquals($found->slug, $this->category->slug);
    }

    /** @test */
    public function it_can_update_category()
    {
        $data = [
            'title' => 'Another Test Category',
            'slug' => 'another-test-category',
            'top_level' => 1,
            'parent_id' => null,
            'status' => 0,
        ];

        $updated = $this->category->update($data);

        $this->assertTrue($updated);
        $this->assertEquals($data['title'], $this->category->title);
        $this->assertEquals($data['slug'], $this->category->slug);
        $this->assertEquals($data['status'], $this->category->status);
    }

    /** @test */
    public function it_can_delete_category()
    {
        $category = $this->createCategory();

        $deleted = $category->delete();

        $this->assertTrue($deleted);
    }

    /** @test */
    public function it_can_attach_and_detach_specifications()
    {
        $specification = $this->createSpecification();

        $this->category->specifications()->attach($specification);

        $this->assertEquals(1, $this->category->specifications->count());

        $this->category->specifications()->detach($specification);
        
        $this->assertEquals(null, $this->category->specifications()->first());
    }
}
