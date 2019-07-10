<?php

namespace App\Actions\Category;

use App\Models\Category;

class CategoryUpdateAction
{
    /**
     * Process the category update action
     *
     * @param array $data
     * @param string $id
     * @return mixed
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
            $category->update($data);

            if (isset($data['spec'])) {
                $category->updateSpecifications($data['spec']);
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
