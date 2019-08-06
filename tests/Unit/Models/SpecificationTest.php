<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Specification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpecificationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->specification = $this->createSpecification();
    }

    /** @test */
    public function it_can_create_specification()
    {
        $data = [
            'slug' => 'test-specification',
            'name' => 'Test Specification'
        ];
        $specification = Specification::create($data);
        
        $this->assertInstanceOf(Specification::class, $specification);
        $this->assertEquals($data['slug'], $specification->slug);
        $this->assertEquals($data['name'], $specification->name);
    }

    /** @test */
    public function it_can_show_specification()
    {
        $found = Specification::find($this->specification->id);

        $this->assertInstanceOf(Specification::class, $found);
        $this->assertEquals($found->slug, $this->specification->slug);
        $this->assertEquals($found->name, $this->specification->name);
    }

    /** @test */
    public function it_can_update_specification()
    {
        $data = [
            'slug' => 'another-test-specification',
            'name' => 'Another Test Specification'
        ];

        $updated = $this->specification->update($data);

        $this->assertTrue($updated);
        $this->assertEquals($data['slug'], $this->specification->slug);
        $this->assertEquals($data['name'], $this->specification->name);
    }

    /** @test */
    public function it_can_delete_specification()
    {
        $specification = $this->createSpecification();

        $deleted = $specification->delete();

        $this->assertTrue($deleted);
    }

    /** @test */
    public function it_can_have_properties()
    {
        $this->createProperty([
            'specification_id' => $this->specification->id
        ]);

        $this->assertEquals(1, $this->specification->properties->count());
    }
}
