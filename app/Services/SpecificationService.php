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
     * @return mixed
     */
    public function update(array $data, Specification $specification)
    {
        if ($data['submit'] === 'delete') {
            $specification->deleteSpecification();

            $this->message = [
                'type' => 'message-success',
                'content' => 'Property group deleted!'
            ];

            return false;
        }

        if ($data['submit'] === 'save') {
            $specification->update($data);
            
            $this->message = [
                'type' => 'message-success',
                'content' => 'Property group successfully updated!'
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