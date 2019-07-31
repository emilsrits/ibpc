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
     * @return mixed
     */
    public function update(array $data, Property $property)
    {
        if ($data['submit'] === 'delete') {
            $property->deleteProperty();

            $this->message = [
                'type' => 'message-success',
                'content' => 'Property deleted!'
            ];

            return false;
        }

        if ($data['submit'] === 'save') {
            $property->update($data);

            $this->message = [
                'type' => 'message-success',
                'content' => 'Property successfully updated!'
            ];

            return true;
        }

        $this->message = [
            'type' => 'message-danger',
            'content' => 'Invalid form action!'
        ];

        return false;
    }
}