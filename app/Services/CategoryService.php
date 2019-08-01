<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * @var array
     */
    public $message;

    /**
     * @var Category
     */
    protected $category;
    
    /**
     * Create a new service instance.
     * 
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->message = [
            'type' => null,
            'content' => null
        ];
        $this->category = $category;
    }

    /**
     * Category mass action
     *
     * @param array $data
     * @return mixed
     */
    public function action(array $data)
    {
        if (isset($data['categories'])) {
            $categoryIds = $data['categories'];

            switch ($data['mass-action']) {
                case 1:
                    $this->category->setStatus($categoryIds, 1);

                    $this->message = [
                        'type' => 'message-success',
                        'content' => 'Categories enabled!'
                    ];
                    
                    return true;
                case 2:
                    $this->category->setStatus($categoryIds, 0);

                    $this->message = [
                        'type' => 'message-success',
                        'content' => 'Categories disabled!'
                    ];

                    return true;
                case 3:
                    if ($this->category->deleteCategory($categoryIds)) {
                        $this->message = [
                            'type' => 'message-success',
                            'content' => 'Categories deleted!'
                        ];
                    } else {
                        $this->message = [
                            'type' => 'message-danger',
                            'content' => 'Cannot delete category with existing products!'
                        ];
                    }

                    return true;
            }
        }

        return false;
    }

    /**
     * Category store action
     *
     * @param array $data
     */
    public function store(array $data)
    {
        $category = Category::create($data);

        if (isset($data['spec'])) {
            $category->setSpecifications($data['spec']);
        }

        $this->message = [
            'type' => 'message-success',
            'content' => 'Category successfully created!'
        ];
    }
    
    /**
     * Category update action
     *
     * @param array $data
     * @param Category $category
     */
    public function update(array $data, Category $category)
    {
        $category->update($data);

        if (isset($data['spec'])) {
            $category->updateSpecifications($data['spec']);
        }

        $this->message = [
            'type' => 'message-success',
            'content' => 'Category successfully updated!'
        ];
    }

    /**
     * Category delete action
     *
     * @param Category $category
     * @return bool
     */
    public function delete(Category $category)
    {
        if ($category->deleteCategory()) {
            $this->message = [
                'type' => 'message-success',
                'content' => 'Category deleted!'
            ];
            
            return true;
        } else {
            $this->message = [
                'type' => 'message-danger',
                'content' => 'Cannot delete category with existing products!'
            ];

            return false;
        }
    }
}