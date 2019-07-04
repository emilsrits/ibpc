<?php

namespace App\Actions\Attribute;

use App\Models\Attribute;

class AttributeActionAction
{
    /**
     * Process the attribute mass-action action
     *
     * @param array $data
     * @return void|array
     */
    public function execute(array $data)
    {
        if (isset($data['attributes'])) {
            $attributeIds = $data['attributes'];
            $attribute = new Attribute();

            switch ($data['mass-action']) {
                case 1:
                    $attribute->deleteAttribute($attributeIds);
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'Attribute(s) deleted!'
                    ];

                    return $flash;
            }
        } else {
            return;
        }
    }
}
