<?php

namespace App\Actions\Specification;

use App\Specification;

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
            $specification->slug = $data['slug'];
            $specification->name = $data['name'];
            $specification->save();
            
            $flash = [
                'type' => 'message-success',
                'message' => 'Attribute group successfully updated!'
            ];

            return $flash;
        }

        return;
    }
}
