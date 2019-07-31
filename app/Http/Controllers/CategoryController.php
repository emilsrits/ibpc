<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use App\Models\Category;
use App\Http\Requests\Category\CategoryActionRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    /**
     * CategoryController constructor
     *
     * @param CategoryService $categoryService
     * @param Category $category
     * @param Specification $specification
     */
    public function __construct(CategoryService $categoryService, Category $category, Specification $specification)
    {
        $this->categoryService = $categoryService;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(CategoryActionRequest $request)
    {
        $action = $this->categoryService->action($request->validated());
        if ($action) {
            $request->session()->flash($this->categoryService->message['type'], $this->categoryService->message['content']);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryStoreRequest $request)
    {
        $this->categoryService->store($request->validated());

        $request->session()->flash($this->categoryService->message['type'], $this->categoryService->message['content']);
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
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $action = $this->categoryService->update($request->except('_token'), $category);
        if ($action) {
            $request->session()->flash($this->categoryService->message['type'], $this->categoryService->message['content']);
            return redirect()->back();
        }

        $request->session()->flash($this->categoryService->message['type'], $this->categoryService->message['content']);
        return redirect()->route('category.index');
    }
}
