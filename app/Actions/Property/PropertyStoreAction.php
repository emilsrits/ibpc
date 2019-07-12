<?php

namespace App\Actions\Property;

use App\Models\Property;

class PropertyStoreAction
{
    /**
     * Process the property store action
     *
     * @param array $data
     * @param Specification $specification
     * @return array
     */
    public function execute(array $data, $specification)
    {
        $data['specification_id'] = $specification->id;
        Property::create($data);

        $flash = [
            'type' => 'message-success',
            'message' => 'Property successfully created!'
        ];

        return $flash;
    }
}
