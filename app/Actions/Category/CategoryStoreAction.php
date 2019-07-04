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
        $category = new Category();
        $category->title = $data['title'];
        $category->slug = str_slug($data['title']);
        $category->parent = $data['parent'];
        if ($data['parent_id']) {
            $category->parent_id = $data['parent_id'];
        }
        $category->status = $data['status'];
        $category->save();

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
