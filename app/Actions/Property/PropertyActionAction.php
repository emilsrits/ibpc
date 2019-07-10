<?php

namespace App\Actions\Property;

use App\Models\Property;

class PropertyActionAction
{
    /**
     * Process the property mass-action action
     *
     * @param array $data
     * @return void|array
     */
    public function execute(array $data)
    {
        if (isset($data['properties'])) {
            $propertyIds = $data['properties'];
            $property = new Property();

            switch ($data['mass-action']) {
                case 1:
                    $property->deleteProperty($propertyIds);
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'Properties deleted!'
                    ];

                    return $flash;
            }
        } else {
            return;
        }
    }
}
