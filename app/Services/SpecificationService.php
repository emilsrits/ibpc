<?php

namespace App\Services;

use App\Models\Specification;

class SpecificationService
{
    /**
     * @var array
     */
    public $message;

    /**
     * @var Specification
     */
    protected $specification;
    
    /**
     * Create a new service instance.
     */
    public function __construct(Specification $specification)
    {
        $this->message = [
            'type' => null,
            'content' => null
        ];
        $this->specification = $specification;
    }

    /**
     * Specification mass action
     *
     * @param array $data
     * @return bool
     */
    public function action(array $data)
    {
        if (isset($data['specifications'])) {
            $specificationIds = $data['specifications'];

            switch ($data['mass-action']) {
                case 1:
                    $this->specification->deleteSpecification($specificationIds);

                    $this->message = [
                        'type' => 'message-success',
                        'content' => 'Property groups deleted!'
                    ];

                    return true;
            }
        }

        return false;
    }

    /**
     * Specification store action
     *
     * @param array $data
     */
    public function store(array $data)
    {
        Specification::create($data);
        
        $this->message = [
            'type' => 'message-success',
            'content' => 'Property group successfully created!'
        ];
    }

    /**
     * Specification update action
     *
     * @param array $data
     * @param Specification $specification
     */
    public function update(array $data, Specification $specification)
    {
        $specification->update($data);
        
        $this->message = [
            'type' => 'message-success',
            'content' => 'Property group successfully updated!'
        ];
    }

    /**
     * Specification delete action
     *
     * @param Specification $specification
     */
    public function delete(Specification $specification)
    {
        $specification->deleteSpecification();

        $this->message = [
            'type' => 'message-success',
            'content' => 'Property group deleted!'
        ];
    }
}