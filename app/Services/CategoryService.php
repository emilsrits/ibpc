<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    /**
     * Create a new service instance.
     * 
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(Category $category, CategoryRepository $categoryRepository)
    {
        $this->category = $category;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Category mass action
     *
     * @param array $data
     * @return mixed
     */
    public function action(array $data)
    {
        if (isset($data['category'])) {
            $categoryIds = $data['category'];

            switch ($data['mass-action']) {
                case 1:
                    $this->category->setStatus($categoryIds, 1);
                    flashMessage('message-success', 'Categories enabled!');
                    return true;
                case 2:
                    $this->category->setStatus($categoryIds, 0);
                    flashMessage('message-success', 'Categories disabled!');
                    return true;
                case 3:
                    if ($this->category->deleteCategory($categoryIds)) {
                        flashMessage('message-success', 'Categories deleted!');
                        return true;
                    }
                    flashMessage('message-danger', 'Could not delete category.');
                    return false;
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
        $category = $this->categoryRepository->create($data);

        if (isset($data['spec'])) {
            $category->setSpecifications($data['spec']);
        }

        flashMessage('message-success', 'Category successfully created!');
    }
    
    /**
     * Category update action
     *
     * @param array $data
     * @param Category $category
     */
    public function update(array $data, Category $category)
    {
        $this->categoryRepository->update($data, $category);

        if (isset($data['spec'])) {
            $category->updateSpecifications($data['spec']);
        } else {
            $category->updateSpecifications([]);
        }

        flashMessage('message-success', 'Category successfully updated!');
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
            flashMessage('message-success', 'Category deleted!');
            return true;
        } else {
            flashMessage('message-danger', 'Could not delete category.');
            return false;
        }
    }
}
