<?php

namespace App\Http\Controllers;

use App\Specification;
use App\Http\Requests\Specification\SpecificationUpdateRequest;
use App\Actions\Specification\SpecificationStoreAction;
use App\Http\Requests\Specification\SpecificationActionRequest;
use App\Actions\Specification\SpecificationActionAction;
use App\Actions\Specification\SpecificationUpdateAction;

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
     * Specification mass action
     *
     * @param \App\Http\Requests\Specification\SpecificationActionRequest $request
     * @param \App\Actions\Specification\SpecificationActionAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(SpecificationActionRequest $request, SpecificationActionAction $action)
    {
        $flash = $action->execute($request->all());
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
        }

        return redirect()->back();
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
     * @param \App\Http\Requests\Specification\SpecificationUpdateRequest $request
     * @param \App\Actions\Specification\SpecificationStoreAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SpecificationUpdateRequest $request, SpecificationStoreAction $action)
    {
        $flash = $action->execute($request->all());

        $request->session()->flash($flash['type'], $flash['message']);
        return redirect()->route('specification.index');
    }

    /**
     * Return specification edit view
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $specification = Specification::with('attributes')->findOrFail($id);

        return view('admin.specification.edit', [
            'specification' => $specification
        ]);
    }

    /**
     * Update specification
     *
     * @param \App\Http\Requests\Specification\SpecificationUpdateRequest $request
     * @param \App\Actions\Specification\SpecificationUpdateAction $action
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SpecificationUpdateRequest $request, SpecificationUpdateAction $action, $id)
    {
        $flash = $action->execute($request->all(), $id);
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $request->session()->flash('message-success', 'Attribute group deleted!');
        return redirect()->route('specification.index');
    }
}
