<?php

namespace App\Http\Controllers;

use App\Admin\Tables\CategoryTable;
use App\Models\Category;
use App\Http\Requests\Category\CategoryActionRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\SpecificationRepository;
use App\Traits\PaginatesModels;

class CategoryController extends Controller
{
    use PaginatesModels;
    
    /**
     * CategoryController constructor
     *
     * @param CategoryService $categoryService
     * @param CategoryRepository $categoryRepository
     * @param CategoryTable $categoryTable
     * @param SpecificationRepository $specificationRepository
     */
    public function __construct(
        CategoryService $categoryService,
        CategoryRepository $categoryRepository,
        CategoryTable $categoryTable,
        SpecificationRepository $specificationRepository
    ) {
        $this->categoryService = $categoryService;
        $this->categoryRepository = $categoryRepository;
        $this->categoryTable = $categoryTable;
        $this->specificationRepository = $specificationRepository;
    }

    /**
     * Return category view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if ($this->setSessionPageSize()) {
            return response()->json(array('redirectUrl' => request()->url()), 200);
        }
        
        $categories = $this->categoryRepository->paginate();
        $table = $this->categoryTable;

        return view('admin.category.categories', compact('categories', 'table'));
    }

    /**
     * Categories mass action
     *
     * @param \App\Http\Requests\Category\CategoryActionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(CategoryActionRequest $request)
    {
        $this->categoryService->action($request->validated());

        return redirect()->back();
    }

    /**
     * Return category create view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $specifications = $this->specificationRepository->orderBy('slug')->get();

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
        $specifications = $this->specificationRepository->orderBy('slug')->get();

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

        if ($async) {
            if ($action) {
                return response()->json(array('redirectUrl' => route('category.index')), 200);
            }
            return response()->json(null, 400);
        }
        
        if ($action) {
            return redirect()->route('category.index');
        }
        return redirect()->back();
    }
}
