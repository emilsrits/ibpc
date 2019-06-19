<?php

namespace App\Actions\Category;

use App\Category;

class CategoryUpdateAction
{
    /**
     * Process the category update action
     *
     * @param array $data
     * @param string $id
     * @return void|array
     */
    public function execute(array $data, $id)
    {
        if ($data['submit'] === 'delete') {
            $category = new Category();
            if ($category->deleteCategory($id)) {
                return;
            } else {
                $flash = [
                    'type' => 'message-danger',
                    'message' => 'Cannot delete category with existing products!'
                ];

                return $flash;
            }
        }

        if ($data['submit'] === 'save') {
            $category = Category::find($id);
            $category->title = $data['title'];
            $category->slug = str_slug($data['title']);
            $category->parent = $data['parent'];
            if ($data['parent_id']) {
                $category->parent_id = $data['parent_id'];
            }
            $category->status = $data['status'];
            $category->save();

            if (isset($data['spec'])) {
                $category->updateSpecifications($data['spec']);
            } else {
                $category->removeSpecifications();
            }

            $flash = [
                'type' => 'message-success',
                'message' => 'Category successfully updated!'
            ];

            return $flash;
        }

        $flash = [
            'type' => 'message-danger',
            'message' => 'Invalid form action!'
        ];

        return $flash;
    }
}
