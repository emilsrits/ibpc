<?php

namespace App\Actions\Specification;

use App\Models\Specification;

class SpecificationStoreAction
{
    /**
     * Process the specification store action
     *
     * @param array $data
     * @return array
     */
    public function execute(array $data)
    {
        Specification::create($data);
        
        $flash = [
            'type' => 'message-success',
            'message' => 'Property group successfully created!'
        ];

        return $flash;
    }
}
