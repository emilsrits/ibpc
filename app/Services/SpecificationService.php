<?php

namespace App\Services;

use App\Models\Specification;
use App\Repositories\SpecificationRepository;

class SpecificationService
{
    /**
     * @var array
     */
    public $message;
    
    /**
     * Create a new service instance.
     * 
     * @param SpecificationRepository $specificationRepository
     */
    public function __construct(SpecificationRepository $specificationRepository)
    {
        $this->message = [
            'type' => null,
            'content' => null
        ];
        $this->specificationRepository = $specificationRepository;
    }

    /**
     * Specification mass action
     *
     * @param array $data
     * @return bool
     */
    public function action(array $data)
    {
        if (isset($data['specification'])) {
            $specificationIds = $data['specification'];

            switch ($data['mass-action']) {
                case 1:
                    $this->specificationRepository->delete($specificationIds);

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
        $this->specificationRepository->create($data);
        
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
        $this->specificationRepository->update($data, $specification);
        
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
        $this->specificationRepository->delete($specification->id);

        $this->message = [
            'type' => 'message-success',
            'content' => 'Property group deleted!'
        ];
    }
}
