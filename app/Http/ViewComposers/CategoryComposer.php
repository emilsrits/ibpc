<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\CategoryRepository;

class CategoryComposer
{
    /**
     * Create a new category composer.
     *
     * @param  CategoryRepository  $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     */
    public function compose(View $view)
    {
        $view->with([
            'parentCategories' => $this->categoryRepository->parent()->with('children')->active()->get()
        ]);
    }
}
