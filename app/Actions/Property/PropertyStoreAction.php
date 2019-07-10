<?php

namespace App\Actions\Property;

use App\Models\Property;

class PropertyStoreAction
{
    /**
     * Process the property store action
     *
     * @param array $data
     * @param string $specificationId
     * @return array
     */
    public function execute(array $data, $specificationId)
    {
        $data['specification_id'] = $specificationId;
        Property::create($data);

        $flash = [
            'type' => 'message-success',
            'message' => 'Property successfully created!'
        ];

        return $flash;
    }
}
