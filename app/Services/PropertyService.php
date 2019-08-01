<?php

namespace App\Services;

use App\Models\Property;
use App\Models\Specification;

class PropertyService
{
    /**
     * @var array
     */
    public $message;

    /**
     * @var Property
     */
    protected $property;
    
    /**
     * Create a new service instance.
     */
    public function __construct(Property $property)
    {
        $this->message = [
            'type' => null,
            'content' => null
        ];
        $this->property = $property;
    }

    /**
     * Property mass action
     *
     * @param array $data
     * @return mixed
     */
    public function action(array $data)
    {
        if (isset($data['properties'])) {
            $propertyIds = $data['properties'];

            switch ($data['mass-action']) {
                case 1:
                    $this->property->deleteProperty($propertyIds);

                    $this->message = [
                        'type' => 'message-success',
                        'content' => 'Properties deleted!'
                    ];

                    return true;
            }
        }

        return false;
    }

    /**
     * Property store action
     *
     * @param array $data
     * @param Specification $specification
     */
    public function store(array $data, Specification $specification)
    {
        $data['specification_id'] = $specification->id;

        Property::create($data);

        $this->message = [
            'type' => 'message-success',
            'content' => 'Property successfully created!'
        ];
    }

    /**
     * Property update action
     *
     * @param array $data
     * @param Property $property
     */
    public function update(array $data, Property $property)
    {
        $property->update($data);

        $this->message = [
            'type' => 'message-success',
            'content' => 'Property successfully updated!'
        ];
    }

    /**
     * Property delete action
     *
     * @param Property $property
     */
    public function delete(Property $property)
    {
        $property->deleteProperty();

        $this->message = [
            'type' => 'message-success',
            'content' => 'Property deleted!'
        ];
    }
}