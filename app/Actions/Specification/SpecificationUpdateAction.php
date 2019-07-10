<?php

namespace App\Actions\Specification;

use App\Models\Specification;

class SpecificationUpdateAction
{
    /**
     * Process the specification update action
     *
     * @param array $data
     * @param string $id
     * @return void|array
     */
    public function execute(array $data, $id)
    {
        if ($data['submit'] === 'delete') {
            $specification = new Specification();
            $specification->deleteSpecification($id);

            return;
        }

        if ($data['submit'] === 'save') {
            $specification = Specification::find($id);
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
