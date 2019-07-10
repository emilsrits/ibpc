<?php

namespace App\Actions\Property;

use App\Models\Property;

class PropertyUpdateAction
{
    /**
     * Process the property update action
     *
     * @param array $data
     * @param string $propertyId
     * @return void|array
     */
    public function execute(array $data, $propertyId)
    {
        if ($data['submit'] === 'delete') {
            $property = new Property();
            $property->deleteProperty($propertyId);

            return;
        }

        if ($data['submit'] === 'save') {
            $property = Property::find($propertyId);
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
