<?php

namespace App\Actions\Category;

use App\Models\Category;

class CategoryUpdateAction
{
    /**
     * Process the category update action
     *
     * @param array $data
     * @param Category $category
     * @return mixed
     */
    public function execute(array $data, $category)
    {
        if ($data['submit'] === 'delete') {
            if ($category->deleteCategory()) {
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
