<?php

namespace App\Http\Controllers;

use App\Specification;
use Illuminate\Http\Request;
use App\Category;

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($this->categoryValidate($request)) {
            return redirect()->back();
        }

        $category = new Category();
        $category->title = $request['title'];
        if ($request['parent']) {
            $category->parent = $request['parent'];
        } else {
            if ($request['parent_id']) {
                $category->parent_id = $request['parent_id'];
            }
        }
        $category->status = $request['status'];
        $category->save();

        if ($request['spec']) {
            $specificationsGroup = collect($request['spec'])->sortBy('id');
            foreach ($specificationsGroup as $specifications => $specification) {
                foreach ($specification as $key => $value) {
                    if ($value) {
                        $category->specifications()->attach(['specification_id' => ['specification_id' => $value]]);
                    }
                }
            }
        }

        $request->session()->flash('message-success', 'Category successfully created!');

        return redirect()->route('category.index');
    }

    /**
     * Return edit category page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::with('specifications')->find($id);

        $specifications = Specification::orderBy('name', 'asc')->get();

        return view('admin.category.edit', [
            'category' => $category,
            'specifications' => $specifications
        ]);
    }

    /**
     * Update category
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Delete category
        if ($request['submit'] === 'delete') {
            $category = new Category();
            $category->deleteCategory($id);

            $request->session()->flash('message-success', 'Category deleted!');

            return redirect()->route('category.index');
        }

        // Update category
        if ($request['submit'] === 'save') {
            $category = Category::find($id);

            if ($request['title'] != $category->title) {
                if ($this->categoryExists($request['title'])) {
                    $request->session()->flash('message-danger', 'Category with this title already exists!');
                    return redirect()->back();
                } else {
                    $category->title = $request['title'];
                }
            }
            if ($request['parent']) {
                $category->parent = $request['parent'];
            } else {
                if ($request['parent_id']) {
                    $category->parent_id = $request['parent_id'];
                }
            }
            $category->status = $request['status'];
            $category->save();

            if ($request['spec']) {
                // Attach new specifications
                $specificationsGroup = collect($request['spec'])->sortBy('id');
                foreach ($specificationsGroup as $specifications => $specification) {
                    foreach ($specification as $key => $value) {
                        $categorySpec = $category->specifications->find($value);
                        if (!$categorySpec) {
                            $category->specifications()->attach(['specification_id' => ['specification_id' => $value]]);
                            continue;
                        }
                    }
                }
                // Remove unchecked values
                if ($category->specifications->first()) {
                    foreach ($category->specifications as $categorySpecs) {
                        $specId = $categorySpecs->id;
                        $matchFound = false;
                        foreach ($specificationsGroup as $specifications => $specification) {
                            foreach ($specification as $key => $value) {
                                if ((int)$value === $specId) {
                                    $matchFound = true;
                                    continue;
                                }
                            }
                        }
                        if (!$matchFound) {
                            $category->specifications()->detach(['specification_id' => ['specification_id' => $specId]]);
                        }
                    }
                }
            } else {
                // Remove all specifications
                if ($category->specifications->first()) {
                    foreach ($category->specifications as $categorySpecs) {
                        $specId = $categorySpecs->id;
                        $category->specifications()->detach(['specification_id' => ['specification_id' => $specId]]);
                    }
                }
            }

            $request->session()->flash('message-success', 'Category successfully updated!');

            return redirect()->back();
        }

        $request->session()->flash('message-danger', 'Invalid form action!');

        return redirect()->back();
    }

    /**
     * Delete a category
     *
     * @param $id
     */
    public function delete($id)
    {
        $category = new Category();
        $category->deleteCategory($id);
    }

    /**
     * Categories mass action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function massAction(Request $request)
    {
        $categoryIds = $request->input('categories');
        $category = new Category();

        switch ($request->input('mass-action')) {
            case 1:
                $category->setStatus($categoryIds, 1);
                $request->session()->flash('message-success', 'Categories enabled!');
                break;
            case 2:
                $category->setStatus($categoryIds, 0);
                $request->session()->flash('message-success', 'Categories disabled!');
                break;
            case 3:
                $category->deleteCategory($categoryIds);
                $request->session()->flash('message-success', 'Categories deleted!');
                break;
        }

        return redirect()->back();
    }

    /**
     * Validate category save
     *
     * @param $request
     * @return bool
     */
    protected function categoryValidate($request)
    {
        if (!$request['title']) {
            $request->session()->flash('message-danger', 'Missing category title!');
            return true;
        } else {
            if ($this->categoryExists($request['title'])) {
                $request->session()->flash('message-danger', 'Category with this title already exists!');
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Check if category exists
     *
     * @param $title
     * @return mixed
     */
    protected function categoryExists($title) {
        return $category = Category::where('title', $title)->exists();
    }
}
