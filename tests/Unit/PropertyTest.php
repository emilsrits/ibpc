<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Property;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->specification = $this->createSpecification();
        $this->property = $this->createProperty([
            'specification_id' => $this->specification->id
        ]);
    }

    /** @test */
    public function it_can_create_property()
    {
        $data = [
            'specification_id' => $this->specification->id,
            'name' => 'Test Property'
        ];
        $property = Property::create($data);
        
        $this->assertInstanceOf(Property::class, $property);
        $this->assertEquals($data['specification_id'], $this->specification->id);
        $this->assertEquals($data['name'], $property->name);
    }

    /** @test */
    public function it_can_show_specification()
    {
        $found = Property::find($this->property->id);

        $this->assertInstanceOf(Property::class, $found);
        $this->assertEquals($found->specification_id, $this->specification->id);
        $this->assertEquals($found->name, $this->property->name);
    }

    /** @test */
    public function it_can_update_specification()
    {
        $data = [
            'name' => 'Another Test Property'
        ];

        $updated = $this->property->update($data);

        $this->assertTrue($updated);
        $this->assertEquals($data['name'], $this->property->name);
    }

    /** @test */
    public function it_can_delete_specification()
    {
        $property = $this->createProperty([
            'specification_id' => $this->specification->id
        ]);

        $deleted = $property->delete();

        $this->assertTrue($deleted);
    }
}
