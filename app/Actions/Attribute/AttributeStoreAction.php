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
        $attribute = new Attribute();
        $attribute->specification_id = $specificationId;
        $attribute->name = $data['name'];
        $attribute->save();

        $flash = [
            'type' => 'message-success',
            'message' => 'Attribute successfully created!'
        ];

        return $flash;
    }
}
