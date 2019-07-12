<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use App\Models\Category;
use App\Http\Requests\Category\CategoryActionRequest;
use App\Actions\Category\CategoryActionAction;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Actions\Category\CategoryStoreAction;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Actions\Category\CategoryUpdateAction;

class CategoryController extends Controller
{
    /**
     * CategoryController constructor
     *
     * @param Category $category
     * @param Specification $specification
     */
    public function __construct(Category $category, Specification $specification)
    {
        $this->category = $category;
        $this->specification = $specification;
    }

    /**
     * Return category view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->category->paginate(20);

        return view('admin.category.categories', compact('categories'));
    }

    /**
     * Categories mass action
     *
     * @param \App\Http\Requests\Category\CategoryActionRequest $request
     * @param \App\Actions\Category\CategoryActionAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(CategoryActionRequest $request, CategoryActionAction $action)
    {
        $flash = $action->execute($request->all());
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        return redirect()->back();
    }

    /**
     * Return category create view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $specifications = $this->specification->oldest('name')->get();

        return view('admin.category.create', compact('specifications'));
    }

    /**
     * Save a category
     *
     * @param \App\Http\Requests\Category\CategoryStoreRequest $request
     * @param \App\Actions\Category\CategoryStoreAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryStoreRequest $request, CategoryStoreAction $action)
    {
        $flash = $action->execute($request->validated());

        $request->session()->flash($flash['type'], $flash['message']);
        return redirect()->route('category.index');
    }

    /**
     * Return edit category page
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        $specifications = $this->specification->oldest('name')->get();

        return view('admin.category.edit', compact('category', 'specifications'));
    }

    /**
     * Update category
     *
     * @param \App\Http\Requests\Category\CategoryUpdateRequest $request
     * @param \App\Actions\Category\CategoryUpdateAction $action
     * @param Category $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, CategoryUpdateAction $action, Category $category)
    {
        $flash = $action->execute($request->all(), $category);
        if ($flash['type'] != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $request->session()->flash('message-success', 'Category deleted!');
        return redirect()->route('category.index');
    }
}
