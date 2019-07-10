<?php

namespace App\Actions\Specification;

use App\Models\Specification;

class SpecificationActionAction
{
    /**
     * Process the specification mass-action action
     *
     * @param array $data
     * @return void|array
     */
    public function execute(array $data)
    {
        if (isset($data['specifications'])) {
            $specificationIds = $data['specifications'];
            $specification = new Specification();

            switch ($data['mass-action']) {
                case 1:
                    $specification->deleteSpecification($specificationIds);
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'Property groups deleted!'
                    ];

                    return $flash;
            }
        } else {
            return;
        }
    }
}
