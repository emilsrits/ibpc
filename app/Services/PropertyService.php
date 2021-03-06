<?php

namespace App\Services;

use App\Models\Property;
use App\Models\Specification;
use App\Repositories\PropertyRepository;

class PropertyService
{
    /**
     * Create a new service instance.
     * 
     * @param PropertyRepository $propertyRepository
     */
    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * Property mass action
     *
     * @param array $data
     * @return mixed
     */
    public function action(array $data)
    {
        if (isset($data['property'])) {
            $propertyIds = $data['property'];

            switch ($data['mass-action']) {
                case 1:
                    $this->propertyRepository->delete($propertyIds);
                    flashMessage('message-success', 'Properties deleted!');
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

        $this->propertyRepository->create($data);

        flashMessage('message-success', 'Property successfully created!');
    }

    /**
     * Property update action
     *
     * @param array $data
     * @param Property $property
     */
    public function update(array $data, Property $property)
    {
        $this->propertyRepository->update($data, $property);

        flashMessage('message-success', 'Property successfully updated!');
    }

    /**
     * Property delete action
     *
     * @param Property $property
     */
    public function delete(Property $property)
    {
        $this->propertyRepository->delete($property->id);

        flashMessage('message-success', 'Property deleted!');
    }
}
