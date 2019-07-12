<?php

namespace App\Actions\Specification;

use App\Models\Specification;

class SpecificationUpdateAction
{
    /**
     * Process the specification update action
     *
     * @param array $data
     * @param Specification $specification
     * @return mixed
     */
    public function execute(array $data, $specification)
    {
        if ($data['submit'] === 'delete') {
            $specification->deleteSpecification();

            return;
        }

        if ($data['submit'] === 'save') {
            $specification->update($data);
            
            $flash = [
                'type' => 'message-success',
                'message' => 'Property group successfully updated!'
            ];

            return $flash;
        }

        return;
    }
}
