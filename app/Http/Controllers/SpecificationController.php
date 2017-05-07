<?php

namespace App\Http\Controllers;

use App\Specification;
use App\Attribute;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    /**
     * SpecificationController constructor
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

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

            if ($request['name'] != $specification->name) {
                if ($this->specificationExists($request['name'])) {
                    $request->session()->flash('message-danger', 'Specification with this name already exists!');
                    return redirect()->back();
                } else {
                    $specification->name = $request['name'];
                }
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
        if (!$request['name']) {
            $request->session()->flash('message-danger', 'Missing attribute group name!');
            return true;
        } else {
            if ($this->specificationExists($request['name'])) {
                $request->session()->flash('message-danger', 'Specification with this name already exists!');
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Check if specification exists
     *
     * @param $name
     * @return mixed
     */
    protected function specificationExists($name) {
        return $specification = Specification::where('name', $name)->exists();
    }
}
