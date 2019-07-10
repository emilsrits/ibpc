<?php

namespace App\Actions\Attribute;

use App\Models\Attribute;

class AttributeStoreAction
{
    /**
     * Process the attribute store action
     *
     * @param array $data
     * @param string $specificationId
     * @return array
     */
    public function execute(array $data, $specificationId)
    {
        $data['specification_id'] = $specificationId;
        Attribute::create($data);

        $flash = [
            'type' => 'message-success',
            'message' => 'Attribute successfully created!'
        ];

        return $flash;
    }
}
