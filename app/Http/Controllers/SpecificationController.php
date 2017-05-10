<?php

namespace App\Http\Controllers;

use App\Specification;
use App\Attribute;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    /**
     * Return specifications view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $specifications = Specification::with('attributes')->paginate(20);

        return view('admin.specification.specifications', ['specifications' => $specifications]);
    }

    /**
     * Return specification create view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.specification.create');
    }

    /**
     * Save a specification
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($this->specificationValidate($request)) {
            return redirect()->back();
        }

        $specification = new Specification();
        $specification->slug = $request['slug'];
        $specification->name = $request['name'];
        $specification->save();

        $request->session()->flash('message-success', 'Attribute group successfully created!');

        return redirect()->route('specification.index');
    }

    /**
     * Return specification edit view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $specification = Specification::with('attributes')->find($id);

        return view('admin.specification.edit', [
            'specification' => $specification
        ]);
    }

    /**
     * Update specification
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Delete specification
        if ($request['submit'] === 'delete') {
            $specification = new Specification();
            $specification->deleteSpecification($id);

            $request->session()->flash('message-success', 'Attribute group deleted!');
            return redirect()->route('specification.index');
        }

        // Update specification
        if ($request['submit'] === 'save') {
            $specification = Specification::find($id);

            if ($request['slug'] != $specification->slug) {
                if ($this->specificationExists($request['slug'])) {
                    $request->session()->flash('message-danger', 'Specification with this slug already exists!');
                    return redirect()->back();
                } else {
                    $specification->slug = $request['slug'];
                }
            }
            if (!ctype_space($request['name']) && !$request['name'] == "") {
                $specification->name = $request['name'];
            } else {
                $request->session()->flash('message-danger', 'Attribute group needs a display name!');
                return redirect()->back();
            }
            $specification->save();

            $request->session()->flash('message-success', 'Attribute group successfully updated!');
            return redirect()->back();
        }

        $request->session()->flash('message-danger', 'Invalid form action!');
        return redirect()->back();
    }

    /**
     * Delete specification
     *
     * @param $id
     */
    public function delete($id)
    {
        $specification = new Specification();
        $specification->deleteSpecification($id);
    }

    /**
     * Specification mass action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function massAction(Request $request)
    {
        $specificationIds = $request->input('specifications');
        $specification = new Specification();

        switch ($request->input('mass-action')) {
            case 1:
                $specification->deleteSpecification($specificationIds);
                $request->session()->flash('message-success', 'Attribute groups deleted!');
                break;
        }

        return redirect()->back();
    }

    /**
     * Validate form input fields when creating a new specification
     *
     * @param $request
     * @return bool
     */
    protected function specificationValidate($request)
    {
        if (!ctype_space($request['slug']) && !$request['slug'] == "") {
            $request->session()->flash('message-danger', 'Missing attribute group slug!');
            return true;
        } else {
            if ($this->specificationExists($request['slug'])) {
                $request->session()->flash('message-danger', 'Specification with this slug already exists!');
                return true;
            }
        }
        if (!ctype_space($request['name']) && !$request['name'] == "") {
            $request->session()->flash('message-danger', 'Missing attribute group name!');
            return true;
        }

        return false;
    }

    /**
     * Check if specification exists
     *
     * @param $slug
     * @return mixed
     */
    protected function specificationExists($slug) {
        return $specification = Specification::where('slug', $slug)->exists();
    }
}
