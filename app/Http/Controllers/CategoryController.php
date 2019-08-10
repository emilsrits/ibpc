<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\Category\CategoryActionRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\SpecificationRepository;

class CategoryController extends Controller
{
    /**
     * CategoryController constructor
     *
     * @param CategoryService $categoryService
     * @param CategoryRepository $categoryRepository
     * @param SpecificationRepository $specificationRepository
     */
    public function __construct(CategoryService $categoryService, CategoryRepository $categoryRepository, SpecificationRepository $specificationRepository)
    {
        $this->categoryService = $categoryService;
        $this->categoryRepository = $categoryRepository;
        $this->specificationRepository = $specificationRepository;
    }

    /**
     * Return category view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryRepository->paginate();

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
        $specifications = $this->specificationRepository->orderBy('name')->get();

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
        $specifications = $this->specificationRepository->orderBy('name')->get();

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
        $this->categoryService->update($request->validated(), $category);

        $request->session()->flash($this->categoryService->message['type'], $this->categoryService->message['content']);
        return redirect()->back();
    }

    /**
     * Delete category
     *
     * @param Request $request
     * @param Category $category
     * @return mixed
     */
    public function delete(Request $request, Category $category)
    {
        $async = $request->wantsJson();

        $action = $this->categoryService->delete($category);

        $request->session()->flash($this->categoryService->message['type'], $this->categoryService->message['content']);

        if ($async) {
            if ($action) {
                return response()->json(array('redirectUrl'=> route('category.index')), 200);
            }
            return response()->json(null, 400);
        }
        
        if ($action) {
            return redirect()->route('category.index');
        }
        return redirect()->back();
    }
}
