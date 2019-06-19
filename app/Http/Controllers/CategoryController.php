<?php

namespace App\Http\Controllers;

use App\Specification;
use App\Category;
use App\Http\Requests\Category\CategoryActionRequest;
use App\Actions\Category\CategoryActionAction;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Actions\Category\CategoryStoreAction;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Actions\Category\CategoryUpdateAction;

class CategoryController extends Controller
{
    /**
     * Return category view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::paginate(20);

        return view('admin.category.categories', ['categories' => $categories]);
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
        $specifications = Specification::orderBy('name', 'asc')->get();

        return view('admin.category.create', [
            'specifications' => $specifications
        ]);
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
        $flash = $action->execute($request->all());

        $request->session()->flash($flash['type'], $flash['message']);
        return redirect()->route('category.index');
    }

    /**
     * Return edit category page
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::with('specifications')->findOrFail($id);

        $specifications = Specification::orderBy('name', 'asc')->get();

        return view('admin.category.edit', [
            'category' => $category,
            'specifications' => $specifications
        ]);
    }

    /**
     * Update category
     *
     * @param \App\Http\Requests\Category\CategoryUpdateRequest $request
     * @param \App\Actions\Category\CategoryUpdateAction $action
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, CategoryUpdateAction $action, $id)
    {
        $flash = $action->execute($request->all(), $id);
        if ($flash['type'] != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $request->session()->flash('message-success', 'Category deleted!');
        return redirect()->route('category.index');
    }
}
