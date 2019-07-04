<?php

namespace App\Actions\Category;

use App\Models\Category;

class CategoryActionAction
{
    /**
     * Process the category mass-action action
     *
     * @param array $data
     * @return void|array
     */
    public function execute(array $data)
    {
        if (isset($data['categories'])) {
            $categoryIds = $data['categories'];
            $category = new Category();

            switch ($data['mass-action']) {
                case 1:
                    $category->setStatus($categoryIds, 1);
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'Categories enabled!'
                    ];

                    return $flash;
                case 2:
                    $category->setStatus($categoryIds, 0);
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'Categories disabled!'
                    ];

                    return $flash;
                case 3:
                    if ($category->deleteCategory($categoryIds)) {
                        $flash = [
                            'type' => 'message-success',
                            'message' => 'Categories deleted!'
                        ];
                    } else {
                        $flash = [
                            'type' => 'message-danger',
                            'message' => 'Cannot delete category with existing products!'
                        ];
                    }

                    return $flash;
            }
        }

        return;
    }
}
