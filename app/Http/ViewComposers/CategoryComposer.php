<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Category;

class CategoryComposer
{
    /**
     * Parent categories.
     *
     * @var Category
     */
    protected $parent;

    /**
     * Child categories.
     *
     * @var Category
     */
    protected $child;

    /**
     * Create a new category composer.
     *
     * @param  Category  $parent
     * @param Category $child
     * @return void
     */
    public function __construct(Category $parent, Category $child)
    {
        $this->parent = $parent;
        $this->child = $child;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'parentCategories' => $this->parent->where('parent', 1)->where('status', 1)->get(),
            'childCategories' => $this->child->where('parent', 0)->where('status', 1)->get()
        ]);
    }
}