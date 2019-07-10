<?php

namespace App\Actions\Category;

use App\Models\Category;

class CategoryStoreAction
{
    /**
     * Process the category store action
     *
     * @param array $data
     * @return void|array
     */
    public function execute(array $data)
    {
        $category = Category::create($data);

        if (isset($data['spec'])) {
            $category->setSpecifications($data['spec']);
        }

        $flash = [
            'type' => 'message-success',
            'message' => 'Category successfully created!'
        ];

        return $flash;
    }
}
