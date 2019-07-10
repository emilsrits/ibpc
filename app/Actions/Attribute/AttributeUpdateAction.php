<?php

namespace App\Actions\Attribute;

use App\Models\Attribute;

class AttributeUpdateAction
{
    /**
     * Process the attribute update action
     *
     * @param array $data
     * @param string $attributeId
     * @return void|array
     */
    public function execute(array $data, $attributeId)
    {
        if ($data['submit'] === 'delete') {
            $attribute = new Attribute();
            $attribute->deleteAttribute($attributeId);

            return;
        }

        if ($data['submit'] === 'save') {
            $attribute = Attribute::find($attributeId);
            $attribute->update($data);
            $flash = [
                
                'type' => 'message-success',
                'message' => 'Attribute successfully updated!'
            ];

            return $flash;
        }

        return;
    }
}
