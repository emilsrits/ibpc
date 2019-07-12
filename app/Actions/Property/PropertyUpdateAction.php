<?php

namespace App\Actions\Property;

use App\Models\Property;

class PropertyUpdateAction
{
    /**
     * Process the property update action
     *
     * @param array $data
     * @param Property $property
     * @return mixed
     */
    public function execute(array $data, $property)
    {
        if ($data['submit'] === 'delete') {
            $property->deleteProperty();

            return;
        }

        if ($data['submit'] === 'save') {
            $property->update($data);
            $flash = [
                
                'type' => 'message-success',
                'message' => 'Property successfully updated!'
            ];

            return $flash;
        }

        return;
    }
}
